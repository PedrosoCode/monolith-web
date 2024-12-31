<?php
require_once __DIR__ . '/config/Database.php';
require_once './funcs/Empresas.php';

// Cria a instância da classe Database e obtém a conexão
$db = new Database();
$conn = $db->getConnection();

// Cria a instância da classe Empresas e obtém as empresas
$empresasClass = new Empresas($conn);
$empresas = $empresasClass->getEmpresas();
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
            if (!empty($empresas)) {
                foreach ($empresas as $empresa) {
                    echo '<option value="' . $empresa['codigo'] . '">' . $empresa['nome_fantasia'] . ' (' . $empresa['razao_social'] . ')</option>';
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
