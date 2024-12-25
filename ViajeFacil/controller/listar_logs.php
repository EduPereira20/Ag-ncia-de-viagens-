<?php
require_once './Connect.php';
require('../fpdf/fpdf.php');  

if (isset($_POST['generate_pdf'])) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(200, 10, 'Relatorio de Logs', 0, 1, 'C');
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(5, 10, 'ID', 1);
    $pdf->Cell(50, 10, 'Usuario', 1);
    $pdf->Cell(110, 10, 'Acao', 1);
    $pdf->Cell(26, 10, 'Data/Hora', 1);
    $pdf->Ln();

    $sql = "
        SELECT log.id_log, usuario.email_user, log.acao, log.data_hora
        FROM log
        INNER JOIN usuario ON log.id_user = usuario.id_user
        ORDER BY log.data_hora ASC
    ";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(5, 10, $row['id_log'], 1);
            $pdf->Cell(50, 10, $row['email_user'], 1);
            $pdf->Cell(110, 10, $row['acao'], 1);
            $pdf->Cell(26, 10, $row['data_hora'], 1);
            $pdf->Ln();
        }
    } else {
        $pdf->Cell(200, 10, 'Nenhuma informação registrada.', 1, 1, 'C');
    }

    $pdf->Output('D', 'relatorio_logs.pdf'); // Nome do relatório 
    exit();
}

$sql = "
    SELECT log.id_log, usuario.email_user, log.acao, log.data_hora
    FROM log
    INNER JOIN usuario ON log.id_user = usuario.id_user
    ORDER BY log.data_hora ASC
";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatorio de Logs</title>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f2f5;
            display: flex;
            flex-direction: column;
        }
        h1 {
            color: #003A66;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
        }
        .generate-button {
            background-color: #e02454;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .generate-button:hover {
            background-color: #c01e48;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        th {
            background-color: #003A66;
            color: white;
            padding: 10px;
        }
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .message {
            font-size: 18px;
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h1>Relatório de Logs de Ações</h1>

<?php if ($result && mysqli_num_rows($result) > 0): ?>
    <table>
        <tr>
            <th>ID Log</th>
            <th>Usuário</th>
            <th>Ação</th>
            <th>Data/Hora</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id_log']; ?></td>
                <td><?php echo $row['email_user']; ?></td>
                <td><?php echo $row['acao']; ?></td>
                <td><?php echo $row['data_hora']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p class="message">Nenhum log encontrado.</p>
<?php endif; ?>
<br>
<form method="POST">
    <input type="submit" name="generate_pdf" value="Gerar Relatório PDF" class="generate-button">
</form>

</body>
</html>

<?php mysqli_close($conn); ?>
