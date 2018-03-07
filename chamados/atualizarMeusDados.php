<?php
// Includes
require("config.inc.php");

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Validando o acesso a este site
	$objFachadaBDR->validarSessaoUsuario();
	
	// Recuperando o Usuário
	$intIdUsuario = @$_SESSION["intIdUsuario"];
	$objUsuario = $objFachadaBDR->procurarUsuario($intIdUsuario);
	
	// Listando todos os Setores Ativos
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
<div id="corpo">
	<h2 class="titulo">Atualizar Meus Dados</h2>
	<div class="conteudo">
		<br/>
		<form id="formCadastrar" method="post" action="xt_atualizarMeusDados.php">
			<table cellspacing="1" cellpadding="3" align="center">
				<tr>
					<td width="90" class="escuro">Nome e Sobrenome</td>
					<td width="280" class="claro"><input type="text" name="strNome" id="strNome" size="41" maxlength="100" class="texto obrigatorio" value="<?php echo htmlentities($objUsuario->getNomeUsuario()); ?>"/></td>
				</tr>
				<tr>
					<td class="escuro">E-mail</td>
					<td class="claro"><input type="text" name="strEmail" id="strEmail" size="41" maxlength="100" class="texto obrigatorio" value="<?php echo htmlentities($objUsuario->getEmailUsuario()); ?>"/></td>
				</tr>
				<tr>
					<td class="escuro">Setor</td>
					<td class="claro">
						<select name="intIdSetor" id="intIdSetor" class="texto obrigatorio">
							<option value="">-- Selecione um Setor --</option>
<?php
	foreach ($arrObjSetor as $objSetor) {
?>
								<option value="<?php echo $objSetor->getIdSetor(); ?>" <?php echo ($objSetor->getIdSetor() == $objUsuario->getIdSetor()) ? 'selected="selected"' : ""; ?>><?php echo htmlentities($objSetor->getDescricaoSetor()); ?></option>
<?php
	}
?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="escuro">Ramal ou Telefone</td>
					<td class="claro"><input type="text" maxlength="25" name="strRamal" id="strRamal" size="30" class="texto obrigatorio" value="<?php echo htmlentities($objUsuario->getRamal()); ?>"/></td>
				</tr>
			</table><br/>
			<div class="mensagem">&nbsp;</div><br/>
			<div align="center"><input type="submit" value="Atualizar" class="botao submit"></div>
		</form>
	</div>
	<div class="clear"></div>
</div>
<?php
// Include do rodapé
include("includes/incRodape.php");