- Users                     Usuario
- User roles                Rol de usuario
- Products                  Producto
- Categories                Categoría
- Wishlists                 Lista de deseo
- Wishlists Objects         Objeto de lista
- Shopping Carts            Carrito de compras
- Shopping Cart Items       Elemento de carrito
- Messages                  Mensaje
- Chats                     Chat
- Comments                  Comentario
- Shoppings                 Compra
- Orders                    Orden


1 Rol de usuario            tiene       M Usuarios
1 Usuario                   tiene       M Productos
1 Usuario                   tiene       M Categorías
1 Usuario                   tiene       M Listas de deseos
1 Usuario                   tiene       1 Carrito de compras
M Productos                 tienen      M Categorias
1 Lista de deseos           tiene       M Objetos
1 Carrito de compras        tiene       M Elementos
1 Producto                  tiene       M Mensajes
1 Usuario                   tiene       M Mensajes
1 Chat                      tiene       M Mensajes
1 Orden                     tiene       M Compras
