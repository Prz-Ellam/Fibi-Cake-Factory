
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
DROP PROCEDURE IF EXISTS sp_get_recent_products $$

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
        GROUP_CONCAT(DISTINCT BIN_TO_UUID(i.image_id)) images,
        GROUP_CONCAT(DISTINCT BIN_TO_UUID(v.video_id)) videos,
        BIN_TO_UUID(p.user_id) userId
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
        AND p.approved = TRUE
    GROUP BY
        p.product_id, 
        p.name, 
        p.description, 
        p.is_quotable, 
        p.price, 
        p.stock, 
        p.approved,
        p.user_id
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



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_get_pending_products $$

CREATE PROCEDURE sp_get_pending_products()
BEGIN

    SELECT
        BIN_TO_UUID(p.product_id) id,
        p.name,
        p.description,
        p.is_quotable,
        p.price,
        p.stock,
        p.approved,
        u.username,
        p.created_at createdAt,
        BIN_TO_UUID(u.profile_picture) profilePicture,
        JSON_ARRAY(GROUP_CONCAT(DISTINCT JSON_OBJECT('id', BIN_TO_UUID(c.category_id), 'name', c.name))) categories,
        GROUP_CONCAT(DISTINCT BIN_TO_UUID(i.image_id)) images,
        GROUP_CONCAT(DISTINCT BIN_TO_UUID(v.video_id)) videos
    FROM
        products AS p
    INNER JOIN
        users AS u
    ON
        BIN_TO_UUID(p.user_id) = BIN_TO_UUID(u.user_id)
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
        p.approved = FALSE
        AND p.approved_by IS NULL
    GROUP BY
        p.product_id, 
        p.name, 
        p.description, 
        p.is_quotable, 
        p.price, 
        p.stock, 
        p.approved,
        u.username,
        u.profile_picture,
        p.created_at;

END $$
DELIMITER ;





DELIMITER $$
DROP PROCEDURE IF EXISTS sp_product_approve $$

CREATE PROCEDURE sp_product_approve(
    IN _product_id              VARCHAR(36),
    IN _user_id                 VARCHAR(36)
)
BEGIN

    UPDATE
        products
    SET
        approved = TRUE,
        approved_by = UUID_TO_BIN(_user_id)
    WHERE
        BIN_TO_UUID(product_id) = _product_id;

END $$
DELIMITER ;




DELIMITER $$
DROP PROCEDURE IF EXISTS sp_product_denied $$

CREATE PROCEDURE sp_product_denied(
    IN _product_id              VARCHAR(36),
    IN _user_id                 VARCHAR(36)
)
BEGIN

    UPDATE
        products
    SET
        approved = FALSE,
        approved_by = UUID_TO_BIN(_user_id)
    WHERE
        BIN_TO_UUID(product_id) = _product_id;

END $$
DELIMITER ;




DELIMITER $$
DROP PROCEDURE IF EXISTS sp_get_user_products_approved $$

CREATE PROCEDURE sp_get_user_products_approved(
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
        AND p.approved = TRUE
        AND p.approved_by IS NOT NULL
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
DROP PROCEDURE IF EXISTS sp_get_user_products_denied $$

CREATE PROCEDURE sp_get_user_products_denied(
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
        AND p.approved = FALSE
        AND p.approved_by IS NOT NULL
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
DROP PROCEDURE IF EXISTS sp_get_user_products_pending $$

CREATE PROCEDURE sp_get_user_products_pending(
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
        AND p.approved = FALSE
        AND p.approved_by IS NULL
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
DROP PROCEDURE IF EXISTS sp_products_get_all_by_sells $$

CREATE PROCEDURE sp_products_get_all_by_sells(
    IN _order                       VARCHAR(4),
    IN _filter                      VARCHAR(255),
    IN _limit                       INT,
    IN _offset                      INT
)
BEGIN

    SELECT
        BIN_TO_UUID(p.product_id),
        name,
        IFNULL(SUM(s.quantity), 0)
    FROM
        products AS p
    LEFT JOIN
        shoppings AS s
    ON
        BIN_TO_UUID(p.product_id) = BIN_TO_UUID(s.product_id)
    WHERE
        p.name LIKE CONCAT('%', IFNULL(NULL, ''), '%')
        AND p.active = TRUE
    GROUP BY
        p.product_id,
        name
    ORDER BY
        CASE _order WHEN 'asc'  THEN COUNT(s.quantity) END ASC,
        CASE _order WHEN 'desc' THEN COUNT(s.quantity) END DESC;

END $$
DELIMITER ;






-- El precio
SELECT
    BIN_TO_UUID(p.product_id),
    name,
    price
FROM
    products AS p
WHERE
    active = TRUE
    AND approved = TRUE
ORDER BY
    price DESC;


-- Alfabetico
SELECT
    BIN_TO_UUID(p.product_id),
    name,
    price
FROM
    products AS p
WHERE
    active = TRUE
    AND approved = TRUE
ORDER BY
    name ASC;


-- Mejor calificados
SELECT
    BIN_TO_UUID(p.product_id),
    p.name,
    IFNULL(AVG(r.rate), 'No reviews')
FROM
    products AS p
LEFT JOIN
    reviews AS r
ON
    BIN_TO_UUID(p.product_id) = BIN_TO_UUID(r.product_id)
WHERE
    p.active = TRUE
    AND p.approved = TRUE
GROUP BY
    BIN_TO_UUID(p.product_id),
    p.name
ORDER BY
    AVG(r.rate) DESC;




-- Filtrar por categoria
SELECT BIN_TO_UUID(category_id), name FROM categories;

-- 06c69dc0-af3a-4663-b504-01b5a449c5f2 (Frutas)
-- 3d7ad7f2-674d-47c2-a1ca-6c8e0170941d (A)

SELECT
    BIN_TO_UUID(p.product_id),
    p.name
FROM
    products AS p
INNER JOIN
    products_categories AS pc
ON
    BIN_TO_UUID(p.product_id) = BIN_TO_UUID(pc.product_id)
WHERE
    p.active = TRUE
    AND p.approved = TRUE
    AND BIN_TO_UUID(pc.category_id) = '3d7ad7f2-674d-47c2-a1ca-6c8e0170941d'




-- Categorias favoritas del usuario



-- Productos recomendados para el usuario