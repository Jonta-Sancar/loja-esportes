<?php
  require_once __DIR__ . '/../BancoDados/Database.php';
  $database  = new Database();
  $entidades = $database->listarEntidades();
  $entidades_nomes = $database->pegarNomeEntidades($entidades);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página Inicial</title>
</head>
<body>
  <h1>Página Inicial</h1>

  <ul>

    <?php
      foreach ($entidades as $i => $entidade){
        $entidade_nome = $entidades_nomes[$i];
        ?>
          <a href="./entidades/?e=<?= $entidade ?>"><li><?= $entidade_nome ?></li></a>
        <?php
      }
    ?>

  </ul>
</body>
</html>