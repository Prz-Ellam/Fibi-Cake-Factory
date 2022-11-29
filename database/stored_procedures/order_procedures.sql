DELIMITER $$
DROP PROCEDURE IF EXISTS sp_create_order $$

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
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_get_orders_report $$

CREATE PROCEDURE sp_get_orders_report(
    IN _user_id             VARCHAR(36),
    IN _category_id         VARCHAR(36),
    IN _from                DATE,
    IN _to                  DATE
)
BEGIN

    SELECT
        date,
        GROUP_CONCAT(categories) categories,
        productName,
        rate,
        price
    FROM
        vw_orders_report
    WHERE
        user = _user_id
        AND (categories_id = _category_id OR _category_id IS NULL)
        AND (date BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'))
    GROUP BY
        date,
        productName,
        rate,
        price;

END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_get_sales_report $$

CREATE PROCEDURE sp_get_sales_report(
    IN _user_id             VARCHAR(36),
    IN _category_id         VARCHAR(36),
    IN _from                DATE,
    IN _to                  DATE
)
BEGIN

    SELECT
        date,
        GROUP_CONCAT(categories) categories,
        productName,
        rate,
        price,
        stock
    FROM
        vw_sales_report
    WHERE
        user = _user_id
        AND (categories_id = _category_id OR _category_id IS NULL)
        AND (date BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'))
    GROUP BY
        date,
        productName,
        rate,
        price;

END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_get_sales_report_2 $$

CREATE PROCEDURE sp_get_sales_report_2(
    IN _user_id             VARCHAR(36),
    IN _category_id         VARCHAR(36),
    IN _from                DATE,
    IN _to                  DATE
)
BEGIN

    SELECT
        date,
        category,
        quantity
    FROM
        vw_sales_report_2
    WHERE
        user_id = _user_id
        AND (category_id = _category_id OR _category_id IS NULL)
        AND (date BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'));

END $$
DELIMITER ;