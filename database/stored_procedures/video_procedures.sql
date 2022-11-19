
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_create_video $$
-- TODO: El tema de los is_quotable
CREATE PROCEDURE sp_create_video(
    IN _video_id                VARCHAR(36),
    IN _name                    VARCHAR(255),
    IN _size                    BIGINT,
    IN _content                 LONGBLOB,
    IN _type                    VARCHAR(30),
    IN _multimedia_entity_id    VARCHAR(36),
    IN _multimedia_entity_type  VARCHAR(50)
)
BEGIN

    INSERT INTO videos(
            video_id,
            name,
            size,
            content,
            type,
            multimedia_entity_id,
            multimedia_entity_type
    )
    VALUES(
            UUID_TO_BIN(_video_id),
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
DROP PROCEDURE IF EXISTS sp_get_video $$

CREATE PROCEDURE sp_get_video(
    IN _video_id                VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(video_id) id,
        name,
        size,
        content,
        type,
        created_at
    FROM
        videos 
    WHERE
        BIN_TO_UUID(video_id) = _video_id;

END $$

DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_delete_multimedia_entity_videos $$

CREATE PROCEDURE sp_delete_multimedia_entity_videos(
    IN _multimedia_entity_id            VARCHAR(36),
    IN _multimedia_entity_type          VARCHAR(50)
)
BEGIN

    DELETE FROM
        videos
    WHERE
        BIN_TO_UUID(multimedia_entity_id) = _multimedia_entity_id
        AND multimedia_entity_type = _multimedia_entity_type;

END $$
DELIMITER ;