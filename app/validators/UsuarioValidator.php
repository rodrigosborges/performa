<?php
class UsuarioValidator{
  public static function rules($usuario, $input){
    //REGRAS DE VALIDAÇÃO
    $rules = [
      //Dados individuo
      'nome'                        => 'required|min:3|max:70',
      'login'                     => 'required|min:5|unique:usuarios,usuario',
      'email'                       => 'required|unique:usuarios,email',
      'password'                    => 'required|min:10|regex:/^(?=(?:.*[a-zA-z]{1,}))(?=(?:.*[0-9]){1,})(?=(?:.*[!@#$%&*]){1,})(.{10,})$/'
    ];
    return $rules;
  }


  public static function passRules(){
    return [
      'password'    => 'required|min:10|regex:/^(?=(?:.*[a-zA-z]{1,}))(?=(?:.*[0-9]){1,})(?=(?:.*[!@#$%&*]){1,})(.{10,})$/|confirmed',
    ];
  }

  public static function msgs(){
    // MENSAGENS DE ERROS DE VALIDAÇÃO
    return [
  			'required'         => 'O campo :attribute é obrigatório.',
  			'email'            => 'O campo :attribute deve ter um endereço de email válido.',
  			'min'              => 'O campo :attribute precisa ter no mínimo :min caracteres.',
        'unique'           => 'O valor informado no campo ":attribute" já existe.',
        'numeric'          => 'O campo :attribute deve ser numérico!',
        'regex'            => 'Formato Inválido no campo :attribute! ',
        'password.regex'   => 'A senha deve ter no mínimo 10 caracteres contendo letras, números e pelo menos um caracter especial!',
        'email.regex'      => 'Preencher apenas a primeira parte do email institucional.',
        'confirmed'        => 'A confirmação de ":attribute" não confere.',
      ];
  }

}

 ?>
