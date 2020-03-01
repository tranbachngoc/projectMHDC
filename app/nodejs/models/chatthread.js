'use strict';

module.exports = function(sequelize, DataTypes) {
  var ChatThread = sequelize.define('ChatThread', {
    type: DataTypes.ENUM('private', 'group', 'public'),
    //this is model id
    ownerId: {
      type: DataTypes.INTEGER(11).UNSIGNED ,

    },
    requesterId: {
      type: DataTypes.INTEGER(11).UNSIGNED ,

    },
    isStreaming: {
      type: DataTypes.BOOLEAN ,

    },
    lastStreamingTime: {
       type: DataTypes.DATE ,

    }

  }, {
    classMethods: {
    },
    tableName: 'chatthreads'
  });

  return ChatThread;
};
