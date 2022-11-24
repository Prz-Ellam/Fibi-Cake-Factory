
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_create_shopping $$

CREATE PROCEDURE sp_create_shopping(
    IN _shopping_id             VARCHAR(36),
    IN _order_id                VARCHAR(36),
    IN _product_id              VARCHAR(36),
    IN _quantity                SMALLINT,
    IN _amount                  DECIMAL(15, 2)
)
BEGIN

    INSERT INTO shoppings(
        shopping_id,
        order_id,
        product_id,
        quantity,
        amount
    )
    VALUES(
        UUID_TO_BIN(_shopping_id),
        UUID_TO_BIN(_order_id),
        UUID_TO_BIN(_product_id),
        _quantity,
        _amount
    );

END $$

DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_shoppings_exists $$

CREATE PROCEDURE sp_shoppings_exists(
    IN _product_id              VARCHAR(36),
    IN _user_id                 VARCHAR(36)
)
BEGIN

    SELECT
        IF(COUNT(*) > 0, 1, 0) `status`
    FROM
        shoppings AS s
    INNER JOIN
        orders AS o
    WHERE
        BIN_TO_UUID(s.product_id) = _product_id
        AND BIN_TO_UUID(o.user_id) = _user_id;

END $$
DELIMITER ;