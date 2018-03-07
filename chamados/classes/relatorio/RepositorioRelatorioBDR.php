<?php
/**
 * Repositório de Relatórios
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 23/02/2015 10:34:42
 */
class RepositorioRelatorioBDR {
	/**
	 * Objeto da conexão
	 *
	 * @access protected
	 * @var Conexao
	 */
	protected $objConexao;
	
	/**
	 * Objeto PDO
	 *
	 * @access protected
	 * @var PDO
	 */
	protected $objPDO;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 */
	public function __construct() {
		$this->objConexao = ConexaoBDR::getInstancia("sistema");
		$this->objPDO     = $this->objConexao->getConexao();
	}
	
	/**
	 * Método que gera um relatório dos Chamados por Sla Mensal
	 * 
	 * @param array $arrParametro
	 * @return array
	 */
	public function relatorioChamadosPorSlaMensal(array $arrParametro, $strComplemento = ""){
		$intMes				= (int) $arrParametro["intMes"];
		$intAno				= (int) $arrParametro["intAno"];
		$arrIdGrupoDestino	= (array) $arrParametro["arrIdGrupoDestino"];
		$strIdGrupoDestino = implode(", ", $arrIdGrupoDestino);
		
		$strSql = "
			SELECT
				YEAR(c.data_abertura) AS ano,
				MONTH(c.data_abertura) AS mes,
				SUM(CASE WHEN c.status_chamado = 1 AND NOW() <= c.data_prazo THEN 1 ELSE 0 END) AS abertos_dentro_prazo,
				SUM(CASE WHEN c.status_chamado = 1 AND NOW() > c.data_prazo THEN 1 ELSE 0 END) AS abertos_fora_prazo,
				SUM(CASE WHEN c.status_chamado = 2 AND c.data_fechamento <= c.data_prazo THEN 1 ELSE 0 END) AS fechados_dentro_prazo,
				SUM(CASE WHEN c.status_chamado = 2 AND c.data_fechamento > c.data_prazo THEN 1 ELSE 0 END) AS fechados_fora_prazo,
				SUM(CASE WHEN c.status_chamado = 3 AND NOW() <= c.data_prazo THEN 1 ELSE 0 END) AS pendentes_dentro_prazo,
				SUM(CASE WHEN c.status_chamado = 3 AND NOW() > c.data_prazo THEN 1 ELSE 0 END) AS pendentes_fora_prazo,
				SUM(CASE WHEN c.status_chamado = 9 THEN 1 ELSE 0 END) AS cancelados
			FROM chamado c
			WHERE c.id_grupo_destino IN (". $strIdGrupoDestino .")
			AND YEAR(c.data_abertura) = '". $intAno ."'
			AND MONTH(c.data_abertura) = '". $intMes ."'
			$strComplemento
			GROUP BY YEAR(c.data_abertura), MONTH(c.data_abertura)
			ORDER BY YEAR(c.data_abertura), MONTH(c.data_abertura)";
		
		try {
			$objResult = $this->objPDO->query($strSql);
			return $objResult->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
	/**
	 * Método que gera um relatório dos Chamados em uma Listagem Geral
	 * 
	 * @param array $arrParametro
	 * @return array
	 */
	public function relatorioChamadosPorSlaGeral(array $arrParametro, $strComplemento = ""){
		$strDataInicial		= (string) $arrParametro["strDataInicial"];
		$strDataFinal		= (string) $arrParametro["strDataFinal"];
		$intStatus			= (int) $arrParametro["intStatus"];
		$arrIdGrupoDestino	= (array) $arrParametro["arrIdGrupoDestino"];
		$strIdGrupoDestino = implode(", ", $arrIdGrupoDestino);
		
		$strSql = "
			SELECT
				c.id_chamado,
				c.descricao_chamado,
				c.data_abertura,
				c.data_prazo,
				c.data_fechamento,
				c.status_chamado,
				g.descricao_grupo,
				(UNIX_TIMESTAMP(CASE WHEN c.status_chamado = 2 OR c.status_chamado = 9 THEN c.data_fechamento ELSE NOW() END) - UNIX_TIMESTAMP(c.data_abertura)) /
				CASE WHEN (UNIX_TIMESTAMP(c.data_prazo) - UNIX_TIMESTAMP(c.data_abertura)) THEN (UNIX_TIMESTAMP(c.data_prazo) - UNIX_TIMESTAMP(c.data_abertura)) ELSE 1 END AS sla
			FROM chamado c
			INNER JOIN grupo g ON g.id_grupo = c.id_grupo_destino
			WHERE c.data_abertura BETWEEN ". $this->objPDO->quote($strDataInicial ." 00:00:00") ." AND ". $this->objPDO->quote($strDataFinal ." 23:59:59") ."
			AND c.id_grupo_destino IN (". $strIdGrupoDestino .")";
		if ($intStatus > 0) {
			$strSql .= "
			AND c.status_chamado = ". $intStatus;
		}
		$strSql .= "
			$strComplemento
			ORDER BY c.data_abertura ASC";
		
		try {
			$objResult = $this->objPDO->query($strSql);
			return $objResult->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
	/**
	 * Método que gera um relatório dos Chamados Abertos e Fechados em um período de tempo
	 * 
	 * @param array $arrParametro
	 * @return array
	 */
	public function relatorioChamadosAbertosFechados(array $arrParametro, $strComplemento = ""){
		$strDataInicial		= (string) $arrParametro["strDataInicial"];
		$strDataFinal		= (string) $arrParametro["strDataFinal"];
		$intIdSetor			= (int) $arrParametro["intIdSetor"];
		$arrIdGrupoDestino	= (array) $arrParametro["arrIdGrupoDestino"];
		$strIdGrupoDestino = implode(", ", $arrIdGrupoDestino);
		
		// Consulta Abertos
		$strSqlAbertos = "
			SELECT YEAR(c.data_abertura) AS ano, MONTH(c.data_abertura) AS mes, COUNT(*) AS qtde
			FROM chamado c
			WHERE c.data_abertura BETWEEN ". $this->objPDO->quote($strDataInicial ." 00:00:00") ." AND ". $this->objPDO->quote($strDataFinal ." 23:59:59") ."
			AND c.id_grupo_destino IN (". $strIdGrupoDestino .")";
		if ($intIdSetor > 0) {
			$strSqlAbertos .= "
				AND c.id_usuario_origem IN (
					SELECT id_usuario
					FROM usuario
					WHERE id_setor = ". $this->objPDO->quote($intIdSetor) ."
				)";
		}
		$strSqlAbertos .= "
			$strComplemento
			GROUP BY YEAR(c.data_abertura), MONTH(c.data_abertura)
			ORDER BY YEAR(c.data_abertura), MONTH(c.data_abertura)";
		
		// Consulta Fechados
		$strSqlFechados = "
			SELECT YEAR(c.data_fechamento) AS ano, MONTH(c.data_fechamento) AS mes, COUNT(*) as qtde
			FROM chamado c
			WHERE c.data_fechamento BETWEEN ". $this->objPDO->quote($strDataInicial ." 00:00:00") ." AND ". $this->objPDO->quote($strDataFinal ." 23:59:59") ."
			AND c.status_chamado IN (2, 9)
			AND c.id_grupo_destino IN (". $strIdGrupoDestino .")";
		if ($intIdSetor > 0) {
			$strSqlFechados .= "
				AND c.id_usuario_origem IN (
					SELECT id_usuario
					FROM usuario
					WHERE id_setor = ". $this->objPDO->quote($intIdSetor) ."
				)";
		}
		$strSqlFechados .= "
			$strComplemento
			GROUP BY YEAR(c.data_abertura), MONTH(c.data_abertura)
			ORDER BY YEAR(c.data_abertura), MONTH(c.data_abertura)";
		try {
			$objResultAbertos = $this->objPDO->query($strSqlAbertos);
			$objResultFechados = $this->objPDO->query($strSqlFechados);
			
			$arrResultsAbertos = $objResultAbertos->fetchAll(PDO::FETCH_ASSOC);
			$arrResultsFechados = $objResultFechados->fetchAll(PDO::FETCH_ASSOC);
			
			// Efetuando o processamento dos dados
			$arrResults = array();
			foreach ($arrResultsAbertos as $arrResult) {
				$strAnoMes = substr(Util::formatarMes($arrResult['mes']), 0, 3) ."/". substr($arrResult['ano'], 2);
				$arrResults[ $strAnoMes ] = array('abertos' => $arrResult['qtde'], 'fechados' => 0);
			}
			foreach ($arrResultsFechados as $arrResult) {
				$strAnoMes = substr(Util::formatarMes($arrResult['mes']), 0, 3) ."/". substr($arrResult['ano'], 2);
				$arrResults[ $strAnoMes ]['fechados'] = $arrResult['qtde'];
				if (empty($arrResults[ $strAnoMes ]['abertos'])) $arrResults[ $strAnoMes ]['abertos'] = 0;
			}
			return $arrResults;
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
	/**
	 * Método que gera um relatório dos Chamados por Assunto
	 * 
	 * @param array $arrParametro
	 * @return array
	 */
	public function relatorioChamadosPorAssunto(array $arrParametro, $strComplemento = ""){
		$intMes				= (int) $arrParametro["intMes"];
		$intAno				= (int) $arrParametro["intAno"];
		$arrIdGrupoDestino	= (array) $arrParametro["arrIdGrupoDestino"];
		$strIdGrupoDestino = implode(", ", $arrIdGrupoDestino);
		
		$strSql = "
			SELECT
				a.descricao_assunto,
				SUM(CASE WHEN (c.status_chamado = 1 OR c.status_chamado = 3) AND NOW() <= c.data_prazo THEN 1 ELSE 0 END) AS abertos_dentro_prazo,
				SUM(CASE WHEN (c.status_chamado = 1 OR c.status_chamado = 3) AND NOW() > c.data_prazo THEN 1 ELSE 0 END) AS abertos_fora_prazo,
				SUM(CASE WHEN c.status_chamado = 2 AND c.data_fechamento <= c.data_prazo THEN 1 ELSE 0 END) AS fechados_dentro_prazo,
				SUM(CASE WHEN c.status_chamado = 2 AND c.data_fechamento > c.data_prazo THEN 1 ELSE 0 END) AS fechados_fora_prazo,
				SUM(CASE WHEN c.status_chamado = 9 THEN 1 ELSE 0 END) AS cancelados,
				COUNT(*) AS qtde
			FROM chamado c
			INNER JOIN assunto a ON c.id_assunto = a.id_assunto
			WHERE c.id_grupo_destino IN (". $strIdGrupoDestino .")
			AND YEAR(c.data_abertura) = '". $intAno ."'
			AND MONTH(c.data_abertura) = '". $intMes ."'
			$strComplemento
			GROUP BY a.descricao_assunto
			ORDER BY COUNT(*) DESC";
		try {
			$objResult = $this->objPDO->query($strSql);
			return $objResult->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
	/**
	 * Método que gera um relatório dos Chamados por Setor
	 * 
	 * @param array $arrParametro
	 * @return array
	 */
	public function relatorioChamadosPorSetor(array $arrParametro, $strComplemento = ""){
		$intMes				= (int) $arrParametro["intMes"];
		$intAno				= (int) $arrParametro["intAno"];
		$arrIdGrupoDestino	= (array) $arrParametro["arrIdGrupoDestino"];
		$strIdGrupoDestino = implode(", ", $arrIdGrupoDestino);
		
		$strSql = "
			SELECT
				s.descricao_setor,
				SUM(CASE WHEN (c.status_chamado = 1 OR c.status_chamado = 3) AND NOW() <= c.data_prazo THEN 1 ELSE 0 END) AS abertos_dentro_prazo,
				SUM(CASE WHEN (c.status_chamado = 1 OR c.status_chamado = 3) AND NOW() > c.data_prazo THEN 1 ELSE 0 END) AS abertos_fora_prazo,
				SUM(CASE WHEN c.status_chamado = 2 AND c.data_fechamento <= c.data_prazo THEN 1 ELSE 0 END) AS fechados_dentro_prazo,
				SUM(CASE WHEN c.status_chamado = 2 AND c.data_fechamento > c.data_prazo THEN 1 ELSE 0 END) AS fechados_fora_prazo,
				SUM(CASE WHEN c.status_chamado = 9 THEN 1 ELSE 0 END) AS cancelados,
				COUNT(*) AS qtde
			FROM chamado c
			INNER JOIN usuario u ON c.id_usuario_origem = u.id_usuario
			INNER JOIN setor s ON u.id_setor = s.id_setor
			WHERE c.id_grupo_destino IN (". $strIdGrupoDestino .")
			AND YEAR(c.data_abertura) = '". $intAno ."'
			AND MONTH(c.data_abertura) = '". $intMes ."'
			$strComplemento
			GROUP BY s.descricao_setor
			ORDER BY COUNT(*) DESC";
		try {
			$objResult = $this->objPDO->query($strSql);
			return $objResult->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
	/**
	 * Método que gera um relatório dos Chamados por Grupo
	 * 
	 * @param array $arrParametro
	 * @return array
	 */
	public function relatorioChamadosPorGrupo(array $arrParametro, $strComplemento = ""){
		$intMes				= (int) $arrParametro["intMes"];
		$intAno				= (int) $arrParametro["intAno"];
		$arrIdGrupoDestino	= (array) $arrParametro["arrIdGrupoDestino"];
		$strIdGrupoDestino = implode(", ", $arrIdGrupoDestino);
		
		$strSql = "
			SELECT
				g.descricao_grupo,
				SUM(CASE WHEN (c.status_chamado = 1 OR c.status_chamado = 3) AND NOW() <= c.data_prazo THEN 1 ELSE 0 END) AS abertos_dentro_prazo,
				SUM(CASE WHEN (c.status_chamado = 1 OR c.status_chamado = 3) AND NOW() > c.data_prazo THEN 1 ELSE 0 END) AS abertos_fora_prazo,
				SUM(CASE WHEN c.status_chamado = 2 AND c.data_fechamento <= c.data_prazo THEN 1 ELSE 0 END) AS fechados_dentro_prazo,
				SUM(CASE WHEN c.status_chamado = 2 AND c.data_fechamento > c.data_prazo THEN 1 ELSE 0 END) AS fechados_fora_prazo,
				SUM(CASE WHEN c.status_chamado = 9 THEN 1 ELSE 0 END) AS cancelados,
				COUNT(*) AS qtde
			FROM chamado c
			INNER JOIN grupo g ON g.id_grupo = c.id_grupo_destino
			WHERE c.id_grupo_destino IN (". $strIdGrupoDestino .")
			AND YEAR(c.data_abertura) = '". $intAno ."'
			AND MONTH(c.data_abertura) = '". $intMes ."'
			$strComplemento
			GROUP BY g.descricao_grupo
			ORDER BY COUNT(*) DESC";
		try {
			$objResult = $this->objPDO->query($strSql);
			return $objResult->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
}
