from flask import Flask
from routes import inventory_routes

app = Flask(__name__)

app.register_blueprint(inventory_routes)

if __name__ == "__main__":
    app.run(port=5000, debug=True)