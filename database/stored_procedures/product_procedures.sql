
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




SELECT
    BIN_TO_UUID(p.product_id) product_id,
    p.name,
    BIN_TO_UUID(p.user_id) user_id,
    BIN_TO_UUID(i.image_id) image_id,
    BIN_TO_UUID(v.video_id) video_id
FROM
    products AS p
INNER JOIN
    images AS i
ON
    p.product_id = i.multimedia_entity_id
INNER JOIN
    videos AS v
ON
    p.product_id = v.multimedia_entity_id;


SELECT * FROM products_categories;







SELECT *, BIN_TO_UUID(category_id) category_id FROM categories;

SELECT *, 
BIN_TO_UUID(product_category_id) product_category_id,
BIN_TO_UUID(product_id) product_id,
BIN_TO_UUID(category_id) category_id
FROM products_categories;

SELECT BIN_TO_UUID(product_id), BIN_TO_UUID(user_id), name FROM products;

CALL sp_get_user_products('516a3887-06b1-4203-ad59-07dc13d1e0fe');
CALL sp_get_user_products('b6cc9bbd-fbb2-4935-bb29-b3c0e40ca7bb');

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
        JSON_ARRAY(GROUP_CONCAT(DISTINCT JSON_OBJECT('id', BIN_TO_UUID(c.category_id), 'name', c.name))) categories,
        GROUP_CONCAT(DISTINCT BIN_TO_UUID(i.image_id)) images,
        GROUP_CONCAT(DISTINCT BIN_TO_UUID(v.video_id)) videos
    FROM
        products AS p
    INNER JOIN
        products_categories AS pc
    ON
        BIN_TO_UUID(p.product_id) = BIN_TO_UUID(pc.product_id)
    INNER JOIN
        categories AS c
    ON
        BIN_TO_UUID(pc.category_id) = BIN_TO_UUID(c.category_id)
    INNER JOIN
        images AS i
    ON
        p.product_id = i.multimedia_entity_id
    INNER JOIN
        videos AS v
    ON
        p.product_id = v.multimedia_entity_id
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
DROP PROCEDURE IF EXISTS sp_get_product $$

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
        JSON_ARRAY(GROUP_CONCAT(DISTINCT JSON_OBJECT('id', BIN_TO_UUID(c.category_id), 'name', c.name))) categories,
        GROUP_CONCAT(DISTINCT BIN_TO_UUID(i.image_id)) images,
        GROUP_CONCAT(DISTINCT BIN_TO_UUID(v.video_id)) videos
    FROM
        products AS p
    INNER JOIN
        products_categories AS pc
    ON
        BIN_TO_UUID(p.product_id) = BIN_TO_UUID(pc.product_id)
    INNER JOIN
        categories AS c
    ON
        BIN_TO_UUID(pc.category_id) = BIN_TO_UUID(c.category_id)
    INNER JOIN
        images AS i
    ON
        p.product_id = i.multimedia_entity_id
    INNER JOIN
        videos AS v
    ON
        p.product_id = v.multimedia_entity_id
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
        JSON_ARRAY(GROUP_CONCAT(DISTINCT BIN_TO_UUID(i.image_id))) images,
        JSON_ARRAY(GROUP_CONCAT(DISTINCT BIN_TO_UUID(v.video_id))) videos
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








SELECT
        BIN_TO_UUID(p.product_id) id,
        p.name,
        p.description,
        p.is_quotable,
        p.price,
        p.stock,
        p.approved,
        JSON_ARRAY(GROUP_CONCAT(BIN_TO_UUID(i.image_id))) images,
        JSON_ARRAY(GROUP_CONCAT(BIN_TO_UUID(v.video_id))) videos
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
        BIN_TO_UUID(p.user_id) = '516a3887-06b1-4203-ad59-07dc13d1e0fe'
        AND p.active = TRUE
    GROUP BY
        p.product_id, 
        p.name, 
        p.description, 
        p.is_quotable, 
        p.price, 
        p.stock, 
        p.approved;