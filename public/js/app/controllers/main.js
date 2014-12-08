define([
	'angular',
	'./index'
], function (angular) {
	'use strict';

	return angular.module('ChatApp.controllers', [
		'ChatApp.controllers.index'
	]);
});
