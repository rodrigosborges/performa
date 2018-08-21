function especificar(input, outros, target){
    var values = $("select[name='"+input+"']").val()
    target = $("#"+target)
    if(values.includes(String(outros))){
        target.show()
        target.find("input").addClass("required")
    }else{
        target.hide()
        target.find("input").removeClass("required")
    }
}

function excluirVeiculo(div){
    $("."+div).remove()
    
}

$(document).ready(function(){

    // $("#adicionarVeiculo").on('click', function(){
    //     var form = $(".veiculo").first().clone()
    //     form.find('input:text, input:file, select').val('');
    //     form.appendTo("#veiculo")
    //     $("#removerVeiculo").show()
    // })

    // $("#removerVeiculo").on('click', function(){
    //     $(".veiculo").last().remove()
    //     if($(".veiculo").length == 1)
    //         $(this).hide() 
    // })

    $("#adicionarVeiculo").on('click', function(){
        if($("#veiculo").find("input:text, input:file, select").valid()){
            var form = $(".veiculo").last().clone()
            var hash = Math.random().toString(36).substring(2, 15)
            var veiculo = $(".veiculo").last().addClass(hash).hide()
            form.find('input:text, input:file, select').val('');
            form.appendTo("#veiculo")
            $("#veiculotable").find('tbody').append(
                "<tr class='"+hash+"'><td>"+veiculo.find("select[name='tipo_veiculo_id[]'] option:selected").html()+
                "</td><td>"+veiculo.find("input[name='placa[]']").val()+
                "</td><td>"+veiculo.find("input[name='registro[]']").val()+
                "</td><td><button type='button' class='btn btn-outline-danger btn-block' onclick='excluirVeiculo(`"+hash+"`)'>Excluir</button></td></tr>"
            );
        }
    })

    $("input[name=roteiro_predefinido]").on('change',function(){
        if($(this).val() == 1){
            $(".roteiro").show()
            $(".roteiro").find("input").addClass("required").prop('disabled',false)
        }else{
            $(".roteiro").hide()
            $(".roteiro").find("input").removeClass("required").prop('disabled',true)
        }
    })

    $("input[name=primeira_vez]").on('change',function(){
        if($(this).val() == 0){
            $(".primeira_vez").show()
            $(".primeira_vez").find("select").addClass("required").prop('disabled',false)
        }else{
            $(".primeira_vez").hide()
            $(".primeira_vez").find("select").removeClass("required").prop('disabled',true)
        }
    })

    $("input[name=organizacao_id]").on('change',function(){
        if($(this).val() == 1){
            $(".empresa").show()
            $(".empresa").find("input:text, select").not("input[name='empresa[site]']").addClass("required")
        }else{
            $(".empresa").hide()
            $(".empresa").find("input:text, select").removeClass("required")
        }
    })

    $(document).on('change', 'select[name="estado"]', function() {
        findElements($('select[name="estado"]').val(), $('select[name="cidade_origem"]'), 'Estado', 'cidades', 3388)
    });

    $(document).on('change', 'select[name="empresa[estado]"]', function() {
        findElements($('select[name="empresa[estado]"]').val(), $('select[name="empresa[cidade_id]"]'), 'Estado', 'cidades', 3388)
    });

})