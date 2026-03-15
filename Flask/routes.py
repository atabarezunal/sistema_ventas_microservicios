from flask import Blueprint, request, jsonify
from models import create_product, get_products, check_stock, update_stock

inventory_routes = Blueprint("inventory_routes", __name__)


# Crear producto
@inventory_routes.route("/products", methods=["POST"])
def add_product():
    data = request.json
    product_id = create_product(data)
    return jsonify({
        "message": "Producto creado",
        "id": product_id
    })


# Listar productos
@inventory_routes.route("/products", methods=["GET"])
def list_products():
    products = get_products()
    return jsonify(products)


# Verificar stock
@inventory_routes.route("/products/<product_id>/stock", methods=["GET"])
def stock(product_id):
    stock = check_stock(product_id)
    if stock is None:
        return jsonify({"error": "Producto no existe"}), 404
    return jsonify({"stock": stock})


# Actualizar stock
@inventory_routes.route("/products/<product_id>/stock", methods=["PUT"])
def decrease_stock(product_id):
    data = request.json
    result = update_stock(product_id, data["quantity"])
    if result is None:
        return jsonify({"error": "Producto no existe"}), 404
    if result == "insufficient":
        return jsonify({"error": "Stock insuficiente"}), 400
    return jsonify({
        "message": "Stock actualizado",
        "stock": result
    })