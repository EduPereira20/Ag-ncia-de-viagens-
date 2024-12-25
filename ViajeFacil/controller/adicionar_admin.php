<?php
require_once 'DAO.php';
require_once 'class_admin.php';


$conn = new mysqli("localhost", "root", "", "viajeFacil");

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST["name_admin"];
    $usuario = $_POST["user_admin"];
    $senha = $_POST["password_admin"];

    $novoAdmin = new Administrador();
    $novoAdmin->setNameAdmin($nome);
    $novoAdmin->setUserAdmin($usuario);
    $novoAdmin->setPasswordAdmin($senha);

    $DAO = new DAO();
    $DAO->insert_admin($conn, $novoAdmin);
}
?>
