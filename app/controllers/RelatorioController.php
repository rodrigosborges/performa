<?php
class RelatorioController extends Controller {
    
    public function index(){
        $tipo = Input::get('tipo');
        if($tipo)
            return Self::$tipo(Input::except('tipo'));
        $data = [
            'tipos' => [
                ''                => 'Selecione',
                'ViagemAtrativo'    => 'Atrativos',
                'ViagemMotivo'      => 'Motivos',
                'ViagemRefeicao'    => 'Locais para refeições',
                'ViagemDestino'     => 'Destinos',
                'ViagemVisitante'   => 'Perfis de visitantes'
            ]
        ];
        return View::make('relatorio.index',compact('data'));
    }

    public static function estatisticos($dados){
        $titulo = $dados['tipoestatistica'];
        $object = new $titulo;
        $objects = $object::groupBy($object->getFillable()[0])->selectRaw('count(*) as total,'.$object->getFillable()[0])->join('viagens','viagens.id','=',$object->getTable().'.viagem_id');
        $titulo = $titulo == "ViagemRefeicao" ? "ViagemRefeição" : $titulo;

        #filtro de datas
        $de = $dados['de'] ? (FormatterHelper::brToEnDate($dados['de'])." 00:00:00") : "";
		$ate = $dados['ate'] ? (FormatterHelper::brToEnDate($dados['ate'])." 23:59:59") : "";
        $tipodata = $dados['tipodata'] == 1 ? "created_at" : "chegada";   
        if($de)
            $objects = $objects->where($tipodata, ">=", $de);
        if($ate)
            $objects = $objects->where($tipodata, "<=", $ate);

        $objects = $objects->get();

        return View::make('relatorio.estatistico',compact('objects','titulo'));
    }
}