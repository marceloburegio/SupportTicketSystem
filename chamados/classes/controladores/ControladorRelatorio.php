<?php
/**
 * Controlador responsável pela regra de negócio envolvendo os Relatório
 * 
 * @author Marcelo Buregio
 * @subpackage controladores
 * @since 23/02/2015 11:13
 * @version 1.0
 */
class ControladorRelatorio {
	/**
	 * Repositório da Classe Relatorio
	 *
	 * @access private
	 * @var RepositorioRelatorioBDR
	 */
	private $objRepositorioRelatorio;
	
	/**
	 * Método contrutor da minha classe
	 * 
	 * @param RepositorioRelatorio $objRepositorioRelatorio
	 */
	public function __construct(RepositorioRelatorioBDR $objRepositorioRelatorio){
		$this->objRepositorioRelatorio = $objRepositorioRelatorio;
	}
	
	/**
	 * Método que gera um relatório dos chamados por Sla Mensal
	 * 
	 * @param array $arrParametro
	 * @return array
	 */
	public function relatorioChamadosPorSlaMensal(array $arrParametro) {
		// Removendo os espaços vazios
		$arrParametro["intMes"]				= (int) @$arrParametro["intMes"];
		$arrParametro["intAno"]				= (int) @$arrParametro["intAno"];
		$arrParametro["arrIdGrupoDestino"]	= (array) @$arrParametro["arrIdGrupoDestino"];
		foreach ($arrParametro["arrIdGrupoDestino"] as $intKey => $intIdGrupoDestino) {
			$arrParametro["arrIdGrupoDestino"][ $intKey ] = (int) $intIdGrupoDestino;
		}
		
		// Validando os dados
		if ($arrParametro["intMes"] < 0 || $arrParametro["intMes"] > 12) throw new CampoInvalidoException("Mês");
		if ($arrParametro["intAno"] < 2015 || strlen($arrParametro["intAno"]) > 4) throw new CampoInvalidoException("Ano");
		if (!is_array($arrParametro["arrIdGrupoDestino"]) || empty($arrParametro["arrIdGrupoDestino"])) throw new CampoObrigatorioException("Grupo");
		
		// Executando o relatório
		return $this->objRepositorioRelatorio->relatorioChamadosPorSlaMensal($arrParametro);
	}
	
	/**
	 * Método que gera um relatório dos chamados em uma listagem geral
	 * 
	 * @param array $arrParametro
	 * @return array
	 */
	public function relatorioChamadosPorSlaGeral(array $arrParametro) {
		// Removendo os espaços vazios
		$arrParametro["strDataInicial"]		= (string) trim(@$arrParametro["strDataInicial"]);
		$arrParametro["strDataFinal"]		= (string) trim(@$arrParametro["strDataFinal"]);
		$arrParametro["intStatus"]			= (int) @$arrParametro["intStatus"];
		$arrParametro["arrIdGrupoDestino"]	= (array) @$arrParametro["arrIdGrupoDestino"];
		foreach ($arrParametro["arrIdGrupoDestino"] as $intKey => $intIdGrupoDestino) {
			$arrParametro["arrIdGrupoDestino"][ $intKey ] = (int) $intIdGrupoDestino;
		}
		
		// Validando os dados
		if (empty($arrParametro["strDataInicial"]))	throw new CampoObrigatorioException("Data Inicial");
		if (empty($arrParametro["strDataFinal"]))	throw new CampoObrigatorioException("Data Final");
		if (!is_array($arrParametro["arrIdGrupoDestino"]) || empty($arrParametro["arrIdGrupoDestino"])) throw new CampoObrigatorioException("Grupo");
		
		// Definindo os valores padrões
		if ($arrParametro["intStatus"] < -1) $arrParametro["intStatus"] = (int) 0;
		if (strlen($arrParametro["strDataInicial"]) < 10) $arrParametro["strDataInicial"] = (string) "01". date("/m/Y");
		if (strlen($arrParametro["strDataFinal"]) < 10) $arrParametro["strDataFinal"] = (string) date("t/m/Y");
		
		// Convertendo a data do formato DD/MM/YYYY para YYYY-MM-DD
		$arrParametro["strDataInicial"] = Util::formatarDataBanco($arrParametro["strDataInicial"]);
		$arrParametro["strDataFinal"]   = Util::formatarDataBanco($arrParametro["strDataFinal"]);
		
		// Executando o relatório
		return $this->objRepositorioRelatorio->relatorioChamadosPorSlaGeral($arrParametro);
	}
	
