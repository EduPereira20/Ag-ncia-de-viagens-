<?php
// editViagem.php
require_once('./Connect.php');

$id = $_GET['id'];

// Busca a viagem no banco de dados
$sql = "SELECT * FROM viagem WHERE id_viagem = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$viagem = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $destino = $_POST['destino'];
    $dataIda = $_POST['data-ida'];
    $dataVolta = $_POST['data-volta'];
    $adultos = $_POST['adultos'];
    $criancas = $_POST['criancas'];

    // Atualiza os dados da viagem
    $sql = "UPDATE viagem SET destino = ?, data_ida = ?, data_volta = ?, numero_adultos = ?, numero_criancas = ? WHERE id_viagem = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiii", $destino, $dataIda, $dataVolta, $adultos, $criancas, $id);
    
    if ($stmt->execute()) {
        header('Location: revisar-viagens.php');
        exit();
    } else {
        echo "Erro ao atualizar a viagem: " . $conn->error;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Editar Viagem</title>
    <link href="../css/style2.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link href="css/programar-viagens.css" rel="stylesheet">
    <link href="css/style2.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />

<style>
    body {
        background-color: #003A66;
    }

    label {
        color: white;
    }

    .topbar {
        background-color: #003A66; 
    }

    .navbar {
        background-color: white;
    }

    .container {
        max-width: 800px;
        margin: 40px auto;
        padding: 20px;
    }

    h1 {
        font-size: 40px;
        margin-bottom: 20px;
        text-align: center;
        color: white;
    }

    .form-group-inline {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .form-group {
        flex: 1;
        margin: 10px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .form-group select,
    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 15px; 
    }

    button {
        margin-left: 12px;
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: #0056b3;
    }
</style>
</head>

<body>

<div class="topbar">
    <div class="social-media">
        <a href="https://wa.me/5561981009639?text=Oi%2C%20tudo%20bem%3F" class="social-icon"><i class="fab fa-whatsapp"></i></a>
        <a href="https://www.youtube.com/@LATAMAirlines_BR" class="social-icon"><i class="fab fa-youtube"></i></a>
        <a href="https://www.instagram.com/eduardo.pereiradv?igsh=anFyMnJ0OWdoMGg3" class="social-icon"><i class="fab fa-instagram"></i></a>
    </div>
    <div>
        <a href="ajuda.html">Ajuda</a>
        <a href="contatos.html">Contatos</a>
    </div>
</div>

<div class="navbar">
    <div class="navbar-brand">
        <img src="../images/brand-logo.png" alt="Logo" class="brand-logo">
        <p>ViajeFácil</p>
    </div>
    <div class="navbar-links">
        <a href="../home.html">Principal</a>
        <a href="../programe-viagens.html">Programe viagens</a>
        <a href="../revisar-viagens.php">Altere suas viagens</a>
    </div>
</div>

<div class="container">
    <h1>Editar Viagem</h1>

    <form method="post">
        <div class="form-group-inline">
            <div class="form-group">
                <label for="destino">Destino</label>
                <select name="destino" id="destino" required>
                    <option value="">Escolha um destino</option>
                    <option value="japao" <?php echo $viagem['destino'] == 'japao' ? 'selected' : ''; ?>>Japão</option>
                    <option value="suica" <?php echo $viagem['destino'] == 'suica' ? 'selected' : ''; ?>>Suíça</option>
                    <option value="tailandia" <?php echo $viagem['destino'] == 'tailandia' ? 'selected' : ''; ?>>Tailândia</option>
                    <option value="brasil" <?php echo $viagem['destino'] == 'brasil' ? 'selected' : ''; ?>>Brasil</option>
                    <option value="estados-unidos" <?php echo $viagem['destino'] == 'estados-unidos' ? 'selected' : ''; ?>>Estados Unidos</option>
                    <option value="israel" <?php echo $viagem['destino'] == 'israel' ? 'selected' : ''; ?>>Israel</option>
                    <option value="china" <?php echo $viagem['destino'] == 'china' ? 'selected' : ''; ?>>China</option>
                    <option value="russia" <?php echo $viagem['destino'] == 'russia' ? 'selected' : ''; ?>>Rússia</option>
                    <option value="franca" <?php echo $viagem['destino'] == 'franca' ? 'selected' : ''; ?>>França</option>
                    <option value="italia" <?php echo $viagem['destino'] == 'italia' ? 'selected' : ''; ?>>Itália</option>
                    <option value="espanha" <?php echo $viagem['destino'] == 'espanha' ? 'selected' : ''; ?>>Espanha</option>
                    <option value="alemanha" <?php echo $viagem['destino'] == 'alemanha' ? 'selected' : ''; ?>>Alemanha</option>
                    <option value="portugal" <?php echo $viagem['destino'] == 'portugal' ? 'selected' : ''; ?>>Portugal</option>
                    <option value="inglaterra" <?php echo $viagem['destino'] == 'inglaterra' ? 'selected' : ''; ?>>Inglaterra</option>
                    <option value="canada" <?php echo $viagem['destino'] == 'canada' ? 'selected' : ''; ?>>Canadá</option>
                    <option value="mexico" <?php echo $viagem['destino'] == 'mexico' ? 'selected' : ''; ?>>México</option>
                    <option value="australia" <?php echo $viagem['destino'] == 'australia' ? 'selected' : ''; ?>>Austrália</option>
                    <option value="nova-zelandia" <?php echo $viagem['destino'] == 'nova-zelandia' ? 'selected' : ''; ?>>Nova Zelândia</option>
                    <option value="grecia" <?php echo $viagem['destino'] == 'grecia' ? 'selected' : ''; ?>>Grécia</option>
                    <option value="turquia" <?php echo $viagem['destino'] == 'turquia' ? 'selected' : ''; ?>>Turquia</option>
                    <option value="africa-do-sul" <?php echo $viagem['destino'] == 'africa-do-sul' ? 'selected' : ''; ?>>África do Sul</option>
                    <option value="argelia" <?php echo $viagem['destino'] == 'argelia' ? 'selected' : ''; ?>>Argélia</option>
                    <option value="egito" <?php echo $viagem['destino'] == 'egito' ? 'selected' : ''; ?>>Egito</option>
                    <option value="india" <?php echo $viagem['destino'] == 'india' ? 'selected' : ''; ?>>Índia</option>
                    <option value="costa-rica" <?php echo $viagem['destino'] == 'costa-rica' ? 'selected' : ''; ?>>Costa Rica</option>
                    <option value="chile" <?php echo $viagem['destino'] == 'chile' ? 'selected' : ''; ?>>Chile</option>
                    <option value="argentina" <?php echo $viagem['destino'] == 'argentina' ? 'selected' : ''; ?>>Argentina</option>
                    <option value="colombia" <?php echo $viagem['destino'] == 'colombia' ? 'selected' : ''; ?>>Colômbia</option>
                    <option value="peru" <?php echo $viagem['destino'] == 'peru' ? 'selected' : ''; ?>>Peru</option>
                    <option value="suecia" <?php echo $viagem['destino'] == 'suecia' ? 'selected' : ''; ?>>Suécia</option>
                    <option value="dinamarca" <?php echo $viagem['destino'] == 'dinamarca' ? 'selected' : ''; ?>>Dinamarca</option>
                    <option value="noruega" <?php echo $viagem['destino'] == 'noruega' ? 'selected' : ''; ?>>Noruega</option>
                    <option value="finlandia" <?php echo $viagem['destino'] == 'finlandia' ? 'selected' : ''; ?>>Finlândia</option>
                    <option value="irlanda" <?php echo $viagem['destino'] == 'irlanda' ? 'selected' : ''; ?>>Irlanda</option>
                </select>
            </div>
            <div class="form-group">
                <label for="data-ida">Data de Ida</label>
                <input type="date" name="data-ida" id="data-ida" value="<?php echo $viagem['data_ida']; ?>" required>
            </div>
            <div class="form-group">
                <label for="data-volta">Data de Volta</label>
                <input type="date" name="data-volta" id="data-volta" value="<?php echo $viagem['data_volta']; ?>" required>
            </div>
        </div>

        <div class="form-group-inline">
            <div class="form-group">
                <label for="adultos">Número de Adultos</label>
                <input type="number" name="adultos" id="adultos" value="<?php echo $viagem['numero_adultos']; ?>" min="0" required>
            </div>
            <div class="form-group">
                <label for="criancas">Número de Crianças</label>
                <input type="number" name="criancas" id="criancas" value="<?php echo $viagem['numero_criancas']; ?>" min="0" required>
            </div>
        </div>

        <button type="submit">Salvar Alterações</button>
    </form>
</div>
</body>
</html>
