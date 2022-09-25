DELIMITER $$

CREATE PROCEDURE sp_add_shopping_cart_item(
    IN _shopping_cart_item_id           VARCHAR(36),
    IN _shopping_cart_id                VARCHAR(36),
    IN _product_id                      VARCHAR(36),
    IN _quantity                        SMALLINT
)
BEGIN

    INSERT INTO shopping_cart_items(
        shopping_cart_item_id,
        shopping_cart_id,
        product_id,
        quantity
    )
    VALUES(
        UUID_TO_BIN(_shopping_cart_item_id),
        UUID_TO_BIN(_shopping_cart_id),
        UUID_TO_BIN(_product_id),
        quantity
    );

END $$
DELIMITER ;



DELIMITER $$

CREATE PROCEDURE sp_delete_shopping_cart_item(
    IN _shopping_cart_item_id           VARCHAR(36)
)
BEGIN

    UPDATE
        shopping_cart_items
    SET
        active = FALSE
    WHERE
        BIN_TO_UUID(shopping_cart_item_id) = _shopping_cart_id;

END $$
DELIMITER ;



DELIMITER $$

CREATE PROCEDURE sp_add_quantity_shopping_cart_item(
    IN _shopping_cart_item          VARCHAR(36),
    IN _quantity                    SMALLINT
)
BEGIN


END $$
DELIMITER ;



DELIMITER $$

CREATE PROCEDURE sp_get_shopping_cart_items(
    IN _shopping_cart_id                 VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(sci.shopping_cart_item_id) id,
        BIN_TO_UUID(p.product_id) product_id,
        p.name,
        sci.quantity,
        p.price
    FROM
        shopping_cart_items AS sci
    INNER JOIN
        products AS p
    ON
        BIN_TO_UUID(p.product_id) = BIN_TO_UUID(sci.product_id);

END $$
DELIMITER ;