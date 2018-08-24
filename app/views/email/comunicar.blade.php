<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    @page { margin: 220px 50px; padding: 0;}
    html,body{padding: 0; margin-bottom: 30px;}
    .footer {text-align: center; margin-top: 30px;}
    li{text-indent: none; font-size: 16px;}
    h4, h5{margin-top: 5px;}
  </style>
</head>
<body>
  <p style="text-align: justify;">{{nl2br($dados['texto'])}}</p>
  <div style="margin-top:20px">
    <p>Este é um e-mail gerado automaticamente. Favor não responder.</p>
  </div>
  <div class="footer">
    <h4>Prefeitura Municipal da Estância Balneária de Caraguatatuba</h4>
    <h4>Estado de São Paulo</h4>
  </div>
</body>
</html>
