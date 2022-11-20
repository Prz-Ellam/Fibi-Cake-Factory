DELIMITER $$
DROP PROCEDURE IF EXISTS sp_quotes_create $$

CREATE PROCEDURE sp_quotes_create(
    IN _quote_id                VARCHAR(36),
    IN _user_id                 VARCHAR(36),
    IN _product_id              VARCHAR(36)
)
BEGIN

    -- TOOD: Solo si el producto tiene la bandera is_quotable en TRUE, si no no
    INSERT INTO quotes(
        quote_id,
        user_id,
        product_id
    )
    VALUES(
        UUID_TO_BIN(_quote_id),
        UUID_TO_BIN(_user_id),
        UUID_TO_BIN(_product_id)
    );

END $$
DELIMITER ;



-- DELETE
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_quotes_delete $$

CREATE PROCEDURE sp_quotes_delete(
    IN _quote_id                VARCHAR(36)
)
BEGIN

    UPDATE
        quotes
    SET
        active = FALSE
    WHERE
        BIN_TO_UUID(quote_id) = _quote_id;

END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_quotes_get_user_pending $$

CREATE PROCEDURE sp_quotes_get_user_pending(
    IN _user_id                 VARCHAR(36)
)
BEGIN

    SELECT
        u.username,
        BIN_TO_UUID(u.profile_picture) `profile_picture`,
        p.name
    FROM
        quotes AS q
    INNER JOIN
        products AS p
    ON
        BIN_TO_UUID(q.product_id) = BIN_TO_UUID(p.product_id)
    INNER JOIN
        users AS u
    ON
        BIN_TO_UUID(q.user_id) = BIN_TO_UUID(u.user_id)
    WHERE
        BIN_TO_UUID(p.user_id) = _user_id;

END $$
DELIMITER ;