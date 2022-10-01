-- Crear un participante para un chat
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_create_chat_participant $$

CREATE PROCEDURE sp_create_chat_participant(
    IN _chat_participant_id         VARCHAR(36),
    IN _chat_id                     VARCHAR(36),
    IN _user_id                     VARCHAR(36)
)
BEGIN

    INSERT INTO chat_participants(
        chat_participant_id,
        chat_id,
        user_id
    )
    VALUES(
        UUID_TO_BIN(_chat_participant_id),
        UUID_TO_BIN(_chat_id),
        UUID_TO_BIN(_user_id)
    );

END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_chat_participants_find_by_user $$

CREATE PROCEDURE sp_chat_participants_find_by_user(
    IN _chat_id                 VARCHAR(36),
    IN _user_id                 VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(chat_participant_id) id
    FROM
        chat_participants
    WHERE
        BIN_TO_UUID(chat_id) = _chat_id
        AND BIN_TO_UUID(user_id) = _user_id;

END $$