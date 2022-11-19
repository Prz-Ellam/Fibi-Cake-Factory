-- Aquí crearemos las vistas para el reporte de pedidos

DELIMITER $$
DROP VIEW IF EXISTS vw_orders_report $$

CREATE VIEW vw_orders_report
AS

    SELECT 
        BIN_TO_UUID(s.shopping_id) `shopping_id`,
        s.created_at `date`,
        c.name `categories`,
        BIN_TO_UUID(c.category_id) `categories_id`,
        p.name `productName`,
        IFNULL(AVG(r.rate), 'No reviews') `rate`,
        s.amount / s.quantity `price`,
        BIN_TO_UUID(o.user_id) `user`
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
        s.amount,
        s.quantity,
        p.name,
        o.user_id;



SELECT * FROM vw_orders_report

