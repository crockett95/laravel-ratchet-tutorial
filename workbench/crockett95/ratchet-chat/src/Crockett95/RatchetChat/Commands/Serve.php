<?php

namespace Crockett95\RatchetChat\Commands;

use Illuminate\Console\Command;
use Crockett95\RatchetChat\ChatInterface;
use Crockett95\RatchetChat\UserInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputAction;

class Serve extends Command
{

    /**
     * The name for the command
     *
     * @access  protected
     * @var     string  $name
     */
    protected $name = 'chat:serve';

    /**
     * The name of the command on the list
     *
     * @access  protected
     * @var     string  $description
     */
    protected $description = 'Start the chat server';

    /**
     * The chat instance
     *
     * @access  protected
     * @var     ChatInterface   $chat
     */
    protected $chat;

    /**
     * Constructor
     *
     * @param   ChatInterface   $chat   The chat instance
     */
    public function __construct(ChatInterface $chat)
    {
        parent::__construct();

        $this->chat = $chat;

        $open = function (UserInterface $user) {
            $name = $this->getUserName($user);

            $this->line("<info>$name connected.</info>");
        };
        $this->chat->getEmitter()->on('open', $open);

        $close = function (UserInterface $user) {
            $name = $this->getUserName($user);

            $this->line("<info>$name disconnected.</info>");
        };
        $this->chat->getEmitter()->on('close', $close);

        $message = function (UserInterface $user, $message) {
            $name = $this->getUserName($user);

            $this->line(
                "<info>New message from $name: </info>" .
                "<comment>$message</comment>" .
                "<info>.</info>"
            );
        };
        $this->chat->getEmitter()->on('message', $message);

        $name = function (UserInterface $user, $message) {
            $this->line(
                "<info>User changed their name to: </info>" .
                "<comment>$message</comment>" .
                "<info>.</info>"
            );
        };
        $this->chat->getEmitter()->on('name', $name);

        $error = function (UserInterface $user, \Exception $exception) {
            $message = $exception->getMessage();
            \Log::error($exception);
            $this->line(
                "<info>User encountered an exception: </info>" .
                "<comment>$message</comment>" .
                "<info>.</info>"
            );
        };
        $this->chat->getEmitter()->on('error', $error);
    }

    /**
     * Get the username display for the console
     *
     * @param   UserInterface   $user   The user
     */
    protected function getUserName(UserInterface $user)
    {
        $suffix = " ({$user->getId()})";

        if ($user->getName()) {
            return $user->getName() . $suffix;
        }

        return 'User' . $suffix;
    }

    /**
     * Fire the command
     */
    public function fire()
    {
        $port = intval($this->option('port'));

        if (!$port) $port = 7778;

        $server = IoServer::factory(
            new HttpServer(
                new WsServer($this->chat)
            ),
            $port
        );

        $this->line(
            "<info>Listening on port </info>" .
            "<comment>$port</comment>" .
            "<info>.</info>"
        );

        $server->run();
    }

    /**
     * Return the options for the command
     *
     * @return  array   Options available
     */
    protected function getOptions()
    {
        return array(
            array(
                "port",
                null,
                InputOption::VALUE_REQUIRED,
                "Port to listen on.",
                null
            )
        );
    }

}
