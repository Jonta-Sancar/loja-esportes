<?php

class CRUD {
  protected $id_sessao     = '';
  protected $titulo_sessao = '';
  
  protected $template      = [];

  protected $registros = [];

  public function iniciar(){
    do{
      $opcao = $this->menu();
      // $repetir = !($opcao == 5);
      $repetir = $opcao != 6;
  
      if($repetir){
        switch($opcao){
          case 1:
            $this->executarCadastro();
            break;
          case 2:
            $this->executarListagem();
            break;
          case 3:
            $this->executarLeitura();
            break;
          case 4:
            $this->executarEdicao();
            break;
          case 5:
            $this->executarExclusao();
            break;
        }
      }
  
      echo "\n";
    }while($repetir); // enquanto repetir for verdadeiro
  }
  
  protected function menu(){
    echo "\n-------------------------\n";
    echo "\n" . $this->titulo_sessao . " - O que deseja fazer:\n";
  
    echo "\n1. Criar";
    echo "\n2. Listar";
    echo "\n3. Ler";
    echo "\n4. Editar";
    echo "\n5. Exclui";
    echo "\n6. Voltar ao início";
  
    echo "\n> ";
    $opcao = readline(''); // capturar a escolha do usuário
  
    return $opcao;
  }
  
  protected function menuEditar($colunas){
    echo "\n\nO que você quer editar:\n";
  
    foreach($colunas as $i => $coluna){
      $titulo_coluna = $this->template[$coluna][0];
      echo "\n" . ($i+1) . ". $titulo_coluna";
    }
  
    echo "\n";
    return readline("> ");
  }
  
  protected function preencher(Array|String|null $valores, $coluna = null, $registro_chave = null){
    $i = 0;
  
  
    $registro = [];
    if($coluna === null){
      foreach($this->template as $coluna => $v){
        $registro[$coluna] = $valores[$i++];
      }
      
      $this->registros[] = $registro;
    } else  {
      $registro = $this->registros[$registro_chave];
  
  
      $registro[$coluna] = $valores;
      $this->registros[$registro_chave] = $registro;
    }
  }
  
  protected function ler($registro, Array|null $colunas = null, $index = null){
    $linha = [];
    if($colunas !== null){
      $linha[] = $index;
    }
  
    $colunas_a_exibir = !empty($colunas) ? $colunas : array_keys($registro);
  
    foreach($colunas_a_exibir as $coluna){
      $titulo_coluna = $this->template[$coluna][0];
  
      $linha[] = !empty($colunas) ? $registro[$coluna] : $titulo_coluna . ": " . $registro[$coluna];
    }
  
    echo implode($colunas !== null ? ' - ' : "\n", $linha);
  }
  
  protected function tem(){
    $vazio = true;
  
    foreach($this->registros as $valor){
      $vazio = $valor === null;
  
      if($vazio === false){
        break;
      }
    }
  
    return !$vazio;
  }
  
  protected function escolherRegistro(){
    echo "\nSelecione o registro:\n";
    $registro_chave = readline("> ");
  
    return [
      'id' => ($registro_chave-1),
      'dados' => $this->registros[$registro_chave-1]
    ];
  }

  public function lerIdSessao(){
    return $this->id_sessao;
  }

  public function lerRegistros(){
    return $this->registros;
  }

  // Geters (Get = capturar|ler|pegar) & Seters (Set = cadastrar|editar|indicar)

  public function atualizarRegistros($registros){
    $this->registros = $registros;
  }
  
  ######################
  
  protected function executarCadastro(){
    echo "\nCadastre:\n";
    
    $registro_valores = [];
  
    foreach($this->template as $coluna => $info_coluna){
      $titulo_coluna = $info_coluna[0];
      $registro_valores[] = readline("$titulo_coluna: ");
    }
    $this->preencher($registro_valores);
    
    echo "\nRegistro criado com sucesso.";
  }
  
  protected function executarListagem(){
    if($this->tem()){
      echo "\nItens cadastrados:\n";
  
      foreach($this->registros as $key => $registro){
        $colunas = [];
        
        foreach($this->template as $coluna => $info_coluna){
          if($info_coluna[1]){
            $colunas[] = $coluna;
          }
        }
  
        $this->ler($registro, $colunas, ($key+1));
        echo "\n";
      }
    } else {
      echo "\nNada para listar.";
    }
  }
  
  protected function executarLeitura(){
    if($this->tem()){
      $registro = $this->escolherRegistro();
      
      echo "\nInformações do seu registro:\n";
      $this->ler($registro['dados']);
    } else {
      echo "\nSem registros disponíveis para leitura.";
    }
  }
  protected function executarEdicao(){
    if($this->tem()){
      $registro = $this->escolherRegistro(); // dados | id
  
      $this->ler($registro['dados']);
    
      $colunas = array_keys($registro['dados']); // ["nome", "descricao", "preco"]
      $opcao_menu_edicao = $this->menuEditar($colunas);
  
      $coluna = $colunas[$opcao_menu_edicao - 1];
      echo "\nInforme o valor da coluna $coluna:\n";
  
      $this->preencher(readline("> "), $coluna, $registro['id']);
    } else {
      echo "\nSem registros disponíveis para edição.";
    }
  }
  protected function executarExclusao(){
    if($this->tem()){
      $registro = $this->escolherRegistro();
    
      unset($this->registros[$registro['id']]);
    
      echo "\nRegistro apagado.";
    } else { 
      echo "\nNada para excluir";
    }
  }
}