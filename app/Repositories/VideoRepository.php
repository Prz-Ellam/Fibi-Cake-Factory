<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Video;
use Fibi\Database\MainConnection;

class VideoRepository
{
    private MainConnection $connection;

    private const CREATE_VIDEO = "CALL sp_create_video(:videoId, :name, :size, :content, :type, :multimediaEntityId, :multimediaEntityType)";
    private const GET_VIDEO = "CALL sp_get_video(:videoId)";

    public function __construct() {
        $this->connection = new MainConnection();
    }

    public function create(Video $video) : bool
    {
        $result = $this->connection->executeNonQuery(self::CREATE_VIDEO, [
            "videoId"               => $video->getVideoId(),
            "name"                  => $video->getName(),
            "size"                  => $video->getSize(),
            "content"               => $video->getContent(),
            "type"                  => $video->getType(),
            "multimediaEntityId"    => $video->getMultimediaEntityId(),
            "multimediaEntityType"  => $video->getMultimediaEntityType()
        ]);

        return $result > 0;
    }

    public function delete(string $videoId) : bool
    {
        return true;
    }

    /**
     * Obtiene el video en base a su ID
     *
     * @param string $videoId
     * @return array
     */
    public function getVideo(string $videoId) : array
    {
        $result = $this->connection->executeReader(self::GET_VIDEO, [
            "videoId"               => $videoId
        ]);
        
        return $result;
    }
}

?>