<?php 

class TipoResposta extends Eloquent{
    protected $table = 'tipos_respostas';

    public $timestamps = false;

    protected $fillable = array('nome');

    public function respostas(){
        return $this->hasMany('Resposta','tipo_resposta_id','id');
    }
}
