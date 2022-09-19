<?php

namespace Fibi\Session;

class PhpSession implements Session
{
    public function __construct() {
        $this->start();
    }

    public function start()
    {
        session_start();
    }

    public function id() : string
    {
        return session_id();
    }

    public function get(?string $key = null) : mixed
    {
        if (is_null($key))
        {
            return $_SESSION;
        }

        return $_SESSION[$key] ?? null;
    }

    public function set(string $key, mixed $value) : self
    {
        $_SESSION[$key] = $value;
        return $this;
    }

    public function has(string $key) : bool
    {
        return isset($_SESSION[$key]);
    }

    public function unset(string $key) : self
    {
        unset($_SESSION[$key]);
        return $this;
    }

    public function destroy()
    {
        session_destroy();
    }
}

?>