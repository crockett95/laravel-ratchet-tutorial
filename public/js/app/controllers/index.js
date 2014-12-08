define([
    'angular',
    '../services/chatroom'
], function (angular) {
    'use strict';

    return angular.module('ChatApp.controllers.index', [
            'ChatApp.services.ChatRoom'
        ])
        .controller('IndexCtrl', [
            '$scope',
            'ChatRoom',
            function (
                $scope,
                ChatRoom
            ) {
                $scope.messages = ChatRoom.getMessages();

                $scope.nameSet = false;
                $scope.setName = function () {
                    ChatRoom.setUsername($scope.name);
                    $scope.nameSet = true;
                };

                $scope.sendMessage = function () {
                    ChatRoom.sendMessage($scope.messageBox);
                    $scope.messageBox = '';
                }

                $scope.getName = ChatRoom.getUsername;
            }]);
});
