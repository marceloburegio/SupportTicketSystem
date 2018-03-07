<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema de Chamados</title>
<style type="text/css">
<!--
body,table,td {
	font-family: Verdana,Helvetica,sans-serif;
	font-size:12px;}
body {
	margin:0;
	padding:0;}
a{
	font-weight:bold;
	text-decoration:none;
	color:#0066CC;}
a:hover{
	color:#0000DD;}
-->
</style>
</head>
<body bgcolor="#FFFFFF">

<!-- Topo do email -->
<div align="center"><h3><strong><?php echo htmlentities($strAssuntoEmail); ?></strong></h3></div>

<!-- Inicio dos detalhes -->
<table width="90%" cellspacing="0" cellpadding="4" border="1" bgcolor="#DDDDDD" align="center">
	<tr>
		<td colspan="3" bgcolor="#009900"><font color="#FFFFFF"><strong>Detalhes do Chamado</strong></font></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td>
			<font color="#333333" style="background-color:#E9E9E9;">Assunto</font><br/><?php echo htmlentities($objChamado->getAssunto()->getDescricaoAssunto()); ?>
		</td>
		<td>
			<font color="#333333" style="background-color:#E9E9E9;">Destino</font><br/><?php echo htmlentities($strDestinatario); ?>
		</td>
		<td>
			<font color="#333333" style="background-color:#E9E9E9;">Prioridade</font><br/>
<?php
$arrPrioridades = Config::getPrioridades();
echo htmlentities($arrPrioridades[$objChamado->getCodigoPrioridade()]);
?>
		</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td>
			<font color="#333333" style="background-color:#E9E9E9;">Data de Abertura</font><br/><?php echo htmlentities(Util::reduzirDataHora(Util::formatarBancoData($objChamado->getDataAbertura()))); ?>
		</td>
		<td>
			<font color="#333333" style="background-color:#E9E9E9;">Data de Encerramento</font><br/>
<?php
if ($objChamado->getStatusChamado() == 2) {
	echo htmlentities(Util::reduzirDataHora(Util::formatarBancoData($objChamado->getDataFechamento())));
}
else {
	echo "-";
}
?>
		</td>
		<td>
			<font color="#333333" style="background-color:#E9E9E9;">Prazo</font><br/><?php echo htmlentities(Util::reduzirDataHora(Util::formatarBancoData($objChamado->getDataPrazo()))); ?>
		</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td>
			<font color="#333333" style="background-color:#E9E9E9;">Aberto Por</font><br/><?php echo htmlentities($objChamado->getUsuarioOrigem()->getNomeUsuario()); ?>
		</td>
		<td>
			<font color="#333333" style="background-color:#E9E9E9;">Setor</font><br/><?php echo htmlentities(Util::formatarFrase($objChamado->getUsuarioOrigem()->getSetor()->getDescricaoSetor())); ?>
		</td>
		<td>
			<font color="#333333" style="background-color:#E9E9E9;">Ramal/Telefone</font><br/><?php echo htmlentities($objChamado->getUsuarioOrigem()->getRamal()); ?>
		</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td colspan="3">
			<font color="#333333" style="background-color:#E9E9E9;">Descri&ccedil;&atilde;o</font><br/><?php echo str_replace(array("\r\n", "\n"), "<br/>", htmlentities(rtrim($objChamado->getDescricaoChamado()))); ?>
		</td>
	</tr>
<?php
if ($objChamado->getCodigoPrioridade() == 4 && strlen(trim($objChamado->getJustificativaPrioridade())) > 0) {
?>
	<tr bgcolor="#FFFFFF">
		<td colspan="3">
			<font color="#333333" style="background-color:#E9E9E9;">Justificativa da Prioridade</font><br/><span style="color:#FF0000;"><?php echo str_replace(array("\r\n", "\n"), "<br/>", htmlentities(rtrim($objChamado->getJustificativaPrioridade()))); ?></span>
		</td>
	</tr>
<?php
}
?>
</table><br/>

<!-- Inicio do Historico -->
<table width="90%" cellspacing="0" cellpadding="4" border="1" bgcolor="#DDDDDD" align="center">
	<tr><td bgcolor="#009900"><font color="#FFFFFF"><strong>Hist&oacute;rico do Chamado</strong></font></td></tr>
	<tr bgcolor="#FFFFFF">
		<td align="center"><strong><a href="<?php echo Config::getUrlBase(); ?>" target="_blank">Este chamado tem uma nova movimenta&ccedil;&atilde;o. Favor entrar no sistema para acompanhar o seu status. (Clique aqui)</a></strong></td>
	</tr>
</table><br/>

<div align="center">Mensagem autom&aacute;tica, favor n&atilde;o responder este e-mail.</div>
</body>
</html>
