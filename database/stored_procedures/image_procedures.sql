DELIMITER $$

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

CREATE PROCEDURE sp_get_image(
    IN _image_id                VARCHAR(36)
)
BEGIN

    SELECT
        name,
        size,
        content,
        type
    FROM
        images 
    WHERE
        BIN_TO_UUID(image_id) = _image_id;

END $$

DELIMITER ;