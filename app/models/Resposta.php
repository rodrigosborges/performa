<?php 

class Resposta extends Eloquent{
    protected $table = 'respostas';

    public $timestamps = false;

    protected $fillable = array('texto','anexo','tipo_resposta_id');

    public function viagens(){
        return $this->belongsTo('Viagem','viagem_id');
    }

    public function tipo_resposta(){
        return $this->belongsTo('TipoResposta','tipo_resposta_id');
    }
}
