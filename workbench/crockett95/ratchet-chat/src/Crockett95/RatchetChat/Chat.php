<?php

namespace Crockett95\RatchetChat;

use Evenement\EventEmitterInterface;
use Exception;
use Ratchet\ConnectionInterface;
use Illuminate\Foundation\Application;
use SplObjectStorage;

class Chat implements ChatInterface
{
    /**
     * The object storage for users
     *
     * @access  protected
     * @var     SplObjectStorage    $users
     */
    protected $users;

    /**
     * The emitter we're using
     *
     * @access  protected
     * @var     EventEmitterInterface   $emitter
     */
    protected $emitter;

    /**
     * Keep track of IDs used
     *
     * @access  protected
     * @var     int     $id
     */
    protected $id = 1;

    /**
     * Keep track of the Laravel application
     *
     * @access  protected
     * @var     Application     $app
     */
    protected $app;

    /**
     * Get the user associated with the socket
     *
     * @param   ConnectionInterface     $socket     The socket to search for
     * @return  User    The user associated with the socket
     */
    public function getUserBySocket(ConnectionInterface $socket)
    {
        foreach ($this->users as $user) {
            if ($user->getSocket() === $socket) return $user;
        }

        return null;
    }

    /**
     * Get the emitter for the chat
     *
     * @return  EventEmitterInterface   The emitter set on the object
     */
    public function getEmitter()
    {
        return $this->emitter;
    }

    /**
     * Sets a new emitter for the object
     *
     * @param   EventEmitterInterface   $emitter    The new emitter
     */
    public function setEmitter(EventEmitterInterface $emitter)
    {
        $this->emitter = $emitter;
    }

    /**
     * Get the users collection
     *
     * @return  SplObjectStorage    The users storage object
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Contructor
     *
     * @param   EventEmitterInterface   $emitter    The emitter to initialize with
     */
    public function __construct(
        EventEmitterInterface $emitter,
        Application $app
    ) {
        $this->setEmitter($emitter);
        $this->users = new SplObjectStorage();
        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $user = $this->app->make('chat.user');
        $user->setId($this->id++);

        $user->setSocket($conn);

        $this->users->attach($user);
        $this->emitter->emit('open', [$user]);
    }

    /**
     * {@inheritdoc}
     */
    public function onClose(ConnectionInterface $conn)
    {
        $user = $this->getUserBySocket($conn);

        if (null !== $user) {
            $this->users->detach($user);
            $this->emitter->emit('close', [$user]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function onError(
        ConnectionInterface $conn,
        Exception $e
    ) {
        $user = $this->getUserBySocket($conn);

        if (null !== $user) {
            $user->getSocket()->close();
            $this->emitter->emit('error', [$user, $e]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function onMessage(ConnectionInterface $from, $message)
    {
        $user = $this->getUserBySocket($from);
        $message = json_decode($message);

        switch ($message->type) {
            case 'name': {
                $user->setName($message->data);
                $this->emitter->emit('name', [
                    $user,
                    $message->data
                ]);

                break;
            }
            case 'message': {
                $this->emitter->emit('message', [
                    $user,
                    $message->data
                ]);

                break;
            }
        }

        foreach ($this->users as $other) {
            if ($user === $other) continue;

            $other->getSocket()->send(
                json_encode([
                    'user' => [
                        'id' => $user->getId(),
                        'name' => $user->getName()
                    ],
                    'message' => $message
                ])
            );
        }
    }

}