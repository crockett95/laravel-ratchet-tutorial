<?php

namespace Crockett95\RatchetChat;

use Illuminate\Support\ServiceProvider;
use Evenement\EventEmitter;
use Ratchet\Server\IoServer;

class RatchetChatServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('crockett95/ratchet-chat', 'chat');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('chat.emitter', function ()
        {
            return new EventEmitter();
        });

        $this->app->bind('chat', function ($app)
        {
            return new Chat(
                $app->make('chat.emitter'),
                $app
            );
        });

        $this->app->bindIf('chat.user', function ()
        {
            return new User();
        });

        $this->app->bind('chat.command.serve', function ($app)
        {
            return new Commands\Serve(
                $app->make('chat')
            );
        });

        $this->commands('chat.command.serve');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(
            'chat.emitter',
            'chat.user',
            'chat.command.serve'
        );
    }

}
