<?php 

class Plano extends Eloquent{
    protected $table = 'planos';

    public $timestamps = false;

    protected $fillable = array('nome', 'valor');

}
