<?php
require_once("../includes/verificar_sessao.php");
require_once("../includes/components/mainNavbar.php");

if (isset($_GET['codigo']) && isset($_GET['codigo_empresa'])) {
    $codigo = $_GET['codigo'];
    $codigo_empresa = $_GET['codigo_empresa'];
} else {
    $codigo = 0;
    $codigo_empresa = $_SESSION['empresa'];
}

?>



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
        <form action='/funcs/class/fnUpsertParceiro.php' id="frmParceiroNegocio">
            <input type="hidden" name="codigo" value="<?php echo $codigo; ?>">
            <input type="hidden" name="codigo_empresa" value="<?php echo $codigo_empresa; ?>">
            <div class="row">
                <div class="col-md-5">
                    <label for="" class="form-label">Nome Fantasia</label>
                    <input type="text" class="form-control" id="txtNomeFantasia" placeholder="Nome fantasia" required name="sNome_fantasia" value="">
                </div>
                <div class="col-md-5">
                    <label for="" class="form-label">Razão Social</label>
                    <input type="text" class="form-control" id="txtRazaoSocial" placeholder="Razão Social" required name="sRazao_social" value="">
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
                    <input type="text" class="form-control" id="txtDocumento" placeholder="Documento" name="sDocumento" required>
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label">E-Mail</label>
                    <input type="email" class="form-control" id="txtEmail" placeholder="E-Mail" name="sEmail">
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="txtTelefone" placeholder="Telefone" name="sTelefone">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="form-label">Bairro</label>
                    <input type="text" class="form-control" id="txtBairro" placeholder="Bairro" name="sBairro">
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label">Logradouro</label>
                    <input type="text" class="form-control" id="txtLogradouro" placeholder="Logradouro" name="sLogradouro">
                </div>
                <div class="col-md-1">
                    <label for="" class="form-label">N°</label>
                    <input type="text" class="form-control" id="txtNumero" placeholder="N°" name="sNumero">
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label">Complemento</label>
                    <input type="text" class="form-control" id="txtComplemento" placeholder="Complemento" name="sComplemento">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="" class="form-label">Cidade</label>
                    <select id="cidadeCombo" class="form-select" name="iCodigo_cidade">
                        <option selected></option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label">Estado</label>
                    <select id="estadoCombo" class="form-select" name="iCodigoEstado" onchange="atualizarCidades(this.value)">
                        <option selected></option>
                    </select>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="" class="form-label">CEP</label>
                    <input type="text" class="form-control" id="txtCEP" name="sCep" placeholder="CEP">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="form-label">Focal Point</label>
                    <input type="text" class="form-control" id="txtContato" placeholder="Contato" name="sFocal_point">
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label for="">Data Cadastro</label>
                    <input id="dtpData_cadastro" type="datetime-local" name="dtpData_cadastro" />
                </div>
                <div class="col-md-2">
                    <label for="">Data Ultima Alteração</label>
                    <input id="dtpData_ultima_alteracao" type="datetime-local" name="dtpData_ultima_alteracao" readonly />
                </div>
            </div>
            <button type="submit" class="btn btn-success mt-3">Salvar!</button>

        </form>
        <button type="button" class="btn btn-primary mt-3" id="btnNovo">Novo Parceiro</button>
    </div>

    <script>

    const urlParams = new URLSearchParams(window.location.search);

    const btnNovo = document.getElementById('btnNovo');
    if (btnNovo) {
                btnNovo.addEventListener('click', function() {
                    // Resetando o formulário, o que limpa todos os campos
                    frmParceiroNegocio.reset();
                });
            } else {
                console.log('O botão btnNovo não foi encontrado no DOM!');
            }

    document.addEventListener('DOMContentLoaded', function() {
        preencherComboEstado();
        CarregarCidades();
        preencherComboTipoParceiro();

        if (urlParams.has('codigo') && urlParams.has('codigo_empresa')) {
            const iCodigo = urlParams.get('codigo');
            const iCodigoEmpresa = urlParams.get('codigo_empresa');

            console.log('Código:', iCodigo);
            console.log('Código Empresa:', iCodigoEmpresa);

            CarregarDados(iCodigo, iCodigoEmpresa);

        } else {
            console.log('Os parâmetros "codigo" ou "codigo_empresa" não estão presentes na URL.');
        }

    });

    

    function CarregarDados(iCodigo, iCodigoEmpresa) {
        console.log("Função chamada preencherComboTipoParceiro");
        const comboSelect = document.getElementById('comboTipoParceiro');

        fetch('../funcs/class/carregarDadosParceiro.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    iCodigo: iCodigo,
                    iCodigoEmpresa: iCodigoEmpresa
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

                if (data) {
                    const nomeInput = document.getElementById('nome');
                    if (nomeInput) {
                        nomeInput.value = data.nome;
                    }

                    const txtNomeFantasia = document.getElementById('txtNomeFantasia');
                    if (txtNomeFantasia) {
                        txtNomeFantasia.value = data.nome_fantasia_parceiro || '';
                    }

                    const txtRazaoSocial = document.getElementById('txtRazaoSocial');
                    if (txtRazaoSocial) {
                        txtRazaoSocial.value = data.razao_social_parceiro || '';
                    }

                    const txtDocumento = document.getElementById('txtDocumento');
                    if (txtDocumento) {
                        txtDocumento.value = data.documento_parceiro || '';
                    }

                    const txtCEP = document.getElementById('txtCEP');
                    if (txtCEP) {
                        txtCEP.value = data.cep_parceiro || '';
                    }

                    const txtEmail = document.getElementById('txtEmail');
                    if (txtEmail) {
                        txtEmail.value = data.email_parceiro || '';
                    }

                    const txtTelefone = document.getElementById('txtTelefone');
                    if (txtTelefone) {
                        txtTelefone.value = data.telefone_parceiro || '';
                    }

                    const txtBairro = document.getElementById('txtBairro');
                    if (txtBairro) {
                        txtBairro.value = data.bairro_parceiro || '';
                    }

                    const txtLogradouro = document.getElementById('txtLogradouro');
                    if (txtLogradouro) {
                        txtLogradouro.value = data.logradouro_parceiro || '';
                    }

                    const txtNumero = document.getElementById('txtNumero');
                    if (txtNumero) {
                        txtNumero.value = data.numero_parceiro || '';
                    }

                    const txtComplemento = document.getElementById('txtComplemento');
                    if (txtComplemento) {
                        txtComplemento.value = data.complemento_parceiro || '';
                    }

                    const txtContato = document.getElementById('txtContato');
                    if (txtContato) {
                        txtContato.value = data.contato_parceiro || '';
                    }

                    const cidadeCombo = document.getElementById('cidadeCombo');
                    if (cidadeCombo) {
                        cidadeCombo.value = data.codigo_cidade_parceiro || '';
                    }

                    const estadoCombo = document.getElementById('estadoCombo');
                    if (estadoCombo) {
                        estadoCombo.value = data.codigo_estado_parceiro || '';
                    }

                    const comboTipoParceiro = document.getElementById('comboTipoParceiro');
                    if (comboTipoParceiro) {
                        comboTipoParceiro.value = data.codigo_tipo_parceiro_parceiro || '';
                    }

                    const dtpData_ultima_alteracao = document.getElementById('dtpData_ultima_alteracao');
                    if (dtpData_ultima_alteracao) {
                        dtpData_ultima_alteracao.value = data.data_ultima_alteracao_parceiro || '';
                    }

                    const dtpData_cadastro = document.getElementById('dtpData_cadastro');
                    if (dtpData_cadastro) {
                        dtpData_cadastro.value = data.data_cadastro_parceiro || '';
                    }

                } else {
                    console.error("Dados não encontrados ou formato inesperado.");
                }
            })
            .catch(error => {
                console.error('Erro ao coletar informações:', error);
            });
    };

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

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>