from config import database

# Crear producto
def create_product(data):
    ref = database.child("products")
    new_product = ref.push({
        "name": data["name"],
        "price": data["price"],
        "stock": data["stock"]
    })
    return new_product.key


# Obtener productos
def get_products():
    ref = database.child("products")
    products = ref.get()
    result = []
    if products:
        for key, value in products.items():
            value["id"] = key
            result.append(value)
    return result


# Verificar stock
def check_stock(product_id):
    ref = database.child("products").child(product_id)
    product = ref.get()
    if not product:
        return None
    return product["stock"]


# Actualizar stock
def update_stock(product_id, quantity):
    ref = database.child("products").child(product_id)
    product = ref.get()
    if not product:
        return None
    stock = product["stock"]
    new_stock = stock - quantity
    if new_stock < 0:
        return "insufficient"
    ref.update({
        "stock": new_stock
    })

    return new_stock