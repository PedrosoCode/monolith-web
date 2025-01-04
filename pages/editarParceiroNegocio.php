<?php
require_once("../config/Database.php");
require_once("../includes/verificar_sessao.php");
require_once("../includes/components/mainNavbar.php");
require_once("../funcs/class/clsParceiroNegocio.php");
require_once("../funcs/class/clsStaticCombos.php");

$db = new Database();
$conn = $db->getConnection();

$Default = -1;

$parceirosClass = new clsParceiroNegocio($conn);
$clsStaticCombos = new stcCombos($conn);
$comboEstados = $clsStaticCombos->carregaComboEstado();
$comboCidades = $clsStaticCombos->carregaComboCidade($Default);  // Inicialmente carrega as cidades com o valor -1

?>



<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Parceiro</title>
    <!-- Adicionando o link para o Bootstrap -->
    <link href="/bootstrap//css//bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- <div class="container md-5 border border-dark-subtle rounded"  > -->
    <div class="container md-5">
        <form action = '/funcs/class/fnUpsertParceiro.php'>
        <input type="hidden" name="codigo" value="<?php echo $codigo; ?>">
        <input type="hidden" name="codigo_empresa" value="<?php echo $codigo_empresa; ?>">
        <div class="row">
            <div class="col-md-5">
                <label for="" class="form-label">Nome Fantasia</label>
                <input type="text" class="form-control" id="" placeholder="Nome fantasia" required name="sNome_fantasia" value="<?php echo htmlspecialchars($codigo_empresa ); ?>">
            </div>
            <div class="col-md-5">
                <label for="" class="form-label">Razão Social</label>
                <input type="text" class="form-control" id="" placeholder="Razão Social" required name="sRazao_social">
            </div>
            <div class="col-md-2">
                <label for="" class="form-label">Tipo Parceiro</label>
                <select id="" class="form-select" name="sTipo_parceiro">
                    <option selected>Choose...</option>
                    <option>...</option>
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
                <select  id="cidadeCombo" class="form-select" name="iCodigo_cidade">
                <option selected></option>
                    <?php
                        if (!empty($comboCidades)) {
                            foreach ($comboCidades as $comboCidade) {
                                echo '<option value="' . htmlspecialchars($comboCidade['codigo_cidade']) . '">' . 
                                    htmlspecialchars($comboCidade['descricao_cidade']) . '</option>';
                            }
                        } else {
                            echo '<option value="">Nenhuma cidade encontrada</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">Estado</label>
                <select id="estadoCombo" class="form-select" name="iCodigoEstado" onchange="atualizarCidades(this.value)">
                <option selected></option>
                    <?php
                        if (!empty($comboEstados)) {
                            foreach ($comboEstados as $comboEstado) {
                                echo '<option value="' . htmlspecialchars($comboEstado['codigo_estado']) . '">' . 
                                    htmlspecialchars($comboEstado['nome_estado']) . '</option>';
                            }
                        } else {
                            echo '<option value="">Nenhum estado encontrado</option>';
                        }
                    ?>
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
                <input id="" type="datetime-local" name="dtpData_ultima_alteracao" readonly/>
            </div>
        </div>
        <button type="submit" class="btn btn-success mt-3">Salvar!</button>
        
        </form>
        <button type="submit" class="btn btn-primary mt-3">Novo Parceiro</button>
    </div>

    <script>
function atualizarCidades() {
    console.log("Função chamada"); // Verifique se a função está sendo chamada corretamente
    const estadoSelect = document.getElementById('estadoCombo'); // Combo de estados
    const codigoEstado = estadoSelect.value; // Valor do estado selecionado

    // Faz a requisição AJAX para carregar as cidades
    fetch('../funcs/class/carregarCidades.php', {  // Aqui você deve corrigir a URL para o script PHP correto
        method: 'POST',
        headers: {
            'Content-Type': 'application/json', // Envia como JSON
        },
        body: JSON.stringify({ codigoEstado: codigoEstado }) // Envia o código do estado como JSON
    })
    .then(response => {
        // Verifique se a resposta foi bem sucedida
        if (!response.ok) {
            throw new Error('Erro na resposta da requisição');
        }
        return response.json(); // Decodifica a resposta JSON
    })
    .then(data => {
        console.log(data); // Verifique o conteúdo da resposta

        // Verifique se data é um array antes de usar forEach
        if (Array.isArray(data)) {
            // Atualiza o combo de cidades com os dados retornados
            const cidadeCombo = document.getElementById('cidadeCombo');
            cidadeCombo.innerHTML = ''; // Limpa as opções existentes

            // Preenche as opções de cidade
            data.forEach(cidade => {
                const option = document.createElement('option');
                option.value = cidade.codigo_cidade;
                option.textContent = cidade.nome_cidade;  // O nome da cidade já estará com os caracteres especiais corretamente decodificados
                cidadeCombo.appendChild(option);
            });
        } else {
            console.error("Erro: A resposta não é um array.");
        }
    })
    .catch(error => {
        console.error('Erro ao carregar cidades:', error);
        // Opcional: adicionar mensagem de erro para o usuário
    });
}
</script>




    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>