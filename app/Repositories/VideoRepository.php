<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Video;
use Fibi\Database\DB;

class VideoRepository
{
    private const CREATE_VIDEO = "CALL sp_create_video(:videoId, :name, :size, :content, :type, :multimediaEntityId, :multimediaEntityType)";
    private const GET_ONE = "CALL sp_get_video(:videoId)";

    public function create(Video $video) : bool
    {
        return DB::executeNonQuery(self::CREATE_VIDEO, [
            "videoId"               => $video->getVideoId(),
            "name"                  => $video->getName(),
            "size"                  => $video->getSize(),
            "content"               => $video->getContent(),
            "type"                  => $video->getType(),
            "multimediaEntityId"    => $video->getMultimediaEntityId(),
            "multimediaEntityType"  => $video->getMultimediaEntityType()
        ]) > 0;
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
        $result = DB::executeReader(self::GET_ONE, [
            "videoId"               => $videoId
        ]);
        
        return $result;
    }
}

?>