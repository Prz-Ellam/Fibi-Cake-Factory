USE cake_factory;

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_create_review $$

CREATE PROCEDURE sp_create_review(
    IN _review_id               VARCHAR(36),
    IN _message                 VARCHAR(255),
    IN _rate                    SMALLINT,
    IN _product_id              VARCHAR(36),
    IN _user_id                 VARCHAR(36)
)
BEGIN

    INSERT INTO reviews(
        review_id,
        message,
        rate,
        product_id,
        user_id
    )
    VALUES(
        UUID_TO_BIN(_review_id),
        _message,
        _rate,
        UUID_TO_BIN(_product_id),
        UUID_TO_BIN(_user_id)
    );

END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_reviews_get_all_by_product $$

CREATE PROCEDURE sp_reviews_get_all_by_product(
    IN _product_id              VARCHAR(36)
)
BEGIN

    SELECT
        BIN_TO_UUID(r.review_id) id,
        r.message,
        r.rate,
        BIN_TO_UUID(r.product_id) productId,
        BIN_TO_UUID(r.user_id) userId,
        u.username,
        BIN_TO_UUID(u.profile_picture) profilePicture,
        r.created_at createdAt,
        r.modified_at modifiedAt
    FROM
        reviews AS r
    INNER JOIN
        users AS u
    ON
        BIN_TO_UUID(r.user_id) = BIN_TO_UUID(u.user_id)
    WHERE
        BIN_TO_UUID(product_id) = _product_id
    ORDER BY
        r.created_at DESC;

END $$
DELIMITER ;

