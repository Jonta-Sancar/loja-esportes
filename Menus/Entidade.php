<?php
require_once __DIR__ . '/../BancoDados/Database.php';
require_once __DIR__ . '/Menu.php';

class Entidade extends Menu {
  protected $Entidade = null;
  protected $titulo_entidade   = null;
  protected $template = null;

  function __construct($entidade) {
    $database = new Database();

    require_once $this->diretorio_entidades . $entidade . '.php';
    $this->Entidade = new $entidade($database->lerDB());

    $this->template = $this->Entidade->describe()['template'];

    $this->titulo_entidade = ucfirst(strtolower($this->Entidade->titulo_sessao));

    parent::__construct('Menu ' . $this->titulo_entidade, [
      "Criar",
      "Listar",
      "Ler",
      "Editar",
      "Deletar",
    ], 'Voltar ao Menu Principal');
  }

  protected function selecionarTarefa($resposta) {
    $resposta = $this->opcoes[$resposta];

    switch ($resposta) {
      case 'Criar':
        $this->cadastrar();
        break;
      case 'Listar':
        $this->listar();
        break;
      case 'Ler':
        $this->ler();
        break;
      case 'Editar':
        $this->editar();
        break;
      case 'Deletar':
        $this->deletar();
        break;
    }
  }

  protected function cadastrar() {
    // formulário de cadastro
    $dados = [];

    echo "\nIndique os valores para o novo registro de " . $this->titulo_entidade;
    foreach ($this->template as $coluna => $coluna_info){
      $dados[$coluna] = $this->input($coluna_info[0]);
    }

    // salvar no banco
    $this->Entidade->manipularBanco('insert', $dados);
  }

  protected function listar() {
    // puxar do banco
    $registros = $this->Entidade->manipularBanco('select*');

    if($registros['status']){
      $registros = $registros['registros'];
    } else {
      echo "\nSem registros a exibir.";
      return;
    }

    // exibir
    echo "\nSeus registros de " . $this->titulo_entidade;
    foreach ($registros as $key => $value) {
      echo "\n" . $key . " - ";

      $valores_a_exibir = [];
      foreach($value as $coluna => $dado){
        if($this->template[$coluna][1]){
          $valores_a_exibir[] = $dado;
        }
      }

      echo implode(' | ', $valores_a_exibir);
    }
  }

  protected function ler() {
    // puxar específico do banco
    $registro = $this->buscarRegistro();

    if($registro === false) {
      return false;
    }

    // exibir
    echo "\nDados do registro " . $registro['id'] . " de " . $this->titulo_entidade;
    foreach(array_values($registro['dados'])[0] as $coluna => $dado){
      $titulo_coluna = $this->template[$coluna][0];
      echo "\n$titulo_coluna:\n- $dado";
    }
  }

  protected function editar() {
    // puxar específico do banco
    $registro = $this->buscarRegistro();

    if($registro === false) {
      return false;
    }

    // formulário de cadastro
    $dados = array_values($registro['dados'])[0];
    $dados['id'] = $registro['id'];

    echo "\nIndique os novos valores para o registro " . $registro['id'] . " de " . $this->titulo_entidade;
    foreach ($this->template as $coluna => $coluna_info){
      $dados[$coluna] = $this->input($coluna_info[0] . "\n(padrão: " . $dados[$coluna] . ")", padrao: $dados[$coluna]);
    }

    // salvar no banco
    $this->Entidade->manipularBanco('update', $dados);
  }

  protected function deletar() {
    // confirmação da ação
    $registro = $this->buscarRegistro();

    if($registro === false) {
      return false;
    }
    
    // remover do banco
    $this->Entidade->manipularBanco('delete', ['id' => $registro['id']]);
  }

  protected function buscarRegistro(){
    $registro_id = $this->input("Indique o registro para leitura");

    // puxar específico do banco
    $registro = $this->Entidade->manipularBanco('select', ['id' => $registro_id]);

    if($registro['status']){
      $registro = $registro['registros'];
    } else {
      $registro = false;
    }
    
    if(!empty($registro)){
        return [
          'id' => $registro_id,
          'dados' => $registro
        ];
    }

    return false;
  }
}