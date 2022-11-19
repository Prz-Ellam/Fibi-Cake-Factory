DELIMITER $$
DROP PROCEDURE IF EXISTS sp_create_wishlist $$

CREATE PROCEDURE sp_create_wishlist(
    IN _wishlist_id             VARCHAR(36),
    IN _name                    VARCHAR(50),
    IN _description             VARCHAR(200),
    IN _visible                 INT,
    IN _user_id                 VARCHAR(36)
)
BEGIN

    INSERT INTO wishlists(
        wishlist_id,
        name,
        description,
        visible,
        user_id
    )
    VALUES(
        UUID_TO_BIN(_wishlist_id),
        _name,
        _description,
        _visible,
        UUID_TO_BIN(_user_id)
    );

END$$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS sp_update_wishlist $$

CREATE PROCEDURE sp_update_wishlist(
    IN _wishlist_id             VARCHAR(36),
    IN _name                    VARCHAR(50),
    IN _description             VARCHAR(200),
    IN _visible                 INT
)
BEGIN

    UPDATE
        wishlists
    SET
        name            = IFNULL(_name, name),
        description     = IFNULL(_description, description),
        visible         = IFNULL(_visible, visible)
    WHERE
        BIN_TO_UUID(wishlist_id) = _wishlist_id
        --AND BIN_TO_UUID(user_id) = _user_id
        AND active = TRUE;

END$$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_delete_wishlist $$

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
        --AND BIN_TO_UUID(user_id) = _user_id
    
END$$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_get_wishlist $$

CREATE PROCEDURE sp_get_wishlist(
    IN _wishlist_id             VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(w.wishlist_id) id,
        w.name,
        w.description,
        w.visible,
        IF(BIN_TO_UUID(i.image_id) IS NOT NULL, 
        JSON_ARRAYAGG(BIN_TO_UUID(i.image_id)),
        JSON_ARRAY()) images
    FROM
        wishlists AS w
    LEFT JOIN
        images AS i
    ON
        BIN_TO_UUID(i.multimedia_entity_id) = BIN_TO_UUID(w.wishlist_id) 
        AND i.multimedia_entity_type = 'wishlists'
    WHERE
        BIN_TO_UUID(w.wishlist_id) = _wishlist_id 
        AND w.active = TRUE
    GROUP BY
        w.wishlist_id,
        w.name, 
        w.description, 
        w.visible;

END $$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS sp_get_user_wishlists $$

CREATE PROCEDURE sp_get_user_wishlists(
    IN _user_id                 VARCHAR(36),
    IN _limit                   INT,
    IN _offset                  INT
)
BEGIN

    SELECT
        BIN_TO_UUID(w.wishlist_id) id,
        w.name,
        w.description,
        w.visible,
        IF(BIN_TO_UUID(i.image_id) IS NOT NULL, 
        JSON_ARRAYAGG(BIN_TO_UUID(i.image_id)),
        JSON_ARRAY()) images
    FROM
        wishlists AS w
    LEFT JOIN
        images AS i
    ON
        BIN_TO_UUID(i.multimedia_entity_id) = BIN_TO_UUID(w.wishlist_id) 
        AND i.multimedia_entity_type = 'wishlists'
    WHERE
        BIN_TO_UUID(w.user_id) = _user_id 
        AND w.active = TRUE
    GROUP BY
        w.wishlist_id,
        w.name, 
        w.description, 
        w.visible
    ORDER BY
        w.created_at ASC
    LIMIT
        _limit
    OFFSET
        _offset;

END$$
DELIMITER ;




DELIMITER $$
DROP PROCEDURE IF EXISTS get_all_by_user_public $$

CREATE PROCEDURE get_all_by_user_public(
    IN _user_id                 VARCHAR(36),
    IN _limit                   INT,
    IN _offset                  INT
)
BEGIN

    SELECT
        BIN_TO_UUID(w.wishlist_id) id,
        w.name,
        w.description,
        w.visible,
        IF(BIN_TO_UUID(i.image_id) IS NOT NULL, 
        JSON_ARRAYAGG(BIN_TO_UUID(i.image_id)),
        JSON_ARRAY()) images
    FROM
        wishlists AS w
    LEFT JOIN
        images AS i
    ON
        BIN_TO_UUID(i.multimedia_entity_id) = BIN_TO_UUID(w.wishlist_id) 
        AND i.multimedia_entity_type = 'wishlists'
    WHERE
        BIN_TO_UUID(w.user_id) = _user_id
        AND w.visible = TRUE
        AND w.active = TRUE
    GROUP BY
        w.wishlist_id,
        w.name, 
        w.description, 
        w.visible
    ORDER BY
        w.created_at ASC
    LIMIT
        _limit
    OFFSET
        _offset;

END$$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_wishlists_get_user_id $$

CREATE PROCEDURE sp_wishlists_get_user_id(
    IN _wishlist_id             VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(user_id) `user_id`
    FROM
        wishlists
    WHERE
        BIN_TO_UUID(wishlist_id) = _wishlist_id
        AND active = TRUE;

END $$
DELIMITER ;

