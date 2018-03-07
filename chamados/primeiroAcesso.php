<?php
// Include
require("config.inc.php");

// Iniciando a sessão (manualmente exclusivamente nesta página)
session_start();

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
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
	<h2 class="titulo">Primeiro Acesso</h2>
	<div class="conteudo">
		<p class="informacoes">
		Este &eacute; o seu primeiro acesso ao sistema de chamados por isso,
		solicitamos algumas informa&ccedil;&otilde;es b&aacute;sicas antes de prosseguirmos.<br/>
		</p>
		<p class="informacoes">
		Voc&ecirc; poder&aacute; trocar estas informa&ccedil;&otilde;es atrav&eacute;s do menu <strong>Meus Dados</strong> ap&oacute;s efetuar o acesso.
		</p>
		<br/>
		<form id="formCadastrar" method="post" action="xt_primeiroAcesso.php">
			<table cellspacing="1" cellpadding="3" align="center">
				<tr>
					<td width="90" class="escuro">Nome e Sobrenome</td>
					<td width="280" class="claro"><input type="text" name="strNome" id="strNome" size="41" maxlength="100" class="texto obrigatorio"></td>
				</tr>
				<tr>
					<td class="escuro">E-mail</td>
					<td class="claro"><input type="text" name="strEmail" id="strEmail" size="41" maxlength="100" class="texto obrigatorio"></td>
				</tr>
				<tr>
					<td class="escuro">Setor</td>
					<td class="claro">
						<select name="intIdSetor" id="intIdSetor" class="texto obrigatorio">
							<option value="">-- Selecione um Setor --</option>
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
					<td class="escuro">Ramal ou Telefone</td>
					<td class="claro"><input type="text" maxlength="25" name="strRamal" id="strRamal" size="30" class="texto obrigatorio"></td>
				</tr>
			</table><br/>
			<div class="mensagem">&nbsp;</div><br/>
			<div align="center"><input type="submit" value="Cadastrar" class="botao submit"></div>
		</form>
	</div>
	<div class="clear"></div>
</div>
<?php
// Include do rodapé
include("includes/incRodape.php");