<?=$this->load->view("../../static/_views/headerGlobalView")?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'ajuda', 'pesquisar'))?>
	<?=end_ToolBar()?>
	
	<?=begin_TabPanel(409)?>
		<?=begin_Tab(lang('grupoTab'))?>
			<?=begin_form('gerenciador/grupo/salvar', 'formGrupo')?>
				<?=form_label('lblCodigo', lang('grupoCodigo'), 80)?>
				<?=form_textField('txtCodigo', @$grupo->id, 40, '', 4, array('readonly' => 'true', 'style' => 'text-align:right;',))?>
				<?=new_line()?>
				
				<?=form_label('lblEmpresa', lang('grupoEmpresa'), 80)?>
				<?=form_combo('cmbEmpresa', $empresas, @$grupo->ger_empresas_id, 302)?>
				<?=new_line()?>
				
				<?=form_label('lblNome', lang('grupoNome'), 80)?>
				<?=form_textField('txtNome', @$grupo->nome, 300, '')?>
				<?=new_line()?>
								
				<?=form_label('lblDtCadastro', lang('grupoDtCadastro'), 80)?>
				<?=form_dateField('dtCadastro', @$grupo->dt_cadastro, array('disabled'=>'true'))?>
			<?=end_form()?>
		<?=end_Tab()?>
		<?=begin_Tab(lang('grupoProgramaTab'))?>
			<?=begin_form('gerenciador/grupo/salvarProgramaPai/', 'formProgramaPai')?>
				<?=form_hidden('txtIdGrupoPai', @$grupo->id)?>
				<?=form_hidden('txtIdProgramaGrupoPai')?>
				
				<?=form_label('lblTituloPrograma', lang('grupoPrograma'), 80, array('style' => 'font-weight: bold;',))?>
				<?=new_line()?>
			
				<?=form_label('lblProgramasPai', lang('grupoPrograma'), 80)?>
				<?=form_combo('cmbProgramaPai', $programas, '', 302)?>
				<?=new_line()?>
				
				<?=form_label('lblDtEntradaPai', lang('grupoProgramaDtEntrada'), 80)?>
				<?=form_dateField('dtEntradaPai')?>
				<?=form_label('lblDtSaidaPai', lang('grupoProgramaDtSaida'), 80)?>
				<?=form_dateField('dtSaidaPai')?>
				<?=new_line()?>
				
				<?=begin_GridPanel('gridProgramasPai', 100, 535, base_url().'index.php/gerenciador/grupo/listaProgramasPai/'.@$grupo->id, false, false, false, true)?>
					<?=addColumn('nome', lang('grupoProgramaNome'), 310, false, 'left')?>
					<?=addColumn('dt_entrada', lang('grupoProgramaDtEntrada'), 100, false, 'center')?>
					<?=addColumn('dt_saida', lang('grupoProgramaDtSaida'), 100, false, 'center')?>
				<?=end_GridPanel()?>
				<?=new_line()?>
				
				<?=form_button('btnExcluirProgramaPai', lang('excluir'), 'excluirProgramaPai()', '80', array('style' => 'float: right; margin-right: 44px;'))?>
				<?=form_button('btnIncluirProgramaPai', lang('incluir'), 'incluirProgramaPai()', '80', array('style' => 'float: right;'))?>
				<?=form_button('btnNovoProgramaPai', lang('novo'), 'novoProgramaPai()', $width = '80', array('style' => 'float: right;'))?>
				<?=new_line()?>
			<?=end_form()?>
			
			<hr/>
			
			<?=begin_form('gerenciador/grupo/salvarPrograma/', 'formPrograma')?>
				<?=form_hidden('txtIdGrupo')?>
				<?=form_hidden('txtIdPai')?>
				<?=form_hidden('txtIdProgramaGrupo')?>
			
				<?=form_label('lblTituloSubPrograma', lang('grupoSubPrograma'), 100, array('style' => 'font-weight: bold;',))?>			
				<?=new_line()?>
				
				<?=form_label('lblProgramas', lang('grupoPrograma'), 80)?>
				<?=form_combo('cmbPrograma', $programas, '', 302)?>
				<?=new_line()?>
				
				<?=form_label('lblDtEntrada', lang('grupoProgramaDtEntrada'), 80)?>
				<?=form_dateField('dtEntrada')?>
				<?=form_label('lblDtSaida', lang('grupoProgramaDtSaida'), 80)?>
				<?=form_dateField('dtSaida')?>
				<?=new_line()?>
				
				<?=begin_GridPanel('gridProgramas', 100, 535, base_url().'index.php/gerenciador/grupo/listaProgramas/'.@$grupo->id, false, false, false, true)?>
					<?=addColumn('nome', lang('grupoProgramaNome'), 310, false, 'left')?>
					<?=addColumn('dt_entrada', lang('grupoProgramaDtEntrada'), 100, false, 'center')?>
					<?=addColumn('dt_saida', lang('grupoProgramaDtSaida'), 100, false, 'center')?>
				<?=end_GridPanel()?>
				<?=new_line()?>
				
				<?=form_button('btnExcluirPrograma', lang('excluir'), 'excluirPrograma()', '80', array('style' => 'float: right; margin-right: 44px;'))?>
				<?=form_button('btnIncluirPrograma', lang('incluir'), 'incluirPrograma()', '80', array('style' => 'float: right;'))?>
				<?=form_button('btnNovoPrograma', lang('novo'), 'novoPrograma()', $width = '80', array('style' => 'float: right;'))?>
			<?=end_form()?>
		<?=end_Tab()?>
	<?=end_TabPanel()?>
	
