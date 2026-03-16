const express = require("express");
const router = express.Router();

const { createSale, getSales } = require("../controllers/salesController");
const verifyGateway = require("../middleware/auth");

// Rutas
router.get("/", verifyGateway, getSales);
router.post("/", verifyGateway, createSale);

module.exports = router;