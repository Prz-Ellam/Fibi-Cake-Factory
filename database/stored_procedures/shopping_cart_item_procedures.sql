
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_add_shopping_cart_item $$

CREATE PROCEDURE sp_add_shopping_cart_item(
    IN _shopping_cart_item_id           VARCHAR(36),
    IN _shopping_cart_id                VARCHAR(36),
    IN _product_id                      VARCHAR(36),
    IN _quantity                        INT
)
BEGIN

    IF (EXISTS (SELECT 
                    BIN_TO_UUID(product_id) 
                FROM 
                    shopping_cart_items
                WHERE 
                    BIN_TO_UUID(product_id) = _product_id 
                    AND BIN_TO_UUID(shopping_cart_id) = _shopping_cart_id
                    AND active = TRUE
                )
    )
    THEN

        UPDATE
            shopping_cart_items
        SET
            quantity = IF(quantity < 100, quantity + _quantity, quantity)
        WHERE
            BIN_TO_UUID(product_id) = _product_id
            AND BIN_TO_UUID(shopping_cart_id) = _shopping_cart_id;

    ELSE

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
            _quantity
        );

    END IF;

    UPDATE
        products
    SET
        stock = stock - _quantity
    WHERE
        BIN_TO_UUID(product_id) = _product_id;

END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_update_shopping_cart_item $$

CREATE PROCEDURE sp_update_shopping_cart_item(
    IN _shopping_cart_item_id           VARCHAR(36),
    IN _quantity                        INT
)
BEGIN

    SET @quantity := (SELECT quantity FROM shopping_cart_items WHERE BIN_TO_UUID(shopping_cart_item_id) = _shopping_cart_item_id);
    SET @product_id := (SELECT BIN_TO_UUID(product_id) FROM shopping_cart_items WHERE BIN_TO_UUID(shopping_cart_item_id) = _shopping_cart_item_id);

    UPDATE
        shopping_cart_items
    SET
        quantity = IFNULL(_quantity, quantity)
    WHERE
        BIN_TO_UUID(shopping_cart_item_id) = _shopping_cart_item_id;

    UPDATE
        products
    SET
        stock = stock + @quantity - _quantity
    WHERE
        BIN_TO_UUID(product_id) = @product_id;

END $$
DELIMITER ;

SELECT * FROM products;

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
        BIN_TO_UUID(shopping_cart_item_id) = _shopping_cart_item_id;

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
DROP PROCEDURE IF EXISTS sp_get_shopping_cart_items $$

CREATE PROCEDURE sp_get_shopping_cart_items(
    IN _shopping_cart_id                 VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(sci.shopping_cart_item_id) id,
        BIN_TO_UUID(p.product_id) product_id,
        p.name,
        sci.quantity,
        p.price,
        BIN_TO_UUID(i.image_id) image
    FROM
        shopping_cart_items AS sci
    INNER JOIN
        products AS p
    ON
        BIN_TO_UUID(p.product_id) = BIN_TO_UUID(sci.product_id)
    INNER JOIN
        images AS i
    ON
        BIN_TO_UUID(p.product_id) = BIN_TO_UUID(i.multimedia_entity_id)
        AND i.multimedia_entity_type = 'products'
    WHERE
        BIN_TO_UUID(sci.shopping_cart_id) = _shopping_cart_id
        AND sci.active = TRUE
    GROUP BY
        sci.shopping_cart_item_id,
        p.product_id,
        p.name,
        sci.quantity,
        p.price;

END $$
DELIMITER ;