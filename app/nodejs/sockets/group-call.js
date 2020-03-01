import uuid from 'node-uuid';
//let models  = require('../models');
var groupRooms = {}, userIds = {}, listUserIds = [], listSameId = [];
//let modelsStorage = require('./../storages/model');
let Redis = require('../components/Redis');
var moment = require('moment');
var Queue = require('../components/Queue')
var http = require('../components/Http');
import config from './../config/environment';
var apiUrl = config.apiUrl;

let GROUP_CACHE_PREFIX = 'GROUP_';

import _ from 'lodash';

var firstAvailableRooms = {};

function getDateTime() {

    var date = new Date();

    var hour = date.getHours();
    hour = (hour < 10 ? "0" : "") + hour;

    var min  = date.getMinutes();
    min = (min < 10 ? "0" : "") + min;

    var sec  = date.getSeconds();
    sec = (sec < 10 ? "0" : "") + sec;

    var year = date.getFullYear();

    var month = date.getMonth() + 1;
    month = (month < 10 ? "0" : "") + month;

    var day  = date.getDate();
    day = (day < 10 ? "0" : "") + day;

    return year + "-" + month + "-" + day + " " + hour + ":" + min + ":" + sec;

  }

export function register(socket, socketio) {
  var currentRoom, id;

  socket.on('group-call-init', function (data) {
      var arrUserCall = data.arrUser;
      var isAudio = data.isAudio;
      currentRoom = (data || {}).groupChatId || uuid.v4();
      var room = groupRooms[currentRoom];
      socket.threadId = data.groupChatId;
      var roomId = data.groupChatId;
      var groupChatTime = getDateTime();
      var d = new Date();
      var groupChatTimeTs = d.getTime();
      var arrExist  = [];
      var arrNotExist  = [];
      var arrNotExist1  = [];
      var token = socket.handshake.query.token;
      groupRooms[roomId] = Array.from(new Set(groupRooms[roomId]));
      var indexKeyFirst = listUserIds.indexOf(socket.user.id);
      var avatar = socket.user.avatar;
      var arrAllUserGroup = arrUserCall;
      arrAllUserGroup.push(socket.user.id);
      var dataReturn = {
                model: socket.user.id,
                groupChatId: roomId,
                use_fullname: socket.user.use_fullname,
                use_username: socket.user.use_username,
                avatar: avatar,
                use_id:  socket.user.id,
                status: 0,
                isAudio: isAudio,
                groupChatTime: groupChatTime,
                groupChatTimeTs: groupChatTimeTs,
                arrAllUserGroup: arrAllUserGroup
              };

      if(indexKeyFirst !=-1) {
        console.log("dang trong cuoc goi");
        if(groupRooms[roomId].length == 1) {
          var info = groupRooms[roomId][0];
          var dataReturn1 = {
                 isAudio:info.isAudio,
                 groupChatId:roomId ,
                 groupChatTime: groupChatTime,
                 userId:socket.user.id,
                 arrAllUserGroup: arrAllUserGroup
            };

          if( socket.user.id = info.user.id ) {
              return socketio.to(socket.id).emit('denycall-otherdevice', dataReturn);
          }
          console.log("2 thang goi cung luc");
          groupRooms[roomId].push(socket);
          dataReturn.status = 1;
          dataReturn.groupChatTime =groupChatTime;
          socketio.to(socket.id).emit('group-call-init',dataReturn  );
          return socketio.to(info.id).emit('accept-call',dataReturn1);
          //return socketio.to(socket.id).emit('accept-call',dataReturn1  );
        }
        else {
          return socketio.to(socket.id).emit('denycall-otherdevice', dataReturn);
        }

      }
      var checkcall = false;
      arrUserCall.forEach(function(element) {
          var indexKey = listUserIds.indexOf(element);
          if(indexKey !=-1) {
            checkcall = true;

          }
      });
      if(checkcall == true) {
        return socketio.to(socket.id).emit('denycall-otherdevice', dataReturn);
      }
      console.log("chen truong khi tra ve ne===============");
      socket.groupChatTime =  groupChatTime;
      groupRooms[currentRoom] = [socket];
      listUserIds[socket.user.id] = socket.user.id;
      arrUserCall.forEach(function(element) {
          listUserIds[element] = element;
      });
      //console.log(listUserIds);
      id = userIds[currentRoom] = 0;
      room = groupRooms[currentRoom];
      firstAvailableRooms[currentRoom] = {
          model: socket.user.id
      };
      console.log("firstAvailableRooms----");
      console.log(firstAvailableRooms[currentRoom]);
      if(room){
            var dataReturn = {
                model: socket.user.id,
                groupChatId: roomId,
                use_fullname: socket.user.use_fullname,
                use_username: socket.user.use_username,
                avatar: avatar,
                use_id:  socket.user.id,
                status: 1,
                isAudio: isAudio,
                groupChatTime: groupChatTime,
                groupChatTimeTs: groupChatTimeTs,
                arrAllUserGroup: arrAllUserGroup
              };
            socketio.to(socket.id).emit('group-call-init', dataReturn);
            arrUserCall.forEach(function(element) {
                if(socket.user.id !=  element ) {
                    socketio.to("roomself_"+element).emit('on-group-chat', dataReturn);
                }
            });
            userIds[currentRoom] += 1;
            id = userIds[currentRoom];
            room[id] = socket;
            socket.groupId = roomId;
            var userReceive =  arrUserCall.join();
            if(isAudio) {
              var dataParam = {
                  "groupChatId": roomId,
                  "userCall": socket.user.id,
                  "userReceive": userReceive,
                  "type": "call",
                  "message": "Cuộc gọi đi",
                  "groupChatTime": groupChatTime,
                  "groupChatTimeTs": groupChatTimeTs,
                  "isAudio" : isAudio

              };
            }
            else {
              var dataParam = {
                  "groupChatId": roomId,
                  "userCall": socket.user.id,
                  "userReceive": userReceive,
                  "type": "video-call",
                  "message": "Cuộc gọi đi",
                  "groupChatTime": groupChatTime,
                  "groupChatTimeTs": groupChatTimeTs,
                  "isAudio" : isAudio
              };
            }
            http.post(apiUrl+'chat/update-info-call', dataParam, {
                "Authorization" :"Bearer " + token
            }).then(function (res) {

                var data = res.data;
            }).catch(function (err) {

                return socket.emit('_error', {
                      event: 'update-info-call',
                      msg: err.msg || 'Lỗi hệ thống',
                      data: data
                  });
            });

          }
  });


  socket.on('join-on-group-chat', function (data) {
      var groupChatTime = data.groupChatTime;
      socket.join(groupChatTime);
  });

  socket.on('join-call', function (data) {
    var arrUserCall = data.arrUser;
    var arrAllUserGroup  = arrUserCall;
    arrAllUserGroup.push(socket.user.id);
    var dataReturn = {
            userId: socket.user.id,
            groupChatId: data.groupChatId,
            isAudio: data.isAudio,
            arrAllUserGroup: arrAllUserGroup
          };
    arrUserCall.forEach(function(element) {
      socketio.to("roomself_"+element).emit('join-call', dataReturn);
    });
  });

  socket.on('accept-call', function (data) {
      console.log("chap nhan cuoc goi ne");
      var roomId = data.groupChatId;
      var available = firstAvailableRooms[roomId];
      if(typeof available.model == 'undefined') {
         console.log("kho co du lieu ne firstAvailableRooms ");
         groupRooms[roomId] = [];
         return false;
      }
      groupRooms[roomId] = Array.from(new Set(groupRooms[roomId]));
      var isAudio = data.isAudio;
      var groupChatTime = data.groupChatTime;
      var listUser1 = groupRooms[roomId];
      var same = false;
      listUser1.forEach(function(element) {
            if(socket.user.id == element.user.id) {
              var dataReturn = {
                userId: socket.user.id,
                groupChatId: roomId,
                isAudio: isAudio,
                arrAllUserGroup: []
              };
              same = true;
              console.log("tu cho 1 thiet bi accept");
              socketio.to(socket.id).emit('denycall-otherdevice', dataReturn);
            }
      });
      if(same == true) {
        return true;
      }
      groupRooms[roomId].push(socket);
      var listUser = groupRooms[roomId];
      var arrAllUserGroup  = [];
      if(Array.isArray(listUser)) {
        if(listUser.length) {
          listUser.forEach(function(element) {
            arrAllUserGroup.push(element.user.id);
          });
        }
      }
      var dataReturn = {
                userId: socket.user.id,
                groupChatId: roomId,
                isAudio: isAudio,
                arrAllUserGroup: arrAllUserGroup
              };
      if(Array.isArray(listUser)) {
        if(listUser.length) {
          //console.log(listUser.length);
          listUser.forEach(function(element) {
            if(socket.user.id != element.user.id) {
              socketio.to(element.id).emit('accept-call', dataReturn);
            }
          });
        }
      }
      console.log("accept call");
      socketio.to(socket.id).emit('accept-call-sucess', dataReturn);
      if(same == false) {
        socket.broadcast.to(groupChatTime).emit('denycall-otherdevice', dataReturn);
      }
      var token = socket.handshake.query.token;
      var dataJson = {
                "groupChatId":roomId,
                "isStreaming": true,
                "virtualId": roomId,
                "lastStreamingTime": getDateTime()
              };
      http.post(apiUrl+'chat/update-info-thread', dataJson, {
          "Authorization" :"Bearer " + token
      }).then(function (res) {
          var data = res.data;
      }).catch(function (err) {
          return socket.emit('_error', {
                event: 'update-info-thread',
                msg: err.msg || 'Lỗi hệ thống',
                data: data
            });
      });
      var dataInfo = {
                "groupChatId":roomId,
                "isStreaming": true,
                "lastStreamingTime": getDateTime()
              };

      http.post(apiUrl+'chat/update-info-threaduser', dataInfo, {
          "Authorization" :"Bearer " + token
      }).then(function (res) {
          var data = res.data;
      }).catch(function (err) {
          return socket.emit('_error', {
                event: 'update-info-thread-user',
                msg: err.msg || 'Lỗi hệ thống',
                data: data
            });
      });
  });
  socket.on('cancel-call', function (data) {
      var isAudio = data.isAudio;
      var roomId = data.groupChatId;
      var listUser = groupRooms[roomId];
      var arrAllUserGroup  = [];
      var groupChatTime = "";
      if(typeof groupChatTime != 'undefined') {
         groupChatTime = data.groupChatTime;
      }
      listUser = Array.from(new Set(listUser));
      if(Array.isArray(listUser)) {
        if(listUser.length) {
          listUser.forEach(function(element) {
            arrAllUserGroup.push(element.user.id);
          });
        }
      }
      var dataReturn = {
                userId: socket.user.id,
                groupChatId: roomId,
                isAudio: isAudio,
                arrAllUserGroup: arrAllUserGroup,
                groupChatTime: groupChatTime
              };
      var index2 = listUserIds.indexOf(socket.user.id);
      if(index2!=-1){
         listUserIds.splice(index2, 1);
      }
      socketio.to("roomself_" + socket.user.id).emit('cancel-call-sucess', dataReturn);
      groupRooms[roomId]= [];
      firstAvailableRooms[roomId] = {};
      if(Array.isArray(listUser)) {
          if(listUser.length > 0) {
            listUser.forEach(function(element) {
                if(socket.user.id != element.user.id) {
                    socketio.to(element.id).emit('cancel-call', dataReturn);
                    var index = listUserIds.indexOf(element.user.id);
                    if(index!=-1){
                       listUserIds.splice(index, 1);
                    }
                }

            });
          }
      }
      listUserIds = listUserIds.filter(function(x){
        return (x !== (undefined || null || ''));
      });
      listUserIds = Array.from(new Set(listUserIds));
  });


  socket.on('usercall-cancel', function (data) {
      var roomId = data.groupChatId;
      var groupChatTime = "";
      if(typeof groupChatTime != 'undefined') {
         groupChatTime = data.groupChatTime;
      }
      listUserIds = listUserIds.filter(function(x){
        return (x !== (undefined || null || ''));
      });
      listUserIds = Array.from(new Set(listUserIds));
      var isAudio = data.isAudio;
      var arrUserCall = data.arrUser;
      var arrAllUserGroup = arrUserCall;
      arrAllUserGroup.push(socket.user.id);
      var dataReturn = {
          roomId: roomId,
          isAudio: isAudio,
          arrAllUserGroup: arrAllUserGroup,
          groupChatTime: groupChatTime
      };
      socketio.to(socket.id).emit('usercall-cancel-sucess', dataReturn);
      var token = socket.handshake.query.token;
      var index_primary = listUserIds.indexOf(socket.user.id);
      if(index_primary!=-1){
          listUserIds.splice(index_primary, 1);
      }
      arrUserCall.forEach(function(element) {
          if(socket.user.id != element) {
              var index3 = listUserIds.indexOf(element);
              if(index3!=-1){
                listUserIds.splice(index3, 1);
              }
              socketio.to("roomself_"+element).emit('usercall-cancel', dataReturn);
          }
          else {
            var indexpri = listUserIds.indexOf(element);
            if(indexpri!=-1){
                listUserIds.splice(indexpri, 1);
            }
          }
      });
      var dem = 0;
      arrUserCall.forEach(function(element) {
          if(socket.user.id != element) {

              if(isAudio) {
                var dataParam = {
                    "groupChatId": roomId,
                    "userCall": socket.user.id,
                    "userReceive": element,
                    "type": "miss-call",
                    "message": "Cuộc gọi lỡ"
                };
              }
              else {
                var dataParam = {
                    "groupChatId": roomId,
                    "userCall": socket.user.id,
                    "userReceive": element,
                    "type": "miss-video-call",
                    "message": "Cuộc gọi lỡ video"
                };
              }

              http.post(apiUrl+'chat/update-info-call', dataParam, {
                  "Authorization" :"Bearer " + token
              }).then(function (res) {

                  socketio.to("roomself_"+res.userReceive).emit('count-call-miss', {"groupChatId": roomId} );
                  var info = socket.user;
                  info.groupChatId = roomId;
                  socketio.to("roomself_"+res.userReceive).emit('alert-notification', info);
                  socketio.to("roomself_"+res.userReceive).emit('new-chat-message', res.detailMes);
                  console.log("nhan cuoc goi lo");
                  if(dem == 0) {
                        console.log("dem= 0");
                        socketio.to("roomself_"+socket.user.id).emit('new-chat-message', res.detailMes);

                  }
                  dem = 1;
              }).catch(function (err) {
                  return socket.emit('_error', {
                        event: 'update-miss-call',
                        msg: err.msg || 'Lỗi hệ thống',
                        data: data
                    });
              });
          }
      });
      listUserIds = listUserIds.filter(function(x){
        return (x !== (undefined || null || ''));
      });
      listUserIds = Array.from(new Set(listUserIds));

  });


  socket.on('disconnect', function () {
    if(!socket) {
      return true;
    }
    if(socket){
      if(typeof socket.user.id  == 'undefined') {
        return true;
      }
      var index2 = listUserIds.indexOf(socket.user.id);
      if(index2!=-1){
         listUserIds.splice(index2, 1);
      }
    }

    if (!currentRoom || !groupRooms[currentRoom] ) {
      return;
    }
    var virtualRoom = currentRoom;

    if(socket){
        var token = socket.handshake.query.token;
        var info = firstAvailableRooms[virtualRoom];
        if(info) {
          var userCall = info.model;
        }
        else {
          var userCall = '';
        }

        groupRooms[virtualRoom] = Array.from(new Set(groupRooms[virtualRoom]));
        var listUser = groupRooms[virtualRoom];
        var arrAllUserGroup  = [];
        if(Array.isArray(listUser)) {
          if(listUser.length) {
            listUser.forEach(function(element) {
              arrAllUserGroup.push(element.user.id);
            });
          }
        }
        var isAudio =true;
        var dataReturn = {
          userId: socket.user.id,
          groupChatId: virtualRoom,
          isAudio: isAudio,
          arrAllUserGroup: arrAllUserGroup
        };

        if( socket.user.id != userCall) {
            if(isAudio) {
              var dataParam = {
                  "groupChatId": virtualRoom,
                  "userCall": userCall,
                  "userReceive": socket.user.id,
                  "type": "comming-call",
                  "message": "Cuộc gọi đến"
              };
            }
            else {
              var dataParam = {
                  "groupChatId": virtualRoom,
                  "userCall": userCall,
                  "userReceive": socket.user.id,
                  "type": "comming-video-call",
                  "message": "Cuộc gọi đến video"
              };
            }
            listUser.forEach(function(element) {
              var index = listUserIds.indexOf(element.user.id);
              if(index!=-1){
                 listUserIds.splice(index, 1);
              }
              socketio.to("roomself_"+element.user.id).emit('leave-call', virtualRoom);
            });
            groupRooms[virtualRoom] = [];
            http.post(apiUrl+'chat/update-info-call', dataParam, {
                "Authorization" :"Bearer " + token
            }).then(function (res) {
                var data = res.data;

            }).catch(function (err) {
                return socket.emit('_error', {
                      event: 'update-info-call',
                      msg: err.msg || 'Lỗi hệ thống',
                      data: err
                  });
            });
        }
        else {
            listUser.forEach(function(element) {
              var index = listUserIds.indexOf(element.user.id);
              if(index!=-1){
                 listUserIds.splice(index, 1);
              }
              socketio.to("roomself_"+element.user.id).emit('leave-call', virtualRoom);
            });
            groupRooms[virtualRoom] = [];
        }
    }
    listUserIds = listUserIds.filter(function(x){
        return (x !== (undefined || null || ''));
    });
    listUserIds = Array.from(new Set(listUserIds));
  });

  socket.on('leave-call', function(data){
    var isAudio = data.isAudio;
    var groupChatId = data.groupChatId;
    var groupChatTime = data.groupChatTime;
    userIds[groupChatId] -= 1;
    var index2 = listUserIds.indexOf(socket.user.id);
    if(index2!=-1){
       listUserIds.splice(index2, 1);
    }
    if(socket){
        var token = socket.handshake.query.token;
        var info = firstAvailableRooms[groupChatId];
        groupRooms[groupChatId] = Array.from(new Set(groupRooms[groupChatId]));
        var listUser = groupRooms[groupChatId];
        var arrAllUserGroup  = [];
        if(Array.isArray(listUser)) {
          if(listUser.length > 0) {
            listUser.forEach(function(element) {
              arrAllUserGroup.push(element.user.id);
            });
          }
        }
        var dataReturn = {
              userId: socket.user.id,
              groupChatId: groupChatId,
              isAudio: isAudio,
              arrAllUserGroup: arrAllUserGroup,
              groupChatTime: groupChatTime
            };

        //leave-callsuceess
        socketio.to(socket.id).emit('leave-callsuccess', dataReturn);
        if(!info) {
          socketio.to("roomself_"+socket.user.id).emit('leave-call', dataReturn);
          return true;
        }
        var userCall = info.model;

        if( socket.user.id != userCall) {

            if(isAudio) {
              var dataParam = {
                  "groupChatId": groupChatId,
                  "userCall": userCall,
                  "userReceive": socket.user.id,
                  "type": "comming-call",
                  "message": "Cuộc gọi đến"
              };
            }
            else {
              var dataParam = {
                  "groupChatId": groupChatId,
                  "userCall": userCall,
                  "userReceive": socket.user.id,
                  "type": "comming-video-call",
                  "message": "Cuộc gọi đến video"
              };
            }
            listUser.forEach(function(element) {
              var index = listUserIds.indexOf(element.user.id);
              if(index!=-1){
                 listUserIds.splice(index, 1);
              }
              socketio.to("roomself_"+element.user.id).emit('leave-call', dataReturn);
            });
            groupRooms[groupChatId] = [];

            http.post(apiUrl+'chat/update-info-call', dataParam, {
                "Authorization" :"Bearer " + token
            }).then(function (res) {
                var data = res.data;


            }).catch(function (err) {
                return socket.emit('_error', {
                      event: 'update-info-call',
                      msg: err.msg || 'Lỗi hệ thống',
                      data: data
                  });
            });
        }
        else {

            listUser.forEach(function(element) {
                var index = listUserIds.indexOf(element.user.id);
                if(index!=-1){
                   listUserIds.splice(index, 1);
                }
                socketio.to("roomself_"+element.user.id).emit('leave-call', dataReturn);
            });


            listUser.forEach(function(element) {
                var index = listUserIds.indexOf(element.user.id);
                if(index!=-1){
                     listUserIds.splice(index, 1);
                }
                if(socket.user.id != element.user.id) {
                        if(isAudio) {
                            var dataParam = {
                                "groupChatId": groupChatId,
                                "userCall": userCall,
                                "userReceive": element.user.id,
                                "type": "comming-call",
                                "message": "Cuộc gọi đến"
                            };
                        }
                        else {
                          var dataParam = {
                              "groupChatId": groupChatId,
                              "userCall": userCall,
                              "userReceive": element.user.id,
                              "type": "comming-video-call",
                              "message": "Cuộc gọi đến video"
                          };
                        }
                        http.post(apiUrl+'chat/update-info-call', dataParam, {
                            "Authorization" :"Bearer " + token
                        }).then(function (res) {

                        }).catch(function (err) {
                            return socket.emit('_error', {
                                  event: 'update-info-call',
                                  msg: err.msg || 'Lỗi hệ thống',
                                  data: data
                              });
                        });

                }

            });
            groupRooms[groupChatId] = [];

        }
        groupRooms[groupChatId] = [];
    }
    listUserIds = listUserIds.filter(function(x){
        return (x !== (undefined || null || ''));
    });
    listUserIds = Array.from(new Set(listUserIds));
  });

  socket.on('status-camera', function(data){
    var groupChatTime = data.groupChatTime;
    var groupChatId = data.groupChatId;
    var camera = data.camera;
    if(typeof data.arrUser != 'undefined') {
        var arrUser = data.arrUser;
        arrUser.forEach(function(element) {
              socketio.to("roomself_"+element).emit('status-camera',  {"status": camera, "groupChatId":groupChatId, "groupChatTime": groupChatTime});
        });
    }
    else {
      var info = firstAvailableRooms[groupChatId];
      if(info) {
        var userCall = info.model;
      }
      else {
        var userCall = "";
      }

      if(userCall == socket.user.id) {
        socket.broadcast.to(groupChatTime).emit('status-camera',  {"status": camera, "groupChatId":groupChatId, "groupChatTime": groupChatTime});
      }
      else {
        var listUser = groupRooms[groupChatId];
        if(listUser.length > 0) {
            listUser.forEach(function(element) {
                if(element.user.id !=  socket.user.id) {
                  socketio.to("roomself_"+element.user.id).emit('status-camera',  {"status": camera, "groupChatId":groupChatId, "groupChatTime": groupChatTime});
                }
            });
        }

      }
    }


  });

  socket.on('swap-camera', function(data){
    var groupChatTime = data.groupChatTime;
    var groupChatId = data.groupChatId;
    var camera = data.camera;
    if(typeof data.arrUser != 'undefined') {
        var arrUser = data.arrUser;
        arrUser.forEach(function(element) {
              socketio.to("roomself_"+element).emit('swap-camera',   {"status": camera, "groupChatId":groupChatId, "groupChatTime": groupChatTime});
        });
    }
    else {
      var info = firstAvailableRooms[groupChatId];
      if(info) {
        var userCall = info.model;
      }
      else {
        var userCall = "";
      }

      if(userCall == socket.user.id) {
        socket.broadcast.to(groupChatTime).emit('swap-camera',  {"status": camera, "groupChatId":groupChatId, "groupChatTime": groupChatTime});
      }
      else {
        var listUser = groupRooms[groupChatId];
        if(listUser.length > 0) {
            listUser.forEach(function(element) {
                if(element.user.id !=  socket.user.id) {
                  socketio.to("roomself_"+element.user.id).emit('swap-camera',   {"status": camera, "groupChatId":groupChatId, "groupChatTime": groupChatTime});
                }
            });
        }

      }
    }


  });


  socket.on('count-call', function(){
      var token = socket.handshake.query.token;
      http.post(apiUrl+'chat/count-call', {}, {
                  "Authorization" :"Bearer " + token
              }).then(function (res) {
                  return socketio.to(socket.id).emit('count-call', res.data);

              }).catch(function (err) {
                  return socket.emit('_error', {
                        event: 'count-call',
                        msg: err.msg || 'Lỗi hệ thống',
                        data: err
                    });
      });
  });

  socket.on('set-count-call', function(){
      var token = socket.handshake.query.token;
      http.post(apiUrl+'chat/set-count-call', {}, {
                  "Authorization" :"Bearer " + token
              }).then(function (res) {
                  return socketio.to(socket.id).emit('set-count-call', res.data);

              }).catch(function (err) {
                  return socket.emit('_error', {
                        event: 'set-count-call',
                        msg: err.msg || 'Lỗi hệ thống',
                        data: err
                    });
      });
  });

  socket.on('check-has-call', function(data){
      var userId = data.userId;
      var index = listUserIds.indexOf(userId);
      if(index!=-1){
         return socketio.to(socket.id).emit('check-has-call', true);
      }
      return socketio.to(socket.id).emit('check-has-call', false);
  });


  socket.on('miss-call', function(data){
    var isAudio = data.isAudio;
    var groupChatId = data.groupChatId;
    userIds[groupChatId] -= 1;
    listUserIds = Array.from(new Set(listUserIds));

    groupRooms[groupChatId] = Array.from(new Set(groupRooms[groupChatId]));
    var listUser = groupRooms[groupChatId];
    var arrAllUserGroup  = [];
    if(Array.isArray(listUser)) {
      if(listUser.length) {
        listUser.forEach(function(element) {
          arrAllUserGroup.push(element.user.id);
        });
      }
    }

    if(socket){
        var token = socket.handshake.query.token;
        var info = firstAvailableRooms[groupChatId];
        if(typeof info.model != 'undefined') {
            var userCall = info.model;
        }
        else {
          var userCall = "";
        }

        var dataReturn = {
          userId: socket.user.id,
          groupChatId: groupChatId,
          isAudio: isAudio,
          arrAllUserGroup: arrAllUserGroup
        };
        socketio.to("roomself_"+socket.user.id).emit('leave-call', groupChatId);
        var index = listUser.indexOf(socket);
        if(index!=-1){
             groupRooms[groupChatId].splice(index, 1);
        }
        listUser.forEach(function(element) {
            var index = listUserIds.indexOf(element.user.id);
            if(index!=-1){
               listUserIds.splice(index, 1);
            }
            socketio.to("roomself_"+element.user.id).emit('leave-call', groupChatId);
        });

        listUser.forEach(function(element) {
          if(socket.user.id != element.user.id) {
              if(isAudio) {

                var dataParam = {
                    "groupChatId": groupChatId,
                    "userCall": userCall,
                    "userReceive": element.user.id,
                    "type": "miss-call",
                    "message": "Cuộc gọi lỡ"
                };
              }
              else {
                var dataParam = {
                    "groupChatId": groupChatId,
                    "userCall": userCall,
                    "userReceive": element.user.id,
                    "type": "miss-video-call",
                    "message": "Cuộc gọi lỡ video"
                };
              }

              http.post(apiUrl+'chat/update-info-call', dataParam, {
                  "Authorization" :"Bearer " + token
              }).then(function (res) {
                  socketio.to("roomself_"+element.user.id).emit('count-call-miss', {"groupChatId": groupChatId} );
                  socketio.to("roomself_"+element.user.id).emit('alert-notification', res.countCall);

              }).catch(function (err) {
                  return socket.emit('_error', {
                        event: 'update-info-call',
                        msg: err.msg || 'Lỗi hệ thống',
                        data: data
                    });
              });
          }

        });

    }
    groupRooms[groupChatId] = [];
    listUserIds = listUserIds.filter(function(x){
        return (x !== (undefined || null || ''));
    });
    listUserIds = Array.from(new Set(listUserIds));
  });
}
