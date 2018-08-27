<?php
class LoginValidator{

  public static function rules(){
    //REGRAS DE VALIDAÇÃO
    return [
      'usuario' => 'required',
      'password'   => 'required',
    ];
  }

  public static function msgs(){
    // MENSAGENS DE ERROS DE VALIDAÇÃO
    return[
      'required'  => 'O  campo :attribute é obrigatório.',
      'min'       => 'O campo :attribute precisa ter no mínimo :min caracteres.',
    ];
  }

}

?>
