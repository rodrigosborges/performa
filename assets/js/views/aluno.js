function especificar(input, outros, target){
    var values = $("select[name='"+input+"']").val()
    target = $("#"+target)
    if(values.includes(String(outros))){
        target.show()
        target.find("input").addClass("required").prop('disabled',false)
    }else{
        target.hide()
        target.find("input").removeClass("required").prop('disabled',true)
    }
}

function estacionamento(){
    var val = $('input[name=estacionamento_proprio]:checked').val()
    var divfalse = $(".estacionamento_false")
    var divtrue = $(".estacionamento_true")
    var file = $("input[name=estacionamento_proprio_file]")
    if(val == 1){
        divfalse.hide();
        divtrue.show();
        divfalse.find("select").removeClass("required").prop("disabled",true)
        divtrue.find("input:file").addClass(file.length == 0 ? "required" : "").prop("disabled",false)
    }else{
        divtrue.hide();
        divfalse.show();    
        divfalse.find("select").addClass("required").prop("disabled",false)
        divtrue.find("input:file").removeClass("required").prop("disabled",true)
    }
}

$(".send-form").on('click',function(){
    if($("#form").valid()){
        $(".send-form").prop("disabled",true) 
        $("#form").submit()  
    } 
})

$(document).ready(function(){
    estacionamento();

    $("input[name=estacionamento_proprio]").on('change',function(){
        estacionamento();
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