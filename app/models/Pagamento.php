<?php 

class Pagamento extends Eloquent{
    protected $table = 'pagamentos';

    public $timestamps = false;

    protected $fillable = array('valor', 'data', 'aluno_id');

    public function aluno(){
        return $this->belongsTo('Aluno', 'aluno_id', 'id');
    }
        
    public function getDataPagamentoAttribute(){
	    return FormatterHelper::enToBrDate($this->attributes['data_pagamento']);
    }
    
    public function setDataPagamentoAttribute($Data){
        $this->attributes['data_pagamento'] = FormatterHelper::brToEnDate($Data);
    }  
    
    public function atrasado(){
        if($this->aluno->pagamentos()->count() == 1)
            return time() - strtotime($this->aluno->created_at." +3 days") > 0;
        $dia = $this->aluno->dia_pagamento;
        $pag_max = strtotime(strftime('%Y-%m-', strtotime($this->attributes['data'])).($dia+3));
        return time() - $pag_max > 0;
    }
}
