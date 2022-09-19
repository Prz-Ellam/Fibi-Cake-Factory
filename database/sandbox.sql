USE cake_factory;

INSERT INTO users(email, username, user_role, birth_date, first_name, last_name, password, 
gender, profile_picture)
VALUES ('a@a.com', 'admin', 1, CURDATE(), 'elrod', 'perez', '123', 1, 1);


SELECT BIN_TO_UUID(image_id) FROM images;

CALL sp_get_image('bea500c4-2847-4493-92ed-ddc4b968fbc5');


SELECT * FROM users;

SELECT * FROM images;

SELECT * FROM products;
SELECT * FROM categories;
SELECT * FROM wishlists;
SELECT * FROM shopping_carts;
SELECT * FROM orders;
SELECT * FROM reviews;

