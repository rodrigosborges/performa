$(document).ready(function(){
    $("#adicionarVeiculo").on('click', function(){
        requiredAddRemove($("#veiculo").find("input:text, input:file, select"), "add")
        if($("#veiculo").find("input:text, input:file, select").valid()){
            var form = $(".veiculo").last().clone(true)
            var hash = Math.random().toString(36).substring(2, 15)
            var veiculo = $(".veiculo").last().addClass(hash).hide()
            form.find('input:text, input:file, select').val('')
            form.appendTo("#veiculo")
            $("#veiculotable").find('tbody').append(
                "<tr class='"+hash+"'><td>"+veiculo.find("select[name='tipo_veiculo_id[]'] option:selected").html()+
                "</td><td>"+veiculo.find("input[name='placa[]']").val()+
                "</td><td>"+veiculo.find("input[name='registro[]']").val()+
                "</td><td><button type='button' class='btn btn-outline-danger btn-block' onclick='excluirVeiculo(`"+hash+"`)'>Excluir</button></td></tr>"
            )
        }
        requiredAddRemove($("#veiculo").find("input:text, input:file, select"), "remove")
    })
})

function excluirVeiculo(div){
    $("."+div).remove() 
}

function requiredAddRemove(inputs, param){
    console.log()
    inputs.map((index,input) => {
        if(param == "add")
            input.classList.add("required")
        else
            input.classList.remove("required")
    })
}
