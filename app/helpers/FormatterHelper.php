<?php
class FormatterHelper
{

  /**
  * Formata os valores de uma array para letra maíuscula
  * @param $value : Array a ser formatada
  * @param $keys : Array contendo o nome dos campos que serão formatadas
  *                Caso seja vazia, todos os campos serão formatados
  **/
  public static function multiSelectValues($array){
    $newarray = [];
    foreach($array as $element){
      array_push($newarray,$element->id);
    }
    return $newarray;
  }

  public static function toUpperCase($values, $except= [], $keys = []) {
    $result = $values;
    if (empty($keys)) {
      foreach ($values as $key => $value) {
        if(!in_array($key, $except)){
          if (!is_array($result[$key])) {
            $result[$key] = mb_strtoupper($value, 'UTF-8');
          }
        }
      }
    } else {
      foreach ($keys as $key) {
        $result[$key] = mb_strtoupper($result[$key], 'UTF-8');
      }
    }

    return $result;
  }

  /**
  * Formata todos os valores de uma array para letra maíuscula
  * @param $value: array ou valor que será convertido
  * @param $except: chaves a não serem formatadas
  **/
  public static function recursiveToUpperCase($values, $except = []) {
    $result = [];

    foreach ($values as $key => $value) {
      if (is_array($value)) { // Caso haja uma array dentro, chama recursivamente
        $result[$key] = self::recursiveToUpperCase($value);
      } else {
        if(!in_array($key, $except)){
          $result[$key] = mb_strtoupper($value, 'UTF-8');
        }else{
          $result[$key] = $value;
        }
      }
    }

    return $result;
  }
  /**
  * Formata todos as primeiras letras para maíuscula
  * @param $value: valor que será convertido
  * @param $except: palavras a não serem formatadas
  **/
  public static function ucwords_improved($value, $except){
    return join(' ',
    array_map(
    create_function('$value','return (!in_array($value, ' . var_export($except, true) . ')) ? ucfirst($value) : $value;'
    ),
    explode(' ', strtolower($value))
    )
    );
  }

  /**
  * Remove letras e caracteres especiais de retornando apenas os números
  * @param String $data : Valor a ser formatadop
  * @return String : Valor sem sinais e letras
  **/
  public static function somenteNumeros($data) {
    return preg_replace("/[^0-9]+/", "", $data);
  }

    /**
  * Remove caracteres especiais de retornando apenas os números e letras
  * @param String $data : Valor a ser formatadop
  * @return String : Valor sem sinais
  **/
  public static function removeSignals($data) {
    return preg_replace("/[^A-Za-z0-9]+/", "", $data);
  }

  /* Formatadores de data por extenso e normal */
  public static function setFullDate($date){
    if(substr($date, -8, 8) !== "00:00:00"){
      return strftime('%d/%m/%Y às %H:%M', strtotime($date));
    }else{
      return strftime('%d/%m/%Y', strtotime($date));
    }
  }
  public static function brToEnDate($date){ return implode('-', array_reverse(explode('/', $date))) ? : ''; }
  public static function enToBrDate($date){ return implode('/', array_reverse(explode('-', $date))) ? : ''; }

  /**
  * Faz a limpeza do Array, removendo todos os indices com valores e arrays filhas vazias
  * @param Array|Mixed $data : Array com os dados a serem limpos
  * @return Array|Mixed : Array sem índices vazios
  **/
  public static function clearData($data) {
    $result = [];

    foreach ($data as $key => $value){
      if (is_array($value)) { // Caso haja uma array dentro, chama recursivamente
        $result[$key] = self::clearData($value);
        if(empty($result[$key])){
          unset($result[$key]);
        }
      } else {
        $value = trim($value);
        if(!empty($value)){
          $result[$key] = $value;
        }
      }
    }

    return $result;
  }

  /**
  * Pega o valor do CPF e adiciona os sinais, retornando ###.###.###-##
  * @param String $cpf : CPF sem sinais
  * @return String: CPF com sinais
  **/
  public static function setCPF($cpf){
    $newCPF = substr_replace($cpf   , '-', 9, 0);
    $newCPF = substr_replace($newCPF, '.', 6, 0);
    $newCPF = substr_replace($newCPF, '.', 3, 0);
    return $newCPF;
  }

  public static function setCNPJ($cnpj){
    $newcnpj = substr_replace($cnpj   , '-', 12, 0);
    $newcnpj = substr_replace($newcnpj   , '/', 8, 0);
    $newcnpj = substr_replace($newcnpj, '.', 5, 0);
    $newcnpj = substr_replace($newcnpj, '.', 2, 0);
    return $newcnpj;
}

  public static function enToBrTimes($times){
    $times = str_replace(":", "-", $times);
    return $times;
  }

  public static function setRG($rg){
    $newRG = substr_replace($rg   , '-', 8, 0);
    $newRG = substr_replace($newRG, '.', 5, 0);
    $newRG = substr_replace($newRG, '.', 2, 0);
    return $newCPF;
  }

  public static function removeSinais($valor){
    $valor = trim($valor);
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", "", $valor);
    $valor = str_replace("-", "", $valor);
    $valor = str_replace("/", "", $valor);
    $valor = str_replace("(", "", $valor);
    $valor = str_replace(")", "", $valor);
    return $valor;
  }


  /**
  * Pega o valor do CEP e adiciona os sinais, retornando #####-###
  * @param String $cep : CEP sem sinais
  * @return String: CEP com sinais
  **/
  public static function setCEP($cep){
    if(!empty($cep)){
      $cep = substr_replace($cep, '-', 5, 0);
    }
    return $cep;
  }

  public static function setTelephone($tel){
    if(!empty($tel)) {
      $tel = substr_replace($tel, '-', -4, 0);
      $tel = substr_replace($tel, ') ', 2, 0);
      $tel = substr_replace($tel, '(', 0, 0);
    }
    return $tel;
  }


  public static function camelToSnakeCase($value) {
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $value));
  }

  public static function getAgeMonthFromDate($date) {
    list($year, $month, $day) = explode('-', $date);
    $today = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    $birth = mktime( 0, 0, 0, $month, $day, $year);
    $age = (((($today - $birth) / 60) / 60) / 24) / 365.25;
    $month = floor(12 * ($age - floor($age)));
    $age = floor($age);

    return ['anos' => $age, 'meses' => $month];
  }


  public static function array_values_recursive($array) {
    $flat = array();

    foreach($array as $value) {
      if (is_array($value)) {
        $flat = array_merge($flat, Self::array_values_recursive($value));
      }
      else {
        $flat[] = $value;
      }
    }
    return $flat;
  }

  public static function setTelefone($tel){
    if(strlen($tel) == 11){
      $tel = substr_replace($tel, '-', 7, 0);
      $tel = substr_replace($tel, ' ', 2, 0);
      $tel = substr_replace($tel, ')', 2, 0);
      $tel = substr_replace($tel, '(', 0, 0);
    }else{
      $tel = substr_replace($tel, '-', 6, 0);
      $tel = substr_replace($tel, ' ', 2, 0);
      $tel = substr_replace($tel, ')', 2, 0);
      $tel = substr_replace($tel, '(', 0, 0);
    }
    return $tel;
  }

}
