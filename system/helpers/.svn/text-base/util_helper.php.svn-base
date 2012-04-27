<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Este arquivo contem os metodos com algumas utilidades no framework
 *
 * @package helpers
 * @subpackage util
 */

/**
 * Retorna o pathBread (caminho de pão) do framework.<br>
 * Abaixo um exemplo de como usar nas views:
 * <code>
 * A variável $path_bread é populada pelo controller do programa
 * <?=path_bread($path_bread);?>
 * </code>
 * @param string $path Caminho de pão do programa a ser informado
 * @return string
 */
function path_bread($path) {
    $path_bread = '';
    if ($path != '') {
        $path_bread .= '<div class="breadCrumb module"><ul>';
        $path_bread .= '<li><a href="' . base_url() . 'dashboard"></a></li>';
        $breadCrumbs = explode(' / ', $path);
        foreach ($breadCrumbs as $bread) {
            $path_bread .= '<li>' . trim($bread) . '</li>';
        }
        $path_bread .= '</ul><div style="clear: both;"></div>';
        $path_bread .= '</div>';
        $path_bread .= '<div style="clear: both;"></div>';
    }
    return $path_bread;
}

/**
 * Exibe uma mensagem de erro.<br/>
 * Os métodos name.showMessageWarning(), name.hideMessageWarning()
 * e name.setMessageWarning("mensagem") estão disponíveis para controle
 * via javascript
 * @param string $name Nome, identificador da mensagem
 * @param string $message Texto da mensagem
 * @param boolean $closeContent FALSE para que o conteúdo seja exposto
 * @param boolean $info TRUE para exibir um bloco de informação em vez de um de erro
 * @return string
 */
function warning($name = 'warning', $message = '', $closeContent = true, $info = false) {
    if ($info || preg_match("/^info/", $name)) {
        $state = 'ui-state-highlight';
    } else {
        $state = 'ui-state-error';
    }
    $warning = '<div id="' . $name . '" class="ui-widget" style="margin-bottom: 5px; display: none;">';
    $warning.= '	<div class="' . $state . ' ui-corner-all" style="padding: 1px;">';
    $warning.= '		<span class="ui-icon ui-icon-info" style="display: block; float: left; margin: 5px;"></span>';
    $warning.= '		<p style="margin: 6px 5px 5px 0px;">' . $message . '</p>';
    $warning.= '	</div>';
    $warning.= '</div>';
    $warning.= '<script type="text/javascript">' .
            "var $name = $('#$name');" .
            "$.extend($name, String.prototype);" .
            "$.extend($name, {toString:function(){return '$name';}});";
    if (!$closeContent) {
        $warning.= '$(document).ready(function(){' . $name . '.showMessageWarning();});';
    }
    $warning.= '</script>';
    return $warning;
}

/**
 * Coleta dados do usuário armazenados na sessão
 * @return object
 * @see getSessionCobalto()
 */
function getUsuarioSession() {
    return getSessionCobalto('usuario');
}

/**
 * Coleta dados armazenados na sessão
 * @param string $session_name Nome do item a ser selecionado da sessão
 * @return mixed
 */
function getSessionCobalto($session_name) {
    $CI = & get_instance();
    return json_decode($CI->session->userdata($session_name));
}

/**
 * Consulta um parâmetro cadastrado nos parâmetros do Cobalto
 * @param type $nome
 * @return type
 */
function getParametro($nome) {
    $CI = & get_instance();
    $CI->db->select('valor');
    $CI->db->where('nome', $nome);
    $query = $CI->db->get('parametros');
    $query = @$query->row();
    return @$query->valor;
}

/**
 * @author Carlos Eduardo Alves
 * Loga a consulta SQL como mensagem de erro nos logs do CodeIgniter.<br>
 * Deve ser chamado antes da ação (get, insert, update, delete) para que funcione.<br>
 * Exemplo de uso:<br>
 * <code>
 *  $this->db->select('campo1, campo2');
 *  $this->db->from('tabela');
 *  logSQL();
 *  $resultado = $this->db->get()->result();
 * </code>
 * <code>
 *  $this->db->set('campo', $valor);
 *  $this->db->from('tabela');
 *  logSQL('insert');
 *  $resultado = $this->db->insert();
 * </code>
 * <code>
 *  $this->db->set('campo', $valor);
 *  logSQL('insert', 'tabela');
 *  $resultado = $this->db->insert('tabela');
 * </code>
 * @since 16/02/2011
 * @param string $type Tipos válidos: select, insert, update, delete
 * @param string $table Tabela de ação (ignorado no "select")
 * @param string $description Descrição do log (útil para identificação)
 */
function logSQL($type = "select", $table = '', $description = '') {
    $CI = & get_instance();
    if ($table == '') {
        if (!isset($CI->db->ar_from[0])) {
            log_message('error', "NO TABLE TO LOG QUERY!!!");
            return;
        } else {
            $table = $CI->db->ar_from[0];
        }
    }
    if ($description == '') {
        $description = $type;
    }
    switch (strtoupper($type)) {
        case 'SELECT':
            $sql = $CI->db->_compile_select();
            break;
        case 'INSERT':
            if (count($CI->db->ar_set) == 0) {
                log_message('error', "NO ITENS SET TO LOG QUERY!!!");
                return;
            }
            $sql = $CI->db->_insert($CI->db->_protect_identifiers($table, TRUE, NULL, FALSE), array_keys($CI->db->ar_set), array_values($CI->db->ar_set));
            break;
        case 'UPDATE':
            if (count($CI->db->ar_set) == 0) {
                log_message('error', "NO ITENS SET TO LOG QUERY!!!");
                return;
            }
            $sql = $CI->db->_update($CI->db->_protect_identifiers($table, TRUE, NULL, FALSE), $CI->db->ar_set, $CI->db->ar_where, $CI->db->ar_orderby, $CI->db->ar_limit);
            break;
        case 'DELETE':
            if (count($CI->db->ar_where) == 0 && count($CI->db->ar_wherein) == 0 && count($CI->db->ar_like) == 0) {
                log_message('error', "NO CLAUSES TO LOG QUERY!!!");
                return;
            }
            $sql = $CI->db->_delete($table, $CI->db->ar_where, $CI->db->ar_like, $CI->db->ar_limit);
            break;
        default:
            break;
    }
    logVar($sql, $type);
}

/**
 * @author Carlos Eduardo Alves
 * Loga a consulta SQL como mensagem de erro nos logs do CodeIgniter.<br>
 * Deve ser chamado após a ação (get, insert, update ou delete) para que funcione.<br>
 * Exemplo de uso:<br>
 * <code>
 *  $this->db->select('coluna1, coluna2');
 *  $this->db->from('tabela');
 *  $resultado = $this->db->get()->row();
 *  logLastSQL();
 * </code>
 * <code>
 *  $this->db->set('coluna', $valor);
 *  $this->db->from('tabela');
 *  $resultado = $this->db->insert();
 *  logLastSQL();
 * </code>
 * @since 15/02/2011
 * @param integer $reverse_index O índice reverso da SQL
 * @param string $description Uma descrição (opcional) para embutir no log
 * @see logSQL()
 */
function logLastSQL($reverse_index = 1, $description = "LAST SQL") {
    $CI = & get_instance();
    $index = count($CI->db->queries);
    if ($reverse_index <= $index) {
        $last = $CI->db->queries[$index - $reverse_index];
    } else {
        $last = "ERROR\nReverse_index ($reverse_index) is greather than queries index ($index)!\n"
                . "In logLastSQL(" . implode(", ", func_get_args()) . ")";
    }
    logVar($last, $description);
}

/**
 * @author Carlos Eduardo Alves
 * Loga um dump da variável passada, como mensagem de erro nos logs do CodeIgniter.<br>
 * Aceita variáveis de todos os tipos, incluindo arrays e objetos.<br>
 * Exemplo de uso:<br>
 * <code>
 *  logVar($minhaVariavel);
 * </code>
 * @since 15/02/2011
 * @param mixed $var A variável a ser logada, será exportada para um formato amigável caso não seja uma string
 * @param string $description Uma descrição (opcional) para embutir no log
 */
function logVar($var, $description = "VAR") {
    if (!is_string($var)) {
        $var = var_export($var, TRUE);
        $var = str_replace(" => \n", " => ", $var);
    }
    log_message('error', str_replace("\n", "\n    ", "$description:\n$var"));
}

/**
 * Retira os acentos da string passada
 * @param string $txt O texto com acentos
 * @return string O texto sem acentos
 */
function retira_acentos($txt) {
    $a = array(
        '/[ÂÀÁÄÃ]/u' => 'A',
        '/[âãàáä]/u' => 'a',
        '/[ÊÈÉË]/u' => 'E',
        '/[êèéë]/u' => 'e',
        '/[ÎÍÌÏ]/u' => 'I',
        '/[îíìï]/u' => 'i',
        '/[ÔÕÒÓÖ]/u' => 'O',
        '/[ôõòóö]/u' => 'o',
        '/[ÛÙÚÜ]/u' => 'U',
        '/[ûúùü]/u' => 'u',
        '/ç/u' => 'c',
        '/Ç/u' => 'C'
    );
    return preg_replace(array_keys($a), array_values($a), $txt);
}