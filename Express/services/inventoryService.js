const axios = require("axios");

const INVENTORY_URL = process.env.FLASK_INVENTORY_URL;
const API_KEY = process.env.MICROSERVICE_API_KEY;

const checkStock = async (productId) => {
    try {
        const response = await axios.get(`${INVENTORY_URL}/products/${productId}/stock`, {
            headers: {
                "X-API-KEY": API_KEY
            }
        });
        return response.data.stock ?? 0;
    } catch (error) {
        console.error("Error checking stock:", error.response?.data || error.message);
        return null;
    }
};

module.exports = { checkStock };