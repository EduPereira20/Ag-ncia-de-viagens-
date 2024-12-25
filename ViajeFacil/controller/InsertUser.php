<?php require_once 'DAO.php'; ?>
<?php require_once 'User.php'; ?>
<?php


 $nome = $_POST["nome"];
 $email = $_POST["email"];
 $telefone = $_POST["telefone"];
 $senha = $_POST["senha"];

 $insert = new User();
 $insert->setNome($nome);
 $insert->setEmail($email);
 $insert->setTelefone($telefone);
 $insert->setSenha($senha);

 $DAO = new DAO();

 $DAO->insertUser($insert, $conn);
 $DAO->logar($insert, $conn);
 



?>
