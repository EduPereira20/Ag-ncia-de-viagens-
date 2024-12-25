<?php
require_once 'Connect.php'; 
require_once 'DAO.php';
require_once 'viagem.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtendo os dados do formulário
    $destino = $_POST['destino'] ?? null;
    $data_ida = $_POST['data-ida'] ?? null;
    $data_volta = $_POST['data-volta'] ?? null;
    $numero_adultos = $_POST['adultos'] ?? null;
    $numero_criancas = $_POST['criancas'] ?? null;

    if (isset($destino, $data_ida, $data_volta, $numero_adultos, $numero_criancas)) {
        session_start();

        if (!isset($_SESSION['id_user'])) {
            echo "Usuário não está logado.";
            header("Location: ../login.html");
            exit; 
        } else {
        }

        $id_user = $_SESSION['id_user']; 

        $DAO = new DAO(); 
        $insertViagem = new Viagem();

        $insertViagem->setDestino($destino);
        $insertViagem->setDataIda($data_ida);
        $insertViagem->setDataVolta($data_volta);
        $insertViagem->setNumeroAdultos($numero_adultos);
        $insertViagem->setNumeroCriancas($numero_criancas);

        $result = $DAO->insertViagem($insertViagem, $conn, $id_user);

        if ($result) {
            echo "Viagem cadastrada com sucesso!";
        } else {
            echo "Erro ao cadastrar a viagem.";
        }
    } else {
        echo "Dados incompletos.";
    }
} else {
    echo "Método não suportado.";
}
?>