	/**
	 * Método que gera um relatório dos chamados abertos e fechados no período
	 * 
	 * @param array $arrParametro
	 * @return array
	 */
	public function relatorioChamadosAbertosFechados(array $arrParametro) {
		// Removendo os espaços vazios
		$arrParametro["intMesInicial"]				= (int) @$arrParametro["intMesInicial"];
		$arrParametro["intAnoInicial"]				= (int) @$arrParametro["intAnoInicial"];
		$arrParametro["intMesFinal"]				= (int) @$arrParametro["intMesFinal"];
		$arrParametro["intAnoFinal"]				= (int) @$arrParametro["intAnoFinal"];
		$arrParametro["intIdSetor"]					= (int) @$arrParametro["intIdSetor"];
		$arrParametro["arrIdGrupoDestino"]			= (array) @$arrParametro["arrIdGrupoDestino"];
		foreach ($arrParametro["arrIdGrupoDestino"] as $intKey => $intIdGrupoDestino) {
			$arrParametro["arrIdGrupoDestino"][ $intKey ] = (int) $intIdGrupoDestino;
		}
		
		// Validando os dados
		if ($arrParametro["intMesInicial"] < 0 || $arrParametro["intMesInicial"] > 12) throw new CampoInvalidoException("Mês Inicial");
		if ($arrParametro["intAnoInicial"] < 2014 || strlen($arrParametro["intAnoInicial"]) > 4) throw new CampoInvalidoException("Ano Inicial");
		if ($arrParametro["intMesFinal"] < 0 || $arrParametro["intMesFinal"] > 12) throw new CampoInvalidoException("Mês Final");
		if ($arrParametro["intAnoFinal"] < 2015 || strlen($arrParametro["intAnoFinal"]) > 4) throw new CampoInvalidoException("Ano Final");
		if ($arrParametro["intIdSetor"] < 0) throw new CampoInvalidoException("Setor");
		if (!is_array($arrParametro["arrIdGrupoDestino"]) || empty($arrParametro["arrIdGrupoDestino"])) throw new CampoObrigatorioException("Grupo");
		
		// Obtendo as datas iniciais e finais
		$arrParametro["strDataInicial"] = "01/". $arrParametro["intMesInicial"] ."/". $arrParametro["intAnoInicial"];
		$arrParametro["strDataFinal"] = date("t", strtotime($arrParametro["intAnoFinal"] ."-". $arrParametro["intMesFinal"] ."-01")) . "/". $arrParametro["intMesFinal"] ."/". $arrParametro["intAnoFinal"];
		
		// Convertendo a data do formato DD/MM/YYYY para YYYY-MM-DD
		$arrParametro["strDataInicial"] = Util::formatarDataBanco($arrParametro["strDataInicial"]);
		$arrParametro["strDataFinal"]   = Util::formatarDataBanco($arrParametro["strDataFinal"]);
		
		// Executando o relatório
		return $this->objRepositorioRelatorio->relatorioChamadosAbertosFechados($arrParametro);
	}
	
