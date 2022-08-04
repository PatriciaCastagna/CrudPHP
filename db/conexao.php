<?php

//config gerais
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "primeiro_banco";

//conexao

$pdo = new PDO("mysql:host=$servidor;dbname=$banco",$usuario,$senha);


//Funções para sanitizar (limpar) entradas:
// --trim = remover espaços extras
// --stripcslashes= Remove barras invertidas em uma string
// --htmlspecialchars=  Torna o seu código mais seguro e previne a entrada de caracteres especiais

function limparPost($dado){
    $dado = trim($dado);
    $dado = stripcslashes($dado);
    $dado = htmlspecialchars($dado);
    return($dado);


}

?>