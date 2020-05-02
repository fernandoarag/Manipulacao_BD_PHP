<?php require_once("../../conexao/conexao.php"); ?>
<?php
    //UPDATE NO BANCO DE DADOS
    if (isset($_POST["alterar"])) {
        $dados_update = array(
                "nome"        => $_POST["nometransportadora"],
                "endereco"    => $_POST["endereco"],
                "cidade"      => $_POST["cidade"],
                "estados"     => $_POST["estados"],
                "cep"         => $_POST["cep"],
                "telefone"    => $_POST["telefone"],
                "cnpj"        => $_POST["cnpj"],
                "id"          => $_POST["transportadoraID"]  
        );

        $qr_update  = " UPDATE transportadoras ";
        $qr_update .= " SET ";
        $qr_update .= " nometransportadora     = '{$dados_update["nome"]}',     ";
        $qr_update .= " endereco               = '{$dados_update["endereco"]}', ";
        $qr_update .= " telefone               = '{$dados_update["telefone"]}', ";
        $qr_update .= " cidade                 = '{$dados_update["cidade"]}',   "; 
        $qr_update .= " estadoID               =  {$dados_update["estados"]},   ";
        $qr_update .= " cep                    = '{$dados_update["cep"]}',      "; 
        $qr_update .= " cnpj                   = '{$dados_update["cnpj"]}'      ";
        $qr_update .= " where transportadoraID =  {$dados_update["id"]};        ";

        $con_update_transportadora = mysqli_query($conecta,$qr_update);
        
        if (!$con_update_transportadora) {
            die("Erro ao tentar atualizar no Banco de Dados!");
        } else {
            header("location:listagem.php");
        }
    }

    //CONSULTA TRANSPORTADORA
    $qr_transportadora  = " SELECT * FROM TRANSPORTADORAS ";
    if (isset($_GET["codigo"]))
    {
        $id_transp = $_GET["codigo"];
        $qr_transportadora .= " WHERE TRANSPORTADORAID = {$id_transp} ";
        $con_transportadora = mysqli_query($conecta,$qr_transportadora);
        
        if (!$con_transportadora) {
            die("Erro ao buscar dados da Transportadora!");
        } else {
            $info_transportadora = mysqli_fetch_assoc($con_transportadora);
            if (!$info_transportadora) {
                echo  "<script type=\"text/javascript\">alert('Transportadora não encontrada! \\nTente novamente!');</script>";
                echo  "<script type=\"text/javascript\">window.location=\"listagem.php\";</script>";
            }
        }
    } else
        header("location:listagem.php");

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
        <thead>
            <?php include_once("_incluir/topo.php"); ?>
        </thead>
        <main>  
            <div id="janela_formulario">
                <form action="alteracao.php" method="POST">
                    <h2>Alteração de Transportadoras</h2>
                    
                    <label for="nometransportadora">Nome da Transportadora:</label>
                    <input type="text" value="<?php echo $info_transportadora["nometransportadora"] ?>" name="nometransportadora" id="nometransportadora">
                    
                    <label for="endereco">Endereço:</label>
                    <input type="text" value="<?php echo $info_transportadora["endereco"] ?>" name="endereco" id="endereco">
                    
                    <label for="cidade">Cidade:</label>
                    <input type="text" value="<?php echo $info_transportadora["cidade"] ?>" name="cidade" id="cidade">
                    
                    <label for="estados">Estados:</label>
                    <select name="estados" id="estados">
                        <?php 
                            $meu_estado = $info_transportadora["estadoID"];                           
                            while ($info_estados = mysqli_fetch_assoc($qr_estados)) { 
                                $estado_atual = $info_estados["estadoID"];
                                if ($meu_estado == $estado_atual) {
                        ?>
                            <option value="<?php echo $info_estados["estadoID"] ?>" selected>
                                <?php echo $info_estados["nome"] ?> 
                            </option>
                        <?php 
                            } else {
                        ?>
                                <option value="<?php echo $info_estados["estadoID"] ?>">
                                    <?php echo $info_estados["nome"] ?> 
                                </option>
                        <?php
                                }
                                
                            }
                        ?>
                    </select>
                    
                    <label for="cep">CEP:</label>
                    <input type="text" value="<?php echo $info_transportadora["cep"] ?>" name="cep" id="cep">
                    
                    <label for="telefone">Telefone:</label>
                    <input type="text" value="<?php echo $info_transportadora["telefone"] ?>" name="telefone" id="telefone">
                    
                    <label for="cnpj">CNPJ:</label>
                    <input type="text" value="<?php echo $info_transportadora["cnpj"] ?>" name="cnpj" id="cnpj">
                    
                    <!-- RECEBENDO O CODIGO DO PARAMETRO DA PAGINA -->
                    <input type="hidden" name="transportadoraID" value="<?php echo $id_transp ?>">
                    
                    <input type="submit" name="alterar" id="alterar" value="Confirmar Alteração">
                </form>
            </div>
        </main>
        <footer>
            <?php include_once("_incluir/rodape.php"); ?>  
        </footer>
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>