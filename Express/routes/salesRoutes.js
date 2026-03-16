const express = require("express");
const router = express.Router();

const {
    createSale,
    getSales
} = require("../controllers/salesController");

const verifyGateway = require("../middleware/auth");


// Obtener ventas
router.get("/", verifyGateway, getSales);

// Crear venta
router.post("/", verifyGateway, createSale);


module.exports = router;