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

<div id="corpo">
	<h2 class="titulo">Relat&oacute;rio Listagem Geral</h2>
	<div style="padding:10px;width:330px;">
		<form id="formRelatorio" method="post" action="xt_relatorioChamadosPorSlaGeral.php">
		<input type="hidden" name="inicio" id="inicio" value="0">
		<table width="100%" cellpadding="3" cellspacing="1" border="0">
			<tr>
				<td class="escuro">Data Inicial</td>
				<td class="claro"><input type="text" id="strDataInicial" name="strDataInicial" size="12" class="texto calendario obrigatorio" value="01<?php echo date("/m/Y"); ?>">&nbsp;</td>
			</tr>
			<tr>
				<td class="escuro">Data Final</td>
				<td class="claro"><input type="text" id="strDataFinal" name="strDataFinal" size="12" class="texto calendario obrigatorio" value="<?php echo date("t/m/Y"); ?>"></td>
			</tr>
			<tr>
				<td class="escuro">Status</td>
				<td class="claro">
					<select id="intStatus" name="intStatus" class="texto">
<?php
$arrStatus = Config::getStatus();
foreach ($arrStatus as $intStatus => $strStatus) {
?>
						<option value="<?php echo $intStatus; ?>"><?php echo htmlentities($strStatus); ?></option>
<?php
}
?>
						<option value="0" selected="selected">Todos</option>
					</select>
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