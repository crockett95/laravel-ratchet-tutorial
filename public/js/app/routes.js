define([
	'angular',
	'text!./views/index.tmpl.html',
	'ui-router'
], function (
	angular,
	indexTemplate
) {
	'use strict';

	return angular.module('ChatApp.routes', [
			'ui.router'
		])
		.config([
			'$stateProvider',
			'$urlRouterProvider',
			function (
				$stateProvider,
				$urlRouterProvider
			) {
				$stateProvider.state('index', {
					url: '/',
					template: indexTemplate,
					controller: 'IndexCtrl'
				});

				$urlRouterProvider.otherwise('/');
			}
		]);
})