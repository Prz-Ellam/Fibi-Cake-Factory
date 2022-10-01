
DELIMITER $$
DROP TRIGGER IF EXISTS tr_create_shopping_cart_item $$

CREATE TRIGGER tr_create_shopping_cart_item
AFTER INSERT ON shopping_cart_items
FOR EACH ROW
BEGIN

    UPDATE
        products
    SET
        stock       = stock - NEW.quantity,
        modified_at = NOW()
    WHERE
        BIN_TO_UUID(product_id) = BIN_TO_UUID(NEW.product_id);

END $$
DELIMITER ;


SELECT * FROM orders;