import os
from flask import request, jsonify

API_KEY = os.getenv("MICROSERVICE_API_KEY")

def verify_gateway(req):

    key = req.headers.get("X-API-KEY")

    if key != API_KEY:
        return False

    return True