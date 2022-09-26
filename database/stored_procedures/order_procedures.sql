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