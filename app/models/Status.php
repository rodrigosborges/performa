<?php 

class Status extends Eloquent{
    protected $table = 'status';

    public $timestamps = false;

    protected $fillable = array('nome');
}