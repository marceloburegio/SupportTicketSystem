<div id="corpo">
	<h2 class="titulo">Mensagem de erro</h2>
	<div class="conteudo">
		<p>
			<table border="0" align="center">
				<tr>
					<td><img src="<?php echo Config::getUrlBase(); ?>/imagens/warning.png" width="48" height="48" border="0"></td>
					<td>Desculpe-nos, n&atilde;o foi poss&iacute;vel atender a sua solicita&ccedil;&atilde;o devido ao seguinte erro:</td>
				</tr>
			</table>
		</p>
		<p>
			<div align="center" style="font-size:16px;color:#0C487C"><strong><?php echo str_replace("\n", "<br/>", $strMensagem); ?></strong></div>
		</p>
		<p>
			<div align="center"><?php echo htmlentities(Config::getMensagemErroPadrao()); ?><div>
		</p>
	</div>
</div>
