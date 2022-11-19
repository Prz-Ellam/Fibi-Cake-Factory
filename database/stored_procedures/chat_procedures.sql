-- Crear un chat
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_create_chat $$

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




-- Busca el id de un chat de dos usuarios si existe
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_chats_find_one_by_users $$

CREATE PROCEDURE sp_chats_find_one_by_users(
    IN _user_id_1               VARCHAR(36),
    IN _user_id_2               VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(c.chat_id) AS id,
        COUNT(BIN_TO_UUID(cp.chat_participant_id)) = 2 AS `exists`
    FROM
        chats AS c
    INNER JOIN
        chat_participants AS cp
    ON
        c.chat_id = cp.chat_id
    WHERE
        BIN_TO_UUID(cp.user_id) = _user_id_1
        OR BIN_TO_UUID(cp.user_id) = _user_id_2
    GROUP BY
        c.chat_id
    HAVING
        COUNT(BIN_TO_UUID(cp.chat_participant_id)) = 2;

END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_find_or_create_chat $$

CREATE PROCEDURE sp_find_or_create_chat(
    IN _chat_id                 VARCHAR(36),
    IN _user_id_1               VARCHAR(36),
    IN _user_id_2               VARCHAR(36)
)
BEGIN

    INSERT INTO chats(
        chat_id
    )
    VALUES(
        UUID_TO_BIN(_chat_id)
    );
    
    INSERT INTO chat_participants(
        chat_participant_id,
        chat_id,
        user_id
    )
    VALUES(
        UUID_TO_BIN(UUID()),
        UUID_TO_BIN(_chat_id),
        UUID_TO_BIN(_user_id_1)
    ),(
        UUID_TO_BIN(UUID()),
        UUID_TO_BIN(_chat_id),
        UUID_TO_BIN(_user_id_2)
    );

END $$
DELIMITER ;




DELIMITER $$
DROP PROCEDURE IF EXISTS sp_get_recent_chats $$

CREATE PROCEDURE sp_get_recent_chats(
    IN _user_id                 VARCHAR(36)
)
BEGIN

    SELECT
        u.email,
        u.username, 
        BIN_TO_UUID(u.profile_picture) 'profile-picture', 
        cs.chat_id 'chat-id', 
        cs.last_message 'last-message'
    FROM users AS u
    INNER JOIN
    (SELECT
    GROUP_CONCAT(DISTINCT
        IF(BIN_TO_UUID(cp.user_id) = _user_id, null, BIN_TO_UUID(cp.user_id)
    )) user_id,
    BIN_TO_UUID(cp.chat_id) chat_id,
    MAX(cm.created_at) AS last_message
    FROM chat_participants AS cp
    LEFT JOIN chat_messages AS cm
    ON BIN_TO_UUID(cp.chat_participant_id) = BIN_TO_UUID(cm.chat_participant_id)
    WHERE BIN_TO_UUID(cp.chat_id) IN
    (
        SELECT BIN_TO_UUID(chat_id) chat_id
        FROM chat_participants
        WHERE BIN_TO_UUID(user_id) = _user_id
    )
    GROUP BY
        chat_id
    HAVING
        COUNT(cm.chat_message_id) > 0) AS cs
    ON 
        BIN_TO_UUID(u.user_id) = cs.user_id
    ORDER BY 
        cs.last_message DESC;

END
DELIMITER ;