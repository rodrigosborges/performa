jQuery.validator.addMethod("verificaCPF", function(value, element) {
  value = jQuery.trim(value);
  cpf = value.replace(/[^\d]+/g,'')

  while(cpf.length < 11) cpf = "0"+ cpf;
  var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
  var a = [], b = new Number, c = 11;
  for (i=0; i<11; i++){
    a[i] = cpf.charAt(i);
    if (i < 9) b += (a[i] * --c);
  }

  ((x = b % 11) < 2) ? a[9] = 0 : a[9] = 11-x ;
  b = 0;
  c = 11;
  for (y=0; y<10; y++) b += (a[y] * c--);
    ((x = b % 11) < 2) ? a[10] = 0 : a[10] = 11-x;

  var retorno = true;
  if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

  return this.optional(element) || retorno;
}, "Informe um CPF válido.");

jQuery.validator.addMethod("cnpj", function(cnpj, element) {
   cnpj = jQuery.trim(cnpj);
  
  // DEIXA APENAS OS NÚMEROS
  cnpj = cnpj.replace(/[^\d]+/g,'');

   var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
   digitos_iguais = 1;

   if (cnpj.length < 14 && cnpj.length < 15){
      return this.optional(element) || false;
   }
   for (i = 0; i < cnpj.length - 1; i++){
      if (cnpj.charAt(i) != cnpj.charAt(i + 1)){
         digitos_iguais = 0;
         break;
      }
   }

   if (!digitos_iguais){
      tamanho = cnpj.length - 2
      numeros = cnpj.substring(0,tamanho);
      digitos = cnpj.substring(tamanho);
      soma = 0;
      pos = tamanho - 7;

      for (i = tamanho; i >= 1; i--){
         soma += numeros.charAt(tamanho - i) * pos--;
         if (pos < 2){
            pos = 9;
         }
      }
      resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
      if (resultado != digitos.charAt(0)){
         return this.optional(element) || false;
      }
      tamanho = tamanho + 1;
      numeros = cnpj.substring(0,tamanho);
      soma = 0;
      pos = tamanho - 7;
      for (i = tamanho; i >= 1; i--){
         soma += numeros.charAt(tamanho - i) * pos--;
         if (pos < 2){
            pos = 9;
         }
      }
      resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
      if (resultado != digitos.charAt(1)){
         return this.optional(element) || false;
      }
      return this.optional(element) || true;
   }else{
      return this.optional(element) || false;
   }
}, "Informe um CNPJ válido."); // Mensagem padrão

jQuery.validator.addMethod("validaDataBR", function (value, element) {
  //contando chars
  if (value.length != 10) return (this.optional(element) || false);
  // verificando data
  var data = new Date();
  var anoAtual = data.getYear();
  var mesAtual = data.getMonth() + 1;
  var diaAtual = data.getDate();
  if (anoAtual < 1000){
    anoAtual+=1900;
  }

  var data = value;
  var dia = data.substr(0, 2);
  var barra1 = data.substr(2, 1);
  var mes = data.substr(3, 2);
  var barra2 = data.substr(5, 1);
  var ano = data.substr(6, 4);
  if (data.length != 10 || barra1 != "/" || barra2 != "/" || isNaN(dia) || isNaN(mes) || isNaN(ano) || dia > 31 || mes > 12) return (this.optional(element) || false);
  if ((mes == 4 || mes == 6 || mes == 9 || mes == 11) && dia == 31) return (this.optional(element) || false);
  if (mes == 2 && (dia > 29 || (dia == 29 && ano % 4 != 0))) return (this.optional(element) || false);
  if (ano < 1900 || ano > anoAtual) return (this.optional(element) || false);
  if (ano >= anoAtual && mes > mesAtual) return (this.optional(element) || false);
  if ((ano >= anoAtual && dia > diaAtual) && (mes >= mesAtual && dia > diaAtual)) return (this.optional(element) || false);

  return (this.optional(element) || true);
}, "Informe uma data válida.");  // Mensagem padrão

jQuery.validator.addMethod("validaDataLivre", function (value, element) {
  //contando chars
  if (value.length != 10) return (this.optional(element) || false);
  // verificando data
  var data = new Date();
  var anoAtual = data.getYear();
  var mesAtual = data.getMonth() + 1;
  var diaAtual = data.getDate();
  if (anoAtual < 1000){
    anoAtual+=1900;
  }

  var data = value;
  var dia = data.substr(0, 2);
  var barra1 = data.substr(2, 1);
  var mes = data.substr(3, 2);
  var barra2 = data.substr(5, 1);
  var ano = data.substr(6, 4);
  if (data.length != 10 || barra1 != "/" || barra2 != "/" || isNaN(dia) || isNaN(mes) || isNaN(ano) || dia > 31 || mes > 12) return (this.optional(element) || false);
  if ((mes == 4 || mes == 6 || mes == 9 || mes == 11) && dia == 31) return (this.optional(element) || false);
  if (mes == 2 && (dia > 29 || (dia == 29 && ano % 4 != 0))) return (this.optional(element) || false);
  if (ano < 1900) return (this.optional(element) || false);

  return (this.optional(element) || true);
}, "Informe uma data válida.");  // Mensagem padrão

