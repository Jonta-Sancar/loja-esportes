<?php
require_once __DIR__ . "/Database.php";

abstract class CRUD {
  protected $id_sessao     = 'system';
  public    $titulo_sessao = 'System';
  
  protected $template      = [
    'dado'  => ['Dado', true],
    'valor' => ['Valor', false]
  ];
  // '<nome_coluna>' => ['<Título Coluna>', <se deve ser listado ou não [true|false]>]

  protected $DB = null;

  protected $registros = [];

  function __construct() {
    $this->DB = new Database();
    $BANCO_DE_DADOS = $this->DB->lerDB();

    $this->registros = isset($BANCO_DE_DADOS[$this->id_sessao])
                       ? $BANCO_DE_DADOS[$this->id_sessao]
                       : [];
  }

  function manipularBanco(String $action, Array|null $dados = null){
    switch($action){
      case 'insert':
        $new_id = $this->cadastrar($dados);
        $resultado = [
          'status'    => true,
          'msg'       => 'operação executada com sucesso',
          'id'        => $new_id,
          'registros' => $this->registros
        ];
        break;
      case 'select*':
        $this->listar();
        $resultado = [
          'status' => true,
          'msg'    => 'operação executada com sucesso',
          'registros' => $this->registros
        ];
        break;
      case 'select':
        $this->ler($dados);
        $resultado = [
          'status' => true,
          'msg'    => 'operação executada com sucesso',
          'registros' => $this->registros
        ];
        break;
      case 'update':
        $this->editar($dados);
        $resultado = [
          'status' => true,
          'msg'    => 'operação executada com sucesso',
          'registros' => $this->registros
        ];
        break;
      case 'delete':
        $this->deletar($dados);
        $resultado = [
          'status' => true,
          'msg'    => 'operação executada com sucesso',
          'registros' => $this->registros
        ];
        break;
      default:
        $resultado = [
          'status' => false,
          'msg'    => 'não foi possível identificar a ação a executar',
          'registros' => $this->registros
        ];
        break;
    }

    
    $this->DB->atualizarBanco($this->id_sessao, $this->registros);
    
    return $resultado;
  }

  protected function cadastrar(Array $dados) : String {
    $new_id = $this->gerarId();

    $this->registros[$new_id] = $dados;
    return $new_id;
  }

  protected function listar(){
    return $this->registros;
  }

  protected function ler(Array $dados){
    return $this->registros[$dados['id']];
  }

  protected function editar(Array $dados){
    $id = $dados['id'];
    unset($dados['id']);
    $this->registros[$id] = $dados;
  }

  protected function deletar(Array $dados){
    unset($this->registros[$dados['id']]);
  }

  public function describe(){
    return [
      'id_sessao' => $this->id_sessao,
      'titulo_sessao' => $this->titulo_sessao,
      'template' => $this->template
    ];
  }

  protected function gerarId() : String{
    $random = '';

    $chars = '0123456789-abcdefghijklmnopqrstuvwxyz-ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for($i = 0; $i < 6; $i++){
      $ran = mt_rand(0, strlen($chars) -1);
      $random .= $chars[$ran];
    }

    $count = count($this->registros);

    return $count . '-' . $random;
  }

  public function lerIdSessao(){
    return $this->id_sessao;
  }

  public function lerRegistros(){
    return $this->registros;
  }
}