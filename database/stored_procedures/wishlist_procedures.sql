
DELIMITER $$

CREATE PROCEDURE sp_create_wishlist(
    IN _wishlist_id             VARCHAR(36),
    IN _name                    VARCHAR(50),
    IN _description             VARCHAR(200),
    IN _visibility              INT,
    IN _user_id                 VARCHAR(36)
)
BEGIN

    INSERT INTO wishlists(
        wishlist_id,
        name,
        description,
        visibility,
        user_id
    )
    VALUES(
        UUID_TO_BIN(_wishlist_id),
        _name,
        _description,
        _visibility,
        UUID_TO_BIN(_user_id)
    );

END$$

DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_update_wishlist(
    IN _wishlist_id             VARCHAR(36),
    IN _name                    VARCHAR(50),
    IN _description             VARCHAR(200),
    IN _visibility              INT
)
BEGIN

    UPDATE
        wishlists
    SET
        name        = IFNULL(_name, name),
        description = IFNULL(_description, description),
        visibility  = IFNULL(_visibility, visibility)
    WHERE
        BIN_TO_UUID(wishlist_id) = _wishlist_id;

END$$

DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_delete_wishlist(
    IN _wishlist_id             VARCHAR(36)
)
BEGIN

    UPDATE 
            wishlists
    SET
            active = FALSE
    WHERE
            BIN_TO_UUID(wishlist_id) = _wishlist_id;
    
END$$


DELIMITER $$

CREATE PROCEDURE sp_get_user_wishlists(
    IN _user_id                 VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(wishlist_id) as 'wishlist_id',
        name,
        description,
        visibility
    FROM
        wishlists
    WHERE
        BIN_TO_UUID(user_id) = _user_id AND
        active = TRUE;

END$$

DELIMITER ;