<?php 

class ViagemMotivo extends Eloquent{
    protected $table = 'viagens_motivos';

    public $timestamps = false;

    public $fillable = ['tipo_motivo_id'];

    public function tipo(){
        return $this->belongsTo('TipoMotivo','tipo_motivo_id','id');
    }
}
