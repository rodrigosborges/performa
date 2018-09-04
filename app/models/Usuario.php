<?php 

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Usuario extends Eloquent implements UserInterface, RemindableInterface {
	use UserTrait, RemindableTrait, SoftDeletingTrait;

    protected $table = 'usuarios';

    protected $fillable = array('nome', 'usuario', 'email', 'password', 'remember_token');

    public $timestamps = true;

}
