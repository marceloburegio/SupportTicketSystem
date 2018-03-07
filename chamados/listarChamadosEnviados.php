<?php
// Includes
require("config.inc.php");

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Validando o acesso a este site
	$objFachadaBDR->validarSessaoUsuario();
	
	// Listando os grupos
	$arrObjGrupo = $objFachadaBDR->listarGruposAtivosQueRecebemChamados();
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
<script type="text/javascript" src="<?php echo Config::getUrlBase(); ?>/js/listarChamados.js?v=<?php echo filemtime("js/listarChamados.js"); ?>"></script>

<div id="corpo">
	<h2 class="titulo">Chamados Enviados</h2>
	<div style="padding:10px;">
		<form id="formFiltro" method="post" action="xt_listarChamados.php">
		<input type="hidden" name="intOffset" value="0">
		<input type="hidden" name="strTipoListagem" value="enviados">
		<table cellpadding="3" cellspacing="1" border="0">
			<tr>
				<td class="escuro">Data Inicial</td>
				<td class="claro"><input type="text" id="strDataInicial" name="strDataInicial" size="12" class="texto calendario" value="<?php echo date("d/m/Y", strtotime("-3 month")); ?>">&nbsp;</td>
			</tr>
			<tr>
				<td class="escuro">Data Final</td>
				<td class="claro"><input type="text" id="strDataFinal" name="strDataFinal" size="12" class="texto calendario"></td>
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
				<td class="escuro">Grupos</td>
				<td class="claro">
					<select name="intIdGrupo" class="texto">
						<option value="0">Todos</option>
<?php
foreach ($arrObjGrupo as $objGrupo) {
?>
						<option value="<?php echo $objGrupo->getIdGrupo(); ?>"><?php echo htmlentities($objGrupo->getDescricaoGrupo()); ?></option>
<?php
}
?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="escuro">N&ordm; Chamado</td>
				<td class="claro"><input type="text" id="intIdChamado" name="intIdChamado" size="12" class="numero">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" class="botao submit" value="Filtrar"></td>
			</tr>
		</table>
	</form>
	</div>
	<div id="listaChamados">&nbsp;</div>
	<div class="clear"></div>
</div>
<?php
// Include do rodapé
include("includes/incRodape.php");