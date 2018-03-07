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
	$arrParametro["intMesInicial"]		= (int) @$_POST["intMesInicial"];
	$arrParametro["intAnoInicial"]		= (int) @$_POST["intAnoInicial"];
	$arrParametro["intMesFinal"]		= (int) @$_POST["intMesFinal"];
	$arrParametro["intAnoFinal"]		= (int) @$_POST["intAnoFinal"];
	$arrParametro["intIdSetor"]			= (int) @$_POST["intIdSetor"];
	$arrParametro["arrIdGrupoDestino"]	= (array) @$_POST["arrIdGrupoDestino"];
	
	// Inicializando as variaveis
	$arrDadosRelatorio = $objFachadaBDR->relatorioChamadosAbertosFechados($arrParametro);
}
catch (Exception $ex) {
	$strMensagem = htmlentities($ex->getMessage());
	include("includes/incErro.php");
	exit();
}

// Validando se ha algum dado a ser exibido
if (!is_array($arrDadosRelatorio) || empty($arrDadosRelatorio)) {
?>
<h3 align="center">N&atilde;o h&aacute; dados com os par&acirc;metros informados.</h3>
<?php
}
else {
	$arrChartData = array();
	foreach ($arrDadosRelatorio as $strAnoMes => $arrDados) {
		$arrChartData[] = "['". $strAnoMes ."', ". implode(", ", $arrDados) ."]";
	}
?>
<div id="relatorioGrafico" class="relatorioGrafico"></div>
<script type="text/javascript">
function drawChart() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Mês');
	data.addColumn('number', 'Abertos');
	data.addColumn('number', 'Fechados');
	data.addRows([
<?php echo implode(", ", $arrChartData); ?>
	]);
	var options = {
		title: 'Evolução dos Chamados Abertos x Fechados',
		vAxis: {
			title: 'Quantidade de Chamados'
		},
		titleTextStyle: {
			color: 'black',
			fontName: 'Verdana',
			fontSize: '20'
		},
		pointSize: 10,
		series: {
			0: { pointShape: 'diamond' },
			1: { pointShape: 'square', lineDashStyle: [10, 5] }
		}
	};
	var chart = new google.visualization.LineChart(document.getElementById('relatorioGrafico'));
	chart.draw(data, options);
}
drawChart();
</script>
<?php
}
?>
<br/>
