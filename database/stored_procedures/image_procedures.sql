DELIMITER $$
DROP PROCEDURE IF EXISTS sp_create_image $$

CREATE PROCEDURE sp_create_image(
    IN _image_id                VARCHAR(36),
    IN _name                    VARCHAR(255),
    IN _size                    BIGINT,
    IN _content                 MEDIUMBLOB,
    IN _type                    VARCHAR(30),
    IN _multimedia_entity_id    VARCHAR(36),
    IN _multimedia_entity_type  VARCHAR(50)
)
BEGIN

    INSERT INTO images(
        image_id,
        name,
        size,
        content,
        type,
        multimedia_entity_id,
        multimedia_entity_type
    )
    VALUES(
        UUID_TO_BIN(_image_id),
        _name,
        _size,
        _content,
        _type,
        UUID_TO_BIN(_multimedia_entity_id),
        _multimedia_entity_type
    );

END $$

DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS sp_get_image $$

CREATE PROCEDURE sp_get_image(
    IN _image_id                VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(image_id) id,
        name,
        size,
        content,
        type,
        created_at
    FROM
        images 
    WHERE
        BIN_TO_UUID(image_id) = _image_id;

END $$

DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_delete_multimedia_entity_images $$

CREATE PROCEDURE sp_delete_multimedia_entity_images(
    IN _multimedia_entity_id            VARCHAR(36),
    IN _multimedia_entity_type          VARCHAR(50)
)
BEGIN

    DELETE FROM
        images
    WHERE
        BIN_TO_UUID(multimedia_entity_id) = _multimedia_entity_id
        AND multimedia_entity_type = _multimedia_entity_type;

END $$

DELIMITER ;