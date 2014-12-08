require.config({
	paths: {
		'jquery': '../bower_components/jquery/dist/jquery',
		'angular': '../bower_components/angular/angular',
		'lodash': '../bower_components/lodash/dist/lodash',
		'ui-router': '../bower_components/angular-ui-router/release/angular-ui-router',
		'angular-websocket': '../bower_components/angular-websocket/angular-websocket',
		'text': '../bower_components/requirejs-text/text',
		'domReady': '../bower_components/requirejs-domready/domReady',
		'modernizr': '../bower_components/requirejs-modernizr/modernizr',
		'bootstrap': '../bower_components/bootstrap-sass-official/assets/javascripts/bootstrap'
	},
	shim: {
		'angular': {
			deps: ['jquery'],
			exports: 'angular'
		},
		'ui-router': {
			deps: ['angular']
		},
		'ng-websockets': {
			deps: ['angular']
		},
		'bootstrap': {
			deps: ['jquery']
		},
		'angular-websocket': {
			deps: ['angular']
		}
	}
});

require([
	'angular',
	'domReady',
	'app/app',
	'bootstrap'
], function (angular, domReady, app) {
	'use strict';

	domReady(function () {
		angular.bootstrap(document, [app.name]);
	});
});