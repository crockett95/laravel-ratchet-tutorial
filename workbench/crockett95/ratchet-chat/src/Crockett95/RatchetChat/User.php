<?php

namespace Crockett95\RatchetChat;

use Ratchet\ConnectionInterface;

class User implements UserInterface
{

    /**
     * The user's connection
     *
     * @access  protected
     * @var     ConnectionInterface     $socket
     */
    protected $socket;

    /**
     * The user's id
     *
     * @access  protected
     * @var     int     $id
     */
    protected $id;

    /**
     * The user's name
     *
     * @access  protected
     * @var     string  $name
     */
    protected $name;

    /**
     * Return the user's connection
     *
     * @return  ConnectionInterface     The user's connection
     */
    public function getSocket()
    {
        return $this->socket;
    }

    /**
     * Set the user's connection
     *
     * @param   ConnectionInterface     $socket     The user's connection
     * @return  User    The user instance for chaining
     */
    public function setSocket(ConnectionInterface $socket)
    {
        $this->socket = $socket;
        return $this;
    }

    /**
     * Return the user's ID
     *
     * @return  int     The user's ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the user's ID
     *
     * @param   int     $id     The user's ID
     * @return  User    The user instance for chaining
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Return the user's name
     *
     * @return  string  The user's name
     */
    public function getName()
    {
        return $this->name ?: "User {$this->id}";
    }

    /**
     * Set the user's name
     *
     * @param   string  $name   The user's name
     * @return  User    The user instance for chaining
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

}