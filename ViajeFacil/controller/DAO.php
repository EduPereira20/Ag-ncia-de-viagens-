<?php 
require_once 'Connect.php';

class DAO {

    public function getLogs($conn) {
        $logs = [];
        $sql = "SELECT log.id_log, log.acao, log.data_acao, usuario.email_user 
                FROM log 
                INNER JOIN usuario ON log.id_user = usuario.id_user
                ORDER BY log.data_acao DESC";
        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            while ($row = mysqli_fetch_assoc($result)) {
                $logs[] = $row;
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Erro ao buscar logs: " . mysqli_error($conn);
        }
        
        return $logs;
    }
    private function salvarLog($conn, $id_user, $acao) {

        $sqlEmail = "SELECT email_user FROM usuario WHERE id_user = ?";
        $stmtEmail = mysqli_prepare($conn, $sqlEmail);
        mysqli_stmt_bind_param($stmtEmail, 'i', $id_user);
        mysqli_stmt_execute($stmtEmail);
        $resultEmail = mysqli_stmt_get_result($stmtEmail);
    
        if ($resultEmail && $row = mysqli_fetch_assoc($resultEmail)) {
            $email = $row['email_user'];
        } else {
            $email = 'Usuário desconhecido';
        }
        mysqli_stmt_close($stmtEmail);
    
        $mensagemLog = "Realizou a seguinte acao: $acao";
    
        $sqlLog = "INSERT INTO log (id_user, acao) VALUES (?, ?)";
        $stmtLog = mysqli_prepare($conn, $sqlLog);
        mysqli_stmt_bind_param($stmtLog, 'is', $id_user, $mensagemLog);
        mysqli_stmt_execute($stmtLog);
        mysqli_stmt_close($stmtLog);
    }

