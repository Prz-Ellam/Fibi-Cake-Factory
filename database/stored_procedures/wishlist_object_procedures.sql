
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_wishlist_objects_create $$

CREATE PROCEDURE sp_wishlist_objects_create(
    IN _wishlist_object_id          VARCHAR(36),
    IN _wishlist_id                 VARCHAR(36),
    IN _product_id                  VARCHAR(36)
)
BEGIN

    IF (NOT EXISTS (SELECT 
                    BIN_TO_UUID(wishlist_object_id) 
                FROM 
                    wishlist_objects
                WHERE 
                    BIN_TO_UUID(product_id) = _product_id 
                    AND BIN_TO_UUID(wishlist_id) = _wishlist_id
                    AND active = TRUE
                )
    )
    THEN

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

    END IF;

END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_delete_wishlist_object $$

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



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_get_wishlist_objects $$

CREATE PROCEDURE sp_get_wishlist_objects(
    IN _wishlist_id             VARCHAR(36),
    IN _user_id                 VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(wo.wishlist_object_id) id,
        BIN_TO_UUID(wo.wishlist_id) wishlist_id,
        BIN_TO_UUID(p.product_id) 'product_id',
        p.name,
        p.description,
        IF(p.is_quotable = 1, IFNULL(c.q_price, 'Cotizable'), p.price) `price`,
        p.stock,
        GROUP_CONCAT(DISTINCT BIN_TO_UUID(i.image_id)) images
    FROM
        wishlist_objects AS wo
    INNER JOIN
        products AS p
    ON
        BIN_TO_UUID(p.product_id) = BIN_TO_UUID(wo.product_id)
    INNER JOIN
        images AS i
    ON
        BIN_TO_UUID(wo.product_id) = BIN_TO_UUID(i.multimedia_entity_id)
    LEFT JOIN
        (SELECT
            BIN_TO_UUID(product_id) `q_product_id`, 
            BIN_TO_UUID(user_id) `q_user_id`, 
            price `q_price`
        FROM
            quotes
        WHERE
            BIN_TO_UUID(user_id) = _user_id) c
    ON
        BIN_TO_UUID(p.product_id) = c.q_product_id AND c.q_price IS NOT NULL
    WHERE
        BIN_TO_UUID(wo.wishlist_id) = _wishlist_id
        AND p.active = TRUE
        AND wo.active = TRUE
    GROUP BY
        wo.wishlist_object_id, 
        wo.wishlist_id, 
        p.name, 
        p.description, 
        p.price, 
        p.stock;

END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_wishlist_objects_get_user_id $$

CREATE PROCEDURE sp_wishlist_objects_get_user_id(
    IN _wishlist_object_id              VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(w.user_id) `user_id`
    FROM
        wishlist_objects AS wo
    INNER JOIN
        wishlists AS w
    ON
        BIN_TO_UUID(wo.wishlist_id) = BIN_TO_UUID(w.wishlist_id)
    WHERE
        BIN_TO_UUID(wo.wishlist_object_id) = _wishlist_object_id
        AND wo.active = TRUE;

END $$

DELIMITER ;