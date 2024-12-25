<?php
session_start(); 

require_once('./Connect.php'); 

if (!isset($_SESSION['id_user'])) {
    die("Você precisa estar logado para acessar esta página.");
}

$id_user = $_SESSION['id_user'];

$sql = "SELECT id_viagem, destino, data_ida, data_volta, numero_adultos, numero_criancas, valor_total FROM viagem WHERE id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_user); 
$stmt->execute();
$result = $stmt->get_result();
?>

<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Revisar Viagens</title>
    <link href="../css/style2.css" rel="stylesheet">
</head>
<body>
<div class="topbar">
    <div class="social-media">
        <a href="https://wa.me/5561981009639?text=Oi%2C%20tudo%20bem%3F" class="social-icon"><i class="fab fa-whatsapp"></i></a>
        <a href="https://www.youtube.com/@LATAMAirlines_BR" class="social-icon"><i class="fab fa-youtube"></i></a>
        <a href="https://www.instagram.com/eduardo.pereiradv?igsh=anFyMnJ0OWdoMGg3" class="social-icon"><i class="fab fa-instagram"></i></a>
    </div>
    <div>
        <a href="../ajuda.html">Ajuda</a>
        <a href="../contatos.html">Contatos</a>
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
        <a href="revisar-viagens.php">Altere suas viagens</a>
    </div>
</div>

<div class="container">
    <h1>Revisar Viagens Cadastradas</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Destino</th>
                    <th>Data de Ida</th>
                    <th>Data de Volta</th>
                    <th>Adultos</th>
                    <th>Crianças</th>
                    <th>Valor Total</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalValor = 0; ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['destino']); ?></td>
                        <td><?php echo htmlspecialchars($row['data_ida']); ?></td>
                        <td><?php echo htmlspecialchars($row['data_volta']); ?></td>
                        <td><?php echo htmlspecialchars($row['numero_adultos']); ?></td>
                        <td><?php echo htmlspecialchars($row['numero_criancas']); ?></td>
                        <td><?php echo 'R$ ' . number_format($row['valor_total'], 2, ',', '.'); ?></td>
                        <td>
                            <a href="editViagem.php?id=<?php echo htmlspecialchars($row['id_viagem']); ?>" class="acao-link">Editar</a>
                            <a href="deleteViagem.php?id=<?php echo htmlspecialchars($row['id_viagem']); ?>" class="acao-link">Deletar</a>
                        </td>
                    </tr>
                    <?php $totalValor += $row['valor_total']; ?>
                <?php endwhile; ?>
                <tr>
                    <td colspan="5" style="text-align: right; font-weight: bold;">Valor Total:</td>
                    <td><?php echo 'R$ ' . number_format($totalValor, 2, ',', '.'); ?></td>
                </tr>
            </tbody>
        </table>
    <?php else: ?>
        <p style="font-size: 25px;">ㅤㅤㅤNenhuma viagem encontrada.</p>
    <?php endif; ?>
</div>

</body>
</html>
