-- Crear un participante para un chat

CREATE PROCEDURE sp_create_chat_participant(
    IN _chat_participant_id             VARCHAR(36),
    IN _chat_id                         VARCHAR(36)
)