<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tabpanel {
	
	
	protected $_id = 0;	
	protected $_height = '';
	protected $_tabName = '';
	protected $_idChild = 0;
	protected $_tabNameChild = '';
	
	function limpaTabpanel(){
		$this->_id = 0;
		$this->_height = '';
		$this->_tabName = '';
	}

	function limpaTabPanelChild(){
		$this->_idChild = 0;
		$this->_tabNameChild = '';
	}
	
	function setHeight($height) {
		$this->_height = $height;
	}
	
	function getHeight() {
		return $this->_height;
	}
	
	function setTabName($tabName) {
		$this->_tabName = $tabName;
	}
	
	function getTabName() {
		return $this->_tabName;
	}	
	
	function getId() {
		return $this->_id++;
	}
	
	function setTabNamechild($tabNameChild){
		$this->_tabNameChild = $tabNameChild;		
	}
	
	function getTabNameChild(){
		return $this->_tabNameChild;
	}
	
	function getIdChild(){
		return $this->_idChild++;		
	}

}