require("dotenv").config();

const express = require("express");
const cors = require("cors");

const connectDB = require("./config/db");
const salesRoutes = require("./routes/salesrRoutes");

const app = express();


// Conectar a MongoDB
connectDB();


// Middlewares
app.use(cors());
app.use(express.json());


// Rutas
app.use("/sales", salesRoutes);


// Ruta de prueba
app.get("/", (req, res) => {
    res.send("Sales Microservice running");
});


const PORT = process.env.PORT || 3000;

app.listen(PORT, () => {
    console.log(`Sales service running on port ${PORT}`);
});