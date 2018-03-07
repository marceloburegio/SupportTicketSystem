<?php
/**
 * Exceção genérica do Repositório
 * Será levantada caso ocorra qualquer erro no Repositório
 *
 * @author Marcelo Burégio
 * @subpackage conexao
 * @version 1.0
 * @since 17/09/2008 09:01:15
 */
class RepositorioException extends Exception {
	public function __construct($strMensagem) {
		parent::__construct("RepositorioException: {$strMensagem}");
	}
}