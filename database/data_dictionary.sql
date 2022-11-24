SELECT 
    BIN_TO_UUID(p.product_id) `product_id`,
    p.name,
    p.is_quotable,
    p.price,
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
            BIN_TO_UUID(o.user_id) = 'd356d225-0cab-4b25-9d6a-fefa66a71990')
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
    BIN_TO_UUID(o.user_id) = 'd356d225-0cab-4b25-9d6a-fefa66a71990' OR o.user_id IS NULL
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







SELECT
    SUM(quantity)
FROM
    shoppings AS s
INNER JOIN
    orders AS o
ON
    BIN_TO_UUID(s.order_id) = BIN_TO_UUID(o.order_id)
WHERE
    BIN_TO_UUID(o.user_id) = 'd356d225-0cab-4b25-9d6a-fefa66a71990';



DELETE FROM quotes;


SELECT * FROM
(SELECT
    BIN_TO_UUID(product_id) `product_id`,
    name,
    description,
    is_quotable,
    IF(is_quotable = 1, 'Cotizable', price),
    stock,
    BIN_TO_UUID(user_id) `user_id`
FROM
    products
WHERE
    active = TRUE) p
LEFT JOIN
(SELECT
    BIN_TO_UUID(product_id) `q_product_id`, 
    BIN_TO_UUID(user_id) `q_user_id`, 
    price 
FROM
    quotes
WHERE
    BIN_TO_UUID(user_id) = 'd356d225-0cab-4b25-9d6a-fefa66a71990') c
ON p.product_id = c.q_product_id AND c.price IS NOT NULL;




SELECT * FROM products AS p
LEFT JOIN quotes AS q
ON p.product_id = q.product_id AND q.price IS NOT NULL