<?php 

class Endereco extends Eloquent{
    protected $table = 'enderecos';

    public $timestamps = false;

    protected $fillable = array('endereco', 'bairro', 'cidade', 'uf', 'cep');

    public function aluno(){
        return $this->hasOne('Aluno', 'endereco_id', 'id');
    }
}
