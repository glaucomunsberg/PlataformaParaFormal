<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Este arquivo contem os métodos que ajudam na utilização de mensagem internacionalidas no framework
 * @package helpers
 * @subpackage lang
 */

/**
 * Retorna o valor da chave do arquivo de internacionalização.<br>
 * Abaixo um exemplo de uso:
 * <code>
 * lang('registroGravado');
 * </code>
 * @param string $key Chave do array que será buscado no arquivo de internacionalização
 * @return string
 */
function lang($key) {
    $CI = & get_instance();
    $lang = $CI->lang->line($key);
    if (empty($lang)) {
        //logVar("The key $key is undefinned, please use:\n\$lang['$key'] = '';", "LANGUAGE FAIL");
        return $key;
    } else {
        return $lang;
    }
}
