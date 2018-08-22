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
                "documentos.veiculo.$key"      => 'mimes:jpeg,jpg,png,pdf | required',
                "documentos.regularidade.$key" => 'mimes:jpeg,jpg,png,pdf | required',
            ];
        }
        
		return $rules;
    }

}
?>
