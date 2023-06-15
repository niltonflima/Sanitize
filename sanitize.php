<?php
	abstract class Sanitize{
		static public function filter($value, $modes = array("sql","html","sex")){
			if(!is_array($modes)){
				$modes = array($modes);
			}
			if(is_string($value)){
				foreach($modes as $type){
				  $value = self::_doFilter($value,$type);
				}
				return $value;
			}
			foreach($value as $key => $toSanatize){
				if(is_array($toSanatize)){
					$value[$key] = self::filter($toSanatize,$modes);
				}
				else{
					foreach($modes as $type){
					  $value[$key] = self::_doFilter($toSanatize,$type);
					}
				}
			}
			return $value;
		}
		static protected function _doFilter($value,$mode){
			switch($mode){				
				case "html":
					if(trim($value) != ""){
						$html_val = array("pastebin","passthru","post_render","ftp:","passwd","wget","shell_exec","ssh2_connect","ssh2_auth_password","self","base64_decode","file_put_contents","cmd","echo","system()","system","upload.php","alfa_data","/alfa_data","error_log","github.com","githubusercontent","eagletube","domlogs","alfacgiapi","think","cachefile","invokefunction","phpinfo","construct");
						foreach ($html_val as $html){
							$go = explode($html,strtolower($value));
							if(count($go) > 1 ){
								self::enviaAlerta(" << html >> ".$value.' >> '.$html);
							}
						}
					}					
				break;
				case "sql":	
					if(trim($value) != ""){
						$sql_val = array("select","insert","delete","where","unhex","\\\\)/","1=1","'or'","'='","'1='","'--",";--","; --","--'","1 = 1","or 1","fromcharcode","insertbefore","createelement");
						foreach ($sql_val as $sql){
							$go = explode($sql,strtolower($value));
							if(count($go) > 1 ){
								self::enviaAlerta(" << sql >> ".$value.' >> '.$sql);
							}
						}
					}				
				break;
				case "sex":	
					if(trim($value) != ""){
						$sex_val = array("amoxicillin","capsules","viagra","antibiotic","anziani","pharmacy","products","cephalexin","girl","ukzakon","Levothyroxine","kaufen","cheapest","decadron");
						foreach ($sex_val as $sex){
							$go = explode($sex,strtolower($value));
							if(count($go) > 1 ){
								self::enviaAlerta(" << sex >> ".$value.' >> '.$sex);
							}
						}
					}				
				break;				
			}
			return $value;
		}
		function enviaAlerta($args){
			$ipaddress = '';
			if (isset($_SERVER['HTTP_CLIENT_IP']))
				$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
			else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_X_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
			else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_FORWARDED'];
			else if(isset($_SERVER['REMOTE_ADDR']))
				$ipaddress = $_SERVER['REMOTE_ADDR'];
			else
				$ipaddress = 'UNKNOWN';	
				
			//Captura endereço de onde parte a inseção
			//$url_full = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
			
			//Passando o IP de quem fez a tentativa para um possível bloqueio diretamente no firewall
			//file_get_contents("https://???/cpanel_api.php?acao=csf&ip=".$ipaddress);
			
			//Encerra e volta para a página principal
			exit("<script>window.location.href='https://".$_SERVER['SERVER_NAME']."?r=".$args."';</script>");				
		}
	}	
?>