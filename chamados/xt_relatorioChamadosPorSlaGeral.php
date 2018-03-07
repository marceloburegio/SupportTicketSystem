<?php
// Includes
require("config.inc.php");

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Validando o acesso a este site
	$objFachadaBDR->validarSessaoUsuario();
	
	// Obtendo os dados informados
	$arrParametro						= array();
	$arrParametro["strDataInicial"]		= (string) @$_POST["strDataInicial"];
	$arrParametro["strDataFinal"]		= (string) @$_POST["strDataFinal"];
	$arrParametro["intStatus"]			= (int) @$_POST["intStatus"];
	$arrParametro["arrIdGrupoDestino"]	= (array) @$_POST["arrIdGrupoDestino"];
	
	// Inicializando as variáveis
	$arrDadosRelatorio = $objFachadaBDR->relatorioChamadosPorSlaGeral($arrParametro);
}
catch (Exception $ex) {
	$strMensagem = htmlentities($ex->getMessage());
	include("includes/incErro.php");
	exit();
}

// Validando se há algum dado a ser exibido
if (!is_array($arrDadosRelatorio) || empty($arrDadosRelatorio)) {
?>
<h3 align="center">N&atilde;o h&aacute; dados com os par&acirc;metros informados.</h3>
<?php
}
else {
?>
<div id="listaChamados">
<table cellpadding="3" cellspacing="1" width="100%" border="0" bgcolor="#DDDDDD">
	<tr>
		<td class="escuro" align="center" width="50">#</td>
		<td class="escuro">Descri&ccedil;&atilde;o</td>
		<td class="escuro" align="center" width="80">Status</td>
		<td class="escuro" align="center" width="130">Data Abertura</td>
		<td class="escuro" align="center" width="130">Data Prazo</td>
		<td class="escuro" align="center" width="130">Data Fechamento</td>
		<td class="escuro" align="center" width="50">%</td>
	</tr>
<?php
	$arrStatus = Config::getStatus();
	foreach ($arrDadosRelatorio as $arrRelatorio) {
		$strDescricaoChamado = $arrRelatorio["descricao_chamado"];
		if (strlen($strDescricaoChamado) > Config::getQtdeCaracteresDescricao()) {
			$strDescricaoChamado = substr($strDescricaoChamado, 0, Config::getQtdeCaracteresDescricao()) ."...";
		}
		
		// Calculando as cores atribuidas aos chamados
		$strCorChamado = "chm_vermelho";
		if ($arrRelatorio["status_chamado"] == 1 || $arrRelatorio["status_chamado"] == 3) { // Chamados Abertos e Pendentes
			if ($arrRelatorio["sla"] < 0.5) $strCorChamado = "chm_verde";
			else if ($arrRelatorio["sla"] < 1) $strCorChamado = "chm_laranja";
			if ($arrRelatorio["status_chamado"] == 3) $strCorChamado .= " chm_pendente";
		}
		else $strCorChamado = "chm_cinza";
?>
	<tr class="rel_item <?php echo $strCorChamado; ?>">
		<td align="center" ><?php echo $arrRelatorio["id_chamado"]; ?></td>
		<td><?php echo htmlentities($strDescricaoChamado); ?></td>
		<td align="center"><?php echo htmlentities($arrStatus[$arrRelatorio["status_chamado"]]); ?></td>
		<td align="center"><?php echo Util::reduzirDataHora(Util::formatarBancoData($arrRelatorio["data_abertura"])); ?></td>
		<td align="center"><?php echo Util::reduzirDataHora(Util::formatarBancoData($arrRelatorio["data_prazo"])); ?></td>
		<td align="center"><?php echo ($arrRelatorio["status_chamado"] == 2 || $arrRelatorio["status_chamado"] == 9) ? Util::reduzirDataHora(Util::formatarBancoData($arrRelatorio["data_fechamento"])) : "---"; ?></td>
		<td align="center"><?php echo number_format($arrRelatorio["sla"] * 100.0, 2, ",", ""); ?></td>
	</tr>
<?php
	}
?>
</table>
</div>
<?php
}
?>
<br/>
