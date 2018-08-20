<?php 

/**
 * Eloquent class to describe the pessoas table
 *
 * automatically generated by ModelGenerator.php
 */
class Pessoa extends Eloquent{
    protected $table = 'pessoas';

    public $timestamps = false;

    protected $fillable = array('nome', 'cpf', 'anexo');

    public function contato(){
        return $this->belongsTo('Contato', 'contato_id', 'id');
    }

    public function viagens(){
        return $this->hasMany('Viagem', 'pessoa_id', 'id');
    }

    public function getCpfAttribute(){
	    return FormatterHelper::setCPF($this->attributes['cpf']);
    }
    
    public function setCpfAttribute($cpf){
		$this->attributes['cpf'] = FormatterHelper::somenteNumeros($cpf);
	}  
}
