<?php
// Include do Header
include("incHeader.php");
?>
<div id="topo">
	<div id="topo_logo"></div>
	<div id="topo_menu">
<?php
if (!empty($_SESSION["intIdUsuario"])) {
?>
		<ul class="menu_horizontal">
<?php
	if (!empty($_SESSION["bolRecebeChamado"]) && $_SESSION["bolRecebeChamado"]) {
?>
			<li><a href="listarChamadosRecebidos.php">Chamados Recebidos</a> &nbsp;&nbsp;|</li>
<?php
	}
?>
			<li><a href="listarChamadosEnviados.php">Chamados Enviados</a> &nbsp;&nbsp;|</li>
			<li>
				<a href="cadastrarChamado.php">Novo Chamado</a> &nbsp;&nbsp;|
<?php
	if (!empty($_SESSION["bolBalaoNovoChamado"])) {
?>
				<div class="balao_info" style="left:-20px;">
					<div class="balao_texto" style="width:145px;">Para abrir um novo chamado basta clicar no link <strong>Novo Chamado</strong></div>
				</div>
<?php
	}
?>
			</li>
<?php
	if ((!empty($_SESSION["bolGrupoAdmin"]) && $_SESSION["bolGrupoAdmin"]) || (!empty($_SESSION["bolSuperAdmin"]) && $_SESSION["bolSuperAdmin"])) {
?>
<?php
		if ($_SESSION["bolRecebeChamado"]) {
?>
			<li>
				<a href="#">Relat&oacute;rios</a> &nbsp;&nbsp;|
				<ul style="width:230px;">
					<li><a href="relatorioChamadosAbertosFechados.php">+ Evolu&ccedil;&atilde;o dos Chamados</a></li>
					<li><a href="relatorioChamadosPorSlaGeral.php">+ Chamados por SLA (Listagem)</a></li>
					<li><a href="relatorioChamadosPorSlaMensal.php">+ Chamados por SLA (Mensal)</a></li>
					<li><a href="relatorioChamadosPorAssunto.php">+ Chamados por Assunto</a></li>
					<li><a href="relatorioChamadosPorSetor.php">+ Chamados por Setor</a></li>
					<li><a href="relatorioChamadosPorGrupo.php">+ Chamados por Grupo</a></li>
				</ul>
			</li>
<?php
		}
?>
<?php
	}
	if ((!empty($_SESSION["bolGrupoAdmin"]) && $_SESSION["bolGrupoAdmin"]) || (!empty($_SESSION["bolSuperAdmin"]) && $_SESSION["bolSuperAdmin"])) {
?>
			<li>
				<a href="#">Adminstrador</a> &nbsp;&nbsp;|
				<ul style="width:100px;">
					<li><a href="listarGrupos.php">+ Grupos</a></li>
<?php
		if ($_SESSION["bolRecebeChamado"]) {
?>
					<li><a href="listarAssuntos.php">+ Assuntos</a></li>
<?php
		}
?>
				</ul>
			</li>
<?php
	}
?>
			<li><a href="xt_sair.php">Sair</a></li>
		</ul>
<?php
}
?>
	</div>
<?php
if (!empty($_SESSION["intIdUsuario"])) {
?>
	<div class="clear" style="clear: right"></div>
	<div id="topo_saudacao"><?php echo Util::fraseSaudacao(); ?>, <?php echo htmlentities($_SESSION["strNomeUsuario"]); ?> [<a href="atualizarMeusDados.php">Meus Dados</a>]</div>
<?php
}
?>
</div>
