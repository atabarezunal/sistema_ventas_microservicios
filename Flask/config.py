import firebase_admin
from firebase_admin import credentials, db

cred = credentials.Certificate("serviceAccountKey.json")

firebase_admin.initialize_app(cred, {
    "databaseURL": "https://flask-firebase-9d2e8-default-rtdb.firebaseio.com/"
})

database = db.reference()