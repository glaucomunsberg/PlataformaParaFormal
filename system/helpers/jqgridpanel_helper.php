<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Helper responsavel por manipular a grid do sistema
	 * @package helpers
	 * @subpackage grid
	 */

	/**
	 * @access public
	 * @param string paramname
	 * @param string paramname
	 * @param integer paramname
	 * @param string paramname
	 * @param array paramname
	 */
	function begin_JqGridPanel($id='grid', $height, $width=0, $url='', $parameters=array()){
		$jqGridPanel = '';
		$jqGridPanel.= '<table id="'.$id.'"></table>';
		$jqGridPanel.= '<div id="'.$id.'Pager"></div>';
		$CI =& get_instance();
		$CI->jqgridpanel->setId($id);

		$parameters['height'] = ($height == '' ? 300 : $height);
		$parameters['jsonReader'] = array('repeatitems' => false, 'id' => 0);
		$functionOnSelectRow = "##function(rowid){";
		$functionOnSelectRow.= "try{".$id."_onSelectRow(rowid);";
		$functionOnSelectRow.= "}catch(err){}";
		$functionOnSelectRow.= "}##";
		$parameters['onSelectRow'] = $functionOnSelectRow;
		$functionCellSelect = "##function(rowid, iRow, iCol, e){";
		$functionCellSelect.= "if(iRow != 0){";
		$functionCellSelect.= '$("#'.$id.'").resetSelection();';
		$functionCellSelect.= '$("#'.$id.'").setSelection(rowid);';
		$functionCellSelect.= "try{".$id."_click(rowid);";
		$functionCellSelect.= "}catch(err){}}";
		$functionCellSelect.= "}##";
		if(isParameterJqGrid('cellEdit', $parameters)){		
			if(!$parameters['cellEdit'])
				$parameters['onCellSelect'] = $functionCellSelect;
		}else{
			$parameters['onCellSelect'] = $functionCellSelect;
		}

		$functionDblClick = "##function(rowid, iRow, iCol, e){";
		$functionDblClick.= "if(iRow != 0){";
		$functionDblClick.= '$("#'.$id.'").resetSelection();';
		$functionDblClick.= '$("#'.$id.'").setSelection(rowid);';
		$functionDblClick.= "try{".$id."_dblClick(rowid);";
		$functionDblClick.= "}catch(err){}}";
		$functionDblClick.= "}##";
		$parameters['ondblClickRow'] = $functionDblClick;
		$functionLoadBeforeSend = "##function(xhr){";
		$functionLoadBeforeSend.= 'try{'.$id.'_loadBeforeSend();}catch(err){}';
		$functionLoadBeforeSend.= "}##";
		$parameters['loadBeforeSend'] = $functionLoadBeforeSend;
		$functionLoadComplete = "##function(data){";
		$functionLoadComplete.= 'if($("#'.$id.'").jqGrid(\'getGridParam\',\'datatype\') != \'local\'){';
		$functionLoadComplete.= 'try{'.$id.'_loadComplete();}catch(err){}';
		$functionLoadComplete.= "}}##";
		$parameters['loadComplete'] = $functionLoadComplete;
		$functionGridComplete = "##function(data){";
		if(isParameterJqGrid('moveRows', $parameters))
			if($parameters['moveRows']){
				$functionGridComplete.= '$("#'.$id.'").tableDnD({scrollAmount:0,';
				$functionGridComplete.= 'onDragStart: function(table, row) {';
				$functionGridComplete.= '$.cookie("'.$id.'", $.tableDnD.serialize());},';
				$functionGridComplete.= 'onDrop: function(table, row) {';
				$functionGridComplete.= 'if($.tableDnD.serialize() != $.cookie("'.$id.'"))';
				$functionGridComplete.= $id.'_moveRowStop(table.tBodies[0].rows);';
				$functionGridComplete.= '}});';
			}
		$functionGridComplete.= 'generateTabs();';
		$functionGridComplete.= 'try{'.$id.'_init();}catch(err){}';
		$functionGridComplete.= "}##";
		$parameters['gridComplete'] = $functionGridComplete;
		$functionLoadError = "##function(xhr,st,err) {";
		$functionLoadError.= 'var url = $("#'.$id.'").jqGrid(\'getGridParam\',\'url\');';
		$functionLoadError.= "messageErrorBox(\"Grid: $id; URL: \"+url+\"; Type: \"+st+\"; Response: \"+ xhr.status + \" \"+xhr.statusText);";
		$functionLoadError.= "}##";
		$parameters['loadError'] = $functionLoadError;
		$parameters['url'] = $url;

		if(is_array($parameters)){
			if(isParameterJqGrid('pager', $parameters))
				if($parameters['pager']){
					$parameters['pager'] = 	'#'.$id.'Pager';
					if(!isParameterJqGrid('rowNum', $parameters))
						$parameters['rowNum'] = 10;
				}else
					$parameters['rowNum'] = -1;

			if(!isParameterJqGrid('rownumbers', $parameters))
				$parameters['rownumbers'] = false;
			if(!isParameterJqGrid('viewrecords', $parameters))
				$parameters['viewrecords'] = true;
			if(!isParameterJqGrid('datatype', $parameters))
				$parameters['datatype'] = 'json';
			if(!isParameterJqGrid('sortorder', $parameters))
				$parameters['sortorder'] = 'asc';
			if(!isParameterJqGrid('autowidth', $parameters))				
				$parameters['width'] = $width;
			if(!isParameterJqGrid('multiselect', $parameters))
				$parameters['multiselect'] = true;
			if(!isParameterJqGrid('forceFit', $parameters))
				$parameters['forceFit'] = true;
			if(!isParameterJqGrid('headertitles', $parameters))
				$parameters['headertitles'] = true;
			if(isParameterJqGrid('autoload', $parameters))
				if(!$parameters['autoload'])
					$parameters['datatype'] = 'local';

		}		
		
		$CI->jqgridpanel->setGridParameters($parameters);
		return $jqGridPanel;
	}

	/**
	 * @access public
	 * @return void
	 */
	function end_JqGridPanel(){
		$CI =& get_instance();
		$parameters = $CI->jqgridpanel->getGridParameters();
		$jqGridPanel = '';
		$jqGridPanel.= '<script>';
		$jqGridPanel.='var '.$CI->jqgridpanel->getId().' =  \''.$CI->jqgridpanel->getId().'\';';
		$jqGridPanel.= '$(document).ready(function (){';
		$jqGridPanel.= '	$("#'.$CI->jqgridpanel->getId().'").jqGrid(';
		$jqGridPanel.= removeCharacteresIlegals(json_encode($parameters));		
		$jqGridPanel.= '	);';
		$jqGridPanel.= '	$("#'.$CI->jqgridpanel->getId().'").setGridParam({datatype: \'json\'});';
		$jqGridPanel.= '	$("#'.$CI->jqgridpanel->getId().'").setGridParam({autoload: true});';		
		
		if(isParameterJqGrid('search', $parameters))
			if($parameters['search']){
				if(isParameterJqGrid('toppager', $parameters))
					if($parameters['toppager'])
						$jqGridPanel.= '	$("#'.$CI->jqgridpanel->getId().'").jqGrid(\'navGrid\', \'#'.$CI->jqgridpanel->getId().'_toppager\', {del:false,add:false,edit:false}, {}, {}, {}, {sopt:[\'cn\']});';

				$jqGridPanel.= '	$("#'.$CI->jqgridpanel->getId().'").jqGrid(\'navGrid\', \'#'.$CI->jqgridpanel->getId().'Pager\', {del:false,add:false,edit:false}, {}, {}, {}, {sopt:[\'cn\']});';								
			}				

		$jqGridPanel.= '});';
		$jqGridPanel.= '</script>';
		
		$CI->jqgridpanel->clearParametersGrid();
		return $jqGridPanel;
	}

	/**
	 * @access private
	 * @return string description
	 */
	function removeCharacteresIlegals($parametersJqGrid){					
		$removeCharacteres = str_replace('\\', '', $parametersJqGrid);
		$removeCharacteres = str_replace('"[', '[', $removeCharacteres);
		$removeCharacteres = str_replace(']"', ']', $removeCharacteres);
		$removeCharacteres = str_replace('"##', '', $removeCharacteres);
		$removeCharacteres = str_replace('##"', '', $removeCharacteres);	
		$removeCharacteres = str_replace('u00e0', 'à', $removeCharacteres);	
		$removeCharacteres = str_replace('u00e1', 'á', $removeCharacteres);		
		$removeCharacteres = str_replace('u00e2', 'â', $removeCharacteres);		
		$removeCharacteres = str_replace('u00e3', 'ã', $removeCharacteres);
		$removeCharacteres = str_replace('u00e4', 'ä', $removeCharacteres);
		$removeCharacteres = str_replace('u00c0', 'À', $removeCharacteres);
		$removeCharacteres = str_replace('u00c1', 'Á', $removeCharacteres);
		$removeCharacteres = str_replace('u00c2', 'Â', $removeCharacteres);
		$removeCharacteres = str_replace('u00c3', 'Ã', $removeCharacteres);
		$removeCharacteres = str_replace('u00c4', 'Ä', $removeCharacteres);
		$removeCharacteres = str_replace('u00e9', 'é', $removeCharacteres);
		$removeCharacteres = str_replace('u00e8', 'è', $removeCharacteres);
		$removeCharacteres = str_replace('u00ea', 'ê', $removeCharacteres);
		$removeCharacteres = str_replace('u00c9', 'É', $removeCharacteres);
		$removeCharacteres = str_replace('u00c8', 'È', $removeCharacteres);
		$removeCharacteres = str_replace('u00ca', 'Ê', $removeCharacteres);
		$removeCharacteres = str_replace('u00cb', 'Ë', $removeCharacteres);		
		$removeCharacteres = str_replace('u00ed', 'í', $removeCharacteres);
		$removeCharacteres = str_replace('u00ec', 'ì', $removeCharacteres);
		$removeCharacteres = str_replace('u00ee', 'î', $removeCharacteres);
		$removeCharacteres = str_replace('u00ef', 'ï', $removeCharacteres);
		$removeCharacteres = str_replace('u00cd', 'Í', $removeCharacteres);
		$removeCharacteres = str_replace('u00cc', 'Ì', $removeCharacteres);
		$removeCharacteres = str_replace('u00ce', 'Î', $removeCharacteres);
		$removeCharacteres = str_replace('u00cf', 'Ï', $removeCharacteres);
		$removeCharacteres = str_replace('u00f3', 'ó', $removeCharacteres);
		$removeCharacteres = str_replace('u00f2', 'ò', $removeCharacteres);
		$removeCharacteres = str_replace('u00f4', 'ô', $removeCharacteres);
		$removeCharacteres = str_replace('u00f5', 'õ', $removeCharacteres);
		$removeCharacteres = str_replace('u00f6', 'ö', $removeCharacteres);
		$removeCharacteres = str_replace('u00d3', 'Ó', $removeCharacteres);
		$removeCharacteres = str_replace('u00d2', 'Ò', $removeCharacteres);
		$removeCharacteres = str_replace('u00d4', 'Ô', $removeCharacteres);
		$removeCharacteres = str_replace('u00d5', 'Õ', $removeCharacteres);
		$removeCharacteres = str_replace('u00d6', 'Ö', $removeCharacteres);
		$removeCharacteres = str_replace('u00fa', 'ú', $removeCharacteres);
		$removeCharacteres = str_replace('u00f9', 'ù', $removeCharacteres);
		$removeCharacteres = str_replace('u00fb', 'û', $removeCharacteres);
		$removeCharacteres = str_replace('u00fc', 'ü', $removeCharacteres);
		$removeCharacteres = str_replace('u00da', 'Ú', $removeCharacteres);
		$removeCharacteres = str_replace('u00d9', 'Ù', $removeCharacteres);
		$removeCharacteres = str_replace('u00db', 'Û', $removeCharacteres);
		$removeCharacteres = str_replace('u00e7', 'ç', $removeCharacteres);
		$removeCharacteres = str_replace('u00c7', 'Ç', $removeCharacteres);
		$removeCharacteres = str_replace('u00f1', 'ñ', $removeCharacteres);
		$removeCharacteres = str_replace('u00d1', 'Ñ', $removeCharacteres);
		$removeCharacteres = str_replace('u0026', '&', $removeCharacteres);
		$removeCharacteres = str_replace('u00ba', 'º', $removeCharacteres);
		return $removeCharacteres;
	}

	/**
	 * @access public
	 * @param datatype paramname
	 * @param datatype paramname
	 * @param datatype paramname
	 * @param datatype paramname
	 * @param datatype paramname
	 */
	function addJqGridColumn($index, $name, $width, $align='left', $parametersColumn=array()){
		$CI =& get_instance();
		$parametersColumn['name'] = $index;
		if(!isParameterJqGrid('index', $parametersColumn))		
			$parametersColumn['index'] = $index;

		$parametersColumn['colName'] = $name;
		$parametersColumn['width'] = $width;
		$parametersColumn['align'] = $align;
		$CI->jqgridpanel->setColumn($parametersColumn);
	}

	/**
	 * @access private
	 * @param datatype paramname
	 */
	function isParameterJqGrid($parameter, $arrayParameter){
		if(array_key_exists($parameter, $arrayParameter))
			return true;
		else
			return false;
	}