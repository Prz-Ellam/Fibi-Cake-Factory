DELIMITER $$
DROP PROCEDURE IF EXISTS sp_quotes_create $$

CREATE PROCEDURE sp_quotes_create(
    IN _quote_id                VARCHAR(36),
    IN _seller_id               VARCHAR(36),
    IN _shopper_id              VARCHAR(36),
    IN _product_id              VARCHAR(36),
    IN _price                   DECIMAL(15, 2)
)
BEGIN

    -- TOOD: Solo si el producto tiene la bandera is_quotable en TRUE, si no no
    INSERT INTO quotes(
        quote_id,
        seller_id,
        shopper_id,
        product_id,
        price
    )
    VALUES(
        UUID_TO_BIN(_quote_id),
        UUID_TO_BIN(_seller_id),
        UUID_TO_BIN(_shopper_id),
        UUID_TO_BIN(_product_id),
        _price
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