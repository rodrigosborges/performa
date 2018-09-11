<?php 

class ViagemRefeicao extends Eloquent{
    protected $table = 'viagens_refeicoes';

    public $timestamps = false;

    public $fillable = ['tipo_refeicao_id'];

    public function tipo(){
        return $this->belongsTo('TipoRefeicao','tipo_refeicao_id','id');
    }
}
