<?php require_once("../../conexao/conexao.php"); ?>
<?php
    //VERIFICA SE FOI CLICADO NO BOTAO PARA INCLUIR
    if (isset($_POST["salvar"])) {
        //PREENCHE O PARAMETRO PARA NAO RETORNAR A PAGINA "LISTAGEM.PHP"
        $_POST["incluir"] = "incluir";
        //PREENCHE UM ARRAY COM OS CAMPOS DO FORM
        $dados_incluir = array (
                "nome"        => $_POST["nometransportadora"],
                "endereco"    => $_POST["endereco"],
                "cidade"      => $_POST["cidade"],
                "estados"     => $_POST["estados"],
                "cep"         => $_POST["cep"],
                "telefone"    => $_POST["telefone"],
                "cnpj"        => $_POST["cnpj"] 
        );
        
        //MONTA O INSERT NO BANCO DE DADOS
        $qr_incluir  = " INSERT INTO transportadoras ";
        $qr_incluir .= " (NOMETRANSPORTADORA, ENDERECO, TELEFONE, CIDADE, ESTADOID, CEP, CNPJ) ";
        $qr_incluir .= " VALUES( ";
        $qr_incluir .= "  '{$dados_incluir["nome"]}',     ";
        $qr_incluir .= "  '{$dados_incluir["endereco"]}', ";
        $qr_incluir .= "  '{$dados_incluir["telefone"]}', ";
        $qr_incluir .= "  '{$dados_incluir["cidade"]}',   "; 
        $qr_incluir .= "   {$dados_incluir["estados"]},   ";
        $qr_incluir .= "  '{$dados_incluir["cep"]}',      "; 
        $qr_incluir .= "  '{$dados_incluir["cnpj"]}'    );";
        
        //EFETUA A CONEXAO E O UPTADE NO BANCO E RETORNA ERRO CASO NÃO COMUNICAR
        $con_insert_transportadora = mysqli_query($conecta,$qr_incluir);
        if (!$con_insert_transportadora) {
            die("Erro ao tentar Incluir no Banco de Dados!");
        } else {
            header("location:listagem.php");
        }
    }
    
    //VERIFICA SE NÃO FOI ACESSADO A PAGINA VIA LINK DIRETO
    if (!isset($_POST["incluir"])){
        header("location:listagem.php");
    }

    //CONSULTA ESTADOS
    $qr_estados  = " SELECT * FROM ESTADOS ";
    $qr_estados = mysqli_query($conecta,$qr_estados);
    if (!$qr_estados) {
        die("Erro ao buscar dados dos Estados!");
    }
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Curso PHP INTEGRACAO</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css"    rel="stylesheet">
        <link href="_css/alteracao.css" rel="stylesheet">
    </head>

    <body>
        <?php include_once("_incluir/topo.php"); ?>
        
        <main>  
            <div id="janela_formulario">
                <form action="inclusao.php" method="POST">
                    <h2>Alteração de Transportadoras</h2>
                    
                    <label for="nometransportadora">Nome da Transportadora:</label>
                    <input type="text" value="" name="nometransportadora" id="nometransportadora">
                    
                    <label for="endereco">Endereço:</label>
                    <input type="text" value="" name="endereco" id="endereco">
                    
                    <label for="cidade">Cidade:</label>
                    <input type="text" value="" name="cidade" id="cidade">
                    
                    <label for="estados">Estados:</label>
                    <select name="estados" id="estados">
                        <?php                          
                            //PREENCHE AS OPCOES DO ESTADO
                            while ($info_estados = mysqli_fetch_assoc($qr_estados)) { 
                        ?>
                            <option value="<?php echo $info_estados["estadoID"] ?>" selected>
                                <?php echo $info_estados["nome"] ?> 
                            </option>
                        <?php        
                            }
                        ?>
                    </select>
                    
                    <label for="cep">CEP:</label>
                    <input type="text" value="" name="cep" id="cep">
                    
                    <label for="telefone">Telefone:</label>
                    <input type="text" value="" name="telefone" id="telefone">
                    
                    <label for="cnpj">CNPJ:</label>
                    <input type="text" value="" name="cnpj" id="cnpj">
                    
                    <!-- RECEBENDO O CODIGO DO PARAMETRO DA PAGINA -->
                    <input type="hidden" name="transportadoraID" value="<?php echo $id_transp ?>">
                    
                    <input type="submit" name="salvar" id="salvar" value="Confirmar Inclusão">
                </form>
            </div>
        </main>

        <?php include_once("_incluir/rodape.php"); ?>  
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>