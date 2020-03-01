var request = require('request');

var service = {
    post: function (url, data, headers) {
        return new Promise(function(resolve, reject) {
            request({
                uri: url,
                headers: headers,
                method: 'POST',
                json: data
            }, function (err, body, data) {
                if (err || !data.data) {
                    return reject(data || err);
                }
                resolve(data);
            });
        });
    }
};

module.exports = service;
