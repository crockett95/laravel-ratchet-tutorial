define([
    'angular',
    'lodash',
    'angular-websocket'
], function (angular, _) {
    'use strict';

    return angular.module('ChatApp.services.ChatRoom', ['angular-websocket'])
        .factory('ChatRoom', ['WebSocket', function (WebSocket) {
            var messages = [],
                users = [],
                username;

            function sendWsMessage(type, message) {
                var body = JSON.stringify({
                    type: type,
                    data: message
                });

                WebSocket.send(body);
            }

            WebSocket.onmessage(function (event) {
                var body = JSON.parse(event.data);

                if ('undefined' === typeof _.find(users, {id: body.user.id})) {
                    users.push(body.user);
                }

                switch (body.message.type) {
                    case 'name':
                        _.find(users, {id: body.user.id}).name =
                            body.message.data;
                        break;

                    case 'message':
                        messages.push({
                            user: body.user.id,
                            message: body.message.data
                        });
                        break;
                }
            });

            return {
                getMessages: function () {
                    return messages;
                },
                sendMessage: function (message) {
                    messages.push({
                        user: 0,
                        message: message
                    });
                    sendWsMessage('message', message);
                },
                setUsername: function (name) {
                    username = name;
                    sendWsMessage('name', name);
                },
                getUsername: function (id) {
                    id = parseInt(id);
                    if (id === 0) return username || 'You';

                    return _.find(users, {id: id}).name;
                }
            };
        }]);
});