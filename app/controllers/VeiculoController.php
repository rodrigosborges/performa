<?php 

class VeiculoController extends BaseController{

	public function index(){
        $viagem = Viagem::where('hash',Input::get('hash'))->first();
        if(!$viagem || $viagem->veiculos()->count())
            return Redirect::to('viagem')->with('error','Formulário não disponível');
		$data = [
			'tiposveiculos'		=> MainHelper::fixArray(TipoVeiculo::all(),'id','nome'),
			'url'				=> url("veiculo"),
			'method'			=> 'POST',
            'id'				=> null,
            'hash'              => Input::get('hash')
		];
		return View::make('veiculo.form',compact('data'));
	}

    public function store(){
        $viagem = Viagem::where('hash',Input::get('hash'))->first();

        if(!empty($viagem->veiculos))
            return Redirect::to('viagem')->with('error','Formulário não disponível');
            
        $dados = Input::all();
        $validator = Validator::make($dados, VeiculoValidator::rules(null, $dados));
		if($validator->fails()){
            return $validator->messages();
			$validator->getMessageBag()->setFormat('<label class="error">:message</label>');
			return Redirect::back()->withErrors($validator)->with('warning','Alguns campos são obrigatórios, favor preenche-los corretamente.');
        }
        
        DB::beginTransaction();
		try{
            $viagem->empresa_veiculo = $dados['empresa_veiculo'];
            $viagem->status_id = 1;
            $viagem->update();
            #salva os veículos cadastrados para a viagem
            foreach($dados['tipo_veiculo_id'] as $key=>$veiculo){
                $veiculo = new Veiculo;
                $veiculo->placa = $dados['placa'][$key];
                $veiculo->registro = $dados['registro'][$key];
                $veiculo->tipo_veiculo_id = $dados['tipo_veiculo_id'][$key];
                $veiculo->anexo = $veiculo->id."-".$veiculo->placa.'.zip';
                $viagem->veiculos()->save($veiculo);
                $veiculo->anexo = $veiculo->id.$veiculo->anexo;
                $veiculo->update();

                #armazenas os arquivos dos veículos

                #veiculo
                $zip = new ZipArchive;
                $zip->open(base_path().'/'.'veiculos/'.$veiculo->id."-".$veiculo->placa.'.zip', ZipArchive::CREATE);

                $ext1 = pathinfo($_FILES['documentos']['name']['veiculo'][$key])['extension'];
                $file1 = base_path()."/veiculos/$veiculo->placa"."-veiculo.".$ext1;
                move_uploaded_file($_FILES['documentos']['tmp_name']['veiculo'][$key],
                    $file1);

                $zip->addFile($file1, "$veiculo->placa-veiculo.".$ext1);

                #regularidade

                $ext2 = pathinfo($_FILES['documentos']['name']['regularidade'][$key])['extension'];
                $file2 = base_path()."/veiculos/$veiculo->placa-regularidade.".$ext2;
                move_uploaded_file($_FILES['documentos']['tmp_name']['regularidade'][$key],
                    $file2);
                $zip->addFile($file2, "$veiculo->placa-regularidade.".$ext2);
                
                $zip->close();

                unlink($file1);
                unlink($file2);
            }
		}catch(Exception $e){
			DB::rollback();
			return $e->getMessage();
        }
        DB::commit();
        return Redirect::to('viagem/create')->with('success','Cadastro de veículos realizado com sucesso.<br>
        Um comprovante de cadastro foi enviado no e-mail do solicitante.<br>
        A resposta para sua solicitação será através de seu e-mail.');
    }
}