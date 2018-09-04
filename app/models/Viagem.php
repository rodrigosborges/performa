<?php 

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Viagem extends Eloquent{
    use SoftDeletingTrait;

    protected $table = 'viagens';

    protected $fillable = array('cidade_origem','bairro_id','numeroPessoas', 'chegada', 'saida', 'primeira_vez', 'local_destino',
        'roteiro_predefinido', 'roteiro_especificar','sugestao','organizacao_id', 'destino_id','quantidade_vez_id', 'empresa_veiculo');

    public $timestamps = true;
    
    public function cidade_origem(){
        return $this->belongsTo('Cidade', 'cidade_origem', 'id');
    }

    public function empresa(){
        return $this->belongsTo('Empresa', 'empresa_id', 'id');
    }

    public function bairro(){
        return $this->belongsTo('Bairro', 'bairro_id', 'id');
    }

    public function cidade(){
        return $this->belongsTo('Cidade', 'cidade_origem', 'id');
    }

    public function destino(){
        return $this->belongsTo('Destino', 'destino_id', 'id');
    }

    public function organizacao(){
        return $this->belongsTo('Organizacao', 'organizacao_id', 'id');
    }

    public function status(){
        return $this->belongsTo('Status', 'status_id', 'id');
    }

    public function respostas(){
        return $this->hasMany('Resposta', 'viagem_id', 'id');
    }

    public function anexos(){
        return $this->hasMany('Anexo', 'viagem_id', 'id');
    }

    public function pessoa(){
        return $this->belongsTo('Pessoa', 'pessoa_id', 'id');
    }

    public function quantidadeVez(){
        return $this->belongsTo('QuantidadeVez', 'quantidade_vez_id', 'id');
    }

    public function veiculos(){
        return $this->hasMany('Veiculo', 'viagem_id', 'id');
    }

    public function tiposAtrativos(){
        return $this->belongsToMany('TipoAtrativo', 'viagens_atrativos', 'viagem_id', 'tipo_atrativo_id')->withPivot('especificar');
    }

    public function getAtrativos(){
        foreach($this->tiposAtrativos as $key => $temp){
            echo ($key!=0 ? ", ":"").$temp->nome.($temp->nome == "Outros" ? " - ".$temp->pivot->especificar :"");
        }
    }

    public function tiposMotivos(){
        return $this->belongsToMany('TipoMotivo', 'viagens_motivos', 'viagem_id', 'tipo_motivo_id')->withPivot('especificar');
    }

    public function getMotivos(){
        foreach($this->tiposMotivos as $key => $temp){
            echo ($key!=0 ? ", ":"").$temp->nome.($temp->nome == "Outros" ? " - ".$temp->pivot->especificar :"");
        }    
    }

    public function tiposRefeicoes(){
        return $this->belongsToMany('TipoRefeicao', 'viagens_refeicoes', 'viagem_id', 'tipo_refeicao_id')->withPivot('especificar');
    }

    public function getRefeicoes(){
        foreach($this->tiposRefeicoes as $key => $temp){
            echo ($key!=0 ? ", ":"").$temp->nome.($temp->nome == "Outros" ? " - ".$temp->pivot->especificar :"");
        } 
    }

    public function tiposVisitantes(){
        return $this->belongsToMany('TipoVisitante', 'viagens_visitantes', 'viagem_id', 'tipo_visitante_id')->withPivot('especificar');
    }

    public function getVisitantes(){
        foreach($this->tiposVisitantes as $key => $temp){
            echo ($key!=0 ? ", ":"").$temp->nome.($temp->nome == "Outros" ? " - ".$temp->pivot->especificar :"");
        }
    }

    public function tiposDestinos(){
        return $this->belongsToMany('TipoDestino', 'viagens_destinos', 'viagem_id', 'tipo_destino_id')->withPivot('especificar');
    }

    public function getDestinos(){
        foreach($this->tiposDestinos as $key => $temp){
            echo ($key!=0 ? ", ":"").$temp->nome.($temp->nome == "Outros" ? " - ".$temp->pivot->especificar :"");
        }
    }

    public function setChegadaAttribute($chegada){
        $this->attributes['chegada'] = FormatterHelper::brToEnDate($chegada);
    }
    
    public function getChegadaAttribute(){
        return FormatterHelper::enToBrDate($this->attributes['chegada']);
    }

    public function setSaidaAttribute($saida){
        $this->attributes['saida'] = FormatterHelper::brToEnDate($saida);
    }

    public function getSaidaAttribute(){
        return FormatterHelper::enToBrDate($this->attributes['saida']);
    }

    public function setRoteiroPredefinidoAttribute($roteiro){
        if($roteiro == 0)
            $this->attributes['roteiro_especificar'] = null;
        $this->attributes['roteiro_predefinido'] = $roteiro;
    }

    public function setPrimeiraVezAttribute($vez){
        if($vez == 1)
            $this->attributes['quantidade_vez_id'] = null;
        $this->attributes['primeira_vez'] = $vez;
    }

}
