CREATE DATABASE viajeFacil;
USE viajeFacil;
drop database viajefacil;

CREATE TABLE usuario (
    id_user INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    email_user VARCHAR(50) NOT NULL,
    name_user VARCHAR(100) NOT NULL,
    number_user CHAR(11) NOT NULL,
    password_user VARCHAR(255) NOT NULL
);

CREATE TABLE viagem (
    id_viagem INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_user INT NOT NULL,
    destino VARCHAR(100) NOT NULL,
    data_ida DATE NOT NULL,
    data_volta DATE NOT NULL,
    numero_adultos INT NOT NULL,
    numero_criancas INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES usuario(id_user) ON DELETE CASCADE
);

CREATE TABLE log (
    id_log INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_user INT NOT NULL,
    acao VARCHAR(255) NOT NULL,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES usuario(id_user) ON DELETE CASCADE
);

CREATE TABLE administradores (
	id_admin INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR (100) NOT NULL, 
    usuario VARCHAR (30) NOT NULL,
    senha VARCHAR(30) NOT NULL
);

INSERT INTO administradores (nome, usuario, senha) 
VALUES ('Ana Laíssa dos Santos Silva', 'adminViajeFacil', '840275G13');

ALTER TABLE viagem ADD COLUMN valor_total DECIMAL(10, 2) NOT NULL DEFAULT 0;

truncate log;
truncate usuario;
truncate viagem;
truncate administradores;

select * from administradores;
select * from log;
select * from viagem;
select * from usuario;

SET FOREIGN_KEY_CHECKS = 0;
SET FOREIGN_KEY_CHECKS = 1;



