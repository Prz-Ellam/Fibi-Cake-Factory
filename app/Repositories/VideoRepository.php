<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Video;
use Fibi\Database\MainConnection;

class VideoRepository
{
    private MainConnection $connection;

    public function __construct() {
        $this->connection = new MainConnection();
    }

    public function create(Video $video) : bool
    {
        return true;
    }

    public function delete(string $videoId) : bool
    {
        return true;
    }
}

?>