<?=$this->load->view("../../static/_views/footerGlobalView")?>

<script type="text/javascript">
	var programa_pai = '';	
	
	function showGrid(){
		dsgridProgramasPai.reload();
	}
	
	function gridProgramasPai_init(){
		if(document.getElementById('txtCodigo').value != ''){
			gridProgramasPai.getSelectionModel().clearSelections();
			grupo = document.getElementById('txtCodigo').value;
			dsgridProgramasPai.load({params:{idGrupo: grupo}});
		}
	}	
	
	function novo(){
		location.href = '<?=base_url()."index.php/gerenciador/grupo/novo"?>';
		parent.pesquisar();
	}
	
	function excluir(){
		if(document.getElementById("txtCodigo").value != ""){
			messageConfirm("<?=lang('excluirRegistros')?>", 370, 80, confirmaExcluirGrupo);
		}
	}
	
	function confirmaExcluirGrupo(excluirGrupo){
		if(excluirGrupo){
			$j.post("<?= base_url();?>index.php/gerenciador/grupo/excluir", {id: document.getElementById("txtCodigo").value}, grupoExcluido);
		}
	}
	
	function grupoExcluido(data){
		if(data.sucess == "false"){
			messageBox("<?=lang('registroNaoExcluido')?>", 250, 80);
		}else{
			messageBox("<?=lang('registroExcluido')?>", 250, 80, novo);
		}
	}
	
	function salvar(){
		formGrupo_submit();
	}
	
	function formGrupo_callback(data){
		if(data.error != undefined){
				messageBox(data.error.message,293,90, data.error.field);
		} else {
			if(data.success != undefined) {
	      		document.getElementById("txtCodigo").value = data.grupo.id;
	      		document.getElementById("txtIdGrupoPai").value = data.grupo.id;
	      		document.getElementById("cmbEmpresa").value = data.grupo.ger_empresas_id;
	      		document.getElementById("txtNome").value = data.grupo.nome;
	      		document.getElementById("dtCadastro").value = data.grupo.dt_cadastro;	      			      	
	      		messageBox(data.success.message,280,90, tabProgramas);
			}
	    }
	}

	function tabProgramas(){
		tabPanel.setSelectedIndex(1);
		parent.pesquisar();
	}

	function gridProgramasPai_dblClick(id){
		var ger_grupo_programa_id = id.split("chr", 2)[0];
		var ger_programa_id = id.split("chr", 2)[1];
		programa_pai = ger_programa_id;
		$j.post("<?= base_url();?>index.php/gerenciador/grupo/buscarProgramaPai", {id: ger_grupo_programa_id}, abrirProgramaPai);
	}
	
	function abrirProgramaPai(data){
		document.getElementById("txtIdProgramaGrupoPai").value = data.programaPai.id;
		document.getElementById("cmbProgramaPai").value = data.programaPai.ger_programas_id;
		document.getElementById("dtEntradaPai").value = data.programaPai.dt_entrada;
		document.getElementById("dtSaidaPai").value = data.programaPai.dt_saida;
		document.getElementById("txtIdGrupo").value = data.programaPai.ger_grupos_id;
		document.getElementById("txtIdPai").value = data.programaPai.ger_programas_id;	
		grupo = document.getElementById("txtCodigo").value;
		dsgridProgramas.load({params:{pai: data.programaPai.ger_programas_id, idGrupo: grupo}});
		novoPrograma();
	}
	
	function novoProgramaPai(){
		document.getElementById("txtIdProgramaGrupoPai").value = '';
		document.getElementById("cmbProgramaPai").value = '';
		document.getElementById("dtEntradaPai").value = '';
		document.getElementById("dtSaidaPai").value = '';
		programa_pai = '';
		gridProgramasPai.getSelectionModel().clearSelections();
		grupo = document.getElementById("txtCodigo").value;
		dsgridProgramasPai.load({params:{idGrupo: grupo}});
		document.getElementById("txtIdProgramaGrupo").value = '';
		document.getElementById("cmbPrograma").value = '';
		document.getElementById("dtEntrada").value = '';
		document.getElementById("dtSaida").value = '';
		dsgridProgramas.removeAll();		
	}
	
	function incluirProgramaPai(){
		formProgramaPai_submit();
	}
	
	function formProgramaPai_callback(data){
		if(data.error != undefined){
			messageBox(data.error.message,293,90, data.error.field);
		}
		if(data.success != undefined) {
      		document.getElementById("txtIdProgramaGrupoPai").value = data.programaPai.id;
			document.getElementById("cmbProgramaPai").value = data.programaPai.ger_programas_id;
			document.getElementById("dtEntradaPai").value = data.programaPai.dt_entrada;
			document.getElementById("dtSaidaPai").value = data.programaPai.dt_saida;
     		messageBox(data.success.message, 280, 90, novoProgramaPai);
	    }
	}
	
	function excluirProgramaPai(){
		var count = gridProgramasPai.getSelectionModel().getCount();
		if(count > 0){
			messageConfirm("<?=lang('excluirRegistros')?>", 370, 80, confirmaExcluirProgramaPai);			
		}else{
			messageBox("<?=lang('nenhumRegistroSelecionado')?>", 250, 80);
		}
	}
	
	function confirmaExcluirProgramaPai(excluirProgramaPai){
		if(excluirProgramaPai){
			programa = gridProgramasPai.getSelectionModel().getSelected();
			idPrograma = programa.id.split("chr", 2)[0];
			programaId = programa.id.split("chr", 2)[1];
			grupoId = document.getElementById("txtCodigo").value;
			$j.post("<?=base_url();?>index.php/gerenciador/grupo/excluirProgramaPai/" + idPrograma + "/" + programaId + "/" + grupoId, programaPaiExcluido);
		}
	}
	
	function programaPaiExcluido(data){
		if(data.sucess == "false"){
			messageBox("<?=lang('registroNaoExcluido')?>", 250, 80);
		}else{
			messageBox("<?=lang('registroExcluido')?>", 250, 80);
			novoProgramaPai();
		}
	}
	
	function gridProgramasPai_upRow(){
		var count = gridProgramasPai.getSelectionModel().getCount();
		if(count > 0){
			if(gridProgramasPai.getSelectionModel().hasPrevious()){
				rowAtual = gridProgramasPai.getSelectionModel().getSelected();
				gridProgramasPai.getSelectionModel().selectPrevious();
				rowAnterior = gridProgramasPai.getSelectionModel().getSelected();
				dsgridProgramasPai.remove(rowAtual);
				dsgridProgramasPai.insert(dsgridProgramasPai.indexOf(rowAnterior), rowAtual);
				gridProgramasPai.getSelectionModel().selectRow(dsgridProgramasPai.indexOf(rowAtual));
				updateGridProgramaPai();
			}
		}
	}
	
	function gridProgramasPai_downRow(){
		var count = gridProgramasPai.getSelectionModel().getCount();
		if(count > 0){
			if(gridProgramasPai.getSelectionModel().hasNext()){
				rowAtual = gridProgramasPai.getSelectionModel().getSelected();
				gridProgramasPai.getSelectionModel().selectNext();
				rowPosterior = gridProgramasPai.getSelectionModel().getSelected();
				dsgridProgramasPai.remove(rowAtual);
				dsgridProgramasPai.insert(dsgridProgramasPai.indexOf(rowPosterior) + 1, rowAtual);
				gridProgramasPai.getSelectionModel().selectRow(dsgridProgramasPai.indexOf(rowAtual));
				updateGridProgramaPai();
			}
		}
	}
	
	function updateGridProgramaPai(){
		var count = dsgridProgramasPai.getCount();
		var strIds = '';
		var strIdProgramas = '';
		var strSplit = '';
		for(var i=0; i < count; i++){
			if(i == 0){
				strSplit = dsgridProgramasPai.getAt(i).id;
				strIds = strSplit.split("chr", 2)[0];
				strIdProgramas = strSplit.split("chr", 2)[1];
			}else{
				strSplit = dsgridProgramasPai.getAt(i).id;
				strIds = strIds + " ," + strSplit.split("chr", 2)[0];
				strIdProgramas = strIdProgramas + " ," + strSplit.split("chr", 2)[1];
			}
		}
		$j.post("<?= base_url();?>index.php/gerenciador/grupo/alterarProgramasPai/<?= @$grupo->id;?>", {ids: strIds, idProgramas:  strIdProgramas}, returnAtualizaGridProgramaPai);
	}
	
	function returnAtualizaGridProgramaPai(data){
		if(data.sucess == "false"){
			messageBox("<?=lang('registroNaoGravado')?>", 250, 80);
		}
	}
	
	function gridProgramas_upRow(){
		var count = gridProgramas.getSelectionModel().getCount();
		if(count > 0){
			if(gridProgramas.getSelectionModel().hasPrevious()){
				rowAtual = gridProgramas.getSelectionModel().getSelected();
				gridProgramas.getSelectionModel().selectPrevious();
				rowAnterior = gridProgramas.getSelectionModel().getSelected();
				dsgridProgramas.remove(rowAtual);
				dsgridProgramas.insert(dsgridProgramas.indexOf(rowAnterior), rowAtual);
				gridProgramas.getSelectionModel().selectRow(dsgridProgramas.indexOf(rowAtual));
				updateGridProgramas();
			}
		}
	}
	
	function gridProgramas_downRow(){
		var count = gridProgramas.getSelectionModel().getCount();
		if(count > 0){
			if(gridProgramas.getSelectionModel().hasNext()){
				rowAtual = gridProgramas.getSelectionModel().getSelected();
				gridProgramas.getSelectionModel().selectNext();
				rowPosterior = gridProgramas.getSelectionModel().getSelected();
				dsgridProgramas.remove(rowAtual);
				dsgridProgramas.insert(dsgridProgramas.indexOf(rowPosterior) + 1, rowAtual);
				gridProgramas.getSelectionModel().selectRow(dsgridProgramas.indexOf(rowAtual));
				updateGridProgramas();
			}
		}
	}
	
	function updateGridProgramas(){
		var count = dsgridProgramas.getCount();
		var strIds = '';
		var strIdProgramas = '';
		var strSplit = '';
		for(var i=0; i < count; i++){
			if(i == 0){
				strSplit = dsgridProgramas.getAt(i).id;
				strIds = strSplit.split("chr", 2)[0];
				strIdProgramas = strSplit.split("chr", 2)[1];
			}else{
				strSplit = dsgridProgramas.getAt(i).id;
				strIds = strIds + " ," + strSplit.split("chr", 2)[0];
				strIdProgramas = strIdProgramas + " ," + strSplit.split("chr", 2)[1];
			}
		}		
		$j.post("<?= base_url();?>index.php/gerenciador/grupo/alterarProgramas/<?= @$grupo->id;?>/" + programa_pai, {ids: strIds, idProgramas:  strIdProgramas}, returnAtualizaGridPrograma);
	}
	
	function returnAtualizaGridPrograma(data){
		if(data.sucess == "false"){
			messageBox("<?=lang('registroNaoGravado')?>", 250, 80);
		}
	}
	
	function gridProgramas_dblClick(id){
		var ger_grupo_programa_id = id.split("chr", 2)[0];		
		$j.post("<?= base_url();?>index.php/gerenciador/grupo/buscarPrograma", {id: ger_grupo_programa_id}, abrirPrograma);
	}
	
	function abrirPrograma(data){
		document.getElementById("txtIdProgramaGrupo").value = data.programa.id;
		document.getElementById("cmbPrograma").value = data.programa.ger_programas_id;
		document.getElementById("dtEntrada").value = data.programa.dt_entrada;
		document.getElementById("dtSaida").value = data.programa.dt_saida;		
	}
	
	function novoPrograma(){
		document.getElementById("txtIdProgramaGrupo").value = '';
		document.getElementById("cmbPrograma").value = '';
		document.getElementById("dtEntrada").value = '';
		document.getElementById("dtSaida").value = '';
		gridProgramas.getSelectionModel().clearSelections();
		dsgridProgramas.reload();
	}
	
	function incluirPrograma(){
		formPrograma_submit();
	}
	
	function excluirPrograma(){
		var count = gridProgramas.getSelectionModel().getCount();
		if(count > 0){
			messageConfirm("<?=lang('excluirRegistros')?>", 380, 80, confirmaExcluirPrograma);			
		}else{
			messageBox("<?=lang('nenhumRegistroSelecionado')?>", 250, 80);
		}
	}
	
	function confirmaExcluirPrograma(excluirPrograma){
		if(excluirPrograma){			
			programa = gridProgramas.getSelectionModel().getSelected();
			idPrograma = programa.id.split("chr", 2)[0];
			$j.post("<?=base_url();?>index.php/gerenciador/grupo/excluirPrograma/" + idPrograma, programaExcluido);			
		}
	}
	
	function programaExcluido(data){
		if(data.sucess == "false"){
			messageBox("<?=lang('registroNaoExcluido')?>", 250, 80);
		}else{
			messageBox("<?=lang('registroExcluido')?>", 250, 80);
			novoPrograma();
		}
	}
	
	function formPrograma_callback(data){
		if(data.error != undefined){
			messageBox(data.error.message,293,90, data.error.field);
		}
		if(data.success != undefined) {
      		document.getElementById("txtIdProgramaGrupo").value = data.programa.id;
			document.getElementById("cmbPrograma").value = data.programa.ger_programas_id;
			document.getElementById("dtEntrada").value = data.programa.dt_entrada;
			document.getElementById("dtSaida").value = data.programa.dt_saida;
      		messageBox(data.success.message, 280, 90, novoPrograma);
	    }
	}
</script>