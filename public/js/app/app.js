define([
    'angular',
    './config',
    './routes',
    './controllers/main'
], function (angular) {
    'use strict';

    return angular.module('ChatApp', [
            'ChatApp.config',
            'ChatApp.routes',
            'ChatApp.controllers'
        ]);
});
