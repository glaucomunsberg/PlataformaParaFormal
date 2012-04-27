/**
 * Método utilizado pela grid para buscar as dados.
 * <code>
 * grid.load();
 * ou
 * grid.load(['txtCpf', 'txtNome']);
 * </code>
 * @author rsantos
 * @param array params Campos da tela que deseja enviar como parametro ex: ['txtCpf', 'txtNome']
 */
String.prototype.load = function(params){
	var nameGrid = this;
	if($.isArray(params))
		for (i = 0; i < params.length; i++)
			this.addParam(params[i], $("#"+params[i]).val());

	setTimeout(function(){
		var url = $("#"+nameGrid).jqGrid('getGridParam','url');
		var params = '?'+$.cookie(nameGrid+'Params');
		$.cookie(nameGrid+'Params', null);
		$("#"+nameGrid).setGridParam({url:url.split('?')[0]+params,page:1}).trigger("reloadGrid");
	}, 500);
}

/**
 * Método utilizado pela grid para recarregar a grid
 * <code>
 * grid.reloadGrid();
 * </code>
 * @author rsantos
 */
String.prototype.reloadGrid = function(){
	var url = $("#"+this).jqGrid('getGridParam','url');
	var params = '?'+$.cookie(this+'Params');
	$.cookie(this+'Params', null);
	$("#"+this).setGridParam({url:url.split('?')[0]+params,page:1});

	newGridParam = $("#"+this).getGridParam();	
	$("#"+this).jqGrid('GridUnload');
	$("#"+this).jqGrid(newGridParam);
}

/**
 * Método responsável por habilitar a edição dos elementos da grid, caso a mesma contenha campos para edição
 * <code>
 * grid.enableEditRows();
 * </code>
 * @author rsantos
 * @param string functionCallback Método que será executado após terminar a ação
 */
String.prototype.enableEditRows = function(functionCallback){
	var ids = $("#"+this).jqGrid('getDataIDs');
	for(var i=0;i < ids.length;i++){
		$("#"+this).editRow(ids[i]);
	}

	if ($.isFunction(functionCallback))
		functionCallback();
}

/**
 * Adicionar coluna dinamicamente na grid
 * <code>
 * grid.addColumn({align: "center", colName: "19:00 - 19:45", hidden: false, editable:true, edittype:"checkbox", editoptions: {value:"Yes:No", checked: true}, index: "teste", name: "teste", resizable: false, sortable: true, title: true, width: 95});
 * </code>
 * @author rsantos
 * @param Object column Um objeto contendo as informações da coluna que deseja adicionar na grid
 */
String.prototype.addColumn = function(column){
	columns = $("#"+this).getGridParam('colModel');
	columnNames = $("#"+this).getGridParam('colNames');
	if($.isArray(column)){
		for (i = 0; i < column.length; i++){
			columns.push(column[i]);
			columnNames.push(column[i].colName);			
		}
	}else{
		columns.push(column);
		columnNames.push(column.colName);
	}
	$("#"+this).setGridParam({'colModel':columns, 'colNames':columnNames});
}

/**
 * Adicionar linha dinamicamente na grid
 * @author rsantos
 * @param Object row Um objeto contendo as informações da linha que deseja adicionar na grid
 */
String.prototype.addRow = function(row){
	$('#'+this).jqGrid('addRowData', $("#"+this).jqGrid('getDataIDs').length, row, 'last');
}

/**
 * Remove a linha dinamicamente na grid
 * <code>
 * grid.removeRow(1);
 * </code>
 * @author rsantos
 * @param integer rowId ID da linha que deseja remover da grid
 */
String.prototype.removeRow = function(rowId){
	$('#'+this).jqGrid('delRowData', rowId);
}

/**
 * Desmarca todas as linhas selecionadas na grid
 * <code>
 * grid.resetSelection();
 * </code>
 */
String.prototype.resetSelection = function(){
	$('#'+this).jqGrid('resetSelection');
}

/**
 * Este método retorna um array de id's da grid. Retorna um array vazio se não contem dados.
 * <code>
 * var gridIds = grid.getDataIDs();
 * </code>
 * @author rsantos
 * @return array Contendo os id's das linhas da grid
 */
String.prototype.getDataIDs = function(){
	return $("#"+this).jqGrid('getDataIDs');
}

/**
 * Limpa os dados carregados da grid. Se o parametro clearfooter estiver setado como true, o método limpa os dados colocados no rodapé.
 * <code>
 * grid.clearGridData();
 * </code>
 * @author rsantos
 */
String.prototype.clearGridData = function(){
	$("#"+this).jqGrid('clearGridData');
}

/**
 * Adiciona parametros utilizados ser enviados na execução do método load da grid
 * <code>
 * grid.addParam('parametro1', 'valor do parametro 1');
 * grid.addParam('parametro2', 'valor do parametro 2');
 * grid.load();
 * </code>
 * @author rsantos
 * @param string name Nome do parametro, utilizado para filtrar as informações carregadas na grid
 * @param string value Valor do parametro, utilizado para filtrar as informações carregadas na grid
 */
