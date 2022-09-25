
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


SELECT BIN_TO_UUID(wishlist_id), name FROM wishlists;

5bf82b20-3a57-47e4-9394-487a6498ee89
d77579cf-2186-4d7d-9c85-a32720773bf9

CALL sp_get_wishlist_objects('5bf82b20-3a57-47e4-9394-487a6498ee89');


DELIMITER $$

CREATE PROCEDURE sp_get_wishlist_objects(
    IN _wishlist_id             VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(wishlist_object_id) id,
        BIN_TO_UUID(wishlist_id) wishlist_id
    FROM
        wishlist_objects
    WHERE
        BIN_TO_UUID(wishlist_id) = _wishlist_id
        AND active = TRUE;

END $$
DELIMITER ;