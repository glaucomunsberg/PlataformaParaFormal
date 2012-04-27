<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Helper responsável por manipular a grid do sistema
 * @package helpers
 * @subpackage grid
 */

/**
 * Inicia uma grid
 * @param string $id o Identificador da grid, utilizado para sua manipulação
 * @param integer $height Altura
 * @param integer $width Largura
 * @param string $url URL para requisitar os dados da grid
 * @param array $parameters Parâmetros de configuração da grid, no formato array(parametro => valor, parametro2 => valor2).<br>
 * Os parâmetros podem ser:<br>
 * <ul>
 * <li><i>string</i> sortname: o(s) campo(s) para ordenar os itens da grid, exemplo: "id", "id, nome, tipo"</li>
 * <li><i>string</i> caption: o título da grade</li>
 * <li><i>boolean</i> pager: se a grid terá paginação</li>
 * <li><i>boolean</i> multiselect: se a grid aceitará seleção de múltiplas linhas</li>
 * <li><i>boolean</i> autowidth: se a grid ajustará automaticamente sua largura</li>
 * </ul>
 * @see end_JqGridPanel
 */
function begin_JqGridPanel($id = 'grid', $height = '', $width = 0, $url = '', $parameters = array()) {
    $jqGridPanel = '<table id="' . $id . '"></table>';
    $jqGridPanel .= '<div id="' . $id . 'Pager"></div>';
    $CI = & get_instance();
    $CI->jqgridpanel->setId($id);

    $parameters['height'] = ($height == '' ? 300 : $height);
    $parameters['jsonReader'] = array('repeatitems' => false, 'id' => 0);
    $functionOnSelectRow = "##function(rowid){";
    $functionOnSelectRow.= "try{" . $id . "_onSelectRow(rowid);";
    $functionOnSelectRow.= "}catch(err){}";
    $functionOnSelectRow.= "}##";
    $parameters['onSelectRow'] = $functionOnSelectRow;
    $functionCellSelect = "##function(rowid, iRow, iCol, e){";
    $functionCellSelect.= "if(iRow != 0){";
    $functionCellSelect.= '$("#' . $id . '").resetSelection();';
    $functionCellSelect.= '$("#' . $id . '").setSelection(rowid);';
    $functionCellSelect.= "try{" . $id . "_click(rowid);";
    $functionCellSelect.= "}catch(err){}}";
    $functionCellSelect.= "}##";
    if (isParameterJqGrid('cellEdit', $parameters)) {
        if (!$parameters['cellEdit']) {
            $parameters['onCellSelect'] = $functionCellSelect;
        }
    } else {
        $parameters['onCellSelect'] = $functionCellSelect;
    }

    $functionDblClick = "##function(rowid, iRow, iCol, e){";
    $functionDblClick.= "if(iRow != 0){";
    $functionDblClick.= '$("#' . $id . '").resetSelection();';
    $functionDblClick.= '$("#' . $id . '").setSelection(rowid);';
    $functionDblClick.= "try{" . $id . "_dblClick(rowid);";
    $functionDblClick.= "}catch(err){}}";
    $functionDblClick.= "}##";
    $parameters['ondblClickRow'] = $functionDblClick;
    $functionLoadBeforeSend = "##function(xhr){";
    $functionLoadBeforeSend.= 'try{' . $id . '_loadBeforeSend();}catch(err){}';
    $functionLoadBeforeSend.= "}##";
    $parameters['loadBeforeSend'] = $functionLoadBeforeSend;
    $functionLoadComplete = "##function(data){";
    $functionLoadComplete.= 'if($("#' . $id . '").jqGrid(\'getGridParam\',\'datatype\') != \'local\'){';
    if (isset($parameters['checkedAll'])) {
        if ($parameters['checkedAll']) {
            $functionLoadComplete.= 'try{' . $id . '.setSelectAllRows();}catch(err){}';
        }
    }
    $functionLoadComplete.= 'try{' . $id . '_loadComplete();}catch(err){}';
    $functionLoadComplete.= "}}##";
    $parameters['loadComplete'] = $functionLoadComplete;
    $functionGridComplete = "##function(data){";
    if (isParameterJqGrid('moveRows', $parameters)) {
        if ($parameters['moveRows']) {
            $functionGridComplete.= '$("#' . $id . '").tableDnD({scrollAmount:0,';
            $functionGridComplete.= 'onDragStart: function(table, row) {';
            $functionGridComplete.= '$.cookie("' . $id . '", $.tableDnD.serialize());},';
            $functionGridComplete.= 'onDrop: function(table, row) {';
            $functionGridComplete.= 'if($.tableDnD.serialize() != $.cookie("' . $id . '"))';
            $functionGridComplete.= $id . '_moveRowStop(table.tBodies[0].rows);';
            $functionGridComplete.= '}});';
        }
    }
    $functionGridComplete.= 'generateTabs();';
    $functionGridComplete.= 'try{' . $id . '_init();}catch(err){}';
    $functionGridComplete.= "}##";
    $parameters['gridComplete'] = $functionGridComplete;
    $functionLoadError = "##function(xhr,st,err) {";
    $functionLoadError.= 'var url = $("#' . $id . '").jqGrid(\'getGridParam\',\'url\');';
    $functionLoadError.= "messageErrorBox(\"Grid: $id; URL: \"+url+\"; Type: \"+st+\"; Response: \"+ xhr.status + \" \"+xhr.statusText);";
    $functionLoadError.= "}##";
    $parameters['loadError'] = $functionLoadError;
    $parameters['url'] = $url;
    $parameters['altRows'] = true;
    $parameters['altclass'] = 'ui-state-default jqgrow-alt';

    if (is_array($parameters)) {
        if (isParameterJqGrid('pager', $parameters)) {
        	if($parameters['pager']){
        		$parameters['pager'] = '#' . $id . 'Pager';
	            if (!isParameterJqGrid('rowNum', $parameters)) {
	                $parameters['rowNum'] = 10;
	            }
        	}
        } else {
            $parameters['rowNum'] = -1;
        }

        if (!isParameterJqGrid('rownumbers', $parameters)) {
            $parameters['rownumbers'] = false;
        }
        if (!isParameterJqGrid('viewrecords', $parameters)) {
            $parameters['viewrecords'] = true;
        }
        if (!isParameterJqGrid('datatype', $parameters)) {
            $parameters['datatype'] = 'json';
        }
        if (!isParameterJqGrid('sortorder', $parameters)) {
            $parameters['sortorder'] = 'asc';
        }
        if (!isParameterJqGrid('autowidth', $parameters)) {
            $parameters['width'] = $width;
        }
        if (!isParameterJqGrid('multiselect', $parameters)) {
            $parameters['multiselect'] = true;
        }
        if (!isParameterJqGrid('forceFit', $parameters)) {
            $parameters['forceFit'] = true;
        }
        if (!isParameterJqGrid('headertitles', $parameters)) {
            $parameters['headertitles'] = true;
        }
        if (isParameterJqGrid('autoload', $parameters)) {
            if (!$parameters['autoload']) {
                $parameters['datatype'] = 'local';
            }
        }
    }

    $CI->jqgridpanel->setGridParameters($parameters);
    return $jqGridPanel;
}

