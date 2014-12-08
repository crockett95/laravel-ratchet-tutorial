/* jshint node: true */

module.exports = function (grunt) {
	require('load-grunt-tasks')(grunt);
	require('time-grunt');

	grunt.initConfig({
		sass: {
			options: {
				unixNewlines: true,
				sourcemap: 'auto',
				style: 'nested',
				loadPath: 'public/bower_components'
			},
			main: {
				files: [{
					expand: true,
					cwd: 'public/scss',
					src: ['*.{scss,sass}'],
					dest: 'public/css',
					ext: '-build.css'
				}]
			}
		},
		watch: {
			sass: {
				files: ['public/scss/**/*.{scss,sass}'],
				tasks: ['sass:main']
			}
		}
	})
}