jQuery.validator.addMethod("multiple_extensions", function (value, element, params) {
  files = $("input[name='"+element.name+"']") //input dos arquivos
  var names = []  
  params = params.split('|') //separa as extensoes obtidas por parametro em array 
  
  for (var i = 0; i < files.get(0).files.length; ++i){
    var ext = ((files.get(0).files[i].name).toLowerCase()).split('.'); 
    names.push(ext[ext.length-1])// armazena as extensoes dos arquivos do input
  }

  return (this.optional(element) || verificaExtensao(names, params));
}, "Por favor, coloque arquivos com a extensão válida( {0} ).");  // Mensagem padrão

jQuery.validator.addMethod("files_size", function (value, element, size) {
  files = $("input[name='"+element.name+"']") //input dos arquivos
  total = 0
  for (var i = 0; i < files.get(0).files.length; ++i){
    total += files.get(0).files[i].size; //soma o tamanho dos arquivos
  }

  return (this.optional(element) || total <= size*1024);
}, "Os arquivos não devem ultrapassar 5MB");  // Mensagem padrão


jQuery.validator.addMethod("placa", function (value, element) {
  return this.optional(element) || /[a-zA-Z]{3}-[0-9]{4}/.test(value);
}, "Insira uma placa de veículo válida");

jQuery.validator.addMethod("telefone", function (value, element) {
  return this.optional(element) || /\([0-9]{2}\) [0-9]{4}-[0-9]{4}/.test(value) || /\([0-9]{2}\) [0-9]{5}-[0-9]{4}/.test(value);
}, "Insira um telefone válido");

jQuery.validator.addMethod("celular", function (value, element) {
  return this.optional(element) || /\([0-9]{2}\) [0-9]{5}-[0-9]{4}/.test(value);
}, "Insira um celular válido ");

jQuery.validator.addMethod("letras", function(value, element) {
  return this.optional(element) || /^[a-z-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/i.test(value);
}, "Somente letras");

jQuery.validator.addMethod("minDate", function(value, element, param) {
  var minDate = new Date(dateReplace(param, '/', '-')), valueDate = new Date(dateReplace(value, '/', '-'));
  return valueDate < minDate ? false : true;
}, "Data válida somente a partir de {0}");

jQuery.validator.addMethod("minDateCompare", function(value, element, param) {
  var val = $("input[name="+param+"]").val()
  if(!val)
    return false
  var minDate = new Date(dateReplace(val, '/', '-')), valueDate = new Date(dateReplace(value, '/', '-'));
  return valueDate < minDate ? false : true;
}, "Data válida somente a partir de {0}");

jQuery.validator.addMethod("regex", function(value, element, regexp) {
  var re = new RegExp(regexp);
  return this.optional(element) || re.test(value);
}, "Favor preencher o campo corretamente.");

jQuery.validator.addMethod("extension", function(value, element, param) {
  param = typeof param === "string" ? param.replace(/,/g, '|') : "";
  return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
}, "Por favor coloque arquivo com a extensão válida( {0} ).");

function dateReplace(date, from, to) {
  split = date.split(from);
  return date = split[2] + to + split[1] + to + split[0];
}

function verificaExtensao(files, exts){
  var correto
  for (var i = 0; i < files.length; i++) {
    var correto = false
    for (var j = 0; j < exts.length; j++) {
      if(exts[j] == files[i])
        correto = true
      if(j == exts.length-1 && !correto)
        return false
    }
  }
  return true
}

jQuery.validator.addMethod("has_multiple", function (value, element, params) {
  inputs = $("input[name='"+element.name+"'")//input dos arquivos
  if(!inputs.length) 
    inputs = $("select[name='"+element.name+"'")

  return (inputs.length > 1);
}, "É necessário adicionar ao menos um veículo à tabela");  // Mensagem padrão

jQuery.validator.addMethod("has_added", function (value, element, params) {
  table = $("table#"+params+" >tbody:last >tr").length

  return table > 0
}, "É necessário adicionar ao menos um veículo à tabela");  // Mensagem padrão

jQuery.validator.addMethod("unique_array", function (value, element, params) {
  inputs = $("input[name='"+element.name+"'")//input dos arquivos
  var quantidade = 0
  $.each(inputs, function(index, input) {
    if(value == input.value)
      quantidade++
  }) 

  return quantidade == 1;
}, "Não é permitido colocar dois veículos com a mesma placa");  // Mensagem padrão

jQuery.validator.addMethod("unique_array_table", function (value, element, params) {
  valores = $("."+params)
  var quantidade = 0
  $.each(valores, function(index, input) {
    if(value == input.innerHTML)
      quantidade++
  }) 

  return quantidade == 0;
}, "Não é permitido colocar dois veículos com a mesma placa");  // Mensagem padrão
