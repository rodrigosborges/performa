<?php 

class Pagamento extends Eloquent{
    protected $table = 'pagamentos';

    public $timestamps = false;

    protected $fillable = array('valor', 'data');

    public function aluno(){
        return $this->belongsTo('Aluno', 'aluno_id', 'id');
    }

        
    public function getDataAttribute(){
	    return FormatterHelper::enToBrDate($this->attributes['data']);
    }
    
    public function setDataAttribute($Data){
        $this->attributes['data'] = FormatterHelper::brToEnDate($Data);
	}  
}
