<?php

class Sistema {
  private $nome_arquivo_db = './db.json';
  private $crud            = null;

  // function iniciar() { // public
  public function iniciar() { // public
    $BANCO_DE_DADOS = $this->lerDB();

    do{
      $selecao = $this->menu();
      $sistema_ativo = $selecao != 3;

      if($sistema_ativo){
        switch($selecao){
          case 1:
            require './Produto.php';

            $this->crud = new Produto();
            break;
          case 2:
            require './Movimentacao.php';

            $this->crud = new Movimentacao();
            break;
        }

        $id_sessao = $this->crud->lerIdSessao();
        $registros = isset($BANCO_DE_DADOS[$id_sessao]) ? $BANCO_DE_DADOS[$id_sessao] : [];

        $this->crud->atualizarRegistros($registros);

        $this->crud->iniciar();

        $BANCO_DE_DADOS[$id_sessao] = $this->crud->lerRegistros();
      }

      $this->cadastrarDB($BANCO_DE_DADOS);
      echo "\n";
    }while($sistema_ativo);
  }

  private function menu(){
    echo "\n------------------------------\n";
    echo "LOJA DE ESPORTES - Página principal\n";

    // opções
    echo "\n1. Produtos";
    echo "\n2. Movimentações";
    echo "\n3. Sair do Sistema";
    
    
    echo "\n\nEscolha uma opção:\n";


    return readline("> ");
  }

  private function cadastrarDB($BANCO_DE_DADOS){
    $json_DB = json_encode($BANCO_DE_DADOS);

    file_put_contents($this->nome_arquivo_db, $json_DB);
  }

  private function lerDB(){
    $conteudo_arquivo = file_get_contents($this->nome_arquivo_db);

    if(!empty($conteudo_arquivo)){
      return json_decode($conteudo_arquivo, true);
    }

    return null;
  }
}