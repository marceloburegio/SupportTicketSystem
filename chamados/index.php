<?php
// Includes
require_once("config.inc.php");

// URL que será encaminhado o usuário
$strUrlDestino = "";

try {
	// Inicializando os objetos
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Validando o acesso a este site
	$objFachadaBDR->validarSessaoUsuario();
	
	// Verificando se o usuário possui algum grupo associado
	if (!empty($_SESSION["bolRecebeChamado"]) && $_SESSION["bolRecebeChamado"]) {
		$strUrlDestino = "listarChamadosRecebidos.php";
	}
	else {
		$strUrlDestino = "listarChamadosEnviados.php";
	}
}
catch (Exception $ex) {
	$strMensagem = htmlentities($ex->getMessage());
	include("includes/incTopo.php");
	include("includes/incErro.php");
	include("includes/incRodape.php");
	exit();
}
?>
<script type="text/javascript">parent.window.location = './<?php echo $strUrlDestino; ?>';</script>