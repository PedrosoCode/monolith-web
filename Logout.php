<?php
session_start(); // Inicia a sessão
session_destroy(); // Destrói todos os dados da sessão

// Redireciona para a página de login
header('Location: index.php');
exit();
?>
