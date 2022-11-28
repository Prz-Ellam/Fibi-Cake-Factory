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
DROP PROCEDURE IF EXISTS sp_products_update $$

CREATE PROCEDURE sp_products_update(
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
        name                = IFNULL(_name, name),
        description         = IFNULL(_description, description),
        is_quotable         = IFNULL(_is_quotable, is_quotable),
        price               = IFNULL(_price, price),
        stock               = IFNULL(_stock, stock),
        modified_at         = NOW()
    WHERE
        BIN_TO_UUID(product_id) = _product_id
        AND active = TRUE;

END
DELIMITER ; 



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_products_delete $$

CREATE PROCEDURE sp_products_delete(
    IN _product_id              VARCHAR(36)
)
BEGIN

    UPDATE
        products
    SET
        active              = FALSE 
        AND modified_at     = NOW()
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
        IF(p.is_quotable = 1, 'Cotizable', p.price) `price`,
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
DROP PROCEDURE IF EXISTS sp_get_user_products $$

CREATE PROCEDURE sp_get_user_products(
    IN _user_id                 VARCHAR(36),
    IN _client_id               VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(p.product_id) id,
        p.name,
        p.description,
        p.is_quotable,
        IF(p.is_quotable = 1, IFNULL(c.q_price, 'Cotizable'), p.price) `price`,
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
    LEFT JOIN
        (SELECT
            BIN_TO_UUID(product_id) `q_product_id`, 
            BIN_TO_UUID(user_id) `q_user_id`, 
            price `q_price`
        FROM
            quotes
        WHERE
            BIN_TO_UUID(user_id) = _client_id) c
    ON
        BIN_TO_UUID(p.product_id) = c.q_product_id AND c.q_price IS NOT NULL
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




CALL sp_get_product('f36d0036-eaa6-4112-8ce2-d471dc63c9bc');

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_get_product $$

CREATE PROCEDURE sp_get_product(
    IN _product_id                 VARCHAR(36),
    IN _user_id                    VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(p.product_id) id,
        p.name,
        p.description,
        p.is_quotable,
        IF(p.is_quotable = 1, IFNULL(c.q_price, 'Cotizable'), p.price) `price`,
        p.stock,
        p.approved,
        BIN_TO_UUID(p.user_id) `user`,
        (SELECT IFNULL(ROUND(AVG(rate), 2), 'No reviews') FROM reviews WHERE BIN_TO_UUID(product_id) = _product_id AND active = TRUE) 'rate',
        GROUP_CONCAT(DISTINCT BIN_TO_UUID(c.category_id)) categories,
        GROUP_CONCAT(DISTINCT c.name) categories_name,
        GROUP_CONCAT(DISTINCT BIN_TO_UUID(i.image_id)) images,
        BIN_TO_UUID(v.video_id) `video`
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
        BIN_TO_UUID(p.product_id) = _product_id
        AND p.active = TRUE
    GROUP BY
        p.product_id, 
        p.name, 
        p.description, 
        p.is_quotable, 
        p.price,
        'rate',
        p.stock, 
        p.approved;

END $$
DELIMITER ;


CALL sp_products_get_all_by_recents('d356d225-0cab-4b25-9d6a-fefa66a71990');
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_products_get_all_by_recents $$

CREATE PROCEDURE sp_products_get_all_by_recents(
    IN _user_id                     VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(p.product_id) id,
        p.name,
        p.description,
        p.is_quotable,
        IF(p.is_quotable = 1, IFNULL(c.q_price, 'Cotizable'), p.price) `price`,
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
        p.active = TRUE
        AND p.approved = TRUE
    GROUP BY
        p.product_id, 
        p.name, 
        p.description, 
        p.is_quotable, 
        p.price, 
        p.stock,
        c.q_price, 
        p.approved,
        p.user_id
    ORDER BY
        p.created_at DESC;

END $$
DELIMITER ;













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
        p.active = TRUE
        AND p.approved = FALSE
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
        approved        = TRUE,
        approved_by     = UUID_TO_BIN(_user_id),
        modified_at     = NOW()
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
        approved        = FALSE,
        approved_by     = UUID_TO_BIN(_user_id),
        modified_at     = NOW()
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
    IN _offset                      INT,
    IN _category_id                 VARCHAR(36),
    IN _user_id                     VARCHAR(36)
)
BEGIN

    SELECT 
        BIN_TO_UUID(p.product_id) id, 
        p.name, 
        IF(p.is_quotable = 1, IFNULL(c.q_price, 'Cotizable'), p.price) `price`,
        p.is_quotable,
        IFNULL(SUM(s.quantity), 0) quantity,
        (SELECT GROUP_CONCAT(BIN_TO_UUID(image_id)) FROM images WHERE BIN_TO_UUID(multimedia_entity_id) = BIN_TO_UUID(p.product_id)) images,
        BIN_TO_UUID(p.user_id) userId
    FROM 
        products AS p
    LEFT JOIN 
        shoppings AS s
    ON 
        BIN_TO_UUID(p.product_id) = BIN_TO_UUID(s.product_id)
    INNER JOIN
        products_categories AS pc
    ON
        BIN_TO_UUID(p.product_id) = BIN_TO_UUID(pc.product_id)
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
        p.name LIKE CONCAT('%', IFNULL(_filter, ''), '%')
        AND p.active = TRUE AND approved = TRUE
        AND (BIN_TO_UUID(pc.category_id) = _category_id
        OR _category_id IS NULL)
    GROUP BY 
        p.product_id, 
        p.name, 
        p.price
    ORDER BY
        CASE _order WHEN 'asc'  THEN COUNT(s.quantity) END ASC,
        CASE _order WHEN 'desc' THEN COUNT(s.quantity) END DESC;

END $$
DELIMITER ;



-- El precio
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_products_get_all_by_price $$

CREATE PROCEDURE sp_products_get_all_by_price(
    IN _order                       VARCHAR(4),
    IN _filter                      VARCHAR(255),
    IN _limit                       INT,
    IN _offset                      INT,
    IN _category_id                 VARCHAR(36),
    IN _user_id                     VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(p.product_id) id,
        name,
        IF(p.is_quotable = 1, IFNULL(c.q_price, 'Cotizable'), p.price) `price`,
        is_quotable,
        (SELECT GROUP_CONCAT(BIN_TO_UUID(image_id)) FROM images WHERE BIN_TO_UUID(multimedia_entity_id) = BIN_TO_UUID(p.product_id)) images
    FROM
        products AS p
    INNER JOIN
        products_categories AS pc
    ON
        BIN_TO_UUID(p.product_id) = BIN_TO_UUID(pc.product_id)
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
        name LIKE CONCAT('%', IFNULL(_filter, ''), '%')
        AND p.active = TRUE
        AND p.approved = TRUE
        AND (BIN_TO_UUID(pc.category_id) = _category_id
        OR _category_id IS NULL)
    GROUP BY
        p.product_id
    ORDER BY
        CASE _order WHEN 'asc'  THEN IF(p.is_quotable = 1, IFNULL(c.q_price, 'Cotizable'), p.price) END ASC,
        CASE _order WHEN 'desc' THEN IF(p.is_quotable = 1, IFNULL(c.q_price, 'Cotizable'), p.price) END DESC;

END $$
DELIMITER ;



-- Alfabetico
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_products_get_all_by_alpha $$

CREATE PROCEDURE sp_products_get_all_by_alpha(
    IN _order                       VARCHAR(4),
    IN _filter                      VARCHAR(255),
    IN _limit                       INT,
    IN _offset                      INT,
    IN _category_id                 VARCHAR(36),
    IN _user_id                     VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(p.product_id) id,
        name,
        IF(p.is_quotable = 1, IFNULL(c.q_price, 'Cotizable'), p.price) `price`,
        is_quotable,
        (SELECT GROUP_CONCAT(BIN_TO_UUID(image_id)) FROM images WHERE BIN_TO_UUID(multimedia_entity_id) = BIN_TO_UUID(p.product_id)) images
    FROM
        products AS p
    INNER JOIN
        products_categories AS pc
    ON
        BIN_TO_UUID(p.product_id) = BIN_TO_UUID(pc.product_id)
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
        name LIKE CONCAT('%', IFNULL(_filter, ''), '%')
        AND p.active = TRUE
        AND p.approved = TRUE
        AND (BIN_TO_UUID(pc.category_id) = _category_id
        OR _category_id IS NULL)
    GROUP BY
        p.product_id
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
    IN _offset                      INT,
    IN _category_id                 VARCHAR(36),
    IN _user_id                     VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(p.product_id) id,
        IF(p.is_quotable = 1, IFNULL(c.q_price, 'Cotizable'), p.price) `price`,
        p.name,
        p.is_quotable,
        IFNULL(AVG(r.rate), 'No reviews') rate,
        BIN_TO_UUID(p.user_id) `userId`,
        (SELECT GROUP_CONCAT(BIN_TO_UUID(image_id)) FROM images WHERE BIN_TO_UUID(multimedia_entity_id) = BIN_TO_UUID(p.product_id)) images
    FROM
        products AS p
    LEFT JOIN
        reviews AS r
    ON
        BIN_TO_UUID(p.product_id) = BIN_TO_UUID(r.product_id)
    INNER JOIN
        products_categories AS pc
    ON
        BIN_TO_UUID(p.product_id) = BIN_TO_UUID(pc.product_id)
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
        p.active = TRUE
        AND p.approved = TRUE
        AND (BIN_TO_UUID(pc.category_id) = _category_id
        OR _category_id IS NULL)
    GROUP BY
        BIN_TO_UUID(p.product_id),
        p.name
    ORDER BY
        CASE _order WHEN 'asc'  THEN AVG(r.rate) END ASC,
        CASE _order WHEN 'desc' THEN AVG(r.rate) END DESC;

END $$
DELIMITER ;




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
        AND BIN_TO_UUID(pc.category_id) = '3d7ad7f2-674d-47c2-a1ca-6c8e0170941d';

END $$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS sp_products_get_user_id $$

CREATE PROCEDURE sp_products_get_user_id(
    _product_id                 VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(user_id) `user_id`
    FROM
        products
    WHERE
        BIN_TO_UUID(product_id) = _product_id
        AND active = TRUE;

END $$
DELIMITER ;




DELIMITER $$
DROP PROCEDURE IF EXISTS sp_products_get_user_favorites $$

CREATE PROCEDURE sp_products_get_user_favorites(
    IN _user_id                     VARCHAR(36)
)
BEGIN

    SELECT 
        BIN_TO_UUID(p.product_id) `id`,
        p.name,
        p.is_quotable,
        IF(p.is_quotable = 1, IFNULL(c.q_price, 'Cotizable'), p.price) `price`,
        p.stock,
        GROUP_CONCAT(DISTINCT BIN_TO_UUID(i.image_id)) images,
        GROUP_CONCAT(DISTINCT BIN_TO_UUID(v.video_id)) videos,
        BIN_TO_UUID(p.user_id) userId,
        IFNULL(uf.percentage, 0) `percentage`
    FROM 
    (SELECT
        BIN_TO_UUID(o.user_id) `user_id`,
        BIN_TO_UUID(p.product_id) `product_id`,
        p.name `product_name`,
        (s.quantity / (SELECT SUM(quantity) FROM
            shoppings AS s
            INNER JOIN
                orders AS o
            ON
                BIN_TO_UUID(s.order_id) = BIN_TO_UUID(o.order_id)
            WHERE
                BIN_TO_UUID(o.user_id) = _user_id)
        ) `percentage`
    FROM 
        shoppings AS s
    INNER JOIN
        orders AS o
    ON
        BIN_TO_UUID(s.order_id) = BIN_TO_UUID(o.order_id)
    INNER JOIN
        products AS p
    ON
        BIN_TO_UUID(s.product_id) = BIN_TO_UUID(p.product_id)
    WHERE
        BIN_TO_UUID(o.user_id) = _user_id OR o.user_id IS NULL
    GROUP BY
        BIN_TO_UUID(s.product_id)) uf
    RIGHT JOIN
        products AS p
    ON 
        uf.product_id = BIN_TO_UUID(p.product_id)
    LEFT JOIN
        images AS i
    ON
        BIN_TO_UUID(i.multimedia_entity_id) = BIN_TO_UUID(p.product_id)
    LEFT JOIN
        videos AS v
    ON
        BIN_TO_UUID(v.multimedia_entity_id) = BIN_TO_UUID(p.product_id)
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
        p.active = TRUE
        AND p.approved = TRUE
    GROUP BY
        p.product_id, 
        p.name,
        p.is_quotable, 
        p.price, 
        p.stock, 
        p.user_id,
        uf.percentage
    ORDER BY 
        uf.percentage DESC;

END $$
DELIMITER ;