    // Método para inserir usuário e salvar log da ação
    function insertUser($insert, $conn) {
        if ($conn instanceof mysqli) {
            $sqlSelect = "SELECT * FROM usuario WHERE email_user = ?";
            $email = $insert->getEmail();

            $stmtSelect = mysqli_prepare($conn, $sqlSelect);
            mysqli_stmt_bind_param($stmtSelect, "s", $email);
            mysqli_stmt_execute($stmtSelect);
            $result = mysqli_stmt_get_result($stmtSelect);

            if (mysqli_num_rows($result) > 0) {
                header("Location: ../usuario-ja-cadastrado.html");
                exit;
            } else {
                $sql = "INSERT INTO usuario (email_user, name_user, number_user, password_user) VALUES (?, ?, ?, ?)";
                $nome = $insert->getNome();
                $telefone = $insert->getTelefone();
                $senha = $insert->getSenha();

                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, 'ssss', $email, $nome, $telefone, $senha);
                try {
                    mysqli_stmt_execute($stmt);
                    $id_user = mysqli_insert_id($conn);
                    $this->salvarLog($conn, $id_user, "Usuario realizou cadastro.");
                    mysqli_stmt_close($stmt);
                    header("Location: ../index.html");
                    exit;
                } catch (mysqli_sql_exception $e) {
                    echo "Fatal Error: " . $e->getMessage();
                }
            }
            mysqli_stmt_close($stmtSelect);
        } else {
            echo "Erro de conexão";
        }
    }

    function logar($conn, $logar) {
        $sql = "SELECT * FROM usuario WHERE email_user = ? AND password_user = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            $email = $logar->getEmail();
            $senha = $logar->getSenha();

            mysqli_stmt_bind_param($stmt, "ss", $email, $senha);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($resultado) > 0) {
                $user_data = mysqli_fetch_assoc($resultado);
                session_start();
                $_SESSION['id_user'] = $user_data['id_user'];
                header("Location: ../home.html");
                exit;
            } else {
                header("Location: ../credenciais-invalidas.html");
                exit;
            }
        }
    }

    public function insertViagem($dados_viagem, $conn, $id_user) {
        if (!$conn) {
            echo "Conexão inválida.";
            return false;
        }
    
        $destino = $dados_viagem->getDestino();
        $dataIda = $dados_viagem->getDataIda();
        $dataVolta = $dados_viagem->getDataVolta();
        $adultos = $dados_viagem->getNumeroAdultos();
        $criancas = $dados_viagem->getNumeroCriancas();
    
        if (strtotime($dataVolta) < strtotime($dataIda)) {
            header("Location: ../data-viagem.html");
            exit;
        }
    
        $sql = "INSERT INTO viagem (id_user, destino, data_ida, data_volta, numero_adultos, numero_criancas, valor_total)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
    
        $valorTotal = ($adultos * 1000) + ($criancas * 250);
        
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            echo "Erro na preparação da consulta: " . mysqli_error($conn);
            return false;
        }
    
        mysqli_stmt_bind_param($stmt, 'issssii', $id_user, $destino, $dataIda, $dataVolta, $adultos, $criancas, $valorTotal);
        
        if (mysqli_stmt_execute($stmt)) {
            $this->salvarLog($conn, $id_user, "Inseriu uma viagem: $destino");
            mysqli_stmt_close($stmt);
            echo '<html>
            <head>
                <meta http-equiv="refresh" content="2;url=./revisar-viagens.php">
                <style>
                    body {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        margin: 0;
                        background-color: #003A66;
                        font-family: Arial, sans-serif;
                    }
                    .loading {
                        font-size: 65px;
                        color: #c01e48;
                        text-align: center;
                        animation: fadeIn 2s;
                    }
                    @keyframes fadeIn {
                        from { opacity: 0; }
                        to { opacity: 1; }
                    }
                </style>
            </head>
            <body>
                <div class="loading">Carregando...</div>
            </body>
          </html>';
            exit;
        } else {
            echo "Erro na inserção: " . mysqli_stmt_error($stmt);
            return false;
        }
    }
    
    // Método para deletar viagem e salvar log da ação
    public function deletarViagem($id_viagem, $conn) {
        $sql = "DELETE FROM viagem WHERE id_viagem = ?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $id_viagem);
            if (mysqli_stmt_execute($stmt)) {
                $id_user = $_SESSION['id_user'] ?? null;
                $this->salvarLog($conn, $id_user, "Deletou uma viagem com ID: $id_viagem");
                echo '<html>
                <head>
                    <meta http-equiv="refresh" content="2;url=./revisar-viagens.php">
                    <style>
                        body {
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            height: 100vh;
                            margin: 0;
                            background-color: #003A66;
                            font-family: Arial, sans-serif;
                        }
                        .loading {
                            font-size: 65px;
                            color: #c01e48;
                            text-align: center;
                            animation: fadeIn 2s;
                        }
                        @keyframes fadeIn {
                            from { opacity: 0; }
                            to { opacity: 1; }
                        }
                    </style>
                </head>
                <body>
                    <div class="loading">Deletando...</div>
                </body>
              </html>';
                exit;
            } else {
                echo "Erro ao deletar: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Erro na preparação da consulta: " . mysqli_error($conn);
        }
    }


    public function logar_admin($conn, $logar_admin) {
        $sql = "SELECT * FROM administradores WHERE usuario = ? AND senha = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            $usuario = $logar_admin->getUserAdmin();
            $senha = $logar_admin->getPasswordAdmin();

            mysqli_stmt_bind_param($stmt, "ss", $usuario, $senha);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($resultado) > 0) {
                $user_data = mysqli_fetch_assoc($resultado);
                session_start();
                $_SESSION['id_admin'] = $user_data['id_admin'];
                header("Location: ../home_admin.html");
                exit;
            } else {
                header("Location: ../credenciais-invalidas.html");
                exit;
            }
        } else {
            die("Erro ao preparar a consulta SQL.");
        }
    }

    function insert_admin($conn, $insert_admin) {
        if ($conn instanceof mysqli) {
            // Verificar se o usuário já existe
            $sqlSelect = "SELECT * FROM administradores WHERE usuario = ?";
            $usuario = $insert_admin->getUserAdmin();
    
            $stmtSelect = mysqli_prepare($conn, $sqlSelect);
            mysqli_stmt_bind_param($stmtSelect, "s", $usuario);
            mysqli_stmt_execute($stmtSelect);
            $result = mysqli_stmt_get_result($stmtSelect);
    
            if (mysqli_num_rows($result) > 0) {
                header("Location: ../usuario-ja-cadastrado.html");
                exit;
            }
    
            $sqlInsert = "INSERT INTO administradores (nome, usuario, senha) VALUES (?, ?, ?)";
            $nome = $insert_admin->getName_admin();
            $senha = $insert_admin->getPasswordAdmin(); 
    
            $stmtInsert = mysqli_prepare($conn, $sqlInsert);
            mysqli_stmt_bind_param($stmtInsert, 'sss', $nome, $usuario, $senha);
    
            try {
                mysqli_stmt_execute($stmtInsert);
                mysqli_stmt_close($stmtInsert);
                header("Location: ../home_admin.html");
                exit;
            } catch (mysqli_sql_exception $e) {
                echo "Erro ao inserir administrador: " . $e->getMessage();
            }
    
            mysqli_stmt_close($stmtSelect);
        } else {
            echo "Erro de conexão.";
        }
    
}

}
?>
