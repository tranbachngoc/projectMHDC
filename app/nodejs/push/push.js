/*let models  = require('../models');
var PushService = require('../push/push-service');
let Sequelize = require('sequelize');
var _ = require('lodash');
import config from '../config/environment';

module.exports = exports = {
    push: function(socket, status) {
        var sequelize = new Sequelize(config.db.database, config.db.username, config.db.password);
        //raw query
        sequelize.query('SELECT deviceToken FROM favorites as f, notificationdevices as n WHERE f.ownerId=n.userId and status = ? and favoriteId = ? and n.push = ? ',
          { replacements: ['like', socket.user.id, 'YES'], type: sequelize.QueryTypes.SELECT }
        ).then(function(devices) {
            if (devices) {
                var deviceIds = [];
                _.map(devices, function(item) {
                        if(!_.isEmpty(item.deviceToken)){
                            deviceIds.push(item.deviceToken);
                        }

                });

                //TODO process push notification here
                if(deviceIds.length > 0){
                    // deviceIds.push('dzGLIF-OOdQ:APA91bFyHD73qOk7eQgUeu4yiiCv1ZWqR7fiQ3prkczDDWNf85-MKeKGluJ-rHKOda7pGak3RgTw2ruUdy__SI6t0zHn-di602X9Ma2MH3CeZEQayP7F3lpKNkztowJs-u2rGzAtC6zF');
                    // deviceIds.push('ba53626d80367a411f8f6307a95c72a81332533881db64172f962266626804e9');
                    socket.user.status = status;
                     // Model_name is Live on Cam, Chat with me at Site_name
                    var message = (status == 'online') ? socket.user.firstName + ' ' + socket.user.lastName + ' is live on Cam, chat with me at xCams' : 'Model ' + socket.user.firstName + ' ' + socket.user.lastName + ' is offline.';
                    var data = {
                      title: message,
                      message: message,
                      titleIos: message,
                      otherfields: socket.user
                    };

                    PushService.send(deviceIds, data, function (result) {
                        console.log(result);
                    }, function(err){
                        console.log(err);
                    });



                }



            }
        });
    }
};
*/
