
DELIMITER $$

CREATE PROCEDURE sp_create_shopping_cart(
    IN _shopping_cart_id            VARCHAR(36),
    IN _user_id                     VARCHAR(36)
)
BEGIN

    INSERT INTO shopping_carts(
        shopping_cart_id,
        user_id
    )
    VALUES(
        UUID_TO_BIN(_shopping_cart_id),
        UUID_TO_BIN(_user_id)
    );

END $$
DELIMITER ;



DELIMITER $$

CREATE PROCEDURE sp_delete_shopping_cart(
    IN _user_id                 VARCHAR(36)
)
BEGIN

    UPDATE
        shopping_carts
    SET
        active = FALSE
    WHERE
        BIN_TO_UUID(_user_id) = _user_id
        AND active = TRUE;

END $$

DELIMITER ;