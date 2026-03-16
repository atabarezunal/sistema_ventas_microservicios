require("dotenv").config();

module.exports = (req, res, next) => {
    const apiKey = req.headers["x-api-key"];
    if (apiKey !== process.env.MICROSERVICE_API_KEY) {
        return res.status(401).json({
            message: "Unauthorized"
        });
    }
    next();
};