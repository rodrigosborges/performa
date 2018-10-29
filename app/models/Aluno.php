<?php 
use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Aluno extends Eloquent{
    protected $table = 'alunos';
    use SoftDeletingTrait;
    public $timestamps = true;

    protected $fillable = array('nome', 'matricula', 'cpf', 'sexo', 'data_nascimento','data_pagamento', 'plano_id', 'contato_id', 'endereco_id', 'dia_pagamento');

    public function contato(){
        return $this->belongsTo('Contato', 'contato_id', 'id');
    }

    public function endereco(){
        return $this->belongsTo('Endereco', 'endereco_id', 'id');
    }

    public function pagamentos(){
        return $this->hasMany('Pagamento', 'aluno_id', 'id');
    }

    public function plano(){
        return $this->belongsTo('Plano', 'plano_id', 'id');
    }
    
    public function getDataNascimentoAttribute(){
	    return FormatterHelper::enToBrDate($this->attributes['data_nascimento']);
    }
    
    public function setDataNascimentoAttribute($data_nascimento){
        $this->attributes['data_nascimento'] = FormatterHelper::brToEnDate($data_nascimento);
    }  
    
    public function situacao(){
        $atrasados = 0;
        if($this->pagamentos()->whereNull('data_pagamento')->count() > 0){
            foreach($this->pagamentos as $pagamento){
                if($pagamento->atrasado())
                    $atrasados++;
            }
        }
        return $atrasados == 0 ? "Normal" : ($atrasados == 2 ? "Bloqueado" : "Em débito" );
    }
}
