'use strict';

module.exports = function(sequelize, DataTypes) {
  var ChatThreadUser = sequelize.define('ChatThreadUser', {
    threadId: {
      type: DataTypes.INTEGER(11).UNSIGNED,
      references: {
        model: 'ChatThread'
      }
    },
    userId: {
      type: DataTypes.INTEGER(11).UNSIGNED

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
    tableName: 'chatthreaduser'
  });

  return ChatThreadUser;
};
