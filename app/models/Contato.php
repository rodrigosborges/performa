<?php


/**
 * Eloquent class to describe the contatos table
 *
 * automatically generated by ModelGenerator.php
 */

class Contato extends Eloquent{
    protected $table = 'contatos';

    public $timestamps = false;

    protected $fillable = array('telefone', 'celular', 'email');
    
	public function setCelularAttribute($celular){
		$this->attributes['celular'] = FormatterHelper::somenteNumeros($celular);
	}  

	public function setTelefoneAttribute($telefone){
		$this->attributes['telefone'] = FormatterHelper::somenteNumeros($telefone);
	}  

    public function getTelefoneAttribute(){
        return FormatterHelper::setTelefone($this->attributes['telefone']);
    }

    public function getCelularAttribute(){
        return FormatterHelper::setTelefone($this->attributes['celular']);
    }

    public function pessoa(){
        return $this->hasOne('Pessoa', 'contato_id', 'id');
    }

    public function empresa(){
        return $this->hasOne('Empresa', 'contato_id', 'id');
    }

}
