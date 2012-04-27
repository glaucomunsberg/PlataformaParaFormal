<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	class GridPanel {
		
		protected $_id = '';
		protected $_url = '';
		protected $_fields = array();
		protected $_columns = array();
		protected $_dataIndexAutoExpandColumn = '';
		protected $_height = '';
		protected $_width = '';
		protected $_autoLoad = true;
		protected $_paginador = true;
		protected $_multiSelecao = false;
		protected $_moveRow = false;
		protected $_groupingStore = false;
		protected $_groupField = '';
		protected $_enableMenu = true;
		protected $_enableColumnMove = true;
		protected $_startCollapsed = true;
		protected $_expander = true;
		protected $_checkedAll = false;
		protected $_remoteSort = false;
		protected $_groupTextTemplate = '';
		
		function limpaGrid(){
			$this->_id = '';
			$this->_url = '';
			$this->_fields = array();
			$this->_columns = array();
			$this->_dataIndexAutoExpandColumn = '';
			$this->_height = '';
			$this->_width = '';
			$this->_autoLoad = true;
			$this->_paginador = true;
			$this->_multiSelecao = false;
			$this->_moveRow = false;
			$this->_expander = false;
			$this->_checkedAll = false;
		}
		
		function addColumn($dataIndex, $name, $width, $sortable, $align, $autoExpandColumn, $editable, $isCheckBox, $isGroupField, $isHidden, $renderer){
			$column = array();
			$column['id'] = $dataIndex;
			$column['header'] = $name;
			$column['width'] = $width;
			$column['sortable'] = $sortable;
			$column['dataIndex'] = $dataIndex;
			$column['align'] = $align;
			$column['editor'] = $editable;
			$column['isCheckBox'] = $isCheckBox;
			$column['isHidden'] = $isHidden;
			$column['renderer'] = $renderer;
			if($isGroupField)
				$this->setGroupField($dataIndex);
	
			array_push($this->_columns, $column);
		}
		
		function getColumns(){
			$count = 0;
			if($this->getMultiSelecao())
				$returnJSON = '[sm,';
				
			if($this->getExpander())
				$returnJSON = '[expander,';
			
			if(!$this->getMultiSelecao() && !$this->getExpander())
				$returnJSON = '[';
	
			foreach($this->_columns as $column){
				if($count > 0)
					$returnJSON .= ',';
	
				if(is_array($column['editor'])){
					$returnJSON .= '{';
					$returnJSON .= 'id:"'.$column['id'].'",';
					$returnJSON .= 'header:"'.$column['header'].'",';
					$returnJSON .= 'width:'.$column['width'].',';
					if($column['isHidden'])
						$returnJSON .= 'hidden: true,';
					
					if($column['sortable'])
						$returnJSON .= 'sortable:'.$column['sortable'].',';	
					else
						$returnJSON .= 'menuDisabled: true,';
					
					$returnJSON .= 'dataIndex:"'.$column['dataIndex'].'",';
					$returnJSON .= 'align:"'.$column['align'].'"';
					if(is_array($column['editor'])){
						switch($column['editor']['editor']){
							case 'number':
								$returnJSON .= ', editor: new fm.NumberField({allowBlank: true, decimalPrecision: '.$column['editor']['decimalPrecision'].', decimalSeparator: \''.$column['editor']['decimalSeparator'].'\', maxValue: '.$column['editor']['maxValue'].', minValue: '.$column['editor']['minValue'].'})';
								break;
							case 'text':
								$returnJSON .= ', editor: new fm.TextField({allowBlank: true, maxLength: '.$column['editor']['maxLength'].'})';
								break;
						}
					}
					$returnJSON .= '}';
				}else{
					$returnJSON .= '{';
					$returnJSON .= 'id:"'.$column['id'].'",';
					$returnJSON .= 'header:"'.$column['header'].'",';
					$returnJSON .= 'width:'.$column['width'].',';				
					if($column['isHidden'])					
							$returnJSON .= 'hidden: true,';
					
					if($column['sortable'])
						$returnJSON .= 'sortable:'.$column['sortable'].',';	
						
					if($column['renderer'] != '')
						$returnJSON .= 'renderer:'.$column['renderer'].',';	
					
					$returnJSON .= 'dataIndex:"'.$column['dataIndex'].'",';
					$returnJSON .= 'align:"'.$column['align'].'"';
					$returnJSON .= '}';
				}
				$count++;
			}
			$returnJSON .= ']';
			return $returnJSON;
		}
		
		function setId($id){
			$this->_id = $id;
		}
		
		function getId(){
			return $this->_id;
		}
			
		function setURL($url){
			$this->_url = $url;
		}
		
		function getURL(){
			return $this->_url;
		}	
		
		function addField($dataIndex){
			array_push($this->_fields, array('name' => $dataIndex));
		}
		
		function getFields(){
			return json_encode($this->_fields);
		}
		
		function setAutoExpandColumn($dataIndex){
			$this->_dataIndexAutoExpandColumn = $dataIndex;
		}
		
		function getAutoExpandColumn(){
			return $this->_dataIndexAutoExpandColumn;
		}
		
		function setHeight($height){
			$this->_height = $height;
		}
		
		function getHeight(){
			return $this->_height;
		}
		
		function setWidth($width){
			$this->_width = $width;
		}
		
		function getWidth(){
			return $this->_width;
		}
		
		function setAutoLoad($autoLoad){
			$this->_autoLoad = $autoLoad;
		}
		
		function getAutoLoad(){
			return $this->_autoLoad;
		}
		
		function setPaginador($paginador){
			$this->_paginador = $paginador;
		}
		
		function getPaginador(){
			return $this->_paginador;
		}
		
		function setMultiSelecao($multiSelecao){
			$this->_multiSelecao = $multiSelecao;
		}
		
		function getMultiSelecao(){
			return $this->_multiSelecao;
		}
		
		function setMoveRow($moveRow){
			$this->_moveRow = $moveRow;
		}
		
		function getMoveRow(){
			return $this->_moveRow;
		}
		
		function isGroupingStore(){
			return $this->_groupingStore;
		}
		
		function setGroupingStore($groupingStore){
			$this->_groupingStore = $groupingStore;
		}
		
		function getGroupField(){
			return $this->_groupField;
		}
		
		function setGroupField($groupField){
			$this->_groupField = $groupField;
		}
		
		function setEnableMenu($enableMenu){
			$this->_enableMenu = $enableMenu;
		}
		
		function getEnableMenu(){
			return $this->_enableMenu;
		}
		
		function setEnableColumnMove($enableColumnMove){
			$this->_enableColumnMove = $enableColumnMove;
		}
		
		function getEnableColumnMove(){
			return $this->_enableColumnMove;
		}
		
		function setStartCollapsed($startCollapsed){
			$this->_startCollapsed = $startCollapsed;
		}
		
		function getStartCollapsed(){
			return $this->_startCollapsed;
		}
		
		function setExpander($expander){
			$this->_expander = $expander;
		}
		
		function getExpander(){
			return $this->_expander;
		}
		
		function setCheckedAll($checkedAll){
			$this->_checkedAll = $checkedAll;
		}
		
		function getCheckedAll(){
			return $this->_checkedAll;
		}
		
		function setRemoteSort($remoteSort){
			$this->_remoteSort = $remoteSort;
		}
		
		function getRemoteSort(){
			return $this->_remoteSort;
		}
		
		function setGroupTextTemplate($groupTextTemplate){
			$this->_groupTextTemplate = $groupTextTemplate;
		}
		
		function getGroupTextTemplate(){
			return $this->_groupTextTemplate;		
		}
		
	}
?>