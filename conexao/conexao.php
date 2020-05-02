<?php 
    //Passo 01: brir Conexão
    $server = "localhost";
    $user = "root";
    $password = "";
    $name_database = "andes"; 
    $conecta = mysqli_connect($server,$user,$password,$name_database);

    //Passo 02: Testar conexão
    if (mysqli_connect_errno() ) {
        die("Conexão Falhou: ".mysqli_connect_errno());
    }
?>