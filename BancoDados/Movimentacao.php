<?php
require_once __DIR__ . '/CRUD.php';

class Movimentacao extends CRUD {
  protected $id_sessao     = 'movimentacoes';
  protected $titulo_sessao = 'MOVIMENTAÇÕES';

  protected $template      = [
    'id_produto'     => ['ID do Produto', true],
    'quantidade'     => ['Quantidade', true],
    'tipo'           => ['Tipo Movimentação', false],
    'preco_unitario' => ['Preço Unitário', true]
  ];
}