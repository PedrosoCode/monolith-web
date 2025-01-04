<?php
require_once("../includes/verificar_sessao.php");
require_once("../includes/components/mainNavbar.php");
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        preencherComboEstado();
        CarregarCidades();
        preencherComboTipoParceiro();
    });

    function preencherComboTipoParceiro() {
        console.log("Função chamada preencherComboTipoParceiro");
        const comboSelect = document.getElementById('comboTipoParceiro');

        fetch('../funcs/class/carregarTipoParceiro.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro na resposta da requisição');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
                if (Array.isArray(data)) {
                    comboSelect.innerHTML = '<option value="" selected>Selecione um tipo de parceiro</option>';

                    data.forEach(tipoParceiro => {
                        const option = document.createElement('option');
                        option.value = tipoParceiro.codigo_tipo_parceiro;
                        option.textContent = tipoParceiro.descricao_tipo_parceiro;
                        comboSelect.appendChild(option);
                    });
                    comboSelect.value = "";
                } else {
                    console.error("Erro: A resposta não é um array.");
                }
            })
            .catch(error => {
                console.error('Erro ao carregar os tipos de parceiro:', error);
            });
    };


    function preencherComboEstado() {
        console.log("Função chamada preencherComboEstado");
        const estadoSelect = document.getElementById('estadoCombo');

        fetch('../funcs/class/carregarEstados.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro na resposta da requisição');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
                if (Array.isArray(data)) {
                    const EstadoCombo = document.getElementById('estadoCombo');
                    EstadoCombo.innerHTML = '<option value="" selected>Selecione UF</option>';
                    data.forEach(estado => {
                        const option = document.createElement('option');
                        option.value = estado.codigo_estado;
                        option.textContent = estado.nome_estado;
                        EstadoCombo.appendChild(option);
                    });
                    estadoSelect.value = "";
                } else {
                    console.error("Erro: A resposta não é um array.");
                }
            })
            .catch(error => {
                console.error('Erro ao carregar estados:', error);
            });
    };

    function atualizarCidades() {
        console.log("Função chamada");
        const estadoSelect = document.getElementById('estadoCombo');
        const codigoEstado = estadoSelect.value;

        fetch('../funcs/class/carregarCidades.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    codigoEstado: codigoEstado
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro na resposta da requisição');
                }
                return response.json();
            })
            .then(data => {
                if (Array.isArray(data)) {
                    const cidadeCombo = document.getElementById('cidadeCombo');
                    cidadeCombo.innerHTML = '';
                    data.forEach(cidade => {
                        const option = document.createElement('option');
                        option.value = cidade.codigo_cidade;
                        option.textContent = cidade.descricao_cidade;
                        cidadeCombo.appendChild(option);
                    });
                    cidadeCombo.value = '<option value="" selected>Selecione a cidade</option>';
                } else {
                    console.error("Erro: A resposta não é um array.");
                }
            })
            .catch(error => {
                console.error('Erro ao carregar cidades:', error);
            });
    };

    function CarregarCidades() {
        console.log("Função chamada");
        const estadoSelect = document.getElementById('estadoCombo');
        const codigoEstado = estadoSelect.value;

        fetch('../funcs/class/carregarCidades.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    codigoEstado: -1
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro na resposta da requisição');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
                if (Array.isArray(data)) {
                    const cidadeCombo = document.getElementById('cidadeCombo');
                    cidadeCombo.innerHTML = '<option value="" selected>Selecione Cidade</option>';
                    data.forEach(cidade => {
                        const option = document.createElement('option');
                        option.value = cidade.codigo_cidade;
                        option.textContent = cidade.descricao_cidade;
                        cidadeCombo.appendChild(option);
                    });
                    cidadeCombo.value = '';
                } else {
                    console.error("Erro: A resposta não é um array.");
                }
            })
            .catch(error => {
                console.error('Erro ao carregar cidades:', error);
            });
    };
</script>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Parceiro</title>
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container md-5">
        <form action='/funcs/class/fnUpsertParceiro.php'>
            <input type="hidden" name="codigo" value="<?php echo $codigo; ?>">
            <input type="hidden" name="codigo_empresa" value="<?php echo $codigo_empresa; ?>">
            <div class="row">
                <div class="col-md-5">
                    <label for="" class="form-label">Nome Fantasia</label>
                    <input type="text" class="form-control" id="" placeholder="Nome fantasia" required name="sNome_fantasia" value="<?php echo htmlspecialchars($codigo_empresa); ?>">
                </div>
                <div class="col-md-5">
                    <label for="" class="form-label">Razão Social</label>
                    <input type="text" class="form-control" id="" placeholder="Razão Social" required name="sRazao_social">
                </div>
                <div class="col-md-2">
                    <label for="" class="form-label">Tipo Parceiro</label>
                    <select id="comboTipoParceiro" class="form-select" name="sTipo_parceiro">
                        <option selected></option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="" class="form-label">Documento</label>
                    <input type="text" class="form-control" id="" placeholder="Nome fantasia" name="sDocumento" required>
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label">E-Mail</label>
                    <input type="email" class="form-control" id="" placeholder="E-Mail" name="sEmail">
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="" placeholder="Telefone" name="sTelefone">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="form-label">Bairro</label>
                    <input type="text" class="form-control" id="" placeholder="Bairro" name="sBairro">
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label">Logradouro</label>
                    <input type="text" class="form-control" id="" placeholder="Logradouro" name="sLogradouro">
                </div>
                <div class="col-md-1">
                    <label for="" class="form-label">N°</label>
                    <input type="text" class="form-control" id="" placeholder="N°" name="sNumero">
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label">Complemento</label>
                    <input type="text" class="form-control" id="" placeholder="Complemento" name="sComplemento">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="" class="form-label">Cidade</label>
                    <select id="cidadeCombo" class="form-select" name="iCodigo_cidade">
                        <option selected></option>
                        <option value="a">a</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label">Estado</label>
                    <select id="estadoCombo" class="form-select" name="iCodigoEstado" onchange="atualizarCidades(this.value)">
                        <option selected></option>
                        <option value="a">a</option>
                    </select>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="" class="form-label">CEP</label>
                    <input type="text" class="form-control" id="" name="sCep">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="form-label">Focal Point</label>
                    <input type="text" class="form-control" id="" placeholder="Contato" name="sFocal_point">
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label for="">Data Cadastro</label>
                    <input id="" type="datetime-local" name="dtpData_cadastro" />
                </div>
                <div class="col-md-2">
                    <label for="">Data Ultima Alteração</label>
                    <input id="" type="datetime-local" name="dtpData_ultima_alteracao" readonly />
                </div>
            </div>
            <button type="submit" class="btn btn-success mt-3">Salvar!</button>

        </form>
        <button type="submit" class="btn btn-primary mt-3">Novo Parceiro</button>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>