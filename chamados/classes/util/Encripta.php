<?php
/**
 * Classe que codifica um array de variáveis em um Hash String
 *  Esta clase foi melhorada para o uso de dados binários
 *  Com essa modificação os índices dos arrays criptografados serão perdidos
 *
 * @author Marcelo Burégio
 * @subpackage util
 * @version 3.0
 * @since 06/10/2008 17:45
 */
class Encripta {
	
	/**
	 * Método construtor da classe
	 * 
	 * @access private
	 */
	private function __construct() {
	}
	
	/**
	 * Método que converte um array em uma string codificada
	 *
	 * @access public
	 * @param mixed $mixVars
	 * @param string $strId
	 * @param int $intExpire=0
	 * @param boolean $bolIpSecurity=false
	 * @return boolean
	 */
	public static function encode($mixVars, $strId, $intExpire=0, $bolIpSecurity=false) {
		/**
		 * FORMATO
		 * -------------------
		 * HASH|TIME|EXPIRE|VARS
		 * 16 bytes
		 * 4  bytes
		 * 4  bytes
		 * X  bytes (X = Bytes Variáveis - Serializados com GZIP)
		 */
		$intTime = time();
		$strIp   = ($bolIpSecurity) ? $_SERVER['REMOTE_ADDR'] : "";
		
		// Serializando o array de forma mais econômica
		$strVars = "";
		if (is_array($mixVars)) {
			foreach ($mixVars as $strVar) {
				if (!empty($strVars)) $strVars .= chr(1);
				$strVars .= serialize($strVar);
			}
		}
		else $strVars = serialize($mixVars);
		
		// Comprime as variáveis usando o GZip DEFLATE
		$binVars = gzdeflate($strVars);
		
		// Montando o hash de verificação
		$strHash = '&*$:#@$Sotl67db9*%$@'. $strVars .'r :dtq '. $intExpire .'Dy9:'. $strId .'v429: '. $intTime .' 641a4'. $strIp .'64b';
		
		// Criando o hash completo (HASH|TIME|EXPIRE|VARS)
		return base64_encode(md5($strHash, true) . pack("NN", $intTime, $intExpire) . $binVars);
	}
	
	/**
	 * Método que converte uma string codificada no array que a gerou
	 * Esse método pode retornar false caso não consiga converter
	 *
	 * @access public
	 * @param string $strHash
	 * @param string $strId
	 * @param boolean $bolIpSecurity=false
	 * @return boolean
	 */
	public static function decode($strHash, $strId, $bolIpSecurity=false) {
		
		// Decodificando a string para binário
		$binHash = base64_decode($strHash);
		
		// Verificando o tamanho mínimo do hash
		if (strlen($binHash) > 24) {
			
			// Separando os elementos do hash
			$arrHash = unpack("H32md5/Ntime/Nexpire/A*vars", $binHash);
			
			// Descomprimindo as variáveis usando o GZip INFLATE
			$strVars   = @gzinflate($arrHash["vars"]);
			$intExpire = $arrHash["expire"];
			$intTime   = $arrHash["time"];
			$strMd5    = $arrHash["md5"];
			$strIp     = ($bolIpSecurity) ? $_SERVER['REMOTE_ADDR'] : "";
			
			// Montando o hash de verificação
			$strHash = '&*$:#@$Sotl67db9*%$@'. $strVars .'r :dtq '. $intExpire .'Dy9:'. $strId .'v429: '. $intTime .' 641a4'. $strIp .'64b';
			
			// Calculando o md5 novamente para validação da integridade da informação
			if (md5($strHash) == $strMd5) {
				
				// Verificando se o tempo de expiração foi atingido
				if ($intExpire != 0 && ($intTime + $intExpire) < time()) return false;
				
				// Verificando se é um array com o separador
				if (strpos($strVars, chr(1)) !== false) {
					
					// Deserializando o array
					$mixVars = array();
					$arrVars = explode(chr(1), $strVars);
					foreach ($arrVars as $strVar) $mixVars[] = unserialize($strVar);
				}
				else $mixVars = unserialize($strVars);
				
				// Retornando a variável
				return $mixVars;
			}
		}
		return false;
	}
	
}