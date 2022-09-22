<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Image;
use Fibi\Database\MainConnection;

class ImageRepository
{
    private MainConnection $connection;

    private const CREATE_IMAGE = "CALL sp_create_image(:imageId, :name, :size, :content, :type, :multimediaEntityId, :multimediaEntityType)";
    private const GET_IMAGE = "CALL sp_get_image(:imageId)";

    public function __construct() {
        $this->connection = new MainConnection();
    }

    public function create(Image $image) : bool
    {
        $result = $this->connection->executeNonQuery(self::CREATE_IMAGE, [
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
        $result = $this->connection->executeReader(self::GET_IMAGE, [
            "imageId"               => $imageId
        ]);
        
        return $result;
    }

    public function getLastInsertId() : ?int
    {
        return $this->connection->getLastInsertId();
    }
}

?>