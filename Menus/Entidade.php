<?php
require_once __DIR__ . '/../BancoDados/Database.php';
require_once __DIR__ . '/Menu.php';

class Entidade extends Menu {
  protected $Entidade = null;
  protected $diretorio_entidades = __DIR__ . '/../BancoDados/';

  function __construct($entidade) {
    $database = new Database();

    require_once $this->diretorio_entidades . $entidade . '.php';
    $this->$Entidade = new $entidade($database->lerDB());

    parent::__construct('Menu principal', [
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
    // salvar no banco
  }

  protected function listar() {
    // puxar do banco
    // exibir
  }

  protected function ler() {
    // puxar específico do banco
    // exibir
  }

  protected function editar() {
    // formulário de edição
    // salvar no banco
  }

  protected function deletar() {
    // confirmação da ação
    // remover do banco
  }
}