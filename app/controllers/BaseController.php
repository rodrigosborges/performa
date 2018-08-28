<?php

class BaseController extends Controller {

	public function listagem($resource,$tipo){
		$data = Self::listModels($resource);
		if(!$data)
			return '<div class="alert alert-danger">Desculpe ocorreu um erro, favor recarregue a página.</div>';

		$data += ['tipo' => $tipo];
		
		$elementos = $data['model'];
		if ($tipo == 'inativos')
			$elementos = $elementos->onlyTrashed();
		
		$dados = Input::except('page','_token','_method');
		if($dados){
			foreach($dados as $key => $dado){
				if($dado){
					$elementos = $elementos->where(function($q)use($key,$dado){
						foreach(explode("|",$key) as $string){
							$q = $q->orWhere($string, 'LIKE', "%$dado%");
						}
					});
				}
			}
		}

		$elementos = $elementos->paginate(10);

		return View::make($data['folder'].'.table', compact('elementos','data'));
    }
    
    public function listModels($resource){
		$data = [
			// DATA DE LISTAGENS ESPECIFICAS
			'usuario' => [
				'model' =>  Usuario::where('nivel_id','>=', Auth::user()->nivel_id)->where('nivel_id','<', '4'),
				'titulo' => 'Usuários',
				'url' => 'usuario/',
				'folder' => 'usuario',
			],
			'viagem' => [
				'model' => Viagem::all(),
				'titulo' => 'Viagens',
				'url' => 'viagem/',
				'folder' => 'viagem',
			],		
		];
		if(isset($data[$resource]))
			return $data[$resource];
		return false;
	}
	
	public function download($caminho, $arquivo){
		return Response::download(base_path()."/$caminho/$arquivo");
	}

}
