<?php
// Includes
require("config.inc.php");

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Validando o acesso a este site
	$objFachadaBDR->validarSessaoUsuario();
	
	// Listando os grupos
	$intIdUsuario = (int) @$_SESSION["intIdUsuario"];
	$arrObjGrupo = $objFachadaBDR->listarGruposAtivosNormaisPorIdUsuario($intIdUsuario);
	
	// Listando os setores
	$arrObjSetor = $objFachadaBDR->listarSetoresAtivos();
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
	<h2 class="titulo">Chamados Recebidos</h2>
	<div style="padding:10px;">
		<form id="formFiltro" method="post" action="xt_listarChamados.php">
		<input type="hidden" name="intOffset" value="0">
		<input type="hidden" name="strTipoListagem" value="recebidos">
		<table cellpadding="3" cellspacing="1" border="0">
			<tr>
				<td class="escuro">Data Inicial</td>
				<td class="claro"><input type="text" id="strDataInicial" name="strDataInicial" size="12" class="texto calendario">&nbsp;</td>
				<td class="escuro">Aberto Por</td>
				<td class="claro"><input type="text" id="strNomeUsuarioOrigem" name="strNomeUsuarioOrigem" size="18" class="texto">&nbsp;</td>
			</tr>
			<tr>
				<td class="escuro">Data Final</td>
				<td class="claro"><input type="text" id="strDataFinal" name="strDataFinal" size="12" class="texto calendario"></td>
				<td class="escuro">Fechado Por</td>
				<td class="claro"><input type="text" id="strNomeUsuarioFechador" name="strNomeUsuarioFechador" size="18" class="texto">&nbsp;</td>
			</tr>
			<tr>
				<td class="escuro">Status</td>
				<td class="claro">
					<select id="intStatus" name="intStatus" class="texto">
						<option value="-1">Aberto e Pendente</option>
<?php
$arrStatus = Config::getStatus();
foreach ($arrStatus as $intStatus => $strStatus) {
?>
						<option value="<?php echo $intStatus; ?>"><?php echo htmlentities($strStatus); ?></option>
<?php
}
?>
						<option value="0">Todos</option>
					</select>
				</td>
				<td class="escuro">Assunto</td>
				<td class="claro"><input type="text" id="strDescricaoAssunto" name="strDescricaoAssunto" size="30" class="texto">&nbsp;</td>
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
				<td class="escuro">Descri&ccedil;&atilde;o</td>
				<td class="claro"><input type="text" id="strDescricaoChamado" name="strDescricaoChamado" size="30" class="texto">&nbsp;</td>
			</tr>
			<tr>
				<td class="escuro">N&ordm; Chamado</td>
				<td class="claro"><input type="text" id="intIdChamado" name="intIdChamado" size="12" class="numero">&nbsp;</td>
				<td class="escuro">Hist&oacute;rico</td>
				<td class="claro"><input type="text" id="strDescricaoHistorico" name="strDescricaoHistorico" size="30" class="texto">&nbsp;</td>
			</tr>
			<tr>
				<td class="escuro">Chamado Ext.</td>
				<td class="claro"><input type="text" id="strCodigoChamadoExterno" name="strCodigoChamadoExterno" size="12" class="texto">&nbsp;</td>
				<td class="escuro">Setor</td>
				<td class="claro">
					<select name="intIdSetor" class="texto">
						<option value="0">Todos</option>
<?php
foreach ($arrObjSetor as $objSetor) {
?>
						<option value="<?php echo $objSetor->getIdSetor(); ?>"><?php echo htmlentities($objSetor->getDescricaoSetor()); ?></option>
<?php
}
?>
					</select>
				</td>
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
