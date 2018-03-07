<?php
// TODO Colocar um script (jQuery) com a conversão ao mudar a unidade de medida
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
	
	// Recuperando o grupo
	$objGrupo = $objFachadaBDR->procurarGrupo($intIdGrupo);
	
	// Listando os feriados do grupo selecionado
	$arrObjFeriado = $objFachadaBDR->listarFeriadosPorIdGrupo($intIdGrupo);
	
	// Gerando o novo hash do ID do Grupo
	$strHashIdGrupo = Encripta::encode($objGrupo->getIdGrupo(), "listarFeriados");
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
<script type="text/javascript" src="js/listarFeriado.js?v=<?php echo filemtime("js/listarFeriado.js"); ?>"></script>
<div id="corpo">
	<h2 class="titulo">Listagem de Feriados do Grupo <?php echo htmlentities($objGrupo->getDescricaoGrupo()); ?></h2>
	<div class="conteudo">
		<div style="float:right;padding-top:15px;"><a href="cadastrarFeriado.php?strHashIdGrupo=<?php echo urlencode($strHashIdGrupo); ?>">Adicionar Novo Feriado</a></div>
		<div style="float:right;padding:7px;"><a href="cadastrarFeriado.php?strHashIdGrupo=<?php echo urlencode($strHashIdGrupo); ?>"><img src="imagens/icone_novo.gif" height="32" border="0" width="32" alt="Adicionar Feriado" title="Adicionar Feriado"></a></div>
		<div class="clear"></div>
<?php
if (empty($arrObjFeriado)) {
?>
		<h3 align="center">Nenhum Feriado foi encontrado</h3>
<?php
}
else {
?>
		<table cellpadding="3" cellspacing="1" width="100%" border="0" bgcolor="#DDDDDD">
			<tr class="escuro">
				<td align="center">#</td>
				<td align="center">Descri&ccedil;&atilde;o do Feriado</td>
				<td width="100" align="center">Data Feriado</td>
				<td width="180" align="center">A&ccedil;&otilde;es</td>
			</tr>
<?php 
	foreach ($arrObjFeriado as $intKey => $objFeriado) {
		$strHashIdFeriado = Encripta::encode($objFeriado->getIdFeriado(), "listarFeriados");
?>
			<tr class="cinza" bgcolor="#FFFFFF">
				<td align="center"><?php echo htmlentities($objFeriado->getIdFeriado());?></td>
				<td align="center"><?php echo htmlentities($objFeriado->getDescricaoFeriado());?></td>
				<td width="100" align="center"><?php echo htmlentities(Util::formatarBancoData($objFeriado->getDataFeriado()));?></td>
				<td width="100" align="center">
					<input type="hidden" class="strHashIdFeriado" value="<?php echo htmlentities($strHashIdFeriado); ?>"/>
					<a href="cadastrarFeriado.php?strHashIdGrupo=<?php echo urlencode($strHashIdGrupo); ?>&strHashIdFeriado=<?php echo urlencode($strHashIdFeriado); ?>"><img src="imagens/icone_editar.gif" width="32" height="32" border="0" alt="Editar Feriado" title="Editar Feriado"/></a>
					<a href="javascript:;" class="excluirFeriado"><img src="imagens/icone_remover.gif" width="30" height="30" border="0" alt="Excluir Feriado" title="Excluir Feriado"/></a>
				</td>
			</tr>
<?php
		}
	}
?>
		</table>
	</div>
</div>
<div class="clear"></div>
<?php
// Include do rodapé
include("includes/incRodape.php");