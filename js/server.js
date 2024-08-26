const express = require('express');
const mysql = require('mysql2');
const cors = require('cors');

const app = express();
const port = 3000;

// Configuração do CORS para permitir requisições do frontend
app.use(cors());

// Configuração da conexão com o banco de dados MySQL
const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'sua_senha',
    database: 'seu_banco_de_dados'
});

// Conectar ao banco de dados
connection.connect((err) => {
    if (err) throw err;
    console.log('Conectado ao banco de dados MySQL!');
});

// Rota para obter dados
app.get('/dados', (req, res) => {
    const query = 'SELECT mes, vendas FROM sua_tabela'; // Substitua pelo seu SQL
    connection.query(query, (err, results) => {
        if (err) throw err;
        res.json(results);
    });
});

// Iniciar o servidor
app.listen(port, () => {
    console.log(`Servidor rodando na porta ${port}`);
});