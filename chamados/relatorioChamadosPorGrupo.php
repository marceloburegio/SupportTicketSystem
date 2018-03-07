<?php
// Includes
require("config.inc.php");

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Validando o acesso a este site
	$objFachadaBDR->validarSessaoAdmin();
	
	// Inicializando a variável
	$intIdUsuario = (int) @$_SESSION["intIdUsuario"];
	
	// Listando todos os grupos
	$arrObjGrupo = $objFachadaBDR->listarGruposAtivosAdminPorIdUsuario($intIdUsuario);
	
	// Processando apenas os grupos que recebem chamados
	foreach ($arrObjGrupo as $intKey => $objGrupo) {
		if (!$objGrupo->getFlagRecebeChamado()) unset($arrObjGrupo[$intKey]);
	}
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
<script type="text/javascript" src="<?php echo Config::getUrlBase(); ?>/js/relatorio.js?v=<?php echo filemtime("js/relatorio.js"); ?>"></script>
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['corechart']}]}"></script>

<div id="corpo">
	<h2 class="titulo">Relat&oacute;rio de Chamados Por Grupo</h2>
	<div style="padding:10px;width:330px;">
		<form id="formRelatorio" method="post" action="xt_relatorioChamadosPorGrupo.php">
		<input type="hidden" name="inicio" id="inicio" value="0">
		<table width="100%" cellpadding="3" cellspacing="1" border="0">
			<tr>
				<td class="escuro">Per&iacute;odo:</td>
				<td class="claro">
					<select id="intMes" name="intMes" class="texto obrigatorio">
<?php
$intMesAtual = date('m');
for ($intMes = 1; $intMes <= 12; $intMes++) {
?>
						<option value="<?php echo $intMes; ?>" <?php echo ($intMes == $intMesAtual) ? 'selected="selected"' : ""; ?>><?php echo htmlentities(Util::formatarMes($intMes)); ?></option>
<?php
}
?>
					</select>
					/
					<input type="text" id="intAno" name="intAno" size="6" maxlength="4" class="numero obrigatorio" value="<?php echo date('Y'); ?>">
				</td>
			</tr>
			<tr>
				<td class="escuro">Grupo</td>
				<td class="claro">
					<select name="arrIdGrupoDestino[]" class="obrigatorio" multiple>
<?php
foreach ($arrObjGrupo as $objGrupo) {
?>
						<option value="<?php echo $objGrupo->getIdGrupo(); ?>" selected="selected"><?php echo htmlentities($objGrupo->getDescricaoGrupo()); ?></option>
<?php
}
?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2"><div class="mensagem">&nbsp;</div></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" class="botao submit" value="Filtrar"></td>
			</tr>
		</table>
	</form>
	</div>
	<div id="relatorio">&nbsp;</div>
	<div class="clear"></div>
</div>
<?php
// Include do rodapé
include("includes/incRodape.php");