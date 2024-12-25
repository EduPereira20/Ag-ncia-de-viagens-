<?php 
session_start(); 

require_once './Connect.php'; 
require_once './DAO.php';
require_once './viagem.php'; 

if (!isset($_SESSION['id_user'])) {
    die("Você precisa estar logado para acessar esta página.");
}

// $conn já foi criado no Connect.php
$dao = new DAO();

if (isset($_GET['id'])) {
    $id_viagem = intval($_GET['id']);
    $dao->deletarViagem($id_viagem, $conn);
} else {
    echo "ID da viagem não especificado.";
}

$conn->close();
?>
