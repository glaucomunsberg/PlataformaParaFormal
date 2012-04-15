<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Ajax {
		
		protected $_data = array();
		protected $_parametersJqGrid = '';

		public function ajaxMessage($key,$value){	
			$this->_data[$key] = array ("message" => $value);
		}	
	    
	    public function addAjaxData($key,$value){    	
	    	$this->_data[$key] = $value;
	    }     
	    
	    public function addAjaxCombo($data){    	
	    	$returnJSON = array();

	    	if(count($data)>0 && !empty($data)){
				foreach ($data as $arrayObject){
					$i = 0;
					foreach($arrayObject as $key => $value){
						if ($i==0){
							$optionValue = $value;
							$i++;
						}else{
							$optionText = $value;
							$i=0;
						}
					}
					$value = (string) $optionValue;
					$optionName = (string) $optionText;

					array_push($returnJSON, array ('value' => $value, 'optionName' => $optionName));
				}
			}

	    	$this->_data['combo'] = $returnJSON;
	    }
	
		public function existsData() {
			if (count($this->_data) == 0){
				return false;
			} else {
				return true;
			}
		}
		
		public function returnAjax() {
			echo json_encode($this->_data);
		}
		
		public function returnGrid($data) {
			echo $_GET['callback'].'('.json_encode($data).')';
		}

		public function returnJqGrid($data){
			echo json_encode($data);
		}		
		
		public function setStartLimitJqGrid($parametersJqGrid, $count, $noPagination=false){
			$page  = $parametersJqGrid['page'];
			if($noPagination)
				$parametersJqGrid['rows'] = $count;
			
			$limit = $parametersJqGrid['rows'];
			$sidx  = $parametersJqGrid['sidx'];
			$sord  = $parametersJqGrid['sord'];

			$totalrows = isset($parametersJqGrid['totalrows']) ? $parametersJqGrid['totalrows']: false;
			if($totalrows)
				$limit = $totalrows; 

			if($count > 0)
				$total_pages = ceil($count/$limit);
			else
				$total_pages = 0;

			if($page > $total_pages)
				$page = $total_pages;

			$start = $limit*$page - $limit;
			if($start<0)
				$start = 0;

			$this->_parametersJqGrid->page = $page;
			$this->_parametersJqGrid->total = $total_pages;
			$this->_parametersJqGrid->records = $count;
			$this->_parametersJqGrid->sortField = $sidx;
			$this->_parametersJqGrid->sortDirection = $sord;
			$this->_parametersJqGrid->start = $start;
			$this->_parametersJqGrid->limit = $limit;
			return $this->_parametersJqGrid;
		}

		public function getParametersJqGrid(){
			return $this->_parametersJqGrid;
		}

		function setParametersJqGrid($parametersJqGrid){
			$this->_parametersJqGrid->page = $parametersJqGrid['page'];
			$this->_parametersJqGrid->sortField = $parametersJqGrid['sidx'];
			$this->_parametersJqGrid->sortDirection = $parametersJqGrid['sord'];
			$this->_parametersJqGrid->limit = $parametersJqGrid['rows'];
			return $this->_parametersJqGrid;
		}

	}