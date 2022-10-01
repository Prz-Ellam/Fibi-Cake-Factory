-- Aqui crearemos las vistas para el reporte de ventas

DELIMITER $$

DROP VIEW IF EXISTS vw_sales_report $$

CREATE VIEW vw_sales_report
AS

    SELECT
        BIN_TO_UUID(s.shopping_id) `shopping_id`,
        s.created_at `date`,
        c.name `categories`,
        BIN_TO_UUID(c.category_id) `categories_id`,
        p.name `productName`,
        IFNULL(AVG(r.rate), 'No reviews') `rate`,
        s.amount / s.quantity `price`,
        BIN_TO_UUID(p.user_id) `user`,
        p.stock `stock`
    FROM
        shoppings AS s
    INNER JOIN
        products AS p
    ON
        BIN_TO_UUID(s.product_id) = BIN_TO_UUID(p.product_id)
    INNER JOIN 
        products_categories AS pc
    ON 
        BIN_TO_UUID(s.product_id) = BIN_TO_UUID(pc.product_id)
    INNER JOIN 
        categories AS c
    ON 
        BIN_TO_UUID(pc.category_id) = BIN_TO_UUID(c.category_id)
    LEFT JOIN 
        reviews AS r
    ON
        BIN_TO_UUID(s.product_id) = BIN_TO_UUID(r.product_id)
    GROUP BY
        s.shopping_id,
        s.created_at,
        c.name,
        c.category_id,
        p.name,
        s.amount,
        s.quantity,
        p.user_id,
        p.stock;






DELIMITER $$
DROP VIEW IF EXISTS vw_sales_report_2 $$

CREATE VIEW vw_sales_report_2
AS

SELECT
    s.created_at `date`,
    c.name `category`,
    BIN_TO_UUID(c.user_id) `category_id`,
    COUNT(s.quantity) `quantity`,
    BIN_TO_UUID(p.user_id) `user_id`
FROM
    shoppings AS s
INNER JOIN
    products AS p
ON
    BIN_TO_UUID(s.product_id) = BIN_TO_UUID(p.product_id)
INNER JOIN
    products_categories AS pc
ON
    BIN_TO_UUID(s.product_id) = BIN_TO_UUID(pc.product_id)
INNER JOIN
    categories AS c
ON
    BIN_TO_UUID(pc.category_id) = BIN_TO_UUID(c.category_id)
GROUP BY
    YEAR(s.created_at), MONTH(s.created_at), c.name, p.user_id;


