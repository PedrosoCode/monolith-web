<?php
require_once("../config/Database.php");
require_once("../includes/verificar_sessao.php");
require_once("../includes/components/mainNavbar.php");
require_once("../funcs/class/clsParceiroNegocio.php");

$db = new Database();
$conn = $db->getConnection();

$parceirosClass = new clsParceiroNegocio($conn);

?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Parceiro</title>
    <!-- Adicionando o link para o Bootstrap -->
    <link href="/monolithweb/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">



    <!-- <div class="container md-5 border border-dark-subtle rounded"  > -->
    <div class="container md-5">
        <form>
        <div class="row">
            <div class="col-md-5">
                <label for="" class="form-label">Nome Fantasia</label>
                <input type="text" class="form-control" id="" placeholder="Nome fantasia" required>
            </div>
            <div class="col-md-5">
                <label for="" class="form-label">Razão Social</label>
                <input type="text" class="form-control" id="" placeholder="Razão Social" required>
            </div>
            <div class="col-md-2">
                <label for="inputCaractere" class="form-label">Tipo Parceiro</label>
                <select id="" class="form-select">
                    <option selected>Choose...</option>
                    <option>...</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="" class="form-label">Documento</label>
                <input type="text" class="form-control" id="" placeholder="Nome fantasia" required>
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">E-Mail</label>
                <input type="email" class="form-control" id="" placeholder="Nome fantasia">
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="" placeholder="Telefone">
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label for="" class="form-label">Bairro</label>
                <input type="text" class="form-control" id="" placeholder="Bairro">
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">Logradouro</label>
                <input type="text" class="form-control" id="" placeholder="Logradouro">
            </div>
            <div class="col-md-1">
                <label for="" class="form-label">N°</label>
                <input type="text" class="form-control" id="" placeholder="N°">
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">Complemento</label>
                <input type="text" class="form-control" id="" placeholder="Complemento">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="" class="form-label">Cidade</label>
                <select id="" class="form-select">
                    <option selected>Choose...</option>
                    <option>...</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">Estado</label>
                <select id="" class="form-select">
                    <option selected>Choose...</option>
                    <option>...</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="" class="form-label">CEP</label>
                <input type="text" class="form-control" id="">
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label for="" class="form-label">Focal Point</label>
                <input type="text" class="form-control" id="" placeholder="Contato">
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label for="">Data Cadastro</label>
                <input id="" type="datetime-local" name="" />
            </div>
            <div class="col-md-2">
                <label for="">Data Ultima Alteração</label>
                <input id="" type="datetime-local" name="" />
            </div>
        </div>
        <button type="submit" class="btn btn-success mt-3">Salvar!</button>
        
        </form>
        <button type="submit" class="btn btn-primary mt-3">Novo Parceiro</button>
    </div>





    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>