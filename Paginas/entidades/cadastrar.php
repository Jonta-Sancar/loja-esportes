<?php
$entidade = ucfirst($_GET['e']);
require_once __DIR__ . "/../../BancoDados/$entidade.php";
$Entidade = new $entidade();
$registros = $Entidade->manipularBanco('select*')['registros'];

$template = $Entidade->describe()['template'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastrar - <?= $Entidade->titulo_sessao ?> - Loja de Esportes</title>
</head>
<body>
  <h1><?= $Entidade->titulo_sessao ?> - Novo Registro</h1>

  <a href="./?e=<?= $_GET['e'] ?>">Voltar à listagem</a>

  <br>

  <form action="../../Processos/cadastro.php" method="POST">
    <input type="hidden" name="entidade" value="<?= $entidade ?>">

    <?php
      foreach($template as $coluna => $coluna_info){
        ?>

        <div class="grupo-formulario">
          <label for="<?= $coluna ?>"><?= $coluna_info[0] ?></label><br>
          <input type="text" id="<?= $coluna ?>" name="<?= $coluna ?>">
        </div>

        <?php
      }
    ?>

    <br>
    <button type="submit">Enviar</button>
  </form>
</body>
</html>