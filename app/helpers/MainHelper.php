<?php

class mainHelper{

	/**
	* Função estática - Trata array de dados da tabela p/ exibição em selects
	* @param array $array - array c/ valores da tabela
	* @param string $value - Valor do option do select
	* @param string $descri - Texto do option
	* @return array $newArray - Array c/ valores atribuidos
	* @author Rafael Domingues Teixeira
	*/
	public static function fixArray($array,$value,$descri, $selecione = 0){
		if($selecione == 0)
			$newArray = array(''=>'Selecione');

		foreach ($array as $array) {
			$newArray[$array[$value]] = $array[$descri];
		}
		return $newArray;
	}

	/**
	* Função estática - Transforma valores de array em maiusculas
	* OBS: Todo os valores de array e sub-arrays serão modificados.
	* @param array $array - array c/ valores a serem alterados
	* @param array $excepts - array c/ valores a serem ignorados
	* @return array $values - Array c/ valores alterados
	* @author Rafael Domingues Teixeira
	*/
	public static function toUpperCase($values,$excepts){
		foreach ($values as $key => $value) {
			if (in_array($key,$excepts)) continue;

			if (is_array($value)) {
				$values[$key] = mainHelper::toUpperCase($value,$excepts);
			}else {
				$values[$key] = mb_strtoupper($value);
			}
		}
		return $values;
	}

	/**
	* Função estática - retorna uma tabela conforme os valores fornecidos
	* @param object $posts - objeto c/ valores a quantidade de dados
	* @param array $values - array c/ valores a serem exibidos na tabela <[cabeçalho => valor]>
	* @param array $valuesArray - array de atribuição de cabeçalho p/ multiplos valores
	* @param array $style - array de atribuição de estilos. *[text-align: ... border: ...]*
	* @return string $table - tabela formatada c/ os valores fornecidos
	* @author Rafael Domingues Teixeira
	*/
	public static function liveTable($posts, $values, $style){
		foreach ($values as $offset => $value) {
			foreach ($value as $key => $val) {
				if(!isset($count[$key])){
					$count[$key] = ['count' => count($val), 'campos' => $val];
				}

				if(count($val) > $count[$key]['count']){
					count($val);
					$count[$key] = ['count' => count($val), 'campos' => $val];
				}
			}
		}

		// ATRIBUIÇÃO DO HEADER DA TABELA
		$colunas = "";
		foreach ($values as $key => $value) {
			if($key > 0) {
				$headers = array_merge($value,$values[$key-1]);
			}else{
				$headers = $value;
			}
		}
		foreach ($headers as $column => $vals) {
			// if(isset($count[$column])) continue;
			if(is_array($vals)){
				for ($i=1; $i <= $count[$column]['count']; $i++) {
					if(is_array($count[$column]['campos'])){
						foreach ($count[$column]['campos'] as $sub_val) {
							if(is_array($sub_val)){
								$colunas .= '<th style="background-color: #D3D3D3; text-align:'.$style['text-align'].'">'.$column.' '.$i.'</th>';
								foreach ($sub_val as $campo => $value) {
									$colunas .= '<th style="text-align:'.$style['text-align'].'">'.$campo.'</th>';
								}
							}else{
								$colunas .= '<th style="text-align:'.$style['text-align'].'">'.$column.' '.$i.'</th>';
							}
							break;
						}
					}else{
						$colunas .= '<th style="text-align:'.$style['text-align'].'">'.$column.' '.$i.'</th>';
					}
				}
			}else{
				$colunas .= '<th style="text-align:'.$style['text-align'].'">'.$column.'</th>';
			}
		}


		$thead ='<div class="table-responsive"><table border="'.$style['border'].'"class="table table-striped"><thead><tr>'.$colunas.'</tr></thead>';
		$tbody = '';
		$tend = '</table></div>';
		if ($posts instanceof \Illuminate\Pagination\Paginator) {
			$thead = $thead.="<tfoot><tr><td colspan='100%' class='text-center'>".$posts->links()."</td></tr></tfoot>";
		}

		// ============================ATRIBUIÇÃO DOS VALORES===========================
		foreach ($posts as $offset => $post){
			$colunas = "";
			foreach ($values[$offset] as $column => $valor) {
				$linha = '';

				if(is_array($valor)){
					foreach ($count[$column]['campos'] as $offset => $value) {
						if (is_array($value)) {
							$linha .= '<td style="background-color: #D3D3D3"></td>';
							foreach ($value as $key => $val) {
								if(isset($valor[$offset][$key])){
									$linha .= '<td style="text-align:'.$style['text-align'].'">'.$valor[$offset][$key].'</td>';
								}else {
									$linha .= '<td></td>';
								}
							}
						}else{
							if (isset($valor[$offset])) {
								$linha.= '<td style="text-align:'.$style['text-align'].'">'.$valor[$offset].'</td>';
							} else{
								$linha .= '<td></td>';
							}
						}
					}
				}else {
					$linha = '<td style="text-align:'.$style['text-align'].'">'.$valor.'</td>';
				}
				$colunas .= $linha;
			}
			$tbody .=  '<tr>'.$colunas.'</tr>';
		}
		$body = '<tbody>'.$tbody.'</tbody>';

		if(!empty($posts)){
			$table = $thead.=$body.=$tend;
			return $table;
		}
		return false;
	}

