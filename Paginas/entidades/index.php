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
  <title><?= $Entidade->titulo_sessao ?> - Loja de Esportes</title>


  <style>
    table{
      border-collapse: collapse;
      border: 1px solid;
      margin-top: 20px;
    }

    th, td{
      border: 1px solid;
      padding: 10px 15px;
    }
  </style>
</head>
<body>
  <h1><?= $Entidade->titulo_sessao ?></h1>

  <a href="../">Voltar à página inicial</a>
  <br>
  <a href="./cadastrar.php?e=<?= $_GET['e'] ?>">Novo Registro</a>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <?php
          foreach($template as $coluna => $coluna_info){
            ?>
              <th><?= $coluna_info[0] ?></th>
            <?php
          }
        ?>

        <th>Ações</th>
      </tr>
    </thead>
    <tbody>

      <?php
        foreach($registros as $id => $valor){
          ?>
            <tr>
              <td><?= $id ?></td>
              <?php
                foreach($template as $coluna => $v){
                  ?>
                    <td><?= $valor[$coluna] ?></td>
                  <?php
                }
              ?>
              <td>
                <a href="./ler.php?r=<?= $id ?>">Ler</a>
                <a href="./editar.php?r=<?= $id ?>">Editar</a>
                <a href="./excluir.php?r=<?= $id ?>">Excluir</a>
              </td>
            </tr>
          <?php
        }
      ?>

    </tbody>
  </table>
</body>
</html>