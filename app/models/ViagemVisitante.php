<?php 

class ViagemVisitante extends Eloquent{
    protected $table = 'viagens_visitantes';

    public $timestamps = false;

    public $fillable = ['tipo_visitante_id'];

    public function tipo(){
        return $this->belongsTo('TipoVisitante','tipo_visitante_id','id');
    }
}