/**
 * Finaliza a grid
 * @return string
 * @see begin_JqGridPanel
 */
function end_JqGridPanel() {
    $CI = & get_instance();
    $parameters = $CI->jqgridpanel->getGridParameters();
    $jqGridPanel = '';
    $jqGridPanel.= '<script>';
    $jqGridPanel.='var ' . $CI->jqgridpanel->getId() . ' =  \'' . $CI->jqgridpanel->getId() . '\';';
    $jqGridPanel.= '$(document).ready(function (){';
    $jqGridPanel.= '	$("#' . $CI->jqgridpanel->getId() . '").jqGrid(';
    $jqGridPanel.= removeCharacteresIlegals(json_encode($parameters));
    $jqGridPanel.= '	);';
    $jqGridPanel.= '	$("#' . $CI->jqgridpanel->getId() . '").setGridParam({datatype: \'json\'});';
    $jqGridPanel.= '	$("#' . $CI->jqgridpanel->getId() . '").setGridParam({autoload: true});';

    if (isParameterJqGrid('search', $parameters)) {
        if ($parameters['search']) {
            if (isParameterJqGrid('toppager', $parameters)) {
                if ($parameters['toppager']) {
                    $jqGridPanel.= '	$("#' . $CI->jqgridpanel->getId() . '").jqGrid(\'navGrid\', \'#' . $CI->jqgridpanel->getId() . '_toppager\', {del:false,add:false,edit:false}, {}, {}, {}, {sopt:[\'cn\']});';
                }
            }
            $jqGridPanel.= '	$("#' . $CI->jqgridpanel->getId() . '").jqGrid(\'navGrid\', \'#' . $CI->jqgridpanel->getId() . 'Pager\', {del:false,add:false,edit:false}, {}, {}, {}, {sopt:[\'cn\']});';
        }
    }
    $jqGridPanel.= '});';
    $jqGridPanel.= '</script>';

    $CI->jqgridpanel->clearParametersGrid();
    return $jqGridPanel;
}

/**
 * Remove caracteres ilegais
 * @param string $parametersJqGrid String para remover os caracteres inválidos
 * @return string A string com os caracteres corrigidos
 */
