<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Image;
use Fibi\Database\DB;

class ImageRepository
{
    private const CREATE = "CALL sp_create_image(:imageId, :name, :size, :content, :type, :multimediaEntityId, :multimediaEntityType)";
    private const GET_ONE = "CALL sp_get_image(:imageId)";
    private const DELETE_MULTIMEDIA_ENTITY_IMAGES = "CALL sp_delete_multimedia_entity_images(:multimedia_entity_id, :multimedia_entity_type)";

    /**
     * Undocumented function
     *
     * @param Image $image
     * @return boolean
     * @throws PDOException Si falla el query
     */
    public function create(Image $image) : bool
    {
        $result = DB::executeNonQuery(self::CREATE, [
            "imageId"               => $image->getImageId(),
            "name"                  => $image->getName(),
            "size"                  => $image->getSize(),
            "content"               => $image->getContent(),
            "type"                  => $image->getType(),
            "multimediaEntityId"    => $image->getMultimediaEntityId(),
            "multimediaEntityType"  => $image->getMultimediaEntityType()
        ]);

        return $result > 0;
    }

    public function getImage(string $imageId) : array
    {
        $result = DB::executeReader(self::GET_ONE, [
            "imageId"               => $imageId
        ]);
        
        return $result;
    }

    public function deleteMultimediaEntityImages(string $multimediaEntityId, string $multimediaEntityType)
    {
        $result = DB::executeNonQuery(self::DELETE_MULTIMEDIA_ENTITY_IMAGES, [
            "multimedia_entity_id"      => $multimediaEntityId,
            "multimedia_entity_type"    => $multimediaEntityType
        ]);

        return $result > 0;
    }
}
