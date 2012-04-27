<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Este arquivo contem os metodos que ajudam na montagem das grids no framework
	 * 
	 * @package framework.helpers
	 * @subpackage grid
	 */

	/**
	 * Retorna um componente grid utilizando a bilioteca extjs
	 * Abaixo um exemplo de como usar nas views:
	 * <code>
	 * <?=begin_GridPanel('gridEmpresa', '', '', base_url().'gerenciador/empresa/listaEmpresas', true, false);?>
	 * 		<?=addColumn('nome', 'Nome', 100, true, 'left', true);?>
	 * 		<?=addColumn('dt_cadastro', 'Dt. cadastro', 100, true, 'center');?>
	 * <?=end_GridPanel();?>
	 * </code>
	 * @access public 
	 * @return string
	 * @param string $id Id do componente grid [optional]
	 * @param int $height Altura do componente grid [optional]
	 * @param int $width Largura do componente grid [optional]
	 * @param string $url URL onde sera buscada as informacoes para montar a grid (JSON) [optional]
	 * @param boolean|array $autoLoad Informa se a grid vai ser carregada automaticamente e tambem pode ser 
	 * 	usada para facilitar a montagem de parametros do componente grid passando um array com possiveis opcoes: 
	 * paginador, multiSelecao, moveRow, grouping, enableMenu, enableColumnMove, startCollapsed, expander, checkedAll [optional]
	 * @param boolean $paginador Informa se tera paginador [optional]
	 * @param boolean $multiSelecao Informa se podera ser selecionado mais de um registro na grid [optional]
	 * @param boolean $moveRow Informa se as linhas poderao ser movimentadas [optional]
	 * @param boolean $groupingStore Informa se a grid tera agrupador de colunas [optional]
	 * @param boolean $enableMenu Informa se sera visualizado o menu da grid para ordenar e outras funcoes da grid [optional]
	 * @param boolean $enableColumnMove Informa se podera mover as colunas de um lado para o outro [optional]
	 * @param boolean $startCollapsed Em caso de dados agrupados informa se os agrupamentos viram abertos [optional]
	 * @param boolean $expander Informa se a grid tera a possibilidade de expadir a linha [optional]
	 * @param boolean $checkedAll Caso tenha escolhido a opcao de multiselecao, podera vir todos os registros selecionados [optional]
	 */
	function begin_GridPanel($id = 'grid', $height=0, $width =0, $url = '', $autoLoad = true, $paginador = true, $multiSelecao = false, $moveRow = false, $groupingStore = false, $enableMenu = true, $enableColumnMove = true, $startCollapsed = true, $expander = false, $checkedAll = false){
		$gridPanel = '';
		$gridPanel .= '<div id="'.$id.'Content" class="content-grid">';
		
		if($height == 0)
			$gridPanel .= '		<div id="'.$id.'" style="width: 99.9%;"></div>';
		else
			$gridPanel .= '		<div id="'.$id.'" style="float: left; width: 99.9%;"></div>';		
		
		$CI =& get_instance();
		$CI->gridpanel->setId($id);
		$CI->gridpanel->setURL($url);
		$CI->gridpanel->setHeight(($height == '' ? 0 : $height));
		$CI->gridpanel->setWidth($width);
		if(is_array($autoLoad)){
			if(isParameter('autoLoad', $autoLoad))
				$CI->gridpanel->setAutoLoad($autoLoad['autoLoad']);				
			else
				$CI->gridpanel->setAutoLoad(true);

			foreach($autoLoad as $chave => $valor){
				switch($chave){
					case 'paginador':
						$paginador = $valor;
						break;
					case 'multiSelecao':
						$multiSelecao = $valor;
						break;
					case 'moveRow':
						$moveRow = $valor;
						break;
					case 'grouping':
						$groupingStore = $valor;
						break;
					case 'enableMenu':
						$enableMenu = $valor;
						break;
					case 'enableColumnMove':
						$enableColumnMove = $valor;
						break;
					case 'startCollapsed':
						$startCollapsed = $valor;
						break;
					case 'expander':
						$expander = $valor;
						break;
					case 'checkedAll':
						$checkedAll = $valor;
						break;
				}
			}
		}else{
			$CI->gridpanel->setAutoLoad($autoLoad);
		}
		
		$CI->gridpanel->setPaginador($paginador);
		$CI->gridpanel->setMultiSelecao($multiSelecao);
		$CI->gridpanel->setMoveRow($moveRow);
		$CI->gridpanel->setGroupingStore($groupingStore);
		$CI->gridpanel->setEnableMenu($enableMenu);
		$CI->gridpanel->setEnableColumnMove($enableColumnMove);
		$CI->gridpanel->setStartCollapsed($startCollapsed);
		$CI->gridpanel->setExpander($expander);
		$CI->gridpanel->setCheckedAll($checkedAll);
		return $gridPanel;
	}
	
	/**
	 * Utilizado para montar a coluna da grid
	 * Abaixo um exemplo de como usar na views, entre a tagbe gin_GridPanel e end_GridPanel:
	 * <code>
	 * <?=addColumn('nome', 'Nome', 100, true, 'left', true);?>
	 * </code>
	 * @access void
	 * @return void
	 * @param string $dataIndex Nome da coluna do select que ira popular a grid
	 * @param string $nome Nome que ira aparecer na coluna da grid
	 * @param int $width Largura do campo da grid
	 * @param boolean $sortable Informa se o usuario podera fqzer a ordenacao por esta coluna
	 * @param center $align Informa qual vai ser o alinhamento das informacoes, com as opcoes:
	 * left, right, center
	 * @param boolean|array $autoExpandColumn Informa se a coluna ira ocupar o espaco que sobrar na grid 
	 * e tambem pode ser usada para facilitar a montagem da coluna na grid [optional]
	 * @param boolean $editable Object[optional]
	 * @param boolean $checkBox Object[optional]
	 * @param boolean $groupField Object[optional]
	 * @param boolean $hidden Object[optional]
	 * @param boolean $renderer Object[optional]
	 */
	function addColumn($dataIndex, $nome, $width, $sortable, $align, $autoExpandColumn = false, $editable = false, $checkBox = false, $groupField = false, $hidden = false, $renderer = '', $remoteSort = false, $groupTextTemplate=''){		
		$CI =& get_instance();
		$CI->gridpanel->addField($dataIndex);
		$expandColumn = false;
		if(is_array($autoExpandColumn)){
			foreach($autoExpandColumn as $chave => $valor){
				switch($chave){
					case 'autoExpandColumn':
						$expandColumn = $valor;
						break;
					case 'editable':
						$editable = $valor;
						break;		
					case 'checkBox':
						$checkBox = $valor;
						break;
					case 'groupField':
						$groupField = $valor;
						break;
					case 'hidden':
						$hidden = $valor;
						break;
					case 'renderer':
						$renderer = $valor;
						break;
					case 'remoteSort':
						$remoteSort = $valor;
						break;
					case 'groupTextTemplate':
						$groupTextTemplate = $valor;
						break;					
				}
			}
		}else{
			$expandColumn = $autoExpandColumn;
		}
		
		$CI->gridpanel->addColumn($dataIndex, $nome, $width, $sortable, $align, $expandColumn, $editable, $checkBox, $groupField, $hidden, $renderer, $remoteSort, $groupTextTemplate);
		
		if($expandColumn)
			$CI->gridpanel->setAutoExpandColumn($dataIndex);
	}
	
	/**
	 * @access public
	 * @ignore
	 * @return string
	 */
	function end_GridPanel(){
		$CI =& get_instance();
		$gridPanel = '';				
		$gridPanel .= '</div>';
			
		if($CI->gridpanel->getMoveRow()){
			$gridPanel .= "<div style='float: left'>";
			$gridPanel .= "<input type='button' id='lblMoveUp' class='moveUp' onclick='".$CI->gridpanel->getId()."_upRow();'/>";
			$gridPanel .= "<input type='button' id='lblMoveDow' class='move_Down' onclick='".$CI->gridpanel->getId()."_downRow();'/>";
			$gridPanel .= "</div>";
		}
					
		$gridPanel .= '<script>';
		$gridPanel .= '	var '.$CI->gridpanel->getId().';';
		$gridPanel .= '	var ds'.$CI->gridpanel->getId().';';
		$gridPanel .= '	var colModel'.$CI->gridpanel->getId().';';
		$gridPanel .= 'Ext.onReady(function(){';
		
		if($CI->gridpanel->getHeight() == 0)
			$gridPanel .= '		resize("conteudo");';		

		$gridPanel .= '		var fields'.$CI->gridpanel->getId().' = Ext.data.Record.create('.$CI->gridpanel->getFields().');';
		
		if($CI->gridpanel->isGroupingStore()){
			$gridPanel .= '		ds'.$CI->gridpanel->getId().' = new Ext.data.GroupingStore({';
			$gridPanel .= '				proxy: new Ext.data.ScriptTagProxy({url:"'.$CI->gridpanel->getURL().'"}),';
			$gridPanel .= '				reader: new Ext.data.JsonReader({totalProperty: "total", root: "results", id: "id"}, fields'.$CI->gridpanel->getId().'),';
			$gridPanel .= '				sortInfo: {field: "'.$CI->gridpanel->getGroupField().'", direction: "ASC"},';
			if($CI->gridpanel->getRemoteSort()){
							$gridPanel .= '				remoteSort: {sort: "'.$CI->gridpanel->getGroupField().'", dir: "ASC"},';	
			}
			$gridPanel .= '				groupField: "'.$CI->gridpanel->getGroupField().'"';
			$gridPanel .= '		});';
		}else{
			$gridPanel .= '		ds'.$CI->gridpanel->getId().' = new Ext.data.Store({';
			$gridPanel .= '				proxy: new Ext.data.ScriptTagProxy({url:"'.$CI->gridpanel->getURL().'"}),';
			$gridPanel .= '				reader: new Ext.data.JsonReader({totalProperty: "total", root: "results", id: "id"}, fields'.$CI->gridpanel->getId().')';
			$gridPanel .= '		});';
		}
		
		if($CI->gridpanel->getMultiSelecao())
			if($CI->gridpanel->getCheckedAll())
				$gridPanel .= '				var sm = new Ext.grid.CheckboxSelectionModel();';
			else
				$gridPanel .= '				var sm = new Ext.grid.CheckboxSelectionModel({header:\'\'});';
        else
			$gridPanel .= '				var sm = new Ext.grid.RowSelectionModel({singleSelect:true});';

		$gridPanel .= '		 colModel'.$CI->gridpanel->getId().' = new Ext.grid.ColumnModel('.$CI->gridpanel->getColumns().');';
				
		$gridPanel .= $CI->gridpanel->getId().' = new Ext.grid.GridPanel({';
		$gridPanel .= '				el: "'.$CI->gridpanel->getId().'", ';
		$gridPanel .= '				ds: ds'.$CI->gridpanel->getId().', ';
        $gridPanel .= '				cm: colModel'.$CI->gridpanel->getId().',';
        $gridPanel .= '				sm: sm,';
        $gridPanel .= '				autoScroll: true,';
        $gridPanel .= '				loadMask: true,';
        $gridPanel .= '				stripeRows: true,';
        $gridPanel .= '				height:'.$CI->gridpanel->getHeight().',';
        		
		if($CI->gridpanel->getExpander())
			$gridPanel .= '				plugins: expander,';

        if(!$CI->gridpanel->getEnableMenu())
        	$gridPanel .= '				enableHdMenu: false,';
        	
        if(!$CI->gridpanel->getEnableColumnMove())
        	$gridPanel .= '				enableColumnMove: false,';

        if($CI->gridpanel->isGroupingStore()){
	        $gridPanel.= '	view: new Ext.grid.GroupingView({';
	        $gridPanel.= '			forceFit:true, ';
	        $gridPanel.= '			startCollapsed: '.($CI->gridpanel->getStartCollapsed() ? 'true' : 'false') .',';
	        $gridPanel.= '			showGroupName: false, ';
	        $gridPanel.= '			showGroupsText: "Exibir dados agrupados", ';
	        $gridPanel.= '			groupByText: "Agrupar por este campo", ';
			$gridPanel.= '			columnsText:"Colunas", ';
			$gridPanel.= '			sortAscText:"Ordem crescente", ';
			$gridPanel.= '			sortDescText:"Ordem decrescente", ';
			$gridPanel.= '			hideGroupedColumn: true';
			if(trim($CI->gridpanel->getGroupTextTemplate()) != '')
				$gridPanel.= '			,groupTextTpl: \''.$CI->gridpanel->getGroupTextTemplate().'\'';

			$gridPanel.= '	}),';
        }else
			$gridPanel .= ' 	view: new Ext.grid.GridView({columnsText:"Colunas",  sortAscText:"Ordem crescente",  sortDescText:"Ordem decrescente"}),';

        if($CI->gridpanel->getWidth() > 0)
        	$gridPanel .= '				width:'.$CI->gridpanel->getWidth().',';

        if($CI->gridpanel->getAutoExpandColumn() != '')
        	$gridPanel .= '				autoExpandColumn: "'.$CI->gridpanel->getAutoExpandColumn().'",';

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
		if($CI->gridpanel->getHeight() == 0){
			$gridPanel .= $CI->gridpanel->getId().'.on("afterrender", function (grid) {';
			$gridPanel .= '		var gridHeight = resizeGrid("'.$CI->gridpanel->getId().'");';			
			$gridPanel .= '		grid.setHeight(gridHeight);';
			$gridPanel .= '		});';
		}
		$gridPanel .= $CI->gridpanel->getId().'.on("rowclick", function (grid, rowIndex, e) {';
		$gridPanel .= '		var id = grid.store.data.items[rowIndex].id;';
		$gridPanel .= ' try	{' . $CI->gridpanel->getId().'_click(id); } catch(err){ 	}';
		$gridPanel .= '		}); ';
		$gridPanel .= '		ds'.$CI->gridpanel->getId().'.on("beforeload", function(){';
		$gridPanel .= '				load = true;';
		$gridPanel .= '				$j.post(\''.base_url().'autenticacao/login/validaAutenticacaoAjax\', "",';
		$gridPanel .= '					function(data){';			
		$gridPanel .= '						if(!data.logged.message){';
		$gridPanel .= '							window.alert(\'Execute novamente o login no sistema.\');';
		$gridPanel .= '							load = false;';
		$gridPanel .= '						}';
		$gridPanel .= '					}, "json");';
		$gridPanel .= '			return load;';
		$gridPanel .= '		});';
		
		$gridPanel .= $CI->gridpanel->getId().'.render();';					
		
		if($CI->gridpanel->getURL() != ''){
			if($CI->gridpanel->getAutoLoad())
				$gridPanel .= 'ds'.$CI->gridpanel->getId().'.load({params:{start:0, limit:15}, callback: function(){ try{'.$CI->gridpanel->getId().'_init();}catch(err){};}});';
			else
				$gridPanel .= ' try	{'.$CI->gridpanel->getId().'_init();} catch(err){};';
		}

		$gridPanel .= '});';
    	
		$gridPanel .= '</script>';
		$CI->gridpanel->limpaGrid();
		return $gridPanel;
	}
	
	/**
	 * Retorna true se o valor informado se encontra dentro do array informado
	 * 
	 * @access private
	 * @return boolean
	 * @param string $parameter Valor a para pesquisa
	 * @param array $arrayParameter Array a ser pesquisado
	 */
	function isParameter($parameter, $arrayParameter){
		if(array_key_exists($parameter, $arrayParameter))
			return true;
		else
			return false;		
	}