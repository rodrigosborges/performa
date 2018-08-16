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

$(document).ready(function(){

    $("#adicionarVeiculo").on('click', function(){
        var form = $(".veiculo").first().clone()
        form.find('input:text, input:file, select').val('');
        form.appendTo("#veiculo")
        $("#removerVeiculo").show()
    })

    $("#removerVeiculo").on('click', function(){
        $(".veiculo").last().remove()
        if($(".veiculo").length == 1)
        $(this).hide() 
    })

    $("input[name=roteiro_predefinido]").on('change',function(){
        if($(this).val() == 1){
            $(".roteiro").show()
            $(".roteiro").find("input").addClass("required")
        }else{
            $(".roteiro").hide()
            $(".roteiro").find("input").removeClass("required")
        }
    })

    $("input[name=primeira_vez]").on('change',function(){
        if($(this).val() == 0){
            $(".primeira_vez").show()
            $(".primeira_vez").find("select").addClass("required")
        }else{
            $(".primeira_vez").hide()
            $(".primeira_vez").find("select").removeClass("required")
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

    $(document).on('change', 'input[name="estado"]', function() {
        findElements($('input[name="estado"]').val(), cidade, 'Estado', 'cidades', 3388)
    });

})