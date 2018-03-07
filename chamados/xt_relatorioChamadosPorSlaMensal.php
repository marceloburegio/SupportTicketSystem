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
	$arrParametro["intMes"]				= (int) @$_POST["intMes"];
	$arrParametro["intAno"]				= (int) @$_POST["intAno"];
	$arrParametro["arrIdGrupoDestino"]	= (array) @$_POST["arrIdGrupoDestino"];
	
	// Inicializando as variáveis
	$arrDadosRelatorio = $objFachadaBDR->relatorioChamadosPorSlaMensal($arrParametro);
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
	// Montando o Gráfico
	$arrDadosGrafico = $arrDadosRelatorio[0];
?>
<div id="relatorioGrafico" class="relatorioGrafico"></div>
<script type="text/javascript">
function drawChart() {
	var data = google.visualization.arrayToDataTable([
		['Task', 'Hours per Day'],
		['Fechados dentro do prazo', <?php echo $arrDadosGrafico["fechados_dentro_prazo"]; ?>],
		['Fechados fora do prazo',   <?php echo $arrDadosGrafico["fechados_fora_prazo"]; ?>],
		['Abertos dentro do prazo',  <?php echo $arrDadosGrafico["abertos_dentro_prazo"]; ?>],
		['Abertos fora do prazo',    <?php echo $arrDadosGrafico["abertos_fora_prazo"]; ?>],
		['Pendentes dentro do prazo',  <?php echo $arrDadosGrafico["pendentes_dentro_prazo"]; ?>],
		['Pendentes fora do prazo',    <?php echo $arrDadosGrafico["pendentes_fora_prazo"]; ?>],
		['Cancelados',               <?php echo $arrDadosGrafico["cancelados"]; ?>]
	]);
	var options = {
		title: 'Chamados Abertos em <?php echo Util::formatarMes($arrParametro["intMes"]) ?> / <?php echo $arrParametro["intAno"]; ?>',
		is3D: true,
		pieSliceText: 'value',
		titleTextStyle: {
			color: 'black',
			fontName: 'Verdana',
			fontSize: '20'
		}
	};
	var chart = new google.visualization.PieChart(document.getElementById('relatorioGrafico'));
	chart.draw(data, options);
}
drawChart();
</script>
<?php
}
?>
<br/>
