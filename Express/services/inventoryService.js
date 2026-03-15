const axios = require("axios");

const checkStock = async (productId) => {
    const url = `${process.env.FLASK_INVENTORY_URL}/products/${productId}/stock`;
    const response = await axios.get(url);
    return response.data.stock;
};

module.exports = { checkStock };