<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Image;
use Fibi\Database\DB;

class ImageRepository
{
    private const CREATE_IMAGE = "CALL sp_create_image(:imageId, :name, :size, :content, :type, :multimediaEntityId, :multimediaEntityType)";
    private const GET_IMAGE = "CALL sp_get_image(:imageId)";
    private const DELETE_MULTIMEDIA_ENTITY_IMAGES = "CALL sp_delete_multimedia_entity_images(:multimedia_entity_id, :multimedia_entity_type)";

    public function create(Image $image) : bool
    {
        $result = DB::executeNonQuery(self::CREATE_IMAGE, [
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
        $result = DB::executeReader(self::GET_IMAGE, [
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

?>