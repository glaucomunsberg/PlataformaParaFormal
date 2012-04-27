<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	class JqGridPanel {

		protected $_id = '';
		protected $_gridParameters = array();
		protected $_colNames = array();
		protected $_colModel = array();

		function clearParametersGrid(){
			$this->_id = '';
			$this->_gridParameters = array();
			$this->_colModel = array();
			$this->_colNames = array();	
		}

		function setGridParameters($parameters){
			$this->_gridParameters = $parameters;
		}

		function getGridParameters(){
			$this->_gridParameters['colNames'] = $this->getColNames();			
		  	$this->_gridParameters['colModel'] = $this->getColModel();
			return $this->_gridParameters;
		}

		function setColumn($column){
			array_push($this->_colNames, $column['colName']);						
			array_push($this->_colModel, $column);
		}

		function getColNames(){
			return json_encode($this->_colNames);
		}

		function getColModel(){
			return json_encode($this->_colModel);
		}

		function setId($id){
			$this->_id = $id;
		}

		function getId(){
			return $this->_id;
		}

	}