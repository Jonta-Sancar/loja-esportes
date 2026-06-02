<?php
require_once './CRUD.php';

class Movimentacao extends CRUD {
  protected $id_sessao     = 'movimentacoes';
  protected $titulo_sessao = 'MOVIMENTAÇÕES';
  protected $template      = [
    'nome_produto'   => ['Nome Produto', true],
    'quantidade'     => ['Quantidade', true],
    'tipo'           => ['Tipo Movimentação', false],
    'preco_unitario' => ['Preço Unitário', true]
  ];
}