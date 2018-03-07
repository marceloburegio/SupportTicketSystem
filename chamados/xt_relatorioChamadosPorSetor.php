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
	$arrDadosRelatorio = $objFachadaBDR->relatorioChamadosPorSetor($arrParametro);
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
	$arrChartData = array();
	$intQtdeLinhas = 0;
	$intQtdeTotalOutros = 0;
	$arrOutros = array();
	foreach ($arrDadosRelatorio as $arrDados) {
		if ($intQtdeLinhas < Config::getQtdeMaxBarrasGrafico()) $arrChartData[] = "['". $arrDados["descricao_setor"] ."', ". $arrDados["fechados_dentro_prazo"] .", ". $arrDados["abertos_dentro_prazo"] .", ". $arrDados["fechados_fora_prazo"] .", ". $arrDados["abertos_fora_prazo"] .", ". $arrDados["cancelados"] ."]";
		else {
			@$arrOutros["fechados_dentro_prazo"] += $arrDados["fechados_dentro_prazo"];
			@$arrOutros["abertos_dentro_prazo"] += $arrDados["abertos_dentro_prazo"];
			@$arrOutros["fechados_fora_prazo"] += $arrDados["fechados_fora_prazo"];
			@$arrOutros["abertos_fora_prazo"] += $arrDados["abertos_fora_prazo"];
			@$arrOutros["cancelados"] += $arrDados["cancelados"];
			@$arrOutros["qtde"] += $arrDados["qtde"];
		}
		$intQtdeLinhas++;
	}
	if (!empty($arrOutros["qtde"])) {
		$arrChartData[] = "['Demais Setores', ". $arrOutros["fechados_dentro_prazo"] .", ". $arrOutros["abertos_dentro_prazo"] .", ". $arrOutros["fechados_fora_prazo"] .", ". $arrOutros["abertos_fora_prazo"] .", ". $arrOutros["cancelados"] ."]";
	}
?>
<div id="relatorioGrafico" class="relatorioGrafico"></div>
<script type="text/javascript">
function drawChart() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Setor');
	data.addColumn('number', 'Fechado no prazo');
	data.addColumn('number', 'Aberto no prazo');
	data.addColumn('number', 'Fechado fora prazo');
	data.addColumn('number', 'Aberto fora prazo');
	data.addColumn('number', 'Cancelado');
	data.addRows([
<?php echo implode(", ", $arrChartData); ?>
	]);
	var options = {
		title: 'Chamados Por Setor - <?php echo Util::formatarMes($arrParametro["intMes"]) ?> / <?php echo $arrParametro["intAno"]; ?>',
		isStacked: true,
		titleTextStyle: {
			color: 'black',
			fontName: 'Verdana',
			fontSize: '20'
		},
		vAxis: {
			title: 'Quantidade de Chamados'
		},
		legend: { position: 'top', maxLines: 2 },
		colors: ['#3366cc', '#109618', '#dc3912', '#ff9900', '#990099', '#0099C6']
	};
	var chart = new google.visualization.ColumnChart(document.getElementById('relatorioGrafico'));
	chart.draw(data, options);
}
drawChart();
</script>
<?php
}
?>
<br/>
