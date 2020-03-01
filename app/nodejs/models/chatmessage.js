'use strict';

module.exports = function(sequelize, DataTypes) {

  var ChatMessage = sequelize.define('ChatMessage', {
    type: DataTypes.ENUM('private', 'group', 'public'),
    ownerId: {
      type: DataTypes.INTEGER(11).UNSIGNED ,
      references:{
        model: 'tbtt_user'
      }
    },
    threadId: {
      type: DataTypes.INTEGER(11).UNSIGNED,

    },
    text: DataTypes.TEXT,
    typedata: DataTypes.TEXT
  }, {
    classMethods: {
    },
    tableName: 'chatmessages'
  });

  return ChatMessage;

};
