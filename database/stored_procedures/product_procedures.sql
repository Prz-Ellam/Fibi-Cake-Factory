
DELIMITER $$
CREATE PROCEDURE sp_create_product(
    IN _product_id              VARCHAR(36),
    IN _name                    VARCHAR(50),
    IN _description             VARCHAR(200),
    IN _is_quotable             BOOLEAN,
    IN _price                   DECIMAL(15, 2),
    IN _stock                   INT,
    IN _user_id                 VARCHAR(36)
)
BEGIN

    INSERT INTO products(
        product_id,
        name,
        description,
        is_quotable,
        price,
        stock,
        user_id
    )
    VALUES(
        UUID_TO_BIN(_product_id),
        _name,
        _description,
        _is_quotable,
        _price,
        _stock,
        UUID_TO_BIN(_user_id)
    );

END $$

DELIMITER ;



DELIMITER $$

CREATE PROCEDURE sp_update_product(
    IN _product_id          VARCHAR(36),
    IN _name                VARCHAR(50),
    IN _description         VARCHAR(200),
    IN _is_quotable         BOOLEAN,
    IN _price               DECIMAL(15, 2),
    IN _stock               INT
)
BEGIN

    UPDATE
        products
    SET
        name            = IFNULL(_name, name),
        description     = IFNULL(_description, description),
        is_quotable     = IFNULL(_is_quotable, is_quotable),
        price           = IFNULL(_price, price),
        stock           = IFNULL(_stock, stock),
        modified_at     = NOW()
    WHERE
        BIN_TO_UUID(product_id) = _product_id
        AND active = TRUE;

END
DELIMITER ; 



DELIMITER $$

CREATE PROCEDURE sp_delete_product(
    IN _product_id              VARCHAR(36)
)
BEGIN

    UPDATE
        products
    SET
        active          = FALSE 
        AND modified_at = NOW()
    WHERE
        BIN_TO_UUID(product_id) = _product_id;

END $$
DELIMITER ;



DELIMITER $$

CREATE PROCEDURE sp_get_user_products(
    IN _user_id                 VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(p.product_id) id,
        p.name,
        p.description,
        p.is_quotable,
        p.price,
        p.stock,
        p.approved,
        JSON_ARRAYAGG(BIN_TO_UUID(i.image_id)) images,
        JSON_ARRAYAGG(BIN_TO_UUID(v.video_id)) videos
    FROM
        products AS p
    LEFT JOIN
        images AS i
    ON
        BIN_TO_UUID(i.multimedia_entity_id) = BIN_TO_UUID(p.product_id)
    LEFT JOIN
        videos AS v
    ON
        BIN_TO_UUID(v.multimedia_entity_id) = BIN_TO_UUID(p.product_id)
    WHERE
        BIN_TO_UUID(p.user_id) = _user_id
        AND p.active = TRUE
    GROUP BY
        p.product_id, 
        p.name, 
        p.description, 
        p.is_quotable, 
        p.price, 
        p.stock, 
        p.approved;

END $$

DELIMITER ;



DELIMITER $$
CREATE PROCEDURE sp_get_product(
    IN _product_id                 VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(p.product_id) id,
        p.name,
        p.description,
        p.is_quotable,
        p.price,
        p.stock,
        p.approved,
        JSON_ARRAYAGG(BIN_TO_UUID(i.image_id)) images,
        JSON_ARRAYAGG(BIN_TO_UUID(v.video_id)) videos
    FROM
        products AS p
    LEFT JOIN
        images AS i
    ON
        BIN_TO_UUID(i.multimedia_entity_id) = BIN_TO_UUID(p.product_id)
    LEFT JOIN
        videos AS v
    ON
        BIN_TO_UUID(v.multimedia_entity_id) = BIN_TO_UUID(p.product_id)
    WHERE
        BIN_TO_UUID(p.product_id) = _product_id
        AND p.active = TRUE
    GROUP BY
        p.product_id, 
        p.name, 
        p.description, 
        p.is_quotable, 
        p.price, 
        p.stock, 
        p.approved;

END $$
DELIMITER ;


DELIMITER $$

CREATE PROCEDURE sp_get_recent_products()
BEGIN

    SELECT
        BIN_TO_UUID(p.product_id) id,
        p.name,
        p.description,
        p.is_quotable,
        p.price,
        p.stock,
        p.approved,
        JSON_ARRAYAGG(BIN_TO_UUID(i.image_id)) images,
        JSON_ARRAYAGG(BIN_TO_UUID(v.video_id)) videos
    FROM
        products AS p
    LEFT JOIN
        images AS i
    ON
        BIN_TO_UUID(i.multimedia_entity_id) = BIN_TO_UUID(p.product_id)
    LEFT JOIN
        videos AS v
    ON
        BIN_TO_UUID(v.multimedia_entity_id) = BIN_TO_UUID(p.product_id)
    WHERE
        p.active = TRUE
    GROUP BY
        p.product_id, 
        p.name, 
        p.description, 
        p.is_quotable, 
        p.price, 
        p.stock, 
        p.approved
    ORDER BY
        p.created_at ASC;

END $$

DELIMITER ;




CREATE PROCEDURE sp_update_product();

CREATE PROCEDURE sp_delete_product();

CREATE PROCEDURE sp_get_products(

);


CREATE PROCEDURE sp_filter_user_products();