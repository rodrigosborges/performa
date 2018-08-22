<?php
Class ViagemValidator{

	public static function rules($id = null, $dados){
		$rules = [
            'pessoa.nome'	            => 'required | min:3',
            'pessoa.cpf'	            => 'required | cpf',
            'pessoa.contato.email'	    => 'required | email | unique:contatos,email',
            'pessoa.contato.telefone'	=> 'required',
            'pessoa.contato.celular'	=> 'required',
            'cidade_origem' 		    => 'required | numeric',
            'numeroPessoas' 		    => 'required | numeric',
            'chegada' 		            => 'required | date_format:d/m/Y',
            'saida' 		            => 'required | date_format:d/m/Y',
            'organizacao_id'	        => 'required | numeric',
            'primeira_vez'	            => 'required',
            'tipovisitante'	            => 'required | array',
            'tipodestino'	            => 'required | array',
            'tiporefeicao'	            => 'required | array',
            'tipomotivo'	            => 'required | array',
            'local_destino'	            => 'required',
            'bairro_id'	                => 'required',
            'roteiro_predefinido'	    => 'required',
            'empresa.nome' 		        => 'required_if:organizacao_id,1',
            'empresa.contato.email'     => 'required_if:organizacao_id,1 | email',
            'empresa.contato.telefone'  => 'required_if:organizacao_id,1',
            'empresa.cidade_id' 		=> 'required_if:organizacao_id,1 | numeric',
            'documentos.solicitante'    => 'required | mimes:jpeg,jpg,png,pdf',  
        ];

        return $rules;
    }

}
?>
