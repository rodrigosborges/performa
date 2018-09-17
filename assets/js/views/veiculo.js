$(document).ready(function(){
    $("#adicionarVeiculo").on('click', function(){
        addRemoveRule($("#veiculo").find("input:text, input:file, select"), "add", "required")
        if($("#veiculo").find("input:text, input:file, select").valid()){
            var form = $(".veiculo").last().clone(false)
            var hash = Math.random().toString(36).substring(2, 15)
            var veiculo = $(".veiculo").last().addClass(hash).hide()
            form.find('input:text, input:file, select').val('')
            form.find('.placa').mask("SSS-9999")
            form.appendTo("#veiculo")
            $("#veiculotable").find('tbody').append(
                "<tr class='"+hash+"'><td>"+veiculo.find("select[name='tipo_veiculo_id[]'] option:selected").html()+
                "</td><td class='placaveiculo'>"+veiculo.find("input[name='placa[]']").val()+
                "</td><td>"+veiculo.find("input[name='registro[]']").val()+
                "</td>"+($("#form").attr('data-veiculo_id')? "<td></td>" : "")+"<td><button type='button' class='btn btn-outline-danger btn-block' onclick='excluirVeiculo(`"+hash+"`)'>Excluir</button></td></tr>"
            )
        }
        addRemoveRule($("#veiculo").find("input:text, input:file, select"), "remove", "has_added")
    })

    $(".send-form").on('click', function(){
        $(".has_added").each(function(index){
            $(this).rules("add",{ has_added: "veiculotable" })
        })
        if($("#form").valid()){
            $(".veiculo").last().find("input:text, input:file, select").prop("disabled",true)
            $(".send-form").prop("disabled",true)    
            $("#form").submit()
        }
    })

})

function excluirVeiculoExistente(id){
    $(".excluirVeiculos").append("<input name='excluir[]' type='hidden' value='"+id+"'>")
    $(".excluirVeiculo"+id).remove()
}

function excluirVeiculo(div){
    $("."+div).remove() 
}

function addRemoveRule(inputs, param, rule){
    inputs.map((index,input) => {
        if(param == "add"){
            if(index != 4 || (index == 4 && $("input[name=logado]").length == 0))
                $(input).rules("add",{ required:true })
            $(input).rules("remove","has_added")
        }else{
            $(input).rules("remove","required")
        }
    })
}


