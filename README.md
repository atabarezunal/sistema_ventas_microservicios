# sistema_ventas_microservicios
| Componente                  | Tecnología        | Función principal                                                      |
| --------------------------- | ----------------- | ---------------------------------------------------------------------- |
| API Gateway                 | Laravel + JWT     | Autenticación, validación de tokens, orquestación de ventas.           |
| Microservicio de Inventario | Flask + Firebase  | Registro de productos, consulta de stock, actualización de inventario. |
| Microservicio de Ventas     | Express + MongoDB | Registro de ventas, consulta por venta, fecha o usuario.               |


# Flujo general de la venta:

- Cliente envía solicitud de venta con JWT.
- API Gateway valida el token.
- Se consulta stock en microservicio de Flask.
- Si hay suficiente stock, se registra la venta en microservicio de Express.
- Se actualiza el stock de los productos vendidos.
- Se devuelve respuesta al cliente.
- 
# Endpoints del Sistema
🔑 API Gateway (Laravel)
Autenticación:
Método	Endpoint	Descripción
POST	/login	Inicia sesión y devuelve JWT
POST	/logout	Cierra sesión
GET	/me	Información del usuario autenticado
Ventas
Método	Endpoint	Descripción
POST	/api/sales	Registrar una venta
GET	/api/sales	Consultar todas las ventas
GET	/api/sales/{id}	Consultar venta por ID

# Microservicio flask

| Método | Endpoint               | Descripción               |
| ------ | ---------------------- | ------------------------- |
| POST   | `/products`            | Registrar producto        |
| GET    | `/products`            | Listar productos          |
| GET    | `/products/{id}`       | Consultar producto por ID |
| GET    | `/products/{id}/stock` | Verificar stock           |
| PUT    | `/products/{id}/stock` | Actualizar stock          |

# Microservicio de express

| Método | Endpoint      | Descripción                |
| ------ | ------------- | -------------------------- |
| POST   | `/sales`      | Registrar venta            |
| GET    | `/sales`      | Listar todas las ventas    |
| GET    | `/sales/{id}` | Consultar venta específica |

