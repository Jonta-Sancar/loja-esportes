<?php

require_once __DIR__ . '/CRUD.php';

class Database {
  private String    $nome_arquivo_db = __DIR__ . '/db.json';
  private CRUD|null $crud            = null;

  private $arquivos_de_controle = ['CRUD.php', 'Database.php', 'db.json', '.', '..'];

  // function iniciar() { // public
  public function manipularBanco(String $nome_entidade, String $action, Array|null $dados) : void { // public
    $BANCO_DE_DADOS = $this->lerDB();

    $entidade = ucfirst(strtolower($nome_entidade));

    require __DIR__ . "/$entidade.php";
    $this->crud = new $entidade($BANCO_DE_DADOS);

    $id_sessao = $this->crud->lerIdSessao();

    $this->crud->manipularBanco($action, $dados);

    $BANCO_DE_DADOS[$id_sessao] = $this->crud->lerRegistros();

    $this->salvarDB($BANCO_DE_DADOS);
  }

  public function atualizarBanco(String $id_sessao, Array $registros) : void { // public
    $BANCO_DE_DADOS = $this->lerDB();

    if(empty($BANCO_DE_DADOS)){
      $BANCO_DE_DADOS = [];
    }

    $BANCO_DE_DADOS[$id_sessao] = $registros;

    $this->salvarDB($BANCO_DE_DADOS);
  }

  public function listarEntidades(){
    $entidades = [];

    foreach(scandir(__DIR__ . "/") as $file) {
      if(!in_array($file, $this->arquivos_de_controle)) {
        $entidades[] = strtolower(explode('.php', $file)[0]);
      }
    }

    return $entidades;
  }


  public function pegarNomeEntidades($entidades) {
    return array_map(function($entidade){
      $entidade = ucfirst($entidade);
      require_once __DIR__ . "/" . $entidade . '.php';

      $instancia = new $entidade();
      return ucfirst(strtolower($instancia->titulo_sessao));
    }, $entidades);
  }

  private function salvarDB($BANCO_DE_DADOS){
    $json_DB = json_encode($BANCO_DE_DADOS);

    file_put_contents($this->nome_arquivo_db, $json_DB);
  }

  public function lerDB(){
    $conteudo_arquivo = file_get_contents($this->nome_arquivo_db);

    if(!empty($conteudo_arquivo)){
      return json_decode($conteudo_arquivo, true);
    }

    return [];
  }
}