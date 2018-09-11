<?php 

class ViagemDestino extends Eloquent{
    protected $table = 'viagens_destinos';

    public $timestamps = false;

    public $fillable = ['tipo_destino_id'];

    public function tipo(){
        return $this->belongsTo('TipoDestino','tipo_destino_id','id');
    }
}
