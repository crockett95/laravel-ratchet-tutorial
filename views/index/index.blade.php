<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel 4 Chat</title>
    {{ HTML::style('css/main-build.css') }}
    {{ HTML::script('bower_components/modernizr/modernizr.js') }}
</head>
<body>
	<div class="container">
		<header class="page-header">
			<h1>Laravel 4 Chat</h1>
		</header>
		<main ui-view></main>
	</div>
	{{ HTML::script('bower_components/requirejs/require.js', ['data-main' => '/js/main']) }}
</body>
</html>