<?php
require_once __DIR__ . '/../BancoDados/Database.php';
require_once __DIR__ . '/Menu.php';
require_once __DIR__ . '/Entidade.php';

class Principal extends Menu{
  function __construct() {
    $database  = new Database();
    $entidades = $database->listarEntidades();

    $entidades = $this->pegarNomeEntidades($entidades);

    $this->limpar_terminal = true;

    parent::__construct('Menu principal', $entidades, 'Sair Do Sistema');
  }

  protected function selecionarTarefa($resposta) {
    $database = new Database();
    $entidades = $database->listarEntidades();

    $Entidade = new Entidade(ucfirst($entidades[$resposta]));
    $Entidade->executar();
  }

  protected function pegarNomeEntidades($entidades) {
    return array_map(function($entidade){
      $entidade = ucfirst($entidade);
      require_once $this->diretorio_entidades . $entidade . '.php';

      $instancia = new $entidade();
      return ucfirst(strtolower($instancia->titulo_sessao));
    }, $entidades);
  }
}