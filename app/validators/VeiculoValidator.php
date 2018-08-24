<?php
Class VeiculoValidator{

	public static function rules($id = null, $dados){
		$rules = [
            'tipo_veiculo_id'	        => 'each:required',
            'placa'	                    => 'each:required',
            'registro'	                => 'each:required',    
            "documentos.veiculo.0"      => 'required | mimes:jpeg,jpg,png,pdf',
            "documentos.regularidade.0" => 'required | mimes:jpeg,jpg,png,pdf',
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
