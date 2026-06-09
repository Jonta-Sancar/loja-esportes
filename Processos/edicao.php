<?php
require_once __DIR__ . '/../BancoDados/Database.php';
$database  = new Database();

$entidade = ucfirst($_POST['entidade']);
require_once __DIR__ . "/../BancoDados/$entidade.php";
$Entidade = new $entidade();
$registros = $Entidade->manipularBanco('select*')['registros'];

$template = $Entidade->describe()['template'];

$dados = $_POST;
unset($dados['entidade']);

$resultado = $Entidade->manipularBanco('update', $dados);


header('Location: http://localhost/coude-27/php/loja-esportes/Paginas/entidades/?e=' . strtolower($_POST['entidade']));