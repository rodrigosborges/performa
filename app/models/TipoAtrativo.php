<?php 

/**
 * Eloquent class to describe the tipos_atrativos table
 *
 * automatically generated by ModelGenerator.php
 */
class TipoAtrativo extends Eloquent{
    protected $table = 'tipos_atrativos';

    public $timestamps = false;

    protected $fillable = array('nome');

    public function viagens(){
        return $this->belongsToMany('Viagem', 'viagens_atrativos', 'tipos_atrativos_id', 'viagens_id');
    }
}
