<?php 

class VeiculoController extends BaseController{

	public function index(){
        $viagem = Viagem::where('hash',Input::get('hash'))->first();
        if(!$viagem || !empty($viagem->veiculos))
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
        $dados = Input::all();
        #salva os veículos cadastrados para a viagem
        foreach($dados['tipo_veiculo_id'] as $key=>$veiculo){
            $veiculo = new Veiculo;
            $veiculo->placa = $dados['placa'][$key];
            $veiculo->registro = $dados['registro'][$key];
            $veiculo->tipo_veiculo_id = $dados['tipo_veiculo_id'][$key];
            $veiculo->anexo = $veiculo->id."-".$veiculo->placa.'.zip';
            $viagem->veiculos()->save($veiculo);

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
    }
}