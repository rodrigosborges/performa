<?php
Class VeiculoValidator{

	public static function rules($id = null, $dados){
		$rules = [
            'tipo_veiculo_id'	        => 'required | array',
            'placa'	                    => 'required | array',
            'registro'	                => 'required | array',    
        ];
        
        foreach($dados['documentos']['veiculo'] as $key => $dado){
            $rules += [
                "documentos.veiculo.$key"      => 'required | mimes:jpeg,jpg,png,pdf',
                "documentos.regularidade.$key" => 'required | mimes:jpeg,jpg,png,pdf',
            ];
        }
        
		return $rules;
    }

}
?>
