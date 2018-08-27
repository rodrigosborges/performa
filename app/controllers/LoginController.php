<?php
class LoginController extends Controller {

  // VIEW PADRÃO DE ACESSO
  public function index(){
    return View::make("usuario.login");
  }

  public function login(){
    $input = Input::except('_token');
    $validator = Validator::make($input, LoginValidator::rules(), LoginValidator::msgs());
    $validator->setAttributeNames(array('password' => 'senha')); //ALTERAÇÃO P/ 'Nice name'
    if($validator->fails()){
      $validator->getMessageBag()->setFormat('<p class="text-danger">:message</p>');
      return Redirect::back()->withInput()->withErrors($validator);
    }

    $input = Input::except('_token','g-recaptcha-response');

    if (Auth::attempt($input)){
        return Redirect::intended('/');
    }else{
      return Redirect::back()->withInput()->with('error', "Usuário ou senha inválidos!");
    }    
  }

  public function logout(){
    Auth::logout();    
    return Redirect::to('/login')->with('success','Usuário deslogado com sucesso.');
  }

}

?>
