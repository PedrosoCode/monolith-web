<?php
// Incluir o arquivo de conexão com o banco de dados
include("./config/database/db_conn.php");

// Passo 1: Chamar a stored procedure
$sql = "CALL sp_select_login_info_empresa()"; // Chama a stored procedure

// Usando o PDO para executar a consulta
$stmt = $conn->query($sql);

// Passo 2: Verificar se a consulta retornou resultados e popular o <select>
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form action="/action_page.php" method="POST">
        <label for="empresa">Escolha uma empresa:</label>
        <select name="empresa" id="empresa">
            <?php
            // Verificar se a consulta retornou resultados e gerar as opções
            if ($stmt->rowCount() > 0) {
                // Iterar sobre os resultados e gerar as opções
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row['codigo'] . '">' . $row['nome_fantasia'] . ' (' . $row['razao_social'] . ')</option>';
                }
            } else {
                echo '<option value="">Nenhuma empresa encontrada</option>';
            }
            ?>
        </select>
        <br><br>

        <label for="fname">Primeiro nome:</label>
        <input type="text" id="fname" name="fname"><br><br>
        
        <label for="lname">Último nome:</label>
        <input type="text" id="lname" name="lname"><br><br>
        
        <input type="submit" value="Submit">
    </form>
</body>

</html>

<?php
?>