<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'ajuda', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel();?>
		<?=begin_Tab(lang('perfilTituloTab'));?>
			<?=begin_form('gerenciador/perfil/salvar', 'formPerfil');?>
				<?=form_label('lblCodigo', lang('perfilCodigo'), 80);?>
				<?=form_textField('txtCodigo', @$perfil->id, 40, '', 4, array('readonly' => 'true', 'style' => 'text-align:right;',));?>
				<?=new_line();?>
				<?=form_label('lblNome', lang('perfilNome'), 80);?>
				<?=form_textField('txtNome', @$perfil->nome_perfil, 300, '');?>
				<?=new_line();?>
				<?=form_label('lblDtCadastro', lang('perfilDtCadastro'), 80);?>
				<?=form_dateField('dtCadastro', @$perfil->dt_cadastro, array('disabled'=>'true'));?>
			<?=end_form();?>
		<?=end_Tab();?>
		<?=begin_Tab(lang('perfilProgramaTab'));?>
			<?=begin_form('gerenciador/perfil/salvarProgramaPai/', 'formProgramaPai');?>
				<?=form_hidden('txtIdPerfilPai', @$perfil->id);?>
				<?=form_hidden('txtIdProgramaPerfilPai');?>

				<?=form_label('lblTituloPrograma', lang('perfilPrograma'), 80, array('style' => 'font-weight: bold;',));?>
				<?=new_line();?>

				<?=form_label('lblProgramasPai', lang('perfilPrograma'), 80);?>
				<?=form_combo('cmbProgramaPai', $programas, '', 453);?>
				<?=new_line();?>

				<?=begin_JqGridPanel('gridProgramasPai', 150, '', base_url().'gerenciador/perfil/listaProgramasPai/',
					array('autoload'=> false, 'sortname'=> 'nome', 'autowidth'=> true, 'multiselect' => false, 'moveRows' => true, 'caption'=> 'Lista de Programas'));?>
					<?=addJqGridColumn('id', 'ID', 0, 'right', array('hidden'=> true));?>
					<?=addJqGridColumn('nome', lang('perfilPrograma'), 510, 'left');?>
				<?=end_JqGridPanel();?>

				<?=form_button('btnNovoProgramaPai', lang('novo'), 'novoProgramaPai()');?>
				<?=form_button('btnIncluirProgramaPai', lang('incluir'), 'incluirProgramaPai()');?>
				<?=form_button('btnExcluirProgramaPai', lang('excluir'), 'excluirProgramaPai()');?>
				<?=new_line();?>
			<?=end_form();?>

			<hr class="ui-state-default"/>

			<?=begin_form('gerenciador/perfil/salvarPrograma/', 'formPrograma');?>
				<?=form_hidden('txtIdPerfil');?>
				<?=form_hidden('txtIdProgramaPai');?>
				<?=form_hidden('txtIdProgramaPerfil');?>
				
				<?=form_label('lblTituloSubPrograma', lang('perfilSubPrograma'), 100, array('style' => 'font-weight: bold;',))?>			
				<?=new_line()?>
				
				<?=form_label('lblProgramas', lang('perfilPrograma'), 80)?>
				<?=form_combo('cmbPrograma', $programas, '', 453)?>
				<?=new_line()?>

				<?=begin_JqGridPanel('gridProgramas', 150, '', base_url().'gerenciador/perfil/listaProgramas/',
					array('autoload'=> false, 'sortname'=> 'nome', 'autowidth'=> true, 'multiselect' => false, 'moveRows' => true, 'caption'=> 'Lista de SubProgramas'));?>
					<?=addJqGridColumn('id', 'ID', 0, 'right', array('hidden'=> true));?>
					<?=addJqGridColumn('nome', lang('perfilPrograma'), 510, 'left');?>
				<?=end_JqGridPanel();?>

				<?=form_button('btnNovoPrograma', lang('novo'), 'novoPrograma()', $width = '80');?>
				<?=form_button('btnIncluirPrograma', lang('incluir'), 'incluirPrograma()', '80');?>
				<?=form_button('btnExcluirPrograma', lang('excluir'), 'excluirPrograma()', '80');?>							

			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script type="text/javascript">

	var loadGridProgramaPai = false;
	
	function init(){
		if($('#txtCodigo').val() == '')
			$("#tab").tabs('disable', 1);	
	}	

	function tabShow(index){
		if(index == 1 && $('#txtCodigo').val() != '' && !loadGridProgramaPai){
			loadGridProgramaPai = true;
			$("#gridProgramasPai").setGridParam({url:BASE_URL+'gerenciador/perfil/listaProgramasPai/?idPerfil='+$('#txtCodigo').val(), page:1}).trigger("reloadGrid");
		}
	}

	function gridProgramasPai_moveRowStop(rows){
		var idsPerfisProgramasPai = '';
		var idsProgramasPai = '';
		for(var i = 1; i < rows.length; i++){
			if(idsProgramasPai == ''){
				idsPerfisProgramasPai = rows[i].id.split('chr', 2)[0];
				idsProgramasPai = rows[i].id.split('chr', 2)[1];
			}else{
				idsPerfisProgramasPai += ',' + rows[i].id.split('chr', 2)[0];
				idsProgramasPai += ',' + rows[i].id.split('chr', 2)[1];
			}
		}

		$.post(BASE_URL+'gerenciador/perfil/alterarProgramasPai/'+$('#txtCodigo').val(),
				{ids: idsPerfisProgramasPai, idProgramas:  idsProgramasPai},
				function(data){
					if(!data.sucess)
						messageErroBox("<?=lang('registroNaoGravado')?>");});
	}

	function gridProgramas_moveRowStop(rows){
		var idsPerfisProgramas = '';
		var idsProgramas = '';
		for(var i = 1; i < rows.length; i++){
			if(idsProgramas == ''){
				idsPerfisProgramas = rows[i].id.split('chr', 2)[0];
				idsProgramas = rows[i].id.split('chr', 2)[1];
			}else{
				idsPerfisProgramas += ',' + rows[i].id.split('chr', 2)[0];
				idsProgramas += ',' + rows[i].id.split('chr', 2)[1];
			}
		}

		$.post(BASE_URL+'gerenciador/perfil/alterarProgramas/'+$('#txtCodigo').val()+'/'+$('#txtIdProgramaPai').val(),
				{ids: idsPerfisProgramas, idProgramas:  idsProgramas},
				function(data){
					if(!data.sucess)
						messageErroBox("<?=lang('registroNaoGravado')?>");});
	}

	function gridProgramasPai_click(id){
		var perfil_programa_id = id.split('chr', 2)[0];
		$.post(BASE_URL+'gerenciador/perfil/buscarProgramaPai/', {id: perfil_programa_id}, abrirProgramaPai);
	}

	function abrirProgramaPai(data){
		$('#txtIdProgramaPerfilPai').val(data.programaPai.id);
		setValueCombo('cmbProgramaPai', data.programaPai.programa_id);		
		$('#txtIdPerfil').val(data.programaPai.perfil_id);
		$('#txtIdProgramaPai').val(data.programaPai.programa_id);
		$("#gridProgramas").setGridParam({url:BASE_URL+'gerenciador/perfil/listaProgramas/?idPerfil='+$('#txtCodigo').val()+'&programa_pai='+data.programaPai.programa_id, page:1}).trigger("reloadGrid");
	}

	function novo(){
		location.href = BASE_URL+'gerenciador/perfil/novo';
	}

	function gridProgramas_click(id){
		var perfil_programa_id = id.split('chr', 2)[0];
		$.post(BASE_URL+'gerenciador/perfil/buscarPrograma/', {id: perfil_programa_id}, abrirPrograma);
	}

	function abrirPrograma(data){
		$('#txtIdProgramaPerfil').val(data.programa.id);
		setValueCombo('cmbPrograma', data.programa.programa_id);
	}

	function excluir(){
		if($("txtCodigo").val() == '')
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		else
			messageConfirm("<?=lang('excluirRegistro')?>", excluirPerfil);
	}

	function excluirPerfil(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+"gerenciador/perfil/excluir/", {perfis: $('#txtCodigo').val()},
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", novo);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}

	function salvar(){
		formPerfil_submit();
	}
	
	function formPerfil_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		}else{
			if(data.success != undefined) {
				$("#txtCodigo").val(data.perfil.id);
				$("#txtIdPerfilPai").val(data.perfil.id);
				$("#txtNome").val(data.perfil.nome_perfil);
				$("#dtCadastro").val(data.perfil.dt_cadastro);
	      		messageBox(data.success.message, enableTabProgramas);
			}
	    }
	}

	function enableTabProgramas(){
		$("#tab").tabs('enable', 1);
	}

	function incluirProgramaPai(){
		formProgramaPai_submit();
	}

	function formProgramaPai_callback(data){
		if(data.error != undefined)
			messageErrorBox(data.error.message, data.error.field);
		else{
			if(data.success != undefined) {
				$('#txtIdProgramaPerfilPai').val(data.programaPai.id);
				setValueCombo('cmbProgramaPai', data.programaPai.programa_id);
	     		messageBox(data.success.message, novoProgramaPai);
		    }
		}
	}

	function novoProgramaPai(){
		$('#txtIdProgramaPerfilPai').val('');
		$('#txtIdProgramaPerfil').val('');
		$('#txtIdProgramaPai').val('');		
		setValueCombo('cmbProgramaPai', '');
		setValueCombo('cmbPrograma', '');
		$('#gridProgramasPai').resetSelection();
		$('#gridProgramasPai').setGridParam({url:BASE_URL+'gerenciador/perfil/listaProgramasPai/?idPerfil='+$('#txtCodigo').val(), page:1}).trigger('reloadGrid');
		$("#gridProgramas").clearGridData();
	}

	function excluirProgramaPai(){
		if(getSelectedRow("gridProgramasPai") != null)
			messageConfirm("<?=lang('excluirRegistros')?>", confirmaExcluirProgramaPai);
		else
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
	}

	function confirmaExcluirProgramaPai(excluirProgramaPai){
		if(excluirProgramaPai){
			var programa = getSelectedRow("gridProgramasPai");
			var perfil_programa_id = programa.split("chr", 2)[0];
			var programa_id = programa.split("chr", 2)[1];
			var perfilId = $('#txtCodigo').val();
			$.post(BASE_URL+'gerenciador/perfil/excluirProgramaPai/'+ perfil_programa_id +'/'+ programa_id +'/'+ perfilId, programaPaiExcluido);
		}
	}

	function programaPaiExcluido(data){
		if(data.sucess == "false")
			messageErrorBox("<?=lang('registroNaoExcluido')?>");
		else
			messageBox("<?=lang('registroExcluido')?>", novoProgramaPai);
	}

	function incluirPrograma(){
		formPrograma_submit();
	}

	function formPrograma_callback(data){
		if(data.error != undefined)
			messageErrorBox(data.error.message, data.error.field);
		else{
			if(data.success != undefined) {
				$('#txtIdProgramaPerfil').val(data.programa.id);
				setValueCombo('cmbPrograma', data.programa.programa_id);
	      		messageBox(data.success.message, novoPrograma);
		    }
		}
	}

	function excluirPrograma(){
		if(getSelectedRow("gridProgramas") != null)
			messageConfirm("<?=lang('excluirRegistros')?>", confirmaExcluirPrograma);
		else
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
	}

	function confirmaExcluirPrograma(excluirPrograma){
		if(excluirPrograma){
			var programa = getSelectedRow("gridProgramas");
			var idPerfilPrograma = programa.split("chr", 2)[0];
			var idPrograma = programa.split("chr", 2)[1];
			$.post(BASE_URL+"gerenciador/perfil/excluirPrograma/"+idPerfilPrograma+"/"+idPrograma, programaExcluido);
		}
	}

	function programaExcluido(data){
		if(!data.sucess)
			messageErrorBox("<?=lang('registroNaoExcluido')?>");
		else
			messageBox("<?=lang('registroExcluido')?>", novoPrograma);
	}

	function novoPrograma(){		
		$('#txtIdProgramaPerfil').val('');
		setValueCombo('cmbPrograma', '');
		$('#gridProgramas').resetSelection();
		$("#gridProgramas").setGridParam({url:BASE_URL+'gerenciador/perfil/listaProgramas/?idPerfil='+$('#txtCodigo').val()+'&programa_pai='+$('#cmbProgramaPai').val(), page:1}).trigger("reloadGrid");
	}

</script>