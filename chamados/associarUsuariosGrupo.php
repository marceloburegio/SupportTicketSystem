<?php
// Includes
require("config.inc.php");

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Validando o acesso a este site
	$objFachadaBDR->validarSessaoAdmin();
	
	// Obtendo os valores postados
	$strHashIdGrupo = (string) @$_GET["strHashIdGrupo"];
	
	// Validando o Hash
	$intIdGrupo = Encripta::decode($strHashIdGrupo, "listarGrupos");
	if (!$intIdGrupo) throw new Exception("O ID do Grupo está inválido.");
	
	// Recuperando o objeto Grupo
	$objGrupo = $objFachadaBDR->procurarGrupo($intIdGrupo);
}
catch (Exception $ex) {
	$strMensagem = htmlentities($ex->getMessage());
	include("includes/incTopo.php");
	include("includes/incErro.php");
	include("includes/incRodape.php");
	exit();
}

// Include do topo
include("includes/incTopo.php");
?>
<script type="text/javascript" src="<?php echo Config::getUrlBase(); ?>/js/associarUsuarioGrupo.js?v=<?php echo filemtime("js/associarUsuarioGrupo.js"); ?>"></script>

<div id="corpo">
	<h2 class="titulo">Associa&ccedil;&atilde;o de Usu&aacute;rios ao Grupo - <?php echo htmlentities($objGrupo->getDescricaoGrupo()); ?></h2>
	<div id="listaChamados">
		<br/>
		<form id="formCadastrarUsuarioGrupo" action="xt_adicionarUsuarioGrupo.php" method="post">
		<input type="hidden" name="strHashIdGrupo" id="strHashIdGrupo" value="<?php echo $strHashIdGrupo; ?>"/>
			<table cellspacing="1" cellpadding="3" align="center">
				<tr>
					<td width="70" class="escuro"><label for="strLogin">Login</label></td>
					<td class="claro"><input type="text" name="strLogin" id="strLogin" size="20"/></td>
					<td class="claro"><input type="text" id="strNomeUsuario" readonly="readonly" size="35" class="loginOk"/></td>
					<td width="120" class="claro" align="center"><input type="submit" class="botao submit" value="Adicionar"/></td>
				</tr>
			</table><br/>
			<div align="center" class="mensagem">&nbsp;</div>
		</form>
	</div>
	<div id="listagemUsuarios"></div>
	<div class="clear"></div>
</div>
<?php
// Include do rodapé
include("includes/incRodape.php");