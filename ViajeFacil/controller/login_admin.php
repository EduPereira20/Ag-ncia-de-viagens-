<?php
require_once 'DAO.php';
require_once 'class_admin.php';

// Estabelecer conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "viajeFacil");

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$usuario = $_POST["user_admin"];
$senha = $_POST["password_admin"];


$logar_admin = new Administrador();
$logar_admin->setUserAdmin($usuario);
$logar_admin->setPasswordAdmin($senha);

$DAO = new DAO();
$DAO->logar_admin($conn, $logar_admin);
?>
