<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Este arquivo contem os metodos com algumas utilidades no framework
	 * 
	 * @package helpers
	 * @subpackage util
	 */
	
	/**
	 * Retorna o pathBread do framework
	 * Abaixo um exemplo de como usar nas views:
	 * <code>
	 * A variavel $path_bread eh populada pelo controller do programa
	 * <?=path_bread($path_bread);?>
	 * </code>
	 * @return string
	 * @param string $path Caminho de pao do programa a ser informado
	 */
	function path_bread($path){
		$path_bread = '';
		if($path != ''){
			$path_bread .= '<div class="breadCrumb module"><ul>';
			$path_bread .= '<li><a href="'.base_url().'dashboard"></a></li>';
			$breadCrumbs = explode(' / ', $path);
			foreach($breadCrumbs as $bread) {
				$path_bread .= '<li>'.trim($bread).'</li>';
			}
			$path_bread .= '</ul><div style="clear: both;"></div>';
			$path_bread .= '</div>';
			$path_bread .= '<div style="clear: both;"></div>';
		}
		return $path_bread;
	}

	function warning($name='warning', $message='', $closeContent=true){
		$warning = '';
		$warning.= '<div id="'.$name.'" class="ui-widget" style="margin-bottom: 5px; display: none;'.($closeContent ? 'none' : 'block').';">';
		$warning.= '	<div class="ui-state-error ui-corner-all" style="padding: 1px;">';
		$warning.= '		<span class="ui-icon ui-icon-info" style="display: block; float: left; margin: 5px;"></span>';
		$warning.= '		<p style="margin: 6px 5px 5px 0px;">'.$message.'</p>';
		$warning.= '	</div>';
		$warning.= '</div>';
		$warning.= '<script type=\'text/javascript\'>';
		$warning.= '	var '.$name.' = \''.$name.'\';';
		if(!$closeContent){
			$warning.= '	$(document).ready(function(){';
			$warning.= 	  		$name.'.showMessageWarning();';
			$warning.= '	});';	
		}		
		$warning.= '</script>';
		return $warning;
	}

	function getUsuarioSession(){
		$CI =& get_instance();
		return json_decode($CI->session->userdata('usuario'));
	}

	function getParametro($nome){
		$CI =& get_instance();

		$CI->db->select('valor');
		$CI->db->where('nome', $nome);
		$query = $CI->db->get('parametros')->row();
		return @$query->valor;			
	}
	
	function getSessionCobalto($session_name){
		$CI =& get_instance();
		return json_decode($CI->session->userdata($session_name));
	}