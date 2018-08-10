<?php

class LoggerHelper{

    public static function log($mensagem) {

        $auxiliar = $mensagem;

        if(date('d')>=1 && date('d')<=10){
            $log_name = date('Y-m-30' ,strtotime (" -1 month"));
        }
        if(date('d')>10 && date('d')<=20){
            $log_name = date('Y-m-10');
        }
        if(date('d')>20 && date('d')<=31){
            $log_name = date('Y-m-20');
        }

        if(!file_exists(base_path()."/log/$log_name.log")){
            $log = fopen(base_path()."/log/$log_name.log",'a');
            foreach(Logger::all() as $db_log){
                $mensagem = mb_strtoupper($db_log->mensagem, 'UTF-8');
                if (!is_null($db_log->usuario)) {
                  $usuario  = mb_strtoupper($db_log->usuario->nome, 'UTF-8');
                  $nivel   = mb_strtoupper($db_log->usuario->nivel->tipo, 'UTF-8');
                }else {
                  $usuario = 'SEM USUÁRIO';
                  $nivel = 'ANONIMO';
                }
                $data = $db_log->data;
                $mensagem = "$data | [ $usuario : $nivel ] | $mensagem \r\n";
                fwrite($log, $mensagem);
            }
            fclose($log);
            Logger::truncate();
        }

        $mensagem = $auxiliar;

            $today = date('Y-m-d H:i:s');
            $last_value = Logger::orderBy('id', 'desc')->first();
            if(Auth::check()){
                $usuario = Auth::user()->id;
              }  else {
                $usuario = null;
              }
            if(is_null($last_value)
                || ($last_value->mensagem != $mensagem
                || $last_value->usuario_id != (Auth::guest() ? null : Auth::user()->id)
                || $mensagem == "Alterou a sua senha"
                || strtotime($last_value->data . ' +' . 10 . ' minutes') < strtotime($today))){

                Logger::create([
                    'mensagem'   => $mensagem,
                    'usuario_id' => $usuario,
                    'data'       => $today
                ]);
            }

    }
}
