<?php

namespace Fibi\Session;

interface Session
{
    public function start();

    public function id() : string;

    public function get(string $key) : mixed;

    public function set(string $ket, mixed $value) : self;

    public function has(string $key) : bool;

    public function unset(string $key) : self;

    public function destroy();
}

?>