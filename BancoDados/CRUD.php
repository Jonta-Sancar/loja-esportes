<?php

abstract class CRUD {
  protected $id_sessao     = 'system';
  protected $titulo_sessao = 'System';
  
  protected $template      = [
    'dado'  => ['Dado', true],
    'valor' => ['Valor', false]
  ];
  // '<nome_coluna>' => ['<Título Coluna>', <se deve ser listado ou não [true|false]>]

  protected $registros = [];

  function __construct($BANCO_DE_DADOS) {
    $this->registros = isset($BANCO_DE_DADOS[$this->id_sessao])
                       ? $BANCO_DE_DADOS[$this->id_sessao]
                       : [];
  }

  function manipularBanco(String $action, Array|null $dados){
    switch($action){
      case 'insert':
        $new_id = $this->cadastrar($dados);
        return [
          'status'    => true,
          'msg'       => 'operação executada com sucesso',
          'id'        => $new_id,
          'registros' => $this->registros
        ];
        break;
      case 'select*':
        $this->listar();
        return [
          'status' => true,
          'msg'    => 'operação executada com sucesso',
          'registros' => $this->registros
        ];
        break;
      case 'select':
        $this->ler($dados);
        return [
          'status' => true,
          'msg'    => 'operação executada com sucesso',
          'registros' => $this->registros
        ];
        break;
      case 'update':
        $this->editar($dados);
        return [
          'status' => true,
          'msg'    => 'operação executada com sucesso',
          'registros' => $this->registros
        ];
        break;
      case 'delete':
        $this->deletar($dados);
        return [
          'status' => true,
          'msg'    => 'operação executada com sucesso',
          'registros' => $this->registros
        ];
        break;
      default:
        return [
          'status' => false,
          'msg'    => 'não foi possível identificar a ação a executar',
          'registros' => $this->registros
        ];
        break;
    }
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

  protected function describe(){
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
}