function removeCharacteresIlegals($parametersJqGrid) {
    $pattern = array(
        '\\' => '',
        '"[' => '[',
        ']"' => ']',
        '"##' => '',
        '##"' => '',
        'u00e0' => 'à',
        'u00e1' => 'á',
        'u00e2' => 'â',
        'u00e3' => 'ã',
        'u00e4' => 'ä',
        'u00c0' => 'À',
        'u00c1' => 'Á',
        'u00c2' => 'Â',
        'u00c3' => 'Ã',
        'u00c4' => 'Ä',
        'u00e9' => 'é',
        'u00e8' => 'è',
        'u00ea' => 'ê',
        'u00c9' => 'É',
        'u00c8' => 'È',
        'u00ca' => 'Ê',
        'u00cb' => 'Ë',
        'u00ed' => 'í',
        'u00ec' => 'ì',
        'u00ee' => 'î',
        'u00ef' => 'ï',
        'u00cd' => 'Í',
        'u00cc' => 'Ì',
        'u00ce' => 'Î',
        'u00cf' => 'Ï',
        'u00f3' => 'ó',
        'u00f2' => 'ò',
        'u00f4' => 'ô',
        'u00f5' => 'õ',
        'u00f6' => 'ö',
        'u00d3' => 'Ó',
        'u00d2' => 'Ò',
        'u00d4' => 'Ô',
        'u00d5' => 'Õ',
        'u00d6' => 'Ö',
        'u00fa' => 'ú',
        'u00f9' => 'ù',
        'u00fb' => 'û',
        'u00fc' => 'ü',
        'u00da' => 'Ú',
        'u00d9' => 'Ù',
        'u00db' => 'Û',
        'u00e7' => 'ç',
        'u00c7' => 'Ç',
        'u00f1' => 'ñ',
        'u00d1' => 'Ñ',
        'u0026' => '&',
        'u00ba' => 'º'
    );
    return strtr($parametersJqGrid, $pattern);
}

/**
 * Adiciona uma coluna à grid.<br>
 * Deve ser invocado entre as chamadas {@link begin_JqGridPanel} e  {@link end_JqGridPanel}.
 * @param string $index Índice para identificar a coluna (corresponde à coluna da consulta sql que popula a grade)
 * @param string $name Nome da coluna
 * @param string $width Largura da coluna
 * @param string $align Alinhamento (left, right, center)
 * @param array $parametersColumn Parâmetros de configuração, no formato array(parametro => valor, parametro2 => valor2).<br>
 * Os parâmetros podem ser:<br>
 * <ul>
 * <li><i>boolean</i> hidden: se a coluna será oculta</li>
 * <li><i>boolean</i> autowidth: se a coluna ajustará automaticamente sua largura</li>
 * <li><i>string</i> formatter: como formatar a coluna. Opções válidas:
 * <ol>
 *  <li>"date" data,</li>
 *  <li>"datetime" data e hora,</li>
 *  <li>"checkbox" checkboxes,</li>
 *  <li>"checkbox:enabled" edição habilitada,</li>
 *  <li>"currency" moeda, já internacionalizada,</li>
 *  <li>"select:t:Sim;f:Não;null:Nenhum" quando vier TRUE, FALSE ou NULL do banco de dados, ou "select:S:Sim;N:Não;T:Talvez", "select:M:Masculino;F:Feminino" ...</li>
 * </ol>
 *  veja mais formatos em {@link http://www.trirand.com/jqgridwiki/doku.php?id=wiki:predefined_formatter#predefined_format_types tipos pré-definidos do jqgrid}
 *  </li>
 * </ul>
 * @return string
 * @see begin_JqGridPanel
 * @todo como salvar alterações num formatter "checkbox:enabled"?
 */
function addJqGridColumn($index, $name, $width, $align = 'left', $parametersColumn = array()) {
    $CI = & get_instance();
    $parametersColumn['name'] = $index;
    if (!isParameterJqGrid('index', $parametersColumn)) {
        $parametersColumn['index'] = $index;
    }
    if (isset($parametersColumn['formatter'])) {
        $format = explode(":", $parametersColumn['formatter'], 2);
        if (count($format) > 1) {
            $parametersColumn['formatter'] = $format[0];
            if ($parametersColumn['formatter'] == "select") {
                $parametersColumn['edittype'] = $format[0];
                $parametersColumn['editoptions']["value"] = $format[1];
            } else {
                $parametersColumn['formatoptions'][$format[1]] = true;
            }
        }
        if ($parametersColumn['formatter'] == 'checkbox') {
            if (!isset($parametersColumn['editoptions'])) {
                $parametersColumn['editoptions'] = array('value' => '1:0');
            }
            if (isset($parametersColumn['formatoptions']['enabled'])) {
                //jqGrid não tem "enabled" para checkboxes
                unset($parametersColumn['formatoptions']['enabled']);
                $parametersColumn['formatoptions']['disabled'] = false;
            }
        }
    }

    $parametersColumn['colName'] = $name;
    $parametersColumn['width'] = $width;
    $parametersColumn['align'] = $align;
    $CI->jqgridpanel->setColumn($parametersColumn);
}

/**
 * @access private
 * Valida um parâmetro
 * @param string $parameter Nome do parâmetro
 * @param string $arrayParameter Valor do parâmetro?
 */
function isParameterJqGrid($parameter, $arrayParameter) {
    return array_key_exists($parameter, $arrayParameter);
}
