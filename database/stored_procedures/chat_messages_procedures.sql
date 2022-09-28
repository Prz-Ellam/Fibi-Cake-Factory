


DELIMITER $$

CREATE PROCEDURE sp_create_chat_message(
    IN _chat_message_id             VARCHAR(36),
    IN _chat_participant_id         VARCHAR(36),
    IN _message_content             VARCHAR(255)
)
BEGIN

    INSERT INTO chat_messages(
        chat_message_id,
        chat_participant_id,
        message_content
    )
    VALUES(
        UUID_TO_BIN(_chat_message_id),
        UUID_TO_BIN(_chat_participant_id),
        _message_content
    );

END $$

DELIMITER ;


CREATE PROCEDURE sp_update_message(
    IN _chat_id                 VARCHAR(36),
    IN _chat_participant_id     VARCHAR(36),
    IN _message                 VARCHAR(255)
)
BEGIN


END $$


CREATE PROCEDURE sp_delete_message(
    IN _chat_id                 VARCHAR(36)
)
BEGIN


END $$




CREATE PROCEDURE sp_get_messages_from_chat(
    IN _chat_id             VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(cm.chat_message_id) id,
        BIN_TO_UUID(cm.chat_participant_id) user,
        cm.message_content content,
        cm.created_at
    FROM
        chat_messages AS cm
    INNER JOIN
        chat_participants AS cp
    ON
        BIN_TO_UUID(cm.chat_participant_id) = BIN_TO_UUID(cp.chat_participant_id)
    WHERE
        BIN_TO_UUID(cp.chat_id) = _chat_id
        AND cm.active = TRUE
    ORDER BY
        cm.created_at ASC;

END $$