	/**
	 * Método que gera um relatório dos chamados por Assunto
	 * 
	 * @param array $arrParametro
	 * @return array
	 */
	public function relatorioChamadosPorAssunto(array $arrParametro) {
		// Removendo os espaços vazios
		$arrParametro["intMes"]				= (int) @$arrParametro["intMes"];
		$arrParametro["intAno"]				= (int) @$arrParametro["intAno"];
		$arrParametro["arrIdGrupoDestino"]	= (array) @$arrParametro["arrIdGrupoDestino"];
		foreach ($arrParametro["arrIdGrupoDestino"] as $intKey => $intIdGrupoDestino) {
			$arrParametro["arrIdGrupoDestino"][ $intKey ] = (int) $intIdGrupoDestino;
		}
		
		// Validando os dados
		if ($arrParametro["intMes"] < 0 || $arrParametro["intMes"] > 12) throw new CampoInvalidoException("Mês");
		if ($arrParametro["intAno"] < 2015 || strlen($arrParametro["intAno"]) > 4) throw new CampoInvalidoException("Ano");
		if (!is_array($arrParametro["arrIdGrupoDestino"]) || empty($arrParametro["arrIdGrupoDestino"])) throw new CampoObrigatorioException("Grupo");
		
		// Executando o relatório
		return $this->objRepositorioRelatorio->relatorioChamadosPorAssunto($arrParametro);
	}
	
	/**
	 * Método que gera um relatório dos chamados por Setor
	 * 
	 * @param array $arrParametro
	 * @return array
	 */
	public function relatorioChamadosPorSetor(array $arrParametro) {
		// Removendo os espaços vazios
		$arrParametro["intMes"]				= (int) @$arrParametro["intMes"];
		$arrParametro["intAno"]				= (int) @$arrParametro["intAno"];
		$arrParametro["arrIdGrupoDestino"]	= (array) @$arrParametro["arrIdGrupoDestino"];
		foreach ($arrParametro["arrIdGrupoDestino"] as $intKey => $intIdGrupoDestino) {
			$arrParametro["arrIdGrupoDestino"][ $intKey ] = (int) $intIdGrupoDestino;
		}
		
		// Validando os dados
		if ($arrParametro["intMes"] < 0 || $arrParametro["intMes"] > 12) throw new CampoInvalidoException("Mês");
		if ($arrParametro["intAno"] < 2015 || strlen($arrParametro["intAno"]) > 4) throw new CampoInvalidoException("Ano");
		if (!is_array($arrParametro["arrIdGrupoDestino"]) || empty($arrParametro["arrIdGrupoDestino"])) throw new CampoObrigatorioException("Grupo");
		
		// Executando o relatório
		return $this->objRepositorioRelatorio->relatorioChamadosPorSetor($arrParametro);
	}
	
	/**
	 * Método que gera um relatório dos chamados por Grupo
	 * 
	 * @param array $arrParametro
	 * @return array
	 */
	public function relatorioChamadosPorGrupo(array $arrParametro) {
		// Removendo os espaços vazios
		$arrParametro["intMes"]				= (int) @$arrParametro["intMes"];
		$arrParametro["intAno"]				= (int) @$arrParametro["intAno"];
		$arrParametro["arrIdGrupoDestino"]	= (array) @$arrParametro["arrIdGrupoDestino"];
		foreach ($arrParametro["arrIdGrupoDestino"] as $intKey => $intIdGrupoDestino) {
			$arrParametro["arrIdGrupoDestino"][ $intKey ] = (int) $intIdGrupoDestino;
		}
		
		// Validando os dados
		if ($arrParametro["intMes"] < 0 || $arrParametro["intMes"] > 12) throw new CampoInvalidoException("Mês");
		if ($arrParametro["intAno"] < 2015 || strlen($arrParametro["intAno"]) > 4) throw new CampoInvalidoException("Ano");
		if (!is_array($arrParametro["arrIdGrupoDestino"]) || empty($arrParametro["arrIdGrupoDestino"])) throw new CampoObrigatorioException("Grupo");
		
		// Executando o relatório
		return $this->objRepositorioRelatorio->relatorioChamadosPorGrupo($arrParametro);
	}
}