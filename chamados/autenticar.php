<?php
// Include
require("config.inc.php");

// Include do topo
include("includes/incTopo.php");

// Mensagem para quando o sistema de chamados estiver em manutenção
//$strMensagem = htmlentities("Sistema em Manutenção");
//include("includes/incErro.php");
//exit();

?>
<div id="corpo">
	<h2 class="titulo">Acesso ao Sistema</h2>
	<div class="conteudo">
		<p class="informacoes">Bem vindo ao sistema de controle de chamados.<br/>
		Para prosseguirmos com o seu chamado, favor efetuar o login no sistema utilizando o seu <strong>usu&aacute;rio e senha da rede.</strong><br/>
		</p>
<!--
			<p class="informacoes" style="color:red;"><strong>Caso tenha d&uacute;vidas, favor consultar este <a href="manual_de_abertura_de_chamados.pdf" target="_blank">Manual de abertura de Chamados</a>.</strong></p>
-->
		<br/>
		<form id="formAutenticar" method="post" action="xt_autenticar.php">
			<table cellspacing="1" cellpadding="3" align="center">
				<tr>
					<td width="60" class="escuro">Usu&aacute;rio</td>
					<td width="170" class="claro"><input class="texto obrigatorio" type="text" name="strLogin" style="width:160px" /></td>
				</tr>
				<tr>
					<td class="escuro">Senha</td>
					<td class="claro"><input class="texto obrigatorio" type="password" name="strSenha" style="width:160px" /></td>
				</tr>
			</table><br/>
			<div class="mensagem">&nbsp;</div><br/>
			<div align="center"><input type="submit" class="botao submit" value="Entrar"></div>
		</form>
		<br/>
	</div>
</div>
<div class="clear"></div>
<?php
// Include do rodapé
include("includes/incRodape.php");
