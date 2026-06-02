<?php
require_once './CRUD.php';

class Produto extends CRUD{
  protected $id_sessao     = 'produtos';
  protected $titulo_sessao = 'PRODUTOS';
  protected $template      = [
    'nome'      => ['Nome', true],
    'descricao' => ['Descrição', false],
    'preco'     => ['Preço', true]
  ];
}