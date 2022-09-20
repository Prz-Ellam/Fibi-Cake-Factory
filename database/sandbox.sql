USE cake_factory;

INSERT INTO users(email, username, user_role, birth_date, first_name, last_name, password, 
gender, profile_picture)
VALUES ('a@a.com', 'admin', 1, CURDATE(), 'elrod', 'perez', '123', 1, 1);


SELECT BIN_TO_UUID(user_id), email FROM users;

CALL sp_get_image('bea500c4-2847-4493-92ed-ddc4b968fbc5');

CALL sp_get_user_wishlists('4b8c6a1b-ab63-461e-9576-029d0d7f256c');

SELECT *, BIN_TO_UUID(user_id) as 'user_id' FROM users;

SELECT *, BIN_TO_UUID(wishlist_id) as 'wishlist_id' FROM wishlists;

SELECT * FROM images;

SELECT * FROM products;
SELECT * FROM categories;
SELECT * FROM wishlists;
SELECT * FROM shopping_carts;
SELECT * FROM orders;
SELECT * FROM reviews;



CALL sp_update_wishlist('6579eafa-bd06-4f5f-8b75-f66b257908a7', 'Adios', 'Mundo', 0);