String.prototype.addParam = function(name, value){
	var stored = '';
	if($.cookie(this+'Params') == '')
		stored = $.cookie(this+'Params')+name+'='+escape(Utf8.encode(value.toUpperCase()));
	else
		stored = $.cookie(this+'Params')+'&'+name+'='+escape(Utf8.encode(value.toUpperCase()));

	$.cookie(this+'Params', stored);
}

/**
 * Método responsável por retornar um array contendo os id's das linhas selecionadas na grid
 * <code>
 * var aIdsSelectedRows = grid.getSelectedRows();
 * </code>
 * @author rsantos
 * @param string gridName Nome da grid a ser utilizada
 * @return array Contendo os id's das linhas selecionadas na grid
 */
String.prototype.getSelectedRows = function(){
	return $("#"+this).jqGrid('getGridParam','selarrrow');
}

/**
 * Método responsável por retornar o ID da última linha selecionada.
 * <code>
 * var idSelectedRow = grid.getSelectedRow()
 * </code>
 * @author rsantos
 * @param string gridName Nome da grid
 * @return integer ID da linha última linha selecionada
 */
String.prototype.getSelectedRow = function(){
	return $("#"+this).jqGrid('getGridParam','selrow');
}

/**
 * Método responsável por retornar uma string contendo os id's das linhas selecionadas na grid, separados por virgula
 * <code>
 * var idsSelectedRows = grid.serializeSelectedRows();
 * </code>
 * @author rsantos
 * @return string Contendo os id's das linhas selecionadas na grid, separadas por virgula
 */
String.prototype.serializeSelectedRows = function(){
	var rowsSelected = '';
	var rowsSelectedGrid = $("#"+this).jqGrid('getGridParam','selarrrow');			
	for(var i = 0; i < rowsSelectedGrid.length; i++)
		if(rowsSelected == '')
			rowsSelected = rowsSelectedGrid[i];
		else
			rowsSelected += ',' + rowsSelectedGrid[i];

	return rowsSelected;
}

/**
 * Retorna um array com os dados do rowid solicitado. 
 * O array retornado é do tipo chave:valor, onde o chave é o nome da colModel e o valor é associado a coluna da linha. 
 * Retorna vazio se o rowid não for encontrado.
 * <code>
 * var rowData = grid.getRowData(1);
 * </code>
 * @author rsantos
 * @param integer id da linha que deseja buscar as informações
 * @return array Contendo as informações da linha
 */
String.prototype.getRowData = function(rowId){
	return $("#"+this).jqGrid('getRowData', rowId);
}

/**
 * Seleciona a linha do id solicitado.
 * <code>
 * grid.setSelectRow(1);
 * </code>
 * @author rsantos
 * @param integer id da linha que deseja selecionar na grid
 */
String.prototype.setSelectRow = function(rowId){
	$("#"+this).jqGrid('setSelection', rowId);
}

/**
 * Seleciona todas as linhas da grid
 * <code>
 * grid.setSelectAllRows();
 * </code>
 * @author rsantos
 */
String.prototype.setSelectAllRows = function(){
	var gridIds = $("#"+this).jqGrid('getDataIDs');
	for(var i = 0; i < gridIds.length; i++)
		$("#"+this).jqGrid('setSelection', gridIds[i]);		
}

/**
 * DEPRECATED
 * Método responsável por retornar o ID da última linha selecionada.
 * <code>
 * var idSelectedRow = getSelectedRow('grid');
 * </code>
 * @author rsantos
 * @param string gridName Nome da grid
 * @return integer ID da linha última linha selecionada
 * @deprecated Usar método String.prototype.getSelectedRow
 * @ignore
 */
function getSelectedRow(gridName){
	return $("#"+gridName).jqGrid('getGridParam','selrow');
}

/**
 * DEPRECATED
 * Método responsável por retornar um array contendo os id's das linhas selecionadas na grid
 * <code>
 * var aIdsSelectedRows = getSelectedRows('grid');
 * </code>
 * @author rsantos
 * @param string gridName Nome da grid a ser utilizada
 * @return array
 * @deprecated Usar método String.prototype.getSelectedRows
 * @ignore
 */
function getSelectedRows(gridName){
	return $("#"+gridName).jqGrid('getGridParam','selarrrow');
}

/**
 * Método responsável por colocar a máscara de data e hora na coluna d/m/Y H:i:s
 * @author rsantos
 * @param cellval
 * @param opts
 * @param rwd
 */
jQuery.extend($.fn.fmatter , {
    datetime : function(cellval, opts, rwd) {
    	var op = $.extend({},opts.date);
		if(!$.fmatter.isUndefined(opts.colModel.formatoptions)) {
			op = $.extend({},op,opts.colModel.formatoptions);
		}
		
		if(!$.fmatter.isEmpty(cellval)) {
			return  $.fmatter.util.DateFormat('Y-m-d H:i:s',cellval,'d/m/Y H:i:s',op);
		} else {
			return $.fn.fmatter.defaultFormat(cellval, opts);
		}
	}
});