
DELIMITER $$

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


