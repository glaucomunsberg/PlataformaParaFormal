<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Este arquivo contem os metodos que ajudam na montagem das grids no framework
	 * 
	 * @package framework.helpers
	 * @subpackage editorGrid
	 */
	
	/**
	 * Retorna um componente editorGrid utilizando a bilioteca extjs
	 * Abaixo um exemplo de como usar nas views:
	 * <code>
	 * <?=begin_EditorGridPanel('gridNotasAvaliacao', 376, 565, 
	 * 							base_url().'avaliacao/avaliacao/listaAlunosAvaliacoes', false, false);?>
	 * 		<?=addColumn('chave', lang('avaliacaoChave'), 50, false, 'left');?>
	 *		<?=addColumn('nome_aluno', lang('avaliacaoNomeAluno'), 394, true, 'left');?>
	 *		<?=addColumn('nota', lang('avaliacaoNota'), 50, false, 'right', false, 
	 * 					array('editor'=>'number', 
	 * 						  'decimalPrecision'=>1, 
	 * 						  'maxValue'=>10, 
	 * 						  'minValue'=>0, 
	 * 						  'decimalSeparator'=>'.'));?>
	 *		<?=addColumn('peso', lang('avaliacaoPeso'), 50, false, 'right');?>
	 * <?=end_EditorGridPanel();?>
	 * </code>
	 * @access public
	 * @return string
	 * @param string $id Id do componente editorGrid [optional]
	 * @param int $height Altura do componente editorGrid [optional]
	 * @param int $width Largura do componente editorGrid [optional]
	 * @param string $url onde sera buscada as informacoes para montar a grid (JSON) [optional]
	 * @param boolean $autoLoad Informa se a grid vai ser carregada automaticamente [optional]
	 * @param boolean $paginador Informa se tera paginador [optional]
	 * @param boolean $multiSelecao Informa se podera ser selecionado mais de um registro na grid [optional]
	 * @param boolean $moveRow Informa se as linhas poderao ser movimentadas [optional]
	 */
	function begin_EditorGridPanel($id = 'grid', $height = 0, $width = 0, $url = '', $autoLoad = true, $paginador = true, $multiSelecao = false, $moveRow = false){
		$gridPanel = '';
		$gridPanel .= '<div id="'.$id.'Content" class="content-grid">';
		
		if($height == 0)
			$gridPanel .= '		<div id="'.$id.'" style="height: 100%;"></div>';
		else
			$gridPanel .= '		<div id="'.$id.'" style="float: left;"></div>';		
		
		$CI =& get_instance();
		$CI->gridpanel->setId($id);
		$CI->gridpanel->setURL($url);
		$CI->gridpanel->setHeight($height);
		$CI->gridpanel->setWidth($width);
		$CI->gridpanel->setPaginador($paginador);
		$CI->gridpanel->setMultiSelecao($multiSelecao);
		$CI->gridpanel->setMoveRow($moveRow);
		$CI->gridpanel->setAutoLoad($autoLoad);
		return $gridPanel;
	}	
	
	/**
	 * @access public
	 * @ignore
	 * @return string
	 */
	function end_EditorGridPanel(){
		$CI =& get_instance();
		$gridPanel = '';
		$gridPanel .= '</div>';
			
		if($CI->gridpanel->getMoveRow()){
			$gridPanel .= "<input type='button' id='lblMoveUp' class='moveUp' onclick='".$CI->gridpanel->getId()."_upRow();'/>";
			$gridPanel .= "<input type='button' id='lblMoveUp' class='move_Down' onclick='".$CI->gridpanel->getId()."_downRow();'/>";
		}
					
		$gridPanel .= '<script>';
		$gridPanel .= '	var '.$CI->gridpanel->getId().';';
		$gridPanel .= '	var ds'.$CI->gridpanel->getId().';';
		$gridPanel .= 'Ext.onReady(function(){';
		
		if($CI->gridpanel->getHeight() == 0){
			$gridPanel .= '		resizeGrid("'.$CI->gridpanel->getId().'Content");';
		}
		$gridPanel .= '		var fm = Ext.form;';
		$gridPanel .= '		var fields'.$CI->gridpanel->getId().' = Ext.data.Record.create('.$CI->gridpanel->getFields().');';
		$gridPanel .= '		ds'.$CI->gridpanel->getId().' = new Ext.data.Store({';
		$gridPanel .= '				proxy: new Ext.data.ScriptTagProxy({url:"'.$CI->gridpanel->getURL().'"}),';
		$gridPanel .= '				reader: new Ext.data.JsonReader({totalProperty: "total", root: "results", id: "id"}, fields'.$CI->gridpanel->getId().')';
		$gridPanel .= '		});';
		$gridPanel .= '		var colModel'.$CI->gridpanel->getId().' = new Ext.grid.ColumnModel('.$CI->gridpanel->getColumns().');';
		$gridPanel .= $CI->gridpanel->getId().' = new Ext.grid.EditorGridPanel({';
		$gridPanel .= '				el: "'.$CI->gridpanel->getId().'", ';
		$gridPanel .= '				ds: ds'.$CI->gridpanel->getId().', ';
        $gridPanel .= '				cm: colModel'.$CI->gridpanel->getId().',';
        $gridPanel .= '				autoScroll: true,';
        $gridPanel .= '				clicksToEdit:1,';
        $gridPanel .= '				loadMask: true,';

        if($CI->gridpanel->getMultiSelecao() == false){
        	        $gridPanel .= '				sm: new Ext.grid.RowSelectionModel({singleSelect:true}),';	
        }
        
        if($CI->gridpanel->getHeight() > 0){
			$gridPanel .= '				height:'.$CI->gridpanel->getHeight().',';
        }
        
        if($CI->gridpanel->getWidth() > 0){
        	$gridPanel .= '				width:'.$CI->gridpanel->getWidth().',';
        }
        
        if($CI->gridpanel->getAutoExpandColumn() != ''){
        	$gridPanel .= '				autoExpandColumn: "'.$CI->gridpanel->getAutoExpandColumn().'",';	
        }
        
        if($CI->gridpanel->getPaginador()){
        	$gridPanel .= '				bbar: new Ext.PagingToolbar({';
			$gridPanel .= '					pageSize: 15, ';
			$gridPanel .= '					store: ds'.$CI->gridpanel->getId().', ';
			$gridPanel .= '					displayInfo: true, ';
			$gridPanel .= '					displayMsg: "Mostrando resultados {0} - {1} de {2}", ';
			$gridPanel .= '					emptyMsg: "Nenhum resultado encontrado"';
			$gridPanel .= '				}),';
        }
        
        $gridPanel .= '				monitorWindowResize: true';		
		$gridPanel .= '		});';
		$gridPanel .= $CI->gridpanel->getId().'.on("rowdblclick", function (grid, rowIndex, e) {';
		$gridPanel .= '		var id = grid.store.data.items[rowIndex].id;';
		$gridPanel .= ' try	{' . $CI->gridpanel->getId().'_dblClick(id); } catch(err){ 	}';
		$gridPanel .= '		});';	
		$gridPanel .= $CI->gridpanel->getId().'.on("rowclick", function (grid, rowIndex, e) {';
		$gridPanel .= '		var id = grid.store.data.items[rowIndex].id;';
		$gridPanel .= ' try	{' . $CI->gridpanel->getId().'_click(id); } catch(err){ 	}';
		$gridPanel .= '		}); ';
		$gridPanel .= '		ds'.$CI->gridpanel->getId().'.on("beforeload", function(){';
		$gridPanel .= '				load = true;';
		$gridPanel .= '				$j.post(\''.base_url().'login/validaAutenticacaoAjax\',';
		$gridPanel .= '					function(data){';
		$gridPanel .= '						if(!data.logged.message){';
		$gridPanel .= '							window.alert(\'Execute novamente o login no sistema.\');';
		$gridPanel .= '							load = false;';
		$gridPanel .= '						}';
		$gridPanel .= '					});';
		$gridPanel .= '			return load;';
		$gridPanel .= '		});';
		$gridPanel .= $CI->gridpanel->getId().'.addListener("afteredit", '.$CI->gridpanel->getId().'_handleEdit);';
		$gridPanel .= $CI->gridpanel->getId().'.render();';
		
		if($CI->gridpanel->getURL() != ''){
			if($CI->gridpanel->getAutoLoad()){
				$gridPanel .= 'ds'.$CI->gridpanel->getId().'.load({params:{start:0, limit:15}})';	
			}
		}
		
		$gridPanel .= '});';
		$gridPanel .= '</script>';
		$CI->gridpanel->limpaGrid();
		return $gridPanel;
	}