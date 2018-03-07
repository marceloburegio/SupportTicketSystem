<?php
/**
 * Controlador responsável pela regra de negócio envolvendo os Feriados
 * 
 * @author Marcelo Burégio
 * @subpackage controladores
 * @since 22/05/2011 12:21:20
 * @version 1.0
 */
class ControladorFeriado {
	/**
	 * Repositório da Classe Feriado
	 *
	 * @access private
	 * @var IRepositorioFeriado
	 */
	private $objRepositorioFeriado;
	
	/**
	 * Método construtor da classe
	 * 
	 * @access public
	 * @param IRepositorioFeriado $objRepositorioFeriado = null
	 */
	public function __construct(IRepositorioFeriado $objRepositorioFeriado = null) {
		$this->objRepositorioFeriado = $objRepositorioFeriado;
	}
	
	/**
	 * Método que cadastra o Feriado no RepositorioFeriado
	 * 
	 * @param int $intIdGrupo
	 * @param string $strDataFeriado
	 * @param string $strDescricaoFeriado
	 * @return void
	 */
	public function cadastrarFeriado($intIdGrupo, $strDataFeriado, $strDescricaoFeriado) {
		// Inicializando os cadastros
		$objCadastroFeriado	 = new CadastroFeriado($this->objRepositorioFeriado);
		
		// Removendo os espaços vazios
		$intIdGrupo				= (int) $intIdGrupo;
		$strDataFeriado			= (string) trim($strDataFeriado);
		$strDescricaoFeriado	= (string) trim($strDescricaoFeriado);
		
		// Validando os dados
		if ($intIdGrupo <= 0)						throw new CampoObrigatorioException("ID do Grupo");
		if (strlen($strDescricaoFeriado) < 1)		throw new CampoObrigatorioException("Descrição do Feriado");
		if (strlen($strDataFeriado) < 1)			throw new CampoObrigatorioException("Data do Feriado");
		if (!Util::validaData($strDataFeriado))		throw new CampoInvalidoException("Data do Feriado");
		
		// Convertendo a data para o formato de banco de dados
		$strDataFeriado	= Util::formatarDataBanco($strDataFeriado);
		
		// Verificando se já existe um feriado cadastrado na data para o grupo
		if ($objCadastroFeriado->existePorIdGrupoPorDataFeriado($intIdGrupo, $strDataFeriado)) {
			throw new FeriadoJaCadastradoException(null);
		}
		
		// Criando o objeto Feriado
		$intIdFeriado	= 0;
		$objFeriado = new Feriado($intIdFeriado, $intIdGrupo, $strDataFeriado, $strDescricaoFeriado);
		
		// Cadastrando o Feriado
		$objCadastroFeriado->cadastrar($objFeriado);
	}
	
	/**
	 * Método que atualiza o Feriado no RepositorioFeriado
	 * 
	 * @param int $intIdFeriado
	 * @param int $intIdGrupo
	 * @param string $strDataFeriado
	 * @param string $strDescricaoFeriado
	 * @return void
	 */
	public function atualizarFeriado($intIdFeriado, $intIdGrupo, $strDataFeriado, $strDescricaoFeriado) {
		// Inicializando os cadastros
		$objCadastroFeriado	 = new CadastroFeriado($this->objRepositorioFeriado);
		
		// Removendo os espaços vazios
		$intIdFeriado			= (int) $intIdFeriado;
		$intIdGrupo				= (int) $intIdGrupo;
		$strDataFeriado			= (string) trim($strDataFeriado);
		$strDescricaoFeriado	= (string) trim($strDescricaoFeriado);
		
		// Validando os dados
		if ($intIdFeriado <= 0)						throw new CampoObrigatorioException("ID do Feriado");
		if ($intIdGrupo <= 0)						throw new CampoObrigatorioException("ID do Grupo");
		if (strlen($strDescricaoFeriado) < 1)		throw new CampoObrigatorioException("Descrição do Feriado");
		if (strlen($strDataFeriado) < 1)			throw new CampoObrigatorioException("Data do Feriado");
		if (!Util::validaData($strDataFeriado))		throw new CampoInvalidoException("Data do Feriado");
		
		// Recuperando o objeto Feriado
		$objFeriado = $objCadastroFeriado->procurar($intIdFeriado);
		
		// Atualizando o objeto Feriado
		$objFeriado->setIdGrupo($intIdGrupo);
		$objFeriado->setDataFeriado(Util::formatarDataBanco($strDataFeriado));
		$objFeriado->setDescricaoFeriado($strDescricaoFeriado);
		
		// Atualizando o Feriado
		$objCadastroFeriado->atualizar($objFeriado);
	}
	
	/**
	 * Método que remove o feriado no banco
	 * 
	 * @param int $intIdFeriado
	 * @return void
	 */
	public function excluirFeriado($intIdFeriado) {
		// Inicializando os cadastros
		$objCadastroFeriado	 = new CadastroFeriado($this->objRepositorioFeriado);
		
		// Removendo os espaços vazios
		$intIdFeriado	= (int) $intIdFeriado;
		
		// Validando o Identificador
		if ($intIdFeriado <= 0)	throw new CampoObrigatorioException("ID do Feriado");
		
		// Excluindo Feriado
		$objFeriado = $objCadastroFeriado->remover($intIdFeriado);
	}
	
	/**
	 * Método que procura um Feriado pelo seu id
	 * 
	 * @param int $intIdFeriado
	 * @return array
	 */
	public function procurarFeriado($intIdFeriado){
		// Inicializando os cadastros
		$objCadastroFeriado	 = new CadastroFeriado($this->objRepositorioFeriado);
		
		// Removendo os espaços vazios
		$intIdFeriado	= (int) $intIdFeriado;
		
		// Validando o Identificador
		if ($intIdFeriado <= 0) throw new CampoObrigatorioException("ID do Feriado");
		
		// Procurando o Feriado especificado
		return $objCadastroFeriado->procurar($intIdFeriado);
	}
	
	/**
	 * Método que lista todos os Feriados pelo Id do Grupo
	 * 
	 * @param int $intIdGrupo
	 * @return array
	 */
	public function listarFeriadosPorIdGrupo($intIdGrupo){
		// Inicializando os cadastros
		$objCadastroFeriado	 = new CadastroFeriado($this->objRepositorioFeriado);
		
		// Removendo os espaços vazios
		$intIdGrupo	= (int) $intIdGrupo;
		
		// Validando o Identificador
		if ($intIdGrupo <= 0) throw new CampoObrigatorioException("ID do Grupo");
		
		// Listando os feriados do grupo informado
		return $objCadastroFeriado->listarPorIdGrupo($intIdGrupo);
	}
}