
DELIMITER $$

CREATE PROCEDURE sp_add_wishlist_object(
    IN _wishlist_object_id          VARCHAR(36),
    IN _wishlist_id                 VARCHAR(36),
    IN _product_id                  VARCHAR(36)
)
BEGIN

    INSERT INTO wishlist_objects(
        wishlist_object_id,
        wishlist_id,
        product_id
    )
    VALUES(
        UUID_TO_BIN(_wishlist_object_id),
        UUID_TO_BIN(_wishlist_id),
        UUID_TO_BIN(_product_id)
    );

END $$
DELIMITER ;



DELIMITER $$

CREATE PROCEDURE sp_delete_wishlist_object(
    IN _wishlist_object_id          VARCHAR(36)
)
BEGIN

    UPDATE
        wishlist_objects
    SET
        active = FALSE
    WHERE
        BIN_TO_UUID(wishlist_object_id) = _wishlist_object_id
        AND active = TRUE;

END $$
DELIMITER ;