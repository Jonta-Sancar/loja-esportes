<?php
$entidade = ucfirst($_GET['e']);
require_once __DIR__ . "/../../BancoDados/$entidade.php";

$Entidade = new $entidade();
$registro = $Entidade->manipularBanco('select*')['registros'][$_GET['r']];

$template = $Entidade->describe()['template'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $Entidade->titulo_sessao ?> - Loja de Esportes</title>
</head>
<body>
  <h1><?= $Entidade->titulo_sessao ?></h1>

  <a href="./?e=<?= $_GET['e'] ?>">Voltar à listagem</a>

  <form action="../../Processos/exclusao.php" method="POST">
    <input type="hidden" name="entidade" value="<?= $entidade ?>">
    <input type="hidden" name="id" value="<?= $_GET['r'] ?>">

    <fieldset>
      <legend>Tem certeza que deseja excluir este registro?</legend>

      <button type="submit">Excluir</button>
      <a href="./?e=<?= $_GET['e'] ?>"><button type="button">Cancelar</button></a>
    </fieldset>
  </form>
</body>
</html>