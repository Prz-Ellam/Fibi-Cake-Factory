
-- Damos de alta todos los roles de usuario
INSERT INTO user_roles(name)
VALUES('super administrador');

INSERT INTO user_roles(name)
VALUES('administrador');

INSERT INTO user_roles(name)
VALUES('vendedor');

INSERT INTO user_roles(name)
VALUES('comprador');

-- Este es el super administrador
INSERT INTO users()
VALUES ('admin', 'admin@correo.com', 'admin');


SELECT * FROM user_roles;
