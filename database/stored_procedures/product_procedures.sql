
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_products_create $$

CREATE PROCEDURE sp_products_create(
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

    UPDATE
        users
    SET
        user_role = (SELECT user_role_id FROM user_roles WHERE name = 'Vendedor')
    WHERE
        BIN_TO_UUID(user_id) = _user_id;

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







-- TODO: Obtener todos los aprobados de un men
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_products_get_all_by_approved_by $$

CREATE PROCEDURE sp_products_get_all_by_approved_by(
    IN _approved_by                 VARCHAR(36)
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
        approved = TRUE
        AND p.active = TRUE
        AND BIN_TO_UUID(approved_by) = _approved_by
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
DROP PROCEDURE IF EXISTS sp_products_get_all_by_ships $$

CREATE PROCEDURE sp_products_get_all_by_ships(
    IN _order                       VARCHAR(4),
    IN _filter                      VARCHAR(255),
    IN _limit                       INT,
    IN _offset                      INT
)
BEGIN

    SELECT 
    BIN_TO_UUID(p.product_id) id, 
    p.name, 
    p.price, 
    IFNULL(SUM(s.quantity), 0) quantity,
    (SELECT GROUP_CONCAT(BIN_TO_UUID(image_id)) FROM images WHERE BIN_TO_UUID(multimedia_entity_id) = BIN_TO_UUID(p.product_id)) images,
    BIN_TO_UUID(p.user_id) userId
    FROM products AS p
    LEFT JOIN shoppings AS s
    ON BIN_TO_UUID(p.product_id) = BIN_TO_UUID(s.product_id)
    WHERE
        p.name LIKE CONCAT('%', IFNULL(NULL, ''), '%')
        AND p.active = TRUE AND approved = TRUE
    GROUP BY p.product_id, p.name, p.price
    ORDER BY
        CASE _order WHEN 'asc'  THEN COUNT(s.quantity) END ASC,
        CASE _order WHEN 'desc' THEN COUNT(s.quantity) END DESC;


    --SELECT
    --    BIN_TO_UUID(p.product_id) id,
    --    p.name,
    --    p.price,
    --    IFNULL(SUM(s.quantity), 0) sells,
    --    GROUP_CONCAT(DISTINCT BIN_TO_UUID(i.image_id)) images
    --FROM
    --    products AS p
    --LEFT JOIN
    --    shoppings AS s
    --ON
    --    BIN_TO_UUID(p.product_id) = BIN_TO_UUID(s.product_id)
    --INNER JOIN
    --    images AS i
    --ON
    --    p.product_id = i.multimedia_entity_id
    --WHERE
    --    p.name LIKE CONCAT('%', IFNULL(NULL, ''), '%')
    --    AND p.active = TRUE
    --    AND approved = TRUE
    --GROUP BY
    --    p.product_id,
    --    p.name,
    --    p.price
    --ORDER BY
    --    CASE _order WHEN 'asc'  THEN COUNT(s.quantity) END ASC,
    --    CASE _order WHEN 'desc' THEN COUNT(s.quantity) END DESC;

END $$
DELIMITER ;



-- El precio
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_products_get_all_by_price $$

CREATE PROCEDURE sp_products_get_all_by_price(
    IN _order                       VARCHAR(4),
    IN _filter                      VARCHAR(255),
    IN _limit                       INT,
    IN _offset                      INT
)
BEGIN

    SELECT
        BIN_TO_UUID(p.product_id) id,
        name,
        price
    FROM
        products AS p
    WHERE
        name LIKE CONCAT('%', IFNULL(NULL, ''), '%')
        AND active = TRUE
        AND approved = TRUE
    ORDER BY
        CASE _order WHEN 'asc'  THEN price END ASC,
        CASE _order WHEN 'desc' THEN price END DESC;

END $$
DELIMITER ;



-- Alfabetico
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_products_get_all_by_alpha $$

CREATE PROCEDURE sp_products_get_all_by_alpha(
    IN _order                       VARCHAR(4),
    IN _filter                      VARCHAR(255),
    IN _limit                       INT,
    IN _offset                      INT
)
BEGIN

    SELECT
        BIN_TO_UUID(p.product_id) id,
        name,
        price
    FROM
        products AS p
    WHERE
        name LIKE CONCAT('%', IFNULL(NULL, ''), '%')
        AND active = TRUE
        AND approved = TRUE
    ORDER BY
        CASE _order WHEN 'asc'  THEN name END ASC,
        CASE _order WHEN 'desc' THEN name END DESC;

END $$
DELIMITER ;



-- Mejor calificados
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_products_get_all_by_rate $$

CREATE PROCEDURE sp_products_get_all_by_rate(
    IN _order                       VARCHAR(4),
    IN _filter                      VARCHAR(255),
    IN _limit                       INT,
    IN _offset                      INT
)
BEGIN

    SELECT
        BIN_TO_UUID(p.product_id) id,
        p.name,
        IFNULL(AVG(r.rate), 'No reviews') rate
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
        CASE _order WHEN 'asc'  THEN AVG(r.rate) END ASC,
        CASE _order WHEN 'desc' THEN AVG(r.rate) END DESC;

END $$
DELIMITER ;



-- Filtrar por categoria
SELECT BIN_TO_UUID(category_id), name FROM categories;

-- 06c69dc0-af3a-4663-b504-01b5a449c5f2 (Frutas)
-- 3d7ad7f2-674d-47c2-a1ca-6c8e0170941d (A)

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_products_get_all_by_category $$

CREATE PROCEDURE sp_products_get_all_by_category(
    IN _category_id                 VARCHAR(36),
    IN _filter                      VARCHAR(255),
    IN _limit                       INT,
    IN _offset                      INT
)
BEGIN

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

END $$
DELIMITER ;



-- Categorias favoritas del usuario



-- Productos recomendados para el usuario
SELECT c.name FROM shoppings AS s
RIGHT JOIN products_categories AS pc
ON BIN_TO_UUID(s.product_id) = BIN_TO_UUID(pc.product_id)
INNER JOIN categories AS c
ON BIN_TO_UUID(c.category_id) = BIN_TO_UUID(pc.category_id)


SELECT BIN_TO_UUID(product_id) FROM shoppings;
SELECT * FROM products_categories;


SELECT 
BIN_TO_UUID(p.product_id), p.name, p.price, SUM(s.quantity),

(SELECT GROUP_CONCAT(BIN_TO_UUID(c.category_id)) 
FROM categories AS c
INNER JOIN products_categories AS pc
ON BIN_TO_UUID(c.category_id) = BIN_TO_UUID(pc.category_id)
WHERE BIN_TO_UUID(pc.product_id) = BIN_TO_UUID(p.product_id))

FROM products AS p
LEFT JOIN shoppings AS s
ON BIN_TO_UUID(p.product_id) = BIN_TO_UUID(s.product_id)
INNER JOIN orders AS o
ON BIN_TO_UUID(o.order_id) = BIN_TO_UUID(s.order_id)
WHERE BIN_TO_UUID(o.user_id) = '76dd9897-f26a-44d5-852c-9f7c0f3f0c90'
GROUP BY BIN_TO_UUID(p.product_id), p.name, p.price;




SELECT 
products.product_id, 
products.name, 
products.price,
IFNULL(COUNT(shoppings.product_id) * shoppings.quantity, 0) AS Cantidad, 
IFNULL(COUNT(shoppings.product_id) * shoppings.quantity, 0) / (SELECT COUNT(shoppings.product_id) FROM shoppings) AS Porcentaje,
categories.name AS category FROM products
INNER JOIN categories
ON categories.category_id = products.category_id
LEFT JOIN shoppings
ON products.product_id = shoppings.product_id
GROUP BY  products.name
ORDER BY IFNULL(COUNT(shoppings.product_id) * shoppings.quantity, 0) DESC;



