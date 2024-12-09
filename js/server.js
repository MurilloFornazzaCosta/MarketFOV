const express = require('express');
const mysql = require('mysql');
const cors = require('cors');
const fs = require('fs');
const path = require('path');
const phpUnserialize = require('php-unserialize');

const app = express();
const port = 3306; // Porta padrão para servidor web
const sessionPath = "C:/xampp/tmp"; // Caminho para os arquivos de sessão do PHP

// Configuração do CORS para permitir requisições do frontend
app.use(cors());

// Middleware para acessar o CNPJ da sessão
app.use((req, res, next) => {
    const sessionId = req.cookies?.['PHPSESSID']; // Obtém o ID da sessão do cookie PHP
    if (!sessionId) {
        return res.status(401).json({ error: "Sessão não encontrada" });
    }

    // Localiza o arquivo da sessão correspondente
    const sessionFile = path.join(sessionPath, `sess_${sessionId}`);
    fs.readFile(sessionFile, 'utf8', (err, data) => {
        if (err) {
            console.error("Erro ao ler a sessão:", err);
            return res.status(500).json({ error: "Erro ao acessar a sessão" });
        }

        try {
            const sessionData = phpUnserialize(data); // Decodifica os dados da sessão PHP
            const cnpj = sessionData?.cnpj; // Obtém o CNPJ da sessão

            if (!cnpj) {
                return res.status(401).json({ error: "CNPJ não encontrado na sessão" });
            }

            req.cnpj = cnpj; // Disponibiliza o CNPJ para outras rotas
            next();
        } catch (err) {
            console.error("Erro ao desserializar a sessão:", err);
            return res.status(500).json({ error: "Erro ao processar a sessão" });
        }
    });
});

// Configuração da conexão com o banco de dados MySQL
const conn = mysql.createConnection({
    host: 'ESN509VMYSQL', // ou '127.0.0.1'
    user: 'aluno',
    password: 'Senai1234',
    database: 'marketfov4'
});

// Conectar ao banco de dados
conn.connect((err) => {
    if (err) {
        console.error('Erro ao conectar ao banco de dados MySQL:', err);
        return;
    }
    console.log('Conectado ao banco de dados MySQL!');
});

// Rota para obter dados da tabela venda com base no CNPJ da sessão
app.get('/vendas', (req, res) => {
    const cnpj = req.cnpj; // Recupera o CNPJ processado no middleware
    const query = `SELECT * FROM venda WHERE cnpj = '${cnpj}'`;

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

// Rota para obter todos os dados da tabela venda
app.get('/vendas-totais', (req, res) => {
    const query = 'SELECT * FROM venda;';
    conn.query(query, (err, results) => {
        if (err) {
            console.error('Erro ao executar a consulta:', err);
            res.status(500).json({ error: 'Erro ao executar a consulta' });
            return;
        }
        res.json(results);
    });
    console.log("Rota /vendas-totais foi acessada.");
});

// Rota para obter produtos vendidos
app.get('/produtos-vendidos', (req, res) => {
    const query = `
        SELECT pvd.qtdVendidos, p.barCode, p.id, p.nome, pvd.codeCupom, v.im 
        FROM produtosvendidos pvd 
        JOIN produtos p ON pvd.id = p.id AND pvd.barCode = p.barCode 
        JOIN venda v ON v.codeCupom = pvd.codeCupom;
    `;
    conn.query(query, (err, results) => {
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