	/**
	* Função estática - Retorna as cidades de acordo ID do estado
	* com os valores formatados p/ exibição em select
	* @param int $id - ID de Estado
	* @author Rafael Domingues Teixeira
	*/
	public static function selectCidades($id){
		$cidades = QuerieHelper::findelements('estado', 'cidades', $id);
		return Self::fixArray($cidades,'id','nome');
	}

	/**
	* Função estática - retorna um valor c/ a mascara solicitada
	* @param string $val - valor a ser atribuido mascara
	* @param string $mask - Mascara utilizada (ex: ###.###.###-##)
	* @return string $maskared - valor c/ mascara atribuida
	* @author Rafael Domingues Teixeira
	*/
	public static function mask($val, $mask){
		$maskared = '';
		$k = 0;
		for($i = 0; $i<=strlen($mask)-1; $i++){
			if($mask[$i] == '#'){
				if(isset($val[$k]))
				$maskared .= $val[$k++];
			}else{
				if(isset($mask[$i]))
				$maskared .= $mask[$i];
			}
		}
		return $maskared;
	}

	/**
	* Função estática - Exporta tabela p/ arquivo EXCEL
	* @param string $table - tabela formatada
	* @author Rafael Domingues Teixeira
	*/
	public static function exportExcel($table){
		header("Content-type: application/msexcel; charset=utf-8");
		header("Content-Disposition: attachment; filename=relatorio.xls"); // Nome que arquivo será salvo
		print chr(255) . chr(254) . mb_convert_encoding($table, 'UTF-16LE', 'UTF-8');
	}

	/**
	* Função estática - Exporta conteúdo p/ arquivo PDF
	* @param string $content - conteúdo a ser exportado
	* @param string $style - formatação da página importada. *[paper: ... position: ...]*
	* @return $pdf - página em PDF
	* @author Wiatan Oliveira Silva
	* @author Rafael Domingues Teixeira
	*/
	public static function exportPdf($content,$style){
		$pdf = App::make('dompdf');
		$pdf->setPaper($style['paper'], $style['position']);
		$pdf->loadHTML($content);
		return $pdf;
	}

	/**
	* Função estática - Verifica se conexão com IP está disponível ou não.
	* @param string $ip - IP de conexão
	* @param string $port - porta de conexão
	* @return int $connected - Valor true ou false de acordo com conexão
	* @author Rafael Domingues Teixeira
	* @since 23/02/2018
	*/
	public static function check_ip($ip, $port){
		$connected = @fsockopen($ip, $port);
		fclose($connected);
		return $connected;
	}

	public static function sendEmail($view,$params, $to)
	{
		Mail::send($view, $params ,function($message)use($params,$to){
			$message->subject($params['assunto']);
			$message->to($to);
		});
	}

	public static function PaginationMake($values,$perPage){
		$pagination = App::make('paginator');
		$count = $values->count();
		$page = $pagination->getCurrentPage($count);
		$items = $values->slice(($page - 1) * $perPage, $perPage)->all();
		$pagination = $pagination->make($items, $count, $perPage);
		return $pagination;
	}

	public static function manyToMany($model,$array, $especificar){
		foreach($array as $var){
			$model->attach([$var => ['especificar' => $especificar]]);
		}
	}
}
?>
