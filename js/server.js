const express = require('express');
const mysql = require('mysql2');
const cors = require('cors');

const app = express();
const port = 3306; // Alterado para uma porta padrão para servidor web

// Configuração do CORS para permitir requisições do frontend
app.use(cors());

// Configuração da conexão com o banco de dados MySQL
const conn = mysql.createConnection({
    host: 'localhost', // ou '127.0.0.1'
    user: 'root',
    password: '',
    database: 'marketfov5',
    port: 3307
});

// Conectar ao banco de dados
conn.connect((err) => {
    if (err) {
        console.error('erro ao conectar ao banco de dados MySQL:', err);
        return;
    }
    console.log('Conectado ao banco de dados MySQL!');
});


// Rota para obter dados da tabela venda
app.get('/vendas', (req, res) => {

    const cnpj = req.query.cnpj; // Obtém o CNPJ dos parâmetros da URL

    if (!cnpj) {
        return res.status(400).json({ error: "CNPJ não fornecido na URL" });
    }

    const query = `SELECT venda.dataVenda, venda.totalVenda FROM venda WHERE cnpj = ?;`; // Usando placeholder para segurança
    conn.query(query, [cnpj], (err, results) => {
        if (err) {
            console.error('Erro ao executar a consulta:', err);
            return res.status(500).json({ error: 'Erro ao executar a consulta' });
        }
        res.json(results);
    });
    console.log(`Consulta de vendas feita para o CNPJ: ${cnpj}`);
});

// Rota para obter TODOS dados da tabela venda
app.get('/vendas-totais', (req, res) => {
    const cnpj = req.query.cnpj; // Obtém o CNPJ dos parâmetros da URL

    if (!cnpj) {
        return res.status(400).json({ error: "CNPJ não fornecido na URL" });
    }

    const query = 'SELECT * FROM venda WHERE cnpj = ?;'; // Usando o CNPJ obtido para filtrar as vendas
    conn.query(query, [cnpj], (err, results) => {
        if (err) {
            console.error('Erro ao executar a consulta:', err);
            res.status(500).json({ error: 'Erro ao executar a consulta' });
            return;
        }
        res.json(results);
    });
    console.log(`Consulta de vendas totais feita para o CNPJ: ${cnpj}`);
});

app.get('/produtos-vendidos', (req, res) => {
    const cnpj = req.query.cnpj;  // Obtém o CNPJ dos parâmetros da URL

    if (!cnpj) {
        return res.status(400).json({ error: "CNPJ não fornecido na URL" });
    }

    const query = 'SELECT pvd.qtdVendidos, p.barCode, p.id, p.nome, pvd.codeCupom FROM produtosVendidos pvd JOIN produtos p ON p.barCode = pvd.barCode JOIN venda v ON v.codeCupom = pvd.codeCupom WHERE v.cnpj = ?;';

    conn.query(query, [cnpj], (err, results) => {
        if (err) {
            console.error('Erro ao executar a consulta:', err);
            res.status(500).json({ error: 'Erro ao executar a consulta' });
            return;
        }
        res.json(results);
    });

    console.log("Rota /produtos-vendidos foi acessada.");
});

// Iniciar o servidor
app.listen(port, () => {
    console.log(`Servidor rodando na porta ${port}`);
});

// AO ALTERAR LEMBRAR DE SALVAR (CTRL + S)