const express = require('express');
const mysql = require('mysql');
const cors = require('cors');

const app = express();
const port = 3306; // Alterado para uma porta padrão para servidor web

// Configuração do CORS para permitir requisições do frontend
app.use(cors());

// Configuração da conexão com o banco de dados MySQL
const conn = mysql.createConnection({
    host: 'ESN509VMYSQL', // ou '127.0.0.1'
    user: 'aluno',
    password: 'Senai1234',
    database: 'marketfov'
});

// Conectar ao banco de dados
conn.connect((err) => {
    if (err) {
        console.error('Erro ao conectar ao banco de dados MySQL:', err);
        return;
    }
    console.log('Conectado ao banco de dados MySQL!');
});

// Rota para obter dados da tabela venda
app.get('/vendas', (req, res) => {
    const query = 'SELECT venda.dataVenda, venda.totalVenda FROM venda;' // Substitua pelo seu SQL
    conn.query(query, (err, results) => {
        if (err) {
            console.error('Erro ao executar a consulta:', err);
            res.status(500).json({ error: 'Erro ao executar a consulta' });
            return;
        }
        res.json(results);
    });
    console.log("Rota /vendas foi acessada.");
});

// Iniciar o servidor
app.listen(port, () => {
    console.log(`Servidor rodando na porta ${port}`);
});

// AO ALTERAR LEMBRAR DE SALVAR (CTRL + S)