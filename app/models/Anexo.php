<?php

class Anexo extends Eloquent{
    protected $table = 'anexos';

    public $timestamps = true;

    protected $fillable = array('nome');

    public function viagem(){
        return $this->belongsTo('Viagem', 'viagem_id');
    }
}
