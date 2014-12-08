define([
	'angular',
	'lodash'
], function (angular, _) {
	'use strict';

	return angular.module('ChatApp.services.Message', [])
		.factory('Message', [function () {
			var store = [
				{
					id: 1,
					user: 'Chris',
					message: 'Hello world'
				},
				{
					id: 2,
					user: 'Dave',
					message: 'Bro, not cool'
				},
				{
					id: 3,
					user: 'Chris',
					message: 'Whatever, bro'
				}
			];

			return {
				get: function (id) {
					return _.find(store, {id: id});
				},
				getAll: function () {
					return store;
				},
				add: function (obj) {
					var id = _.last(store).id + 1;

					obj.id = id;
					store.push(obj);

					return id;
				}
			};
		}]);
})