const Sale = require("../models/Sale");
const { checkStock } = require("../services/inventoryService");

const createSale = async (req, res) => {
    try {
        // soportar un solo producto o un arreglo de productos
        const products = req.body.products || [{
            productId: req.body.productId,
            quantity: req.body.quantity
        }];

        if (!products || !products.length) {
            return res.status(400).json({ message: "Faltan productos para la venta" });
        }

        const stockErrors = [];

        // verificar stock de cada producto
        for (const p of products) {
            const stock = await checkStock(p.productId);
            if (stock < p.quantity) {
                stockErrors.push({
                    product_id: p.productId,
                    available: stock,
                    requested: p.quantity
                });
            }
        }

        if (stockErrors.length > 0) {
            return res.status(400).json({
                message: "Stock insuficiente",
                details: stockErrors
            });
        }

        // guardar venta de cada producto
        const savedSales = [];
        for (const p of products) {
            const sale = new Sale(p);
            await sale.save();
            savedSales.push(sale);
        }

        res.json({
            message: "Venta registrada",
            sales: savedSales
        });

    } catch (error) {
        res.status(500).json({
            message: "Error registrando venta",
            error: error.message
        });
    }
};

const getSales = async (req, res) => {
    const sales = await Sale.find();
    res.json(sales);
};

module.exports = {
    createSale,
    getSales
};