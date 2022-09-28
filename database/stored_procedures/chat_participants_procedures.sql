-- Crear un participante para un chat
DELIMITER $$

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