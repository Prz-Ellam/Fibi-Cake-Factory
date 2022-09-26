DELIMITER $$

CREATE PROCEDURE sp_create_order(
    IN _order_id                VARCHAR(36),
    IN _user_id                 VARCHAR(36),
    IN _phone                   VARCHAR(12),
    IN _address                 VARCHAR(50),
    IN _city                    VARCHAR(50),
    IN _state                   VARCHAR(50),
    IN _postal_code             VARCHAR(30)
)
BEGIN

    INSERT INTO orders(
        order_id,
        user_id,
        phone,
        address,
        city,
        state,
        postal_code
    )
    VALUES(
        UUID_TO_BIN(_order_id),
        UUID_TO_BIN(_user_id),
        _phone,
        _address,
        _city,
        _state,
        _postal_code
    );

END $$
DELIMITER ;


-- TODO: Bajar la cantidad de productos en la BD



SELECT 
    s.created_at,
    p.name,
    p.price,
    p.stock
FROM
    shoppings AS s
INNER JOIN
    products AS p
ON
    BIN_TO_UUID(s.product_id) = BIN_TO_UUID(p.product_id)
LEFT JOIN
    products_categories AS pc
ON
    BIN_TO_UUID(p.product_id) = BIN_TO_UUID(pc.product_id);



