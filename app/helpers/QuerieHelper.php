<?php

class QuerieHelper extends Controller{

  public function unique($tabela,$campo,$tipo,$id){
    $dados = Input::all();
    foreach ($dados as $offset => $dado) {
      if(is_array($dado)){
        foreach ($dado as $offset => $value) {
          if(is_array($dado)){
            foreach ($value as $offset => $value2) {
              $dado = $value2;
            }
          }else{
            $dado = $value;
          }
        }
      }
      $data['value'] = ($offset != 'email' && $offset != 'numero')? FormatterHelper::removeSinais($dado): $data['value'] = $dado;
    }
    $validacao = Validator::make($data, UniqueValidator::rules($tabela,$campo,$tipo,$id), UniqueValidator::msgs($data));
    if($validacao->passes()) return 'true';
    return 'false';
  }

  /**
  * Função estática - retorna resultado(s) conforme busca em relação do modelo
  * @param string $model - Model onde será buscado a relação
  * @param string $relacao - relação referente ao modelo informado
  * @return object Resultado(s) da relação c/ o modelo
  * @author Rafael Domingues Teixeira
  */
  public static function findElements($model, $relacao, $id){
    $model = ucfirst($model);
    $result = $model::find($id);
    return json_encode($result->$relacao);
  }

  public static function search($model,$fields){
    foreach($fields as $key=>$field){
      if($field != ""){
        $model = $model->where("$key",$field);
      }
    }
    return $model;
  }

}
?>
