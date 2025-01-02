<?php
    require_once("../config/Database.php");
    require_once("../includes/verificar_sessao.php");
    require_once("../includes/components/mainNavbar.php");
    require_once("../funcs/class/clsParceiroNegocio.php");

    $db = new Database();
    $conn = $db->getConnection();

    $parceirosClass = new clsParceiroNegocio($conn);
    $parceiros = $parceirosClass->getParceiros();

?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <!-- Adicionando o link para o Bootstrap -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <?php
        if (!empty($parceiros)) {
            foreach ($parceiros as $parceiro) {
                echo htmlspecialchars($parceiro['codigo']) .  htmlspecialchars($parceiro['nome_fantasia']);
            }
        } else {
            echo 'Nenhuma empresa encontrada';
        }
    ?>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
