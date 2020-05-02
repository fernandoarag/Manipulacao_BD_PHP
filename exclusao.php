<?php require_once("../../conexao/conexao.php"); ?>
<?php 
    //UPDATE NO BANCO DE DADOS
    if (isset($_POST["excluir"])) {
        $transpID = $_POST["transportadoraID"];
        print_r($transpID);
        
        $qr_delete  = " delete from transportadoras ";
        $qr_delete .= " where transportadoraID = {$transpID} ";

        $con_delete_transportadora = mysqli_query($conecta,$qr_delete);
        
        if (!$con_delete_transportadora) {
            die("Erro ao tentar apagar informação no Banco de Dados!");
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
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Curso PHP INTEGRACAO</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/alteracao.css" rel="stylesheet">
    </head>

    <body>
        <?php include_once("_incluir/topo.php"); ?>
        
        <main>  
            <div id="janela_formulario">
                <form action="exclusao.php" method="POST">
                    <h2>Exclusão de Transportadoras</h2>
                    
                    <label for="nometransportadora">Nome da Transportadora:</label>
                    <input type="text" value="<?php echo $info_transportadora["nometransportadora"] ?>" name="nometransportadora" id="nometransportadora" Readonly >
                    
                    <label for="endereco">Endereço:</label>
                    <input type="text" value="<?php echo $info_transportadora["endereco"] ?>" name="endereco" id="endereco" Readonly >
                    
                    <label for="cidade">Cidade:</label>
                    <input type="text" value="<?php echo $info_transportadora["cidade"] ?>" name="cidade" id="cidade" Readonly >
                    
                    <!-- RECEBENDO O CODIGO DO PARAMETRO DA PAGINA -->
                    <input type="hidden" name="transportadoraID" value="<?php echo $id_transp ?>">
                    <input type="submit" name="excluir" id="excluir" value="Confirmar Exclusão">
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