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

	function delete_directory($dirname) {
			if (is_dir($dirname))
			$dir_handle = opendir($dirname);
		if (!$dir_handle)
			return false;
		while($file = readdir($dir_handle)) {
			if ($file != "." && $file != "..") {
					if (!is_dir($dirname."/".$file))
						unlink($dirname."/".$file);
					else
						delete_directory($dirname.'/'.$file);
			}
		}
		closedir($dir_handle);
		rmdir($dirname);
		return true;
	}

	public function restore($model,$id){	
		$model = ucfirst($model);
		try{
			$result = $model::onlyTrashed()->find($id);
			if(!$result)
				return Redirect::back()->with('error', "Não foi possível reativar o(a) $model informado(a), tente novamente mais tarde.");

			$result->restore();
			return Redirect::back()->with('success', "$model reativado(a) com sucesso!");
		}catch(Exception $e){
			return Redirect::back()->with('error','Desculpe, ocorreu um erro, favor tente novamente.<br>
			Caso o erro persista, contate o suporte técnico.');
		}
		

	}
}
