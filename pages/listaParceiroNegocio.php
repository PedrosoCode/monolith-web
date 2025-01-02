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

<table class="table table-sm">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Razão Social</th>
            <th scope="col">Nome Fantasia</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($parceiros)) {
            foreach ($parceiros as $index => $parceiro) {
                echo '<tr>';
                echo '<th scope="row">' . htmlspecialchars($parceiro['codigo']) . '</th>';
                echo '<td>' . htmlspecialchars($parceiro['razao_social']) . '</td>';
                echo '<td>' . htmlspecialchars($parceiro['nome_fantasia']) . '</td>';
                echo '<td>';
                // Botão Editar
                echo '<form action="editarParceiro.php" method="GET" style="display:inline;">';
                echo '<input type="hidden" name="codigo" value="' . htmlspecialchars($parceiro['codigo']) . '">';
                echo '<input type="hidden" name="codigo_empresa" value="' . htmlspecialchars($parceiro['codigo_empresa']) . '">';
                echo '<button type="submit" class="btn btn-sm btn-warning">Editar</button>';
                echo '</form>';
                // Botão Excluir com Modal
                echo '<button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal" 
                    data-codigo="' . htmlspecialchars($parceiro['codigo']) . '" 
                    data-codigo_empresa="' . htmlspecialchars($parceiro['codigo_empresa']) . '"
                    data-nome_fantasia="' . htmlspecialchars($parceiro['nome_fantasia']) . '">
                    Excluir
                </button>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="4" class="text-center">Nenhum parceiro encontrado</td></tr>';
        }
        ?>
    </tbody>
</table>


<!-- Modal de Confirmação -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmação de Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tem certeza de que deseja excluir o parceiro <strong id="parceiroNomeFantasia"></strong>? Esta ação não pode ser desfeita.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">Excluir</a>
            </div>
        </div>
    </div>
</div>


<script>
    // Script para capturar o código e o código_empresa e passar para o modal
    var confirmModal = document.getElementById('confirmModal');
confirmModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget; // O botão que disparou o modal
    var codigo = button.getAttribute('data-codigo');
    var codigo_empresa = button.getAttribute('data-codigo_empresa');
    var nome_fantasia = button.getAttribute('data-nome_fantasia');
    
    // Atualizando o nome do parceiro no modal
    var parceiroNomeFantasia = document.getElementById('parceiroNomeFantasia');
    parceiroNomeFantasia.textContent = nome_fantasia;
    
    // Atualizando o link de confirmação para incluir os parâmetros
    var confirmDeleteButton = document.getElementById('confirmDelete');
    confirmDeleteButton.href = '/monolithweb/funcs/class/fnExcluirParceiro.php?codigo=' + codigo + '&codigo_empresa=' + codigo_empresa;
});

</script>




    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>