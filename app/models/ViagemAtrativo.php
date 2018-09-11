<?php 

class ViagemAtrativo extends Eloquent{
    protected $table = 'viagens_atrativos';

    public $timestamps = false;

    public $fillable = ['tipo_atrativo_id'];

    public function tipo(){
        return $this->belongsTo('TipoAtrativo','tipo_atrativo_id','id');
    }
}
