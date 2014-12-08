define([
	'angular',
	'angular-websocket'
], function (angular) {
	'use strict';

	return angular.module('ChatApp.config', ['angular-websocket'])
		.config(['WebSocketProvider', function (WebSocketProvider) {
			WebSocketProvider.prefix('')
				.uri('ws://' + window.location.hostname + ':7778');
		}]);
})