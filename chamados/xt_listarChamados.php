<?php
// Includes
require("config.inc.php");

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Validando o acesso a este site
	$objFachadaBDR->validarSessaoUsuario();
	
	// Obtendo os dados informados
	$intIdUsuario				= (int) @$_SESSION["intIdUsuario"];
	$strDataInicial				= (string) @$_POST["strDataInicial"];
	$strDataFinal				= (string) @$_POST["strDataFinal"];
	$intStatus					= (int) @$_POST["intStatus"];
	$intIdGrupo					= (int) @$_POST["intIdGrupo"];
	$intIdChamado				= (int) @$_POST["intIdChamado"];
	$strCodigoChamadoExterno	= (string) @$_POST["strCodigoChamadoExterno"];
	$strNomeUsuarioOrigem		= (string) @$_POST["strNomeUsuarioOrigem"];
	$strNomeUsuarioFechador		= (string) @$_POST["strNomeUsuarioFechador"];
	$strDescricaoAssunto		= (string) @$_POST["strDescricaoAssunto"];
	$strDescricaoChamado		= (string) @$_POST["strDescricaoChamado"];
	$strDescricaoHistorico		= (string) @$_POST["strDescricaoHistorico"];
	$intIdSetor					= (int) @$_POST["intIdSetor"];
	$intOffSet					= (int) @$_POST["intOffSet"];
	$strTipoListagem			= (string) @$_POST["strTipoListagem"];
	
	// Inicializando as variáveis
	$arrObjChamado = array();
	$intQtdeTotalChamados = 0;
	
	// Array de Parametros
	$arrParametro = array();
	$arrParametro["intIdUsuario"] = $intIdUsuario;
	$arrParametro["strDataInicial"] = $strDataInicial;
	$arrParametro["strDataFinal"] = $strDataFinal;
	$arrParametro["intStatus"] = $intStatus;
	$arrParametro["intIdGrupo"] = $intIdGrupo;
	$arrParametro["intIdChamado"] = $intIdChamado;
	
	// Verificando qual o tipo da listagem a ser exibida
	if ($strTipoListagem == "enviados") {
		// Listando todos os chamados
		$arrObjChamado = $objFachadaBDR->listarChamadosEnviadosPorParametro($arrParametro, $intOffSet);
		
		// Recuperando a quantidade total de chamados (usada na paginação)
		$intQtdeTotalChamados = $objFachadaBDR->quantidadeChamadosEnviadosPorParametro($arrParametro);
	}
	elseif ($strTipoListagem == "recebidos") {
		// Obtendo os dados do filtro específico
		$arrParametro["strCodigoChamadoExterno"] = $strCodigoChamadoExterno;
		$arrParametro["strNomeUsuarioOrigem"] = $strNomeUsuarioOrigem;
		$arrParametro["strNomeUsuarioFechador"] = $strNomeUsuarioFechador;
		$arrParametro["strDescricaoAssunto"] = $strDescricaoAssunto;
		$arrParametro["strDescricaoChamado"] = $strDescricaoChamado;
		$arrParametro["strDescricaoHistorico"] = $strDescricaoHistorico;
		$arrParametro["intIdSetor"] = $intIdSetor;
		
		// Listando todos os chamados
		$arrObjChamado = $objFachadaBDR->listarChamadosRecebidosPorParametro($arrParametro, $intOffSet);
		
		// Recuperando a quantidade total de chamados (usada na paginação)
		$intQtdeTotalChamados = $objFachadaBDR->quantidadeChamadosRecebidosPorParametro($arrParametro);
	}
	else throw new Exception("A listagem só poderá ser acessada pelos Chamados Enviados e Chamados Recebidos.");
	
	// Criando a paginação
	$objPaginacao = new Paginacao($intQtdeTotalChamados, $intOffSet, Config::getChamadosPorPagina());
}
catch (Exception $ex) {
	$strMensagem = htmlentities($ex->getMessage());
	include("includes/incErro.php");
	exit();
}

if (empty($arrObjChamado)) {
?>
<h3 align="center">Nenhum chamado foi encontrado</h3>
<?php
}
else {
?>
<form id="formListagem">
	<input type="hidden" value="<?php echo $strDataInicial; ?>" name="strDataInicial"/>
	<input type="hidden" value="<?php echo $strDataFinal; ?>" name="strDataFinal"/>
	<input type="hidden" value="<?php echo $intStatus; ?>" name="intStatus"/>
	<input type="hidden" value="<?php echo $intIdGrupo; ?>" name="intIdGrupo"/>
	<input type="hidden" value="<?php echo $intIdChamado; ?>" name="intIdChamado"/>
	<input type="hidden" value="<?php echo htmlspecialchars($strCodigoChamadoExterno); ?>" name="strCodigoChamadoExterno"/>
	<input type="hidden" value="<?php echo htmlspecialchars($strNomeUsuarioOrigem); ?>" name="strNomeUsuarioOrigem"/>
	<input type="hidden" value="<?php echo htmlspecialchars($strNomeUsuarioFechador); ?>" name="strNomeUsuarioFechador"/>
	<input type="hidden" value="<?php echo htmlspecialchars($strDescricaoAssunto); ?>" name="strDescricaoAssunto"/>
	<input type="hidden" value="<?php echo htmlspecialchars($strDescricaoChamado); ?>" name="strDescricaoChamado"/>
	<input type="hidden" value="<?php echo htmlspecialchars($strDescricaoHistorico); ?>" name="strDescricaoHistorico"/>
	<input type="hidden" value="<?php echo $intIdSetor; ?>" name="intIdSetor"/>
	<input type="hidden" value="<?php echo $strTipoListagem; ?>" name="strTipoListagem" id="strTipoListagem"/>
	<input type="hidden" value="<?php echo $intOffSet; ?>" name="intOffSet" id="intOffSet"/>
</form>
<table cellpadding="3" cellspacing="1" width="100%" border="0" bgcolor="#DDDDDD">
	<tr class="escuro">
		<td width="45" align="center">#</td>
		<td width="20">&nbsp;</td>
		<td width="20"><div class="listaChamadoExtShow">Chamado Ext.</div>&nbsp;</td>
		<td width="130">Assunto</td>
		<td>Descri&ccedil;&atilde;o</td>
		<td width="120">Destinat&aacute;rio</td>
		<td width="120" align="center">Prazo</td>
		<td width="70" align="center">Status</td>
	</tr>
<?php
	foreach ($arrObjChamado as $objChamado) {
		$strDescricaoChamado = $objChamado->getDescricaoChamado();
		if (strlen($strDescricaoChamado) > Config::getQtdeCaracteresDescricao()) {
			$strDescricaoChamado = substr($strDescricaoChamado, 0, Config::getQtdeCaracteresDescricao()) ."...";
		}
		
		// Processando o destinatário
		$strDestinatario = $objChamado->getGrupoDestino()->getDescricaoGrupo();
		if ($objChamado->getIdUsuarioDestino() != 0) $strDestinatario = $objChamado->getUsuarioDestino()->getNomeUsuario();
		
		// Processando a cor do chamado
		$strCorChamado = "chm_vermelho";
		if ($objChamado->getStatusChamado() == 1 || $objChamado->getStatusChamado() == 3) { // Chamados Abertos e Pendentes
			$intDataAbertura = strtotime($objChamado->getDataAbertura());
			$intDataPrazo = strtotime($objChamado->getDataPrazo());
			$intDataAtual = time();
			
			if ($intDataAtual < $intDataPrazo) {
				// Calculando as durações
				$intDuracaoTotal = $intDataPrazo - $intDataAbertura;
				$intDuracaoAtual = $intDataAtual - $intDataAbertura;
				$floPercentual = $intDuracaoAtual / $intDuracaoTotal;
				
				// Calculando as cores atribuidas aos chamados
				if ($floPercentual < 0.5) $strCorChamado = "chm_verde";
				else $strCorChamado = "chm_laranja";
			}
			if ($objChamado->getStatusChamado() == 3) {
				$strCorChamado .= " chm_pendente";
			}
		}
		else $strCorChamado = "chm_cinza";
		
		// Lendo os vetores padrões
		$arrPrioridades = Config::getPrioridades();
		$arrStatus = Config::getStatus();
		$arrImagensPrioridades = Config::getImagensPrioridades();
		
		// Criptografando o ID do Chamado em Hash
		$strListagem = "";
		if ($strTipoListagem == "enviados") $strListagem = "listarChamadosEnviados";
		elseif ($strTipoListagem == "recebidos") $strListagem = "listarChamadosRecebidos";
		$strHashIdChamado = Encripta::encode($objChamado->getIdChamado(), $strListagem);
?>
	<tr class="chm_item <?php echo $strCorChamado; ?>">
		<td align="center">
			<input type="hidden" class="strHashIdChamado" value="<?php echo $strHashIdChamado; ?>" />
			<?php echo htmlentities($objChamado->getIdChamado()); ?>
		</td>
		<td align="center"><img src="imagens/<?php echo $arrImagensPrioridades[$objChamado->getCodigoPrioridade()]; ?>" width="17" height="14" border="0" alt="<?php echo $arrPrioridades[$objChamado->getCodigoPrioridade()]; ?>" title="<?php echo $arrPrioridades[$objChamado->getCodigoPrioridade()]; ?>"/></td>
		<td align="center">
<?php
		if (strlen($objChamado->getCodigoChamadoExterno()) > 0) {
?>
			<img class="listaChamadoExtHide" src="imagens/icone_nota.gif" width="17" height="14" border="0" alt="Chamado Externo: <?php echo $objChamado->getCodigoChamadoExterno(); ?>" title="Chamado Externo: <?php echo $objChamado->getCodigoChamadoExterno(); ?>" />
			<div class="listaChamadoExtShow"><?php echo htmlentities($objChamado->getCodigoChamadoExterno()); ?></div>
<?php
		}
?>
		</td>
		<td><?php echo htmlentities($objChamado->getAssunto()->getDescricaoAssunto()); ?></td>
		<td><?php echo htmlentities($strDescricaoChamado); ?></td>
		<td><?php echo htmlentities($strDestinatario); ?></td>
		<td align="center"><?php echo htmlentities(Util::reduzirDataHora(Util::formatarBancoData($objChamado->getDataPrazo()))); ?></td>
		<td align="center"><?php echo htmlentities($arrStatus[$objChamado->getStatusChamado()]); ?></td>
	</tr>
<?php
	}
?>
	<tr>
		<td colspan="5"><?php echo $objPaginacao->getPaginacao(); ?>&nbsp;</td>
		<td colspan="3" align="right"><strong>Total de <?php echo $objPaginacao->getQtdeTotal(); ?> Chamado(s)</strong></td>
	</tr>
</table>
<?php
}
?>
<div id="detalhamentoChamado"></div>
