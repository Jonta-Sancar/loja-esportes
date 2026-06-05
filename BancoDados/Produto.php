<?php
require_once __DIR__ . '/CRUD.php';

class Produto extends CRUD{
  protected $id_sessao     = 'produtos';
  public    $titulo_sessao = 'PRODUTOS';
  
  protected $template      = [
    'nome'      => ['Nome', true],
    'descricao' => ['Descrição', false],
    'preco'     => ['Preço', true]
  ];
}