<?php
Class VeiculoValidator{

	public static function rules($id = null, $dados){
		$rules = [
            'tipo_veiculo_id'	        => 'each:required',
            'placa'	                    => 'each:required',
            'registro'	                => 'each:required',    
        ];
        
        if($id == null){
            $rules += [
            "documentos.veiculo.0"      => 'required | mimes:jpeg,jpg,png,pdf',
            "documentos.regularidade.0" => 'required | mimes:jpeg,jpg,png,pdf'
            ];
        };
        if(isset($dados['documentos'])){
            foreach($dados['documentos']['veiculo'] as $key => $dado){
                $rules += [
                    "documentos.veiculo.$key"      => 'required | mimes:jpeg,jpg,png,pdf',
                    "documentos.regularidade.$key" => (Auth::check() ? "" :'required|').'mimes:jpeg,jpg,png,pdf',
                ];
            }
        }
        
		return $rules;
    }

}
?>
