define([
	'angular',
	'angular-websocket'
], function (angular) {
	'use strict';

	return angular.module('ChatApp.config', ['angular-websocket'])
		.config(['WebSocketProvider', function (WebSocketProvider) {
			WebSocketProvider.prefix('')
				.uri('ws://127.0.0.1:7778');
		}]);
})