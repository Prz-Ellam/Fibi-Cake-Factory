DELIMITER $$
DROP PROCEDURE IF EXISTS sp_quotes_create $$

CREATE PROCEDURE sp_quotes_create(
    IN _quote_id                VARCHAR(36),
    IN _user_id                 VARCHAR(36),
    IN _product_id              VARCHAR(36)
)
BEGIN

    IF NOT EXISTS (SELECT BIN_TO_UUID(`quote_id`) FROM `quotes` WHERE BIN_TO_UUID(`user_id`) = _user_id AND BIN_TO_UUID(`product_id`) = _product_id)
    THEN
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
    END IF;

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
        BIN_TO_UUID(q.quote_id) `quote_id`,
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
        BIN_TO_UUID(p.user_id) = _user_id
        AND q.price IS NULL;

END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_quotes_update $$

CREATE PROCEDURE sp_quotes_update(
    IN _quote_id                VARCHAR(36),
    IN _price                   DECIMAL(15, 2)
)
BEGIN

    UPDATE
        quotes
    SET
        price           = _price,
        modified_at     = NOW()
    WHERE
        BIN_TO_UUID(quote_id) = _quote_id;

END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_quotes_get_by_user_product $$

CREATE PROCEDURE sp_quotes_get_by_user_product(
    IN _user_id                 VARCHAR(36),
    IN _product_id              VARCHAR(36)
)
BEGIN

    SELECT
        COUNT(*) `count`
    FROM
        quotes
    WHERE
        BIN_TO_UUID(user_id) = _user_id
        AND BIN_TO_UUID(product_id) = _product_id;

END $$
DELIMITER ;