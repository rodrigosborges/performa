<?php 

/**
 * Eloquent class to describe the quantidade_vezes table
 *
 * automatically generated by ModelGenerator.php
 */
class QuantidadeVez extends Eloquent{
    protected $table = 'quantidade_vezes';

    public $timestamps = false;

    protected $fillable = array('nome');

    public function viagens(){
        return $this->hasMany('Viagem', 'quantidade_vezes_id', 'id');
    }
}
