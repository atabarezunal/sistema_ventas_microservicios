const Sale = require("../models/Sale");
const { checkStock } = require("../services/inventoryService");

const createSale = async (req, res) => {
    try {
        const { productId, quantity } = req.body;
        const stock = await checkStock(productId);
        if(stock < quantity){
            return res.status(400).json({
                message: "Stock insuficiente"
            });
        }
        const sale = new Sale({
            productId,
            quantity
        });
        await sale.save();
        res.json({
            message: "Venta registrada",
            sale
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