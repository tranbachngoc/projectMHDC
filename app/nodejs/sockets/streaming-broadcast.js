//handler for broad cast streaming
//TODO - should change with redis or something else?
//hold for broadcast list conenct
var listOfBroadcasts = {};
var streamingStorage = require('./../storages/streaming');
var _ = require('lodash');
let models  = require('../models');
let Redis = require('../components/Redis');
var moment = require('moment');
var PushService = require('../push/push');
var async = require('async');

var MAX_CONNECTORS = 50; //should be 3 for scalable
let STREAMING_CACHE_PREFIX = 'STREAMING_';

function getFirstAvailableBraodcater(user) {

  var broadcasters = listOfBroadcasts[user.broadcastid].broadcasters;
  var firstResult;
  for (var userid in broadcasters) {
    if (broadcasters[userid].numberOfViewers <= MAX_CONNECTORS) {
      firstResult = broadcasters[userid];
      continue;
    } else delete listOfBroadcasts[user.broadcastid].broadcasters[userid];
  }
  return firstResult;
}

var firstAvailableBroadcasters = {};

module.exports = exports = {
  register: function(socket) {
    var currentUser;
    socket.on('join-broadcast', function(user) {
      currentUser = user;
      socket.broadcastUser =  user;
      var modelHasJoined = false;

      user.numberOfViewers = 0;
      //if user is model we can open a new room, otherwise check room and notify for user if it does not exist
      //TODO - should create model room from model jwt id instead of broadcastid
      //TODO - check model id with broadcastid
      if (!listOfBroadcasts[user.broadcastid]) {
        if (socket.user && socket.user.role === 'model') {
          listOfBroadcasts[user.broadcastid] = {
            broadcasters: {},
            allusers: {},
            typeOfStreams: user.typeOfStreams, // object-booleans: audio, video, screen
            openBroadcast: false
          };

          //pass broadcastid as session
          socket.broadcastid = user.broadcastid;
          //flag key to update event if model join any room
          modelHasJoined = true;

          //add model to broadcaster
          firstAvailableBroadcasters[user.broadcastid] = {
            broadcastid            : user.broadcastid,
            userid                 : user.userid,
            goalId                 : user.goalId,
            goalTipTitle           : user.goalTipTitle,
            goalTipAmountAchieved  : user.goalTipAmountAchieved,
            goalTipAmountGoal      : user.goalTipAmountGoal,
            archievedGoalTipsNumber: user.archievedGoalTipsNumber,
            lastedArchievedGoalTip : user.lastedArchievedGoalTip,
            typeOfStreams          : { video: true, screen: false, audio: true, oneway: true },
            numberOfViewers        : 0,
            openBroadcast          : false
          };

        } else {
          //do nothing and alert to user that room is not exist
          return socket.emit('broadcast-error', {
            msg: 'Model is not available in this room'
          });
        }
      } else {
        if (socket.user && socket.user.role === 'model') {
          modelHasJoined = true;
          listOfBroadcasts[user.broadcastid].typeOfStreams = { video: true, screen: false, audio: true, oneway: true };
          listOfBroadcasts[user.broadcastid].openBroadcast = false;
        }
      }

      // console.log('join-broadcaster data', user);

      //var firstAvailableBroadcaster = getFirstAvailableBraodcater(user);
      //model will be broadcaster
      var firstAvailableBroadcaster = socket.user && socket.user.role === 'model' ? null : firstAvailableBroadcasters[user.broadcastid];
      //only emit for
      if (firstAvailableBroadcaster) {
        if(firstAvailableBroadcaster.openBroadcast){
            //listOfBroadcasts[user.broadcastid].broadcasters[firstAvailableBroadcaster.userid].numberOfViewers++;
          socket.emit('join-broadcaster', firstAvailableBroadcaster, listOfBroadcasts[user.broadcastid].typeOfStreams);

          //TODO update viewer time here
          if(socket.user && socket.user.role == 'member') {
            models.ChatThreadUser.update({
              isStreaming: true,
              lastStreamingTime: new Date()
            }, {
              where: {threadId: socket.threadId, userId: socket.user.id}
            });
            socket.broadcast.to(socket.threadId).emit('join-room', socket.user);
          }

          // console.log('User <', user.userid, '> is trying to get stream from user <', firstAvailableBroadcaster.userid, '>');
        }else{
          // console.log('Room does not init');
          socket.emit('public-room-status', false);
        }
      } else if(user.openBroadcast){
        currentUser.isInitiator = true;
        // console.log('broadcast data',user);
        firstAvailableBroadcasters[user.broadcastid].openBroadcast = true;
        socket.emit('start-broadcasting', listOfBroadcasts[user.broadcastid].typeOfStreams);

        models.ChatThread.update({
          isStreaming: true,
          lastStreamingTime: new Date()
        }, {
          where: {id: socket.threadId, ownerId: socket.user.id}
        }).then(function(thread) {
          if(!thread){console.log( 'Update isStreaming = true error');return;}

          // console.log('User <', user.room, '> will be next to serve broadcast.');
          socket.broadcast.to(socket.threadId).emit('public-chat-init', user);
          // //send push notification here
          PushService.push(socket, 'online');
        });
      }
      listOfBroadcasts[user.broadcastid].broadcasters[user.userid] = user;
      listOfBroadcasts[user.broadcastid].allusers[user.userid] = user;

      //storage this socket into streaming storage to emit event
      streamingStorage.add(user.broadcastid, socket);

      if (modelHasJoined && listOfBroadcasts[user.broadcastid].typeOfStreams.video) {
        //send reconnect event to client?
        //send re join event to clients
        streamingStorage.emitToRoom(user.broadcastid, 'rejoin-broadcast', { id: user.broadcastid }, [socket]);
        // console.log('rejoin broadcast');
      }
      var broadcastUser = socket.broadcastUser;

      //Set list of broadcast to redis for shared data for multile platforms
      Redis.get(STREAMING_CACHE_PREFIX + 'USERS', function(err, users) {
        if (err) { return; }

        if (!users) { users = []; }
        else {
          users = JSON.parse(users);
        }
        //push user to the array
        users.push(broadcastUser);

        //set to redis
        Redis.set(STREAMING_CACHE_PREFIX + 'USERS', JSON.stringify(users));
      });
    });

    socket.on('broadcast-message', function(message) {
      socket.broadcast.emit('broadcast-message', message);
    });

    socket.on('disconnect', function() {
      //remove socket
      streamingStorage.remove(socket);
      var broadcastUser = socket.broadcastUser;

      //if model is disconnect, remove all sockets which are viewing this mode
      //TODO - check streaming model here because shared session

      if (socket.user && socket.user.role === 'model') {
        //check broadcast id
        delete listOfBroadcasts[socket.broadcastid];
        delete firstAvailableBroadcasters[socket.broadcastid];

        streamingStorage.emitToRoom(socket.broadcastid, 'model-left');

        if (broadcastUser) {
          models.ChatThread.findOne({
            where: { id: socket.threadId, isStreaming: 1, ownerId: socket.user.id}
          }).then(function(room) {
            if (!room) {
              return;
            }
            var endDate = moment(new Date());//now
            var startDate = moment(room.get('lastStreamingTime'));

            models.ChatThread.update({
              isStreaming: false,
              streamingTime: parseInt(room.get('streamingTime') + endDate.diff(startDate, 'minutes'))
            }, {
              where: {id: room.get('id')}
            }).then(function(thread) {
              if(!thread) { console.log('update thread status false error'); return;}
              //send push notification here
              PushService.push(socket, 'offline');
            });
          });
          //TODO update ChatThreadUser here
          models.ChatThreadUser.findAll({
            where: {
              threadId: socket.threadId,
              isStreaming: true
            }
          }).then(function(threadUsers) {
            if(!threadUsers){
              return;
            }

            async.map(threadUsers, function (item, cb){
              var endDate = moment(new Date());//now
              var startDate = moment(item.lastStreamingTime);

              models.ChatThreadUser.update({
                isStreaming: false,
                streamingTime: parseInt(item.streamingTime + endDate.diff(startDate, 'minutes'))
              }, {
                where: {id: item.id}
              }).then(function(threadUser) {
                if(!threadUser){
                  console.log('disconnected: Save threadUser error');
                }
                cb();
              }, cb);
            }, function(err, results) {
              console.log(err);
            });
          });
        }
      }else if(socket.user){
        // console.log('disconnected Update ChatThreadUser');
        models.ChatThreadUser.findOne({
          where: {
              threadId: socket.threadId,
              isStreaming: true,
              userId: socket.user.id
            }
          }).then(function(threadUser) {
            if(!threadUser){
              return;
            }

            var endDate = moment(new Date());//now
            var startDate = moment(threadUser.get('lastStreamingTime'));

            models.ChatThreadUser.update({
              isStreaming: false,
              streamingTime: parseInt(threadUser.get('streamingTime') + endDate.diff(startDate, 'minutes'))
            }, {
              where: {id: threadUser.get('id')}
            });
          });
      }

      if (!currentUser) return;
      if (!listOfBroadcasts[currentUser.broadcastid]) return;
      if (!listOfBroadcasts[currentUser.broadcastid].broadcasters[currentUser.userid]) return;

      delete listOfBroadcasts[currentUser.broadcastid].broadcasters[currentUser.userid];
      if (currentUser.isInitiator) {
        delete listOfBroadcasts[currentUser.broadcastid];
      }

      if (broadcastUser) {
        //update redis
        Redis.get(STREAMING_CACHE_PREFIX + 'USERS', function(err, users) {
          if (err || !users) { return; }
          users = JSON.parse(users);

          _.remove(users, function(user) {
            return user.userid === broadcastUser.userid;
          });

          //set to redis
          Redis.set(STREAMING_CACHE_PREFIX + 'USERS', JSON.stringify(users));
        });
      }
    });

    socket.on('has-broadcast', function(broadcastid, cb) {
      if (typeof cb !== 'function') { return; }
      if (listOfBroadcasts[broadcastid]) {
        cb(true);
      } else {
        cb(false);
      }
    });
  }
};