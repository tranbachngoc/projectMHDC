var models  = require('../models');
var Queue = require('../components/Queue')
import config from './../config/environment';
var apiUrl = config.apiUrl;
var http = require('../components/Http');

export function register(socket, socketio) {
  //create new message
  socket.on('new-chat-message', function(body) {
    //TODO - store to DB then emit to client
    // if isset user save user id else it is anonymous save 0
    //io.sockets.in('foobar').emit('message', 'anyone in this room yet?');
    var width = 0;
    var height = 0;
    var size = "";
    var caption = "";
    var timeDelete = 0;
    var productId = 0;
    var message_repeat = 0;
    var content_repeat = "";
    var time_repeat = 0;
    var share_lat = 0;
    var share_lng = 0;
    var share_time = 0;


    if(typeof body.productId != 'undefined') {
      productId = body.productId;
    }
    if(typeof body.timeDelete != 'undefined') {
      timeDelete = body.timeDelete;
    }
    if(typeof body.width != 'undefined') {
      width = body.width;
    }
    if(typeof body.height != 'undefined') {
      height = body.height;
    }
    if(typeof body.size != 'undefined') {
      size = body.size;
    }
    var listImage = [];
    if(typeof body.listImage != 'undefined') {
      listImage = body.listImage;
    }

    if(typeof body.caption != 'undefined') {
      caption = body.caption;
    }

    if(typeof body.message_repeat != 'undefined') {
      message_repeat = body.message_repeat;
    }

    if(typeof body.content_repeat != 'undefined') {
      content_repeat = body.content_repeat;
    }

    if(typeof body.time_repeat != 'undefined') {
      time_repeat = body.time_repeat;
    }

    if(typeof body.share_lat != 'undefined') {
      share_lat = body.share_lat;
    }
    if(typeof body.share_lng != 'undefined') {
      share_lng = body.share_lng;
    }
    if(typeof body.share_time != 'undefined') {
      share_time = body.share_time;
    }
    var element = null;
    if(typeof body.element != 'undefined') {
      element = body.element;
    }

    if(socket.user){
      var message = {
        type: body.type,
        ownerId: socket.user.id,
        threadId: body.roomId,
        text: body.text,
        typedata: body.typedata,
        messageId: body.messageId,
        width: width,
        height: height,
        size: size,
        listImage: listImage,
        caption: caption,
        timeDelete: timeDelete,
        productId: productId,
        message_repeat: message_repeat,
        content_repeat: content_repeat,
        time_repeat:time_repeat,
        share_lat: share_lat,
        share_lng: share_lng,
        share_time: share_time,
        element: element

      };

      var token = socket.handshake.query.token;
      http.post(apiUrl+'chat/send-message', message, {
          "Authorization" :"Bearer " + token
      }).then(function (res) {
          var arrUser = res.arrUser;
          if(res.condGroup == 1) {
            arrUser.forEach(function(element) {
                var datareturn  = res.data;
                if(datareturn['parentMessId'] != 0) {
                  if( datareturn['ownerId'] != element) {
                    if(datareturn['message_repeat'] == 0) {
                      datareturn['status_repeat'] = 0;
                     }
                     else {
                        datareturn['status_repeat'] = 1;
                     }
                  }
                  else {
                    datareturn['status_repeat'] = 0;
                  }
                }
                else {
                  if( (datareturn['parentMessId']) == 0 && (datareturn['ownerId'] != element) && ( datareturn['message_repeat'] == 1) ) {
                      datareturn['status_repeat'] = 1;
                  }
                  else {
                    datareturn['status_repeat'] = 0;
                  }
                }

                if( typeof res.arrAlias[element] != 'undefined') {
                    datareturn['use_fullname'] = res.arrAlias[element];
                }
                socketio.to("roomself_"+element).emit('new-chat-message', datareturn);
                if(res.type == 'private' || res.type == 'secret') {
                    socketio.to("roomself_"+element).emit('count-message', res.arrCountMessage[element]);
                }
                else {
                  socketio.to("roomself_"+element).emit('count-invite', res.arrCountMessage[element]);
                }

            });
            arrUser.forEach(function(element) {
                if( typeof res.dataDefault[element] != 'undefined') {
                  socketio.to("roomself_"+element).emit('new-chat-message', res.dataDefault[element]);
                  socketio.to("roomself_"+element).emit('count-message', parseInt(res.arrCountMessage[element]) + 1);

                }
            });
          }
          else {
              arrUser.forEach(function(element) {
                  if( typeof res.dataDefault[element] != 'undefined') {
                    socketio.to("roomself_"+element).emit('new-chat-message', res.dataDefault[element]);
                    socketio.to("roomself_"+element).emit('count-message', res.arrCountMessage[element]);

                  }
                  else {
                    var datareturn  = res.data;
                    if(datareturn['parentMessId'] != 0) {
                       if( datareturn['ownerId'] != element) {
                         if(datareturn['message_repeat'] == 0) {
                          datareturn['status_repeat'] = 0;
                         }
                         else {
                            datareturn['status_repeat'] = 1;
                         }

                        }
                        else {
                          datareturn['status_repeat'] = 0;
                        }
                    }
                    else {
                      if( (datareturn['parentMessId']) == 0 && (datareturn['ownerId'] != element) && ( datareturn['message_repeat'] == 1) ) {
                          datareturn['status_repeat'] = 1;
                      }
                      else {
                        datareturn['status_repeat'] = 0;
                      }
                    }
                    if( typeof res.arrAlias[element] != 'undefined') {
                        datareturn['use_fullname'] = res.arrAlias[element];
                    }
                    socketio.to("roomself_"+element).emit('new-chat-message', datareturn);
                    if(res.type == 'private' || res.type == 'secret') {
                        socketio.to("roomself_"+element).emit('count-message', res.arrCountMessage[element]);
                    }
                    else {
                      socketio.to("roomself_"+element).emit('count-invite', res.arrCountMessage[element]);
                    }

                  }
              });
          }
          return true;
          //socketio.sockets.in(body.roomId).emit('new-chat-message', res.data);
          /*var data = res.data;
          socket.broadcast.to(data.threadId).emit('create-room', data);
          return socket.emit('createRoomSuccess', data);*/
      }).catch(function (err) {
          console.log(err);
          return socket.emit('_error', {
                event: 'send-message',
                msg: err.msg || 'Lỗi hệ thống',
                data: err.msg
            });
      });

      /*Queue.create('CREATE_DB', {
        model: 'ChatMessage',
        data: message,
        flag: true
      }).save();



      var object = {
          message: message,
          text: body.text,
          typedata: body.typedata,
          createdAt: new Date(),
          username: socket.user.username,
          userId: socket.user.id,

        };

      socketio.sockets.in(body.roomId).emit('new-chat-message', object);

      /*socket.broadcast.in(body.roomId).emit('new-chat-message', {
        message: message,
        text: body.text,
        typedata: body.typedata,
        createdAt: new Date(),
        username: socket.user.username,
        userId: socket.user.id,

      });
      */
    }
  });

  socket.on('set-count-message', function(dataRequest){
      var token = socket.handshake.query.token;
      http.post(apiUrl+'chat/set-count-call', dataRequest, {
            "Authorization" :"Bearer " + token
        }).then(function (res) {
            return socketio.to(socket.id).emit('set-count-call', res.data);

        }).catch(function (err) {
            return socket.emit('_error', {
                  event: 'set-count-message',
                  msg: err.msg || 'Lỗi hệ thống',
                  data: err
              });
      });
  });
}
