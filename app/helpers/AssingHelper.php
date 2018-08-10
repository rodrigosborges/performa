<?php

class AssingHelper extends Controller{

  public static function assingUsuario($input){
    $telefones = array();
    foreach ($input['tipo_telefone_id'] as $offset => $tipo) {
      $input['telefone_numero'][$offset] = FormatterHelper::somenteNumeros($input['telefone_numero'][$offset]);
      array_push($telefones,['tipo_telefone_id'	=>	$input['tipo_telefone_id'][$offset], 'numero'	=>	$input['telefone_numero'][$offset]]);
    }

    $data['individuo'] = ($input['tipo'] == 1)? ['tipo'=> 1,'nome'=> $input['nome'],'data_nascimento' => $input['data_nascimento'],
                        'sexo_id' => $input['sexo_id'],'funcao' => $input['funcao'],'documento'=>$input['cpf']]:
                        ['nome'=> $input['nome'],'razao_social' => $input['razao_social'],
                        'responsavel' => $input['responsavel'],'documento'=>$input['cnpj']];
    $data['endereco'] = [
      'logradouro' => mb_strtoupper($input['logradouro']), 'numero' => $input['numero'],
      'cep' => $input['cep'], 'bairro' => mb_strtoupper($input['bairro']),
      'complemento' => mb_strtoupper($input['complemento']), 'cidade_id' => $input['cidade_id'] ];
      $data['telefones'] = $telefones;
      return $data;
    }

    public static function returnValues($usuario, $estado){      
      $data = [
        'niveis' => MainHelper::fixArray(Nivel::getNiveis(),'id','tipo'),
        'sexos' => MainHelper::fixArray(Sexo::all(),'id','sexo'),
        'tp_telefones' => MainHelper::fixArray(TipoTelefone::all(),'id','tipo'),
        'estados' => MainHelper::fixArray(Estado::orderBy('uf')->get(),'id','uf'),
        'cidades' => Cache::remember('cidades['.$estado.']', 60, function() use($estado){ return MainHelper::fixArray(Cidade::where('estado_id',$estado)->get(),'id','nome'); }),
        'bairros' => MainHelper::fixArray(Bairro::all(),'id','nome'),
      ];   

      if(!is_null($usuario)){
        $data['select'] = [
          'estado' => $usuario->individuo->endereco->cidade->estado,         
          'cidade' => $usuario->individuo->endereco->cidade,         
        ];
      }      
      return $data;
    }

  }
