-- Crear un chat
DELIMITER $$

CREATE PROCEDURE sp_create_chat(
    IN _chat_id                 VARCHAR(36)
)
BEGIN

    INSERT INTO chats(
        chat_id
    )
    VALUES(
        UUID_TO_BIN(_chat_id)
    );

END $$

DELIMITER ;




CREATE PROCEDURE sp_get_user_chats()