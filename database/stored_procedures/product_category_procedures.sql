DELIMITER $$
DROP PROCEDURE IF EXISTS sp_create_product_category $$

CREATE PROCEDURE sp_create_product_category(
    IN _product_category_id             VARCHAR(36),
    IN _product_id                      VARCHAR(36),
    IN _category_id                     VARCHAR(36)
)
BEGIN

    INSERT INTO products_categories(
        product_category_id,
        product_id,
        category_id
    )
    VALUES(
        UUID_TO_BIN(_product_category_id),
        UUID_TO_BIN(_product_id),
        UUID_TO_BIN(_category_id)
    );

END $$
DELIMITER ;