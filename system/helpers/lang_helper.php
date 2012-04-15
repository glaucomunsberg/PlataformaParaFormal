<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Este arquivo contem os metodos que ajudam na utilizacao de mensagem internacionalidas no framework
	 * 
	 * @package helpers
	 * @subpackage lang
	 */
	
	/**
	 * Retorna o valor da chave do arquivo de intrenacionalizacao
	 * Abaixo um exemplo de uso:
	 * <code>
	 * lang('registroGravado');
	 * </code>
	 * @access public
	 * @return string
	 * @param string $key Chave do array que sera buscado no arquivo de internacionalizacao
	 */
	function lang($key){
		$CI =& get_instance();
		return ($CI->lang->line($key) == '' ? $key : $CI->lang->line($key));
	}