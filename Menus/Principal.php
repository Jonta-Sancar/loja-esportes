<?php
require_once __DIR__ . '/../BancoDados/Database.php';
require_once __DIR__ . '/Menu.php';
require_once __DIR__ . '/Entidade.php';

class Principal extends Menu{

  function __construct() {
    $database = new Database();
    $entidades = $database->listarEntidades();

    $this->limpar_terminal = true;

    parent::__construct('Menu principal', $entidades, 'Sair Do Sistema');
  }

  protected function selecionarTarefa($resposta) {
    $database = new Database();
    $entidades = $database->listarEntidades();

    $Entidade = new Entidade(ucfirst($entidades[$resposta]));
    $Entidade->executar();
  }
}