<?php

/**
* Classe única e exclusiva p/ aplicação de novos metodos de validação
* @author Rafael Domingues Teixeira
*/

class CustomValidator extends Illuminate\Validation\Validator {

  /**
  * Validador de data mínima a ser inserida
  * @param string $value - Valor informado
  * @param string $param - Data mínima atribuida
  * @author Rafael Domingues Teixeira
  */

  public function validateEach($attribute, $value, $parameters){
      // Transform the each rule
      // For example, `each:exists,users,name` becomes `exists:users,name`
      $ruleName = array_shift($parameters);
      $rule = $ruleName.(count($parameters) > 0 ? ':'.implode(',', $parameters) : '');

      foreach ($value as $arrayKey => $arrayValue)
      {
          $this->validate($attribute.'.'.$arrayKey, $rule);
      }

      // Always return true, since the errors occur for individual elements.
      return true;
  }

  public function validateMinDate($attribute, $value, $param){
    $value = FormatterHelper::brToEnDate($value);
    $param[0] = FormatterHelper::brToEnDate($param[0]);
    return (strtotime($value) < strtotime($param[0])) ? false : true;
  }

  public static function validateCnpj($attribute, $value, $param) {
    $cnpj = $value;
    // Valida tamanho
    if (strlen($cnpj) != 14  || $cnpj == "00000000000000" || $cnpj == "11111111111111" || $cnpj == "22222222222222" || $cnpj == "33333333333333" || $cnpj == "44444444444444" || $cnpj == "55555555555555" || $cnpj == "66666666666666" || $cnpj == "77777777777777" || $cnpj == "88888888888888" ||  $cnpj == "99999999999999")
    return false;
    // Valida primeiro dígito verificador
    for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
    {
      $soma += $cnpj{$i} * $j;
      $j = ($j == 2) ? 9 : $j - 1;
    }
    $resto = $soma % 11;
    if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
    return false;
    // Valida segundo dígito verificador
    for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
    {
      $soma += $cnpj{$i} * $j;
      $j = ($j == 2) ? 9 : $j - 1;
    }
    $resto = $soma % 11;
    return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
  }

  public function validateExtension($attribute, $value, $param){

    if(empty($value[0]))
    return true;

    foreach($value as $val){
      $ext = strtolower(explode(".",$val)[count(explode(".",$val))-1]);
      if($ext != "pdf" && $ext !="png" && $ext !="jpg" && $ext !="jpeg" && $ext !="doc" &&
      $ext !="docx" && $ext !="dwg" && $ext !="xls" && $ext !="xlsx"){
        return false;
      }
    }
    return true;
  }

  protected function replaceMinDate($message, $attribute, $rule, $parameters){
    return str_replace(':mindate', $parameters[0], $message);
  }

  /**
  * Validador de valores duplicados dentro de um array
  * @param array $value - array informado
  * @author Rafael Domingues Teixeira
  */
  public function validateDuplicate($attribute, $value, $parameters){
    if(count(array_unique($value))<count($value)){
      return false;
    }
    return true;
  }

  protected function replaceDuplicate($message, $attribute, $rule, $parameters){
    return str_replace(':duplicate', $attribute, $message);
  }

  /**
  * Validador de CPF
  * @param array $value - numero de cpf
  * @author Rafael Domingues Teixeira
  */
  public static function validateCpf($attribute, $value, $param) {
    $cpf = $value;
    // Valida tamanho
    if (strlen($cpf) != 11 || $cpf == "00000000000" || $cpf == "11111111111" || $cpf == "22222222222" || $cpf == "33333333333" || $cpf == "44444444444" || $cpf == "55555555555" || $cpf == "66666666666" || $cpf == "77777777777" || $cpf == "88888888888" ||  $cpf == "99999999999")
    return false;
    // Calcula e confere primeiro dígito verificador
    for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
    $soma += $cpf{$i} * $j;
    $resto = $soma % 11;
    if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto))
    return false;
    // Calcula e confere segundo dígito verificador
    for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
    $soma += $cpf{$i} * $j;
    $resto = $soma % 11;
    return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
  }

  protected function replaceCPF($message, $attribute, $rule, $parameters)
  {
    if(count($parameters) > 0)
    return str_replace(':cpf', $parameters, $message);
    else
    return $message;
  }
}
