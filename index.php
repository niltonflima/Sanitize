<?php
	//Classe para testar as entradas POST ou GET e fazer o devido tratamento.
	require_once("sanitize.php");
	$_POST = Sanitize::filter($_POST);
	//$_POST = Sanitize::filter($_GET);
	
	if ($_GET["r"]<>"")
		echo "Argumento >> ".$_GET["r"]." << inválido identificado.";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Form</title>
    </head>
  
    <body>
        <h1 style="font-size:14px;">Testa possíveis entradas inválidas como Scripts que tem a finalidade de hackear ou comprometer o website.</h1>
        <h2 style="font-size:12px;">Alguns exemplos:<br>"pastebin","passthru","post_render","ftp:","passwd","wget","shell_exec","ssh2_connect","ssh2_auth_password","self","base64_decode","file_put_contents","cmd","echo","system()","system","upload.php","alfa_data","/alfa_data","error_log","github.com","githubusercontent","eagletube","locasiteweb","domlogs","alfacgiapi","think","cachefile","invokefunction","phpinfo","construct"</h2>
        
        <form action="" method="post" name="teste_sanitize">
            <input name="valor" id="valor" type="text" value="www.google.com.br" />
            <input type = "submit" name = "submit" value = "Submit">
        </form>
        
	</body>
</html>
<?php
if(isset($_POST["valor"])){
	echo "Válido -> ".$_POST["valor"];
}
?>
