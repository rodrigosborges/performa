<?php 

/**
 * Eloquent class to describe the tipos_refeicoes table
 *
 * automatically generated by ModelGenerator.php
 */
class TipoRefeicao extends Eloquent{
    protected $table = 'tipos_refeicoes';

    public $timestamps = false;

    protected $fillable = array('nome');

    public function viagens(){
        return $this->belongsToMany('Viagem', 'viagens_refeicoes', 'tipos_refeicoes_id', 'viagens_id');
    }
}
