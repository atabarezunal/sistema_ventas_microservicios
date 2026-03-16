# sistema_ventas_microservicios
1. Arquitectura del Sistema

El sistema está compuesto por tres capas principales:

API Gateway (Laravel)

Gestiona la autenticación mediante JWT.

Recibe solicitudes de clientes y las enruta hacia los microservicios correspondientes.

Valida tokens y permite inicio y cierre de sesión.

Responsable de orquestar el flujo de ventas.

Microservicio de Inventario (Flask + Firebase)

Registro de productos.

Consulta de productos.

Verificación de stock.

Actualización de inventario después de ventas.

Microservicio de Ventas (Express + MongoDB)

Registro de ventas realizadas.

Consulta de ventas registradas.

Consulta de ventas por fecha o usuario.

Tecnologías utilizadas:

Componente	Tecnología
API Gateway	Laravel
Autenticación	JWT
Microservicio de Inventario	Flask + Firebase
Microservicio de Ventas	Express + MongoDB
2. Endpoints del Sistema
API Gateway (Laravel)

Todos los endpoints deben incluir el header Authorization: Bearer <token> cuando sea necesario.

Autenticación
Método	Endpoint	Descripción
POST	/login	Inicia sesión y devuelve JWT
POST	/logout	Cierra sesión y invalida token
GET	/me	Obtiene información del usuario autenticado
Ventas
Método	Endpoint	Descripción
POST	/api/sales	Crea una venta. Envía lista de productos y cantidades.
GET	/api/sales	Obtiene todas las ventas registradas del usuario.
GET	/api/sales/{id}	Obtiene una venta específica por ID.
Microservicio Flask (Inventario)
Método	Endpoint	Descripción
POST	/products	Registrar un nuevo producto.
GET	/products	Obtener todos los productos.
GET	/products/{id}	Consultar un producto por ID.
GET	/products/{id}/stock	Consultar stock de un producto.
PUT	/products/{id}/stock	Actualizar stock de un producto después de una venta.
Microservicio Express (Ventas)
Método	Endpoint	Descripción
POST	/sales	Registrar una venta.
GET	/sales	Listar todas las ventas.
GET	/sales/{id}	Obtener una venta específica.
3. Flujo de Registro de una Venta

Validación de usuario:
El cliente envía una solicitud de venta al API Gateway con su token JWT. El gateway valida el token.

Verificación de inventario:
El API Gateway consulta al microservicio de Flask el stock de cada producto solicitado. Si algún producto no tiene stock suficiente, se devuelve un error al cliente.

Registro de venta:
Una vez verificado el stock, el API Gateway envía los datos de la venta al microservicio de Express para registrarla en MongoDB.

Actualización de inventario:
Tras confirmar la venta, el microservicio de Flask actualiza el stock de los productos vendidos.

Respuesta al cliente:
Se devuelve al cliente un JSON indicando el éxito de la operación y los detalles de la venta.

Ejemplo de JSON de venta:

{
  "success": true,
  "sale": {
    "products": [
      {
        "product_id": "-OnnXB8vJdZIyGPg1Fr_",
        "quantity": 2
      }
    ],
    "total": 150
  }
}
| - Productos      |      | - Consultas      |
+------------------+      +------------------+
