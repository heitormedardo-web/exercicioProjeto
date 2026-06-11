USE agenda;

CREATE TABLE contatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefone VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    endereco TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    estoque INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO contatos (nome, email, telefone) VALUES
('Ana Silva', 'ana.silva@email.com', '(11) 91234-5678'),
('Bruno Costa', 'bruno.costa@email.com', '(21) 98765-4321'),
('Carla Mendes', 'carla.mendes@email.com', '(31) 99876-5432'),
('Diego Rocha', 'diego.rocha@email.com', '(41) 97654-3210'),
('Elena Ferreira', 'elena.ferreira@email.com', '(51) 96543-2109');

INSERT INTO clientes (nome, cpf, email, telefone, endereco) VALUES
('João Santos', '123.456.789-00', 'joao@email.com', '(11) 99999-1111', 'Rua A, 123 - São Paulo, SP'),
('Maria Oliveira', '987.654.321-00', 'maria@email.com', '(21) 98888-2222', 'Av. B, 456 - Rio de Janeiro, RJ'),
('Pedro Souza', '456.789.123-00', 'pedro@email.com', '(31) 97777-3333', 'Rua C, 789 - Belo Horizonte, MG');

INSERT INTO produtos (nome, descricao, preco, estoque) VALUES
('Notebook Dell', 'Intel Core i5, 8GB RAM, 256GB SSD', 3500.00, 10),
('Mouse Gamer', 'RGB, 6 botões, 4800 DPI', 89.90, 50),
('Teclado Mecânico', 'Switch azul, RGB, ABNT2', 199.90, 30);

SELECT '=== CONTATOS (SUA AGENDA) ===' AS '';
SELECT * FROM contatos;

SELECT '=== CLIENTES ===' AS '';
SELECT * FROM clientes;

SELECT '=== PRODUTOS ===' AS '';
SELECT * FROM produtos;
USE agenda;

ALTER TABLE produtos ADD COLUMN imagem VARCHAR(255) NULL;