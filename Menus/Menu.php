<?php

abstract class Menu {
  protected $titulo = '';
  protected $opcoes = [];

  protected $diretorio_entidades = __DIR__ . '/../BancoDados/';

  protected $opcao_saida = 'Sair';

  protected $limpar_terminal = false;

  public function __construct($titulo = "Menu", $opcoes = [], $opcao_saida = "Sair") {
    $this->titulo = $titulo;
    $this->opcoes = $opcoes;
    $this->opcao_saida = $opcao_saida;
  }

  public function executar(){
    do{
      echo "\n\n$this->titulo\n";
  
      $resposta = $this->input("Opções", [...$this->opcoes, $this->opcao_saida]);
  
      if($resposta == count($this->opcoes)){
        return;
      }
      
      $this->selecionarTarefa($resposta);

      if($this->limpar_terminal){
        system("clear");
      }
    }while(true);
  }

  abstract protected function selecionarTarefa($resposta);

  public function input (String $nome, Array|null $opcoes = null, $padrao = null, Bool $nulo = false, String $tipo = 'string') {
    do{
      echo "\n$nome\n";
  
      if($opcoes !== null) {
        $tipo = 'number';
        foreach ($opcoes as $key => $value) {
          echo "\n" . ($key+1) . ". $value";
        }
        echo "\nSua resposta:\n";
      }
  
      $resposta = trim(readline("> "));
      $resposta = empty($resposta) && $padrao !== null ? $padrao : $resposta;

      if(!$this->validaRespostaInput($resposta, $opcoes, $nulo)) {
        echo "\nResposta inválida, tente novamente.\n";
        continue;
      }

      if(!$this->validaTipoInput($resposta, $tipo)){
        echo "\nResposta com tipo inválido, tente novamente com o tipo de valor correto.\n";
        continue;
      }

      return $opcoes === null ? $resposta : $resposta-1;
    }while(true);
  }

  protected function validaRespostaInput($resposta, $opcoes, $nulo){
    $opcao_valida = $opcoes === null || ($opcoes !== null && !isset($opcoes[$resposta]));
    $valor_vazio = $nulo === true || ($nulo === false && !empty($resposta));

    return $opcao_valida || $valor_vazio;
  }

  protected function validaTipoInput($resposta, $tipo){
    if($tipo === null){
      return true;
    }

    switch($tipo){
      case "number":
        return is_numeric($resposta);
        break;
      default:
        return true;
        break;
    }
  }
}