<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Helper responsavel por manipular as tabs do sistema
	 * @package helpers
	 * @subpackage tabs
	 * @author rsantos
	 */
	
	/**
	 * Abre o painel onde será incluida as tabs
	 * @param String $name
	 */
	function begin_TabPanel($name='tab'){
		$CI =& get_instance();
		$CI->tabpanel->setTabName($name);
		$tabName = $CI->tabpanel->getTabName();
		$tabPanel = '';
		$tabPanel.= '<div id="'.$tabName.'" class="tabs">';
		$tabPanel.= '	<ul></ul>';
		return $tabPanel;
	}

	/**
	 * @deprecated version - 02/12/2011
	 */
	function begin_TabPanelChild($name='tabChild'){
		$CI =& get_instance();
		$CI->tabpanel->setTabNamechild($name);
		$tabNameChild = $CI->tabpanel->getTabNameChild();
		$tabPanelChild = '';
		$tabPanelChild.= '<div id="'.$tabNameChild.'" class="tabs">';		
		$tabPanelChild.= '	<ul></ul>';
		return $tabPanelChild;
	}
	
	function begin_Tab($titulo, $url='') {
		$CI =& get_instance();		
		$id = $CI->tabpanel->getId();
		$tabName = $CI->tabpanel->getTabName();

		$tab = '';
		$tab.= '<div id="'.$tabName.'-'.$id.'" class="ui-widget '.$tabName.'">';
		if($url == '')
			$tab.= '	<ul><li class="label'.$tabName.'"><a href="#'.$tabName.'-'.$id.'" title="'.$tabName.'-'.$id.'">'.$titulo.'</a></li></ul>';
		else
			$tab.= '	<ul><li class="label'.$tabName.'"><a href="'.$url.'" title="'.$tabName.'-'.$id.'">'.$titulo.'</a></li></ul>';

		return $tab;
	}
	
	/**
	 * @deprecated version - 02/12/2011
	 */
	function begin_TabChild($titulo, $url='') {
		$CI =& get_instance();
		$idChild = $CI->tabpanel->getIdChild();		
		$tabNameChild = $CI->tabpanel->getTabNameChild();
		
		$tabChild = '';
		$tabChild.= '<div id="'.$tabNameChild.'-'.$idChild.'" class="ui-widget '.$tabNameChild.'">';
		if($url == '')
			$tabChild.= '	<ul><li class="label'.$tabNameChild.'"><a href="#'.$tabNameChild.'-'.$idChild.'" title="'.$tabNameChild.'-'.$idChild.'">'.$titulo.'</a></li></ul>';
		else
			$tabChild.= '	<ul><li class="label'.$tabNameChild.'"><a href="'.$url.'" title="'.$tabNameChild.'-'.$idChild.'">'.$titulo.'</a></li></ul>';
			
		return $tabChild;
	}
		
	function end_Tab(){
		$tab = '';
		$tab .= '<br /></div>';
		return $tab;
	}
	
	/**
	 * @deprecated version - 02/12/2011
	 */
	function end_TabChild(){
		$tabChild = '';
		$tabChild .= '<br /></div>';
		return $tabChild;
	}
	
	function end_TabPanel(){
		$tabPanel = '';
		$tabPanel .= '</div>';
		return $tabPanel;
	}
	
	/**
	 * @deprecated version - 02/12/2011
	 */
	function end_TabPanelChild(){
		$tabPanelChild = '';
		$tabPanelChild .= '</div>';
		return $tabPanelChild;
	}