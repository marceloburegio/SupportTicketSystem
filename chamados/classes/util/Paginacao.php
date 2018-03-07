<?php
/**
 * Classe de Paginação
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 01/07/2011 14:11:32
 */
class Paginacao {
	/**
	 * Quantidade Total de Registros
	 *
	 * @access private
	 * @var int
	 */
	private $intQtdeTotal;
	
	/**
	 * Posição Atual dos Registros
	 *
	 * @access private
	 * @var int
	 */
	private $intOffSet;
	
	/**
	 * Quantidade de Registros Por Página
	 *
	 * @access private
	 * @var int
	 */
	private $intQtdePorPagina;
	
	/**
	 * Quantidade de Páginas por Cada Lado
	 *
	 * @access private
	 * @var int
	 */
	private $intQtdePaginasPorLado;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 */
	public function __construct($intQtdeTotal, $intOffSet = 0, $intQtdePorPagina = 10, $intQtdePaginasPorLado = 10) {
		$this->setQtdeTotal($intQtdeTotal);
		$this->setOffSet($intOffSet);
		$this->setQtdePorPagina($intQtdePorPagina);
		$this->setQtdePaginasPorLado($intQtdePaginasPorLado);
	}
	
	/**
	 * Retorna o valor de <var>$this->intQtdeTotal</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getQtdeTotal() {
		return $this->intQtdeTotal;
	}
	
	/**
	 * Define o valor de <var>$this->intQtdeTotal</var>
	 *
	 * @access public
	 * @param int $intQtdeTotal
	 * @return void
	 */
	public function setQtdeTotal($intQtdeTotal) {
		if ($intQtdeTotal < 0) $intQtdeTotal = 0;
		$this->intQtdeTotal = (int) $intQtdeTotal;
	}
	
	/**
	 * Retorna o valor de <var>$this->intOffSet</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getOffSet() {
		return $this->intOffSet;
	}
	
	/**
	 * Define o valor de <var>$this->intOffSet</var>
	 *
	 * @access public
	 * @param int $intOffSet
	 * @return void
	 */
	public function setOffSet($intOffSet) {
		if ($intOffSet < 0) $intOffSet = 0;
		$this->intOffSet = (int) $intOffSet;
	}
	
	/**
	 * Retorna o valor de <var>$this->intQtdePorPagina</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getQtdePorPagina() {
		return $this->intQtdePorPagina;
	}
	
	/**
	 * Define o valor de <var>$this->intQtdePorPagina</var>
	 *
	 * @access public
	 * @param int $intQtdePorPagina
	 * @return void
	 */
	public function setQtdePorPagina($intQtdePorPagina) {
		if ($intQtdePorPagina < 1) $intQtdePorPagina = 1;
		$this->intQtdePorPagina = (int) $intQtdePorPagina;
	}
	
	/**
	 * Retorna o valor de <var>$this->intQtdePaginasPorLado</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getQtdePaginasPorLado() {
		return $this->intQtdePaginasPorLado;
	}
	
	/**
	 * Define o valor de <var>$this->intQtdePaginasPorLado</var>
	 *
	 * @access public
	 * @param int $intQtdePaginasPorLado
	 * @return void
	 */
	public function setQtdePaginasPorLado($intQtdePaginasPorLado) {
		if ($intQtdePaginasPorLado < 1) $intQtdePaginasPorLado = 1;
		$this->intQtdePaginasPorLado = (int) $intQtdePaginasPorLado;
	}
	
	/**
	 * Método que calcula a quantidade de páginas
	 *
	 * @access public
	 * @return int
	 */
	public function getQtdePaginas() {
		return (int) ceil($this->intQtdeTotal / $this->intQtdePorPagina);
	}
	
	/**
	 * Método que calcula a página atual
	 *
	 * @access public
	 * @return int
	 */
	public function getPaginaAtual() {
		return (int) ceil($this->intOffSet / $this->intQtdePorPagina) + 1;
	}
	
	/**
	 * Método que calcula o OffSet da primeira página
	 *
	 * @access public
	 * @return int
	 */
	public function getOffSetPrimeira() {
		return 0;
	}
	
	/**
	 * Método que calcula o OffSet da próxima página
	 *
	 * @access public
	 * @return int
	 */
	public function getOffSetProxima() {
		$intOffSetProxima = (int) $this->intOffSet + $this->intQtdePorPagina;
		$intOffSetUltima  = (int) $this->getOffSetUltima();
		return ($intOffSetProxima > $intOffSetUltima) ? $intOffSetUltima : $intOffSetProxima;
	}
	
	/**
	 * Método que calcula o OffSet da página anterior
	 *
	 * @access public
	 * @return int
	 */
	public function getOffSetAnterior() {
		$intOffSetAnterior = (int) $this->intOffSet - $this->intQtdePorPagina;
		return ($intOffSetAnterior < 0) ? 0 : $intOffSetAnterior;
	}
	
	/**
	 * Método que calcula o OffSet da última página
	 *
	 * @access public
	 * @return int
	 */
	public function getOffSetUltima() {
		$intQtdePaginas = (int) $this->getQtdePaginas();
		$intOffSetUltima = ($intQtdePaginas - 1) * $this->intQtdePorPagina;
		if ($intOffSetUltima < 0) $intOffSetUltima = 0;
		return $intOffSetUltima;
	}
	
	/**
	 * Método que verifica se o OffSet está dentro da faixa de aceitação
	 *
	 * @access private
	 * @return void
	 */
	private function verificarOffSet() {
		$intOffSetUltima = (int) $this->getOffSetUltima();
		if ($this->intOffSet > $intOffSetUltima) $this->intOffSet = $intOffSetUltima;
	}
	
	/**
	 * Método que gera toda a string de paginação
	 *
	 * @access public
	 * @return string
	 */
	public function getPaginacao() {
		// Inicializando a variável
		$strConteudo = "";
		
		// Calculando variáveis da paginação
		$this->verificarOffSet();
		$intQtdePaginas = (int) $this->getQtdePaginas();
		$intPaginaAtual = (int) $this->getPaginaAtual();
		$intPaginacaoInicial = $intPaginaAtual - $this->intQtdePaginasPorLado;
		$intPaginacaoFinal   = $intPaginaAtual + $this->intQtdePaginasPorLado - 1;
		if ($intPaginacaoInicial < 1) $intPaginacaoInicial = 1;
		if ($intPaginacaoFinal   > $intQtdePaginas) $intPaginacaoFinal = $intQtdePaginas;
		
		// Primeira Página
		if ($intPaginacaoInicial > 1) $strConteudo .= '<a href="javascript:;" onclick="listar('. $this->getOffSetPrimeira() .')" class="paginacao paginacao_primeira">&lt;&lt;</a>';
		
		// Página Anterior
		if ($intPaginaAtual > 1) $strConteudo .= '<a href="javascript:;" onclick="listar('. $this->getOffSetAnterior() .')" class="paginacao paginacao_anterior">&lt;</a>';
		
		// Paginas
		for ($intPaginaI = $intPaginacaoInicial; $intPaginaI <= $intPaginacaoFinal; $intPaginaI++) {
			if ($intPaginaI == $intPaginaAtual) { // Página Atual
				$strConteudo .= '<span class="paginacao paginacao_atual">'. $intPaginaI .'</span>';
			}
			else { // Páginas Anteriores / Próximas
				$strConteudo .= '<a href="javascript:;" onclick="listar('. (($intPaginaI - 1) * $this->intQtdePorPagina) .')" class="paginacao paginacao_paginas">'. $intPaginaI .'</a>';
			}
		}
		
		// Página Próxima
		if ($intPaginaAtual < $intQtdePaginas) $strConteudo .= '<a href="javascript:;" onclick="listar('. $this->getOffSetProxima() .')" class="paginacao paginacao_proxima">&gt;</a>';
		
		// Última Página
		if ($intPaginacaoFinal < $intQtdePaginas) $strConteudo .= '<a href="javascript:;" onclick="listar('. $this->getOffSetUltima() .')" class="paginacao paginacao_ultima">&gt;&gt;</a>';
		
		return $strConteudo;
	}
}