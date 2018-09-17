<?php
Class ViagemValidator{

	public static function rules($id = null, $dados){
		$rules = [
            'pessoa.nome'	            => 'required | min:3',
            'pessoa.cpf'	            => ($id ? "" : "required |").' cpf',
            'pessoa.contato.email'	    => 'required | email',
            'pessoa.contato.telefone'	=> 'required',
            'pessoa.contato.celular'	=> 'required',
            'cidade_origem' 		    => 'required | numeric',
            'numeroPessoas' 		    => 'required | numeric',
            'chegada' 		            => 'required | date_format:d/m/Y|after:'.date('Y-m-d', strtotime("+10 days")),
            'saida' 		            => 'required | date_format:d/m/Y|after:'.FormatterHelper::brToEnDate($dados['chegada']),
            'organizacao_id'	        => 'required | numeric',
            'primeira_vez'	            => 'required',
            'quantidade_vez_id' 		=> 'required_if:primeira_vez,0',
            'tipovisitante'	            => 'required | array',
            'tipodestino'	            => 'required | array',
            'tiporefeicao'	            => 'required | array',
            'tipomotivo'	            => 'required | array',
            'tipoatrativo'	            => 'required | array',
            'local_destino'	            => 'required',
            'bairro_id'	                => 'required',
            'roteiro_predefinido'	    => 'required',
            'roteiro_especificar' 		=> 'required_if:roteiro_predefinido,1',
            'empresa.nome' 		        => 'required_if:organizacao_id,1',
            'empresa.contato.email'     => 'required_if:organizacao_id,1 | email',
            'empresa.contato.telefone'  => 'required_if:organizacao_id,1',
            'empresa.cidade_id' 		=> 'required_if:organizacao_id,1 | numeric',
            'documentos.solicitante'    => ($id ? "" : "required |").'mimes:jpeg,jpg,png,pdf',
        ];
        
        if(isset($dados['tipoatrativo']) && in_array(7,$dados['tipoatrativo'])){
            $rules += [
                'especificar_atrativo' => 'required'
            ];
        }
        if(isset($dados['tipodestino']) && in_array(5,$dados['tipodestino'])){
            $rules += [
                'especificar_destino'   => 'required',
            ];
        }
        if(isset($dados['tipomotivo']) && in_array(5,$dados['tipomotivo'])){
            $rules += [
                'especificar_motivo'    => 'required',
            ];
        }
        if(isset($dados['tiporefeicao']) && in_array(6,$dados['tiporefeicao'])){
            $rules += [
                'especificar_refeicao'  => 'required',
            ];
        }
        if(isset($dados['tipovisitante']) && in_array(6,$dados['tipovisitante'])){
            $rules += [
                'especificar_visitante' => 'required',
            ];
        }

        if($dados['estacionamento_proprio'] == 1 && (!$id || ($id && !$dados['file_exists']))){
            foreach($dados['estacionamento_anexos'] as $key=>$anexo){
                $rules += [
                    "estacionamento_anexos.$key" => ($id ? "" : "required |").'mimes:jpeg,jpg,png,pdf'
                ];
            }
        }
        
        if($dados['estacionamento_proprio'] == 0){
            $rules += [
                'estacionamento_id' => 'required',
            ];
        }
            
        return $rules;
    }

}
?>
