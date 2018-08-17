<?php 

/**
 * Eloquent class to describe the empresas table
 *
 * automatically generated by ModelGenerator.php
 */
class Empresa extends Eloquent{
    protected $table = 'empresas';

    public $timestamps = false;

    protected $fillable = array('nome', 'site','cidade_id');

    public function cidade(){
        return $this->belongsTo('Cidade', 'cidade_id', 'id');
    }

    public function contato(){
        return $this->belongsTo('Contato', 'contato_id', 'id');
    }

    public function viagem(){
        return $this->hasOne('Viagem', 'empresa_id', 'id');
    }
}
