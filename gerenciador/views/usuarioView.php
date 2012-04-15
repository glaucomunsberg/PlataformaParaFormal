<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'ajuda', 'pesquisar'));?>
		<?=addButtonToolBar('Fazer login como', 'fazerLoginComo()', 'btnLoginComo', 'ui-icon-gear');?>
	<?=end_ToolBar();?>
	
	<?=begin_TabPanel();?>
		<?=begin_Tab(lang('usuarioTab1'));?>
			<?=begin_form('gerenciador/usuario/salvar', 'formUsuario');?>
				<?=form_hidden('txtCodigo', @$usuario->id);?>
				<?=form_label('lblNome', lang('usuarioNome'), 100);?>
				<?=form_textField('txtNome', @$usuario->nome, 300, '');?>
				<?=new_line();?>
				
				<?=form_label('lblSexo', lang('usuarioSexo'), 100);?>
				<?=form_radio('chkMasculino', 'chksexo', 'M', (@$usuario->sexo == 'M' || @$usuario->sexo == '' ? true : false));?>
				<?=form_label('lblSexoMasculino', lang('usuarioSexoMasculino'), 80, array('for'=>'chkMasculino'));?>
				<?=form_radio('chkFeminino', 'chksexo', 'F', (@$usuario->sexo == 'F' ? true : false));?>
				<?=form_label('lblSexoFeminino', lang('usuarioSexoFeminino'), 80, array('for'=>'chkFeminino'));?>
				<?=new_line();?>
				
				<?=form_label('lblDtNascimento', lang('usuarioDtNascimento'), 100);?>
				<?=form_dateField('dtNascimento', @$usuario->dt_nascimento);?>
				<?=new_line();?>
				
				<?=form_label('lblCPF', lang('usuarioCPF'), 100);?>
				<?=form_textField('txtCPF', @$usuario->cpf, 103, 'cpf');?>
				<?=new_line();?>
				
				<?=form_label('lblRG', lang('usuarioRG'), 100);?>
				<?=form_textField('txtRG', @$usuario->rg, 103, '');?>
				<?=new_line();?>
				
				<?=form_label('lblLogin', lang('usuarioLogin'), 100);?>
				<?=form_textField('txtLogin', @$usuario->login, 103, '');?>
				<?=new_line();?>
				
				<?=form_label('lblSenha', lang('usuarioSenha'), 100);?>			
				<?=form_textField('txtSenha', '', 103, '', '', array('type' => 'password'));?>
				<?=new_line();?>
				
				<?=form_label('lblEmail', lang('usuarioEmail'), 100);?>
				<?=form_textField('txtEmail', @$usuario->email, 300, '');?>				
			<?=end_form();?>
		<?=end_Tab();?>
		<?=begin_Tab('Grupos de acesso');?>
			<?=begin_form('gerenciador/usuario/salvarGruposAcessos', 'formGrupoAcesso');?>
				<?=form_hidden('txtIdUsuarioGrupoAcesso', @$usuario->id);?>
				<?=form_hidden('txtGruposAcessos');?>

				<?=begin_JqGridPanel('gridGrupoAcesso', 'auto', '', base_url().'gerenciador/usuario/listaGruposAcessos', array('autoload'=> false, 'sortname'=> 'nome', 'autowidth'=> true, 'toppager' => false, 'pager'=> false, 'caption'=>'Lista de Grupos de acesso'));?>
					<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
					<?=addJqGridColumn('nome', 'Nome', 300, 'left', array('sortable'=>true));?>
				<?=end_JqGridPanel();?>
			<?=end_form();?>
		<?=end_Tab();?>
		<?=begin_Tab(lang('usuarioTab2'));?>
			<?=begin_form('gerenciador/usuario/incluirEmpresa', 'formEmpresa');?>
				<?=form_hidden('txtIdUsuarioEmpresa', @$usuario->id);?>
				<?=form_hidden('txtPerfis');?>

				<?=form_label('lblEmpresa', lang('usuarioEmpresa'), 100);?>
				<?=form_combo('cmbEmpresa', $empresas, '', 304);?>

				<?=form_checkbox('chkEmpresaBoot', array('id'=>'chkEmpresaBoot'), 'S');?>
				<?=form_label('lblEmpresaBoot', lang('usuarioEmpresaBoot'), 100, array('for'=>'chkEmpresaBoot'));?>
				<?=new_line();?>

				<?=begin_JqGridPanel('gridEmpresa', 100, '', base_url().'gerenciador/usuario/listaEmpresas', array('autoload'=> false, 'sortname'=> 'nome', 'autowidth'=> true, 'caption'=> 'Setores'));?>
					<?=addJqGridColumn('id', 'ID', 0, 'right', array('hidden'=> true));?>
					<?=addJqGridColumn('nome', 'Nome', 440, 'left', array('sortable'=>false));?>
					<?=addJqGridColumn('empresa_boot', lang('usuarioEmpresaBoot'), 100, 'center', array('sortable'=>false));?>
				<?=end_JqGridPanel();?>
		
				<?=form_button('btnNovoEmpresa', lang('novo').' setor', 'novoEmpresa()');?>
				<?=form_button('btnIncluirEmpresa', lang('incluir').' setor', 'incluirEmpresa()');?>
				<?=form_button('btnExcluirEmpresa', lang('excluir').' setor', 'excluirEmpresa()');?>
				<?=new_line();?>
			<?=end_form();?>
					
			<?=begin_JqGridPanel('gridPerfil', 150, '', base_url().'gerenciador/empresa/listaPerfisEmpresaGrid', array('autoload'=> false, 'sortname'=> 'nome_perfil', 'autowidth'=> true, 'caption'=> 'Módulos'));?>
				<?=addJqGridColumn('id', 'ID', 0, 'right', array('hidden'=> true));?>
				<?=addJqGridColumn('nome_perfil', lang('usuarioPerfil'), 520, 'left');?>
			<?=end_JqGridPanel();?>

			<?=form_button('btnSalvarPerfis', lang('salvar'). ' perfis', 'salvarPerfis()');?>							
		<?=end_Tab();?>
		<?=begin_Tab(lang('usuarioTab3'));?>
			<?=begin_form('gerenciador/usuario/salvarUsuarioProgramaAcessos', 'formUsuarioProgramaAcesso');?>
				<?=form_hidden('txtIdUsuarioProgramaAcesso', @$usuario->id);?>

				<?=begin_ToolBar(array('imprimir', 'abrir', 'ajuda', 'pesquisar', 'voltar-pagina', 'novo', 'salvar', 'excluir'));?>
					<?=addButtonToolBar('Marcar/Desmarcar todos programas', 'marcarDesmarcarTodos()', 'btnMarcarDesmarcarTodos', 'ui-icon-check');?>					
				<?=end_ToolBar();?>

				<ul id="permissao_aplicativos" class="ui-widget treeview-gray" style="white-space: nowrap; background-color:none !important; overflow: auto !important">
					<li class="no-tabs">
						<span>/</span>
						<ul style="background: none !important;"> 
							<?=$permissao_aplicativos;?>	
						</ul>
					</li>
				</ul>
			<?=end_form();?>
		<?=end_Tab();?>		
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script type="text/javascript">

	var loadGridEmpresa = false;
	var loadGridGruposAcessos = false;
	var programasChecked = false;

	function init(){
		$('.permissoes').button({text: false, icons: {primary: 'ui-icon-wrench'}}).live('click', function(){
			$('button').blur();			
			openWindow(BASE_URL+'gerenciador/usuario/permissoes/'+this.id, '<?=lang('usuarioTab3');?> - ' + $('#p-'+this.id).text(), 700, false);
		});

		if($('#txtCodigo').val() == '')
			$("#tab").tabs( "option", "disabled", [1, 2, 3]);
	}
	
	function tabShow(index){
		switch(index){
			case 1:
				if($('#txtCodigo').val() != '' && !loadGridGruposAcessos){
					loadGridGruposAcessos = true;
					gridGrupoAcesso.load();
				}
				break;
			case 2:
				if($('#txtCodigo').val() != '' && !loadGridEmpresa){
					loadGridEmpresa = true;
					gridEmpresa.addParam('usuarioId', $('#txtCodigo').val());
					gridEmpresa.load();					
				}
				break;			
		}		
	}
	
	function gridEmpresa_click(id){
		var usuarioId = id.split("chr", 2)[0];
		var empresaId = id.split("chr", 2)[1];
		$('#txtIdUsuarioEmpresa').val(usuarioId);
		$('#cmbEmpresa').val(empresaId);
		$("#cmbEmpresa").selectmenu('value', $('#cmbEmpresa').get(0).selectedIndex);
		$.post(BASE_URL+'gerenciador/usuario/getEmpresaUsuario', {usuarioId: usuarioId, empresaId: empresaId},
			function(data){
				if(data.usuarioEmpresa.empresa_boot == 'S')
					document.getElementById('chkEmpresaBoot').checked = true;
				else
					document.getElementById('chkEmpresaBoot').checked = false;
			}, 'json');
		$("#gridPerfil").setGridParam({url:BASE_URL+'gerenciador/empresa/listaPerfisEmpresaGrid?empresaId='+empresaId, page:1}).trigger("reloadGrid");
	}
	
	function gridGrupoAcesso_loadComplete(){
		var usuarioId = $('#txtIdUsuarioGrupoAcesso').val();		
		if(usuarioId != '')
			$.post(BASE_URL+'gerenciador/usuario/listaGruposAcessosUsuario', {usuarioId: usuarioId},
				function(data){
					for(var i = 0; i < data.usuarioGruposAcessos.length; i++)
						gridGrupoAcesso.setSelectRow(data.usuarioGruposAcessos[i].grupo_acesso_id);
				}, 'json');
	}
	
	function gridPerfil_loadComplete(){
		var usuarioId = $('#txtIdUsuarioEmpresa').val();
		var empresaId = $('#cmbEmpresa').val();
		if(usuarioId != '' && empresaId != '')
			$.post(BASE_URL+'gerenciador/usuario/listaPerfisUsuario', {usuarioId: usuarioId, empresaId: empresaId},
				function(data){
					for(var i = 0; i < data.usuarioPerfis.length; i++)
						$("#gridPerfil").jqGrid('setSelection', data.usuarioPerfis[i].id);
				}, 'json');
	}

	function enableTabs(){
		$('#tab').tabs("option","disabled",[]);
	}

	function novo(){
		location.href = BASE_URL+'gerenciador/usuario/novo';
	}

	function salvar(){
		switch($("#tab").tabs("option", "selected")){
			case 0:
				formUsuario_submit();
				break;
			case 1:
				$('#txtGruposAcessos').val(gridGrupoAcesso.serializeSelectedRows());
				formGrupoAcesso_submit();
				break;
			case 3:
				formUsuarioProgramaAcesso_submit();
				break;
		}
	}
	
	function formUsuario_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		}else{
			if(data.success != undefined) {
				$('#txtCodigo').val(data.usuario.id);
				$('#txtIdUsuarioEmpresa').val(data.usuario.id);
				$('#txtIdUsuarioGrupoAcesso').val(data.usuario.id);				
				$('#txtIdUsuarioProgramaAcesso').val(data.usuario.id);				
	      		messageBox(data.success.message, enableTabs);
			}
	    }
	}
	
	function formGrupoAcesso_callback(data){		
		if(data.success == 'true')
			messageBox("<?=lang('registroGravado');?>");
		else
			messageErrorBox("<?=lang('registroNaoGravado');?>");
	}

	function formUsuarioProgramaAcesso_callback(data){
		if(data.error != undefined)
			messageErrorBox(data.error.message, data.error.field);
		else
			if(data.success != undefined)
	      		messageBox(data.success.message);
	}

	function incluirEmpresa(){
		formEmpresa_submit();
	}

	function formEmpresa_callback(data){
		if(data.error != undefined)
			messageErrorBox(data.error.message, data.error.field);
		else
			if(data.success != undefined)
	      		messageBox(data.success.message, novoEmpresa);
	}

	function novoEmpresa(){
		$('#cmbEmpresa').val();
		$("#cmbEmpresa").selectmenu('value', 0);
		document.getElementById('chkEmpresaBoot').checked = false;
		$("#gridEmpresa").setGridParam({url:BASE_URL+'gerenciador/usuario/listaEmpresas?usuarioId='+$('#txtCodigo').val(), page:1}).trigger("reloadGrid");
		$("#gridPerfil").clearGridData();
	}

	function excluirEmpresa(){		
		if(gridEmpresa.getSelectedRows().length == 0)
			messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
		else
			messageConfirm('<?=lang('excluirRegistros')?>', confirmaExcluirEmpresa);		
	}
	
	function confirmaExcluirEmpresa(confirma){
		if(confirma){
			var usuarioId = $('#txtIdUsuarioEmpresa').val();
			var empresaId = $('#cmbEmpresa').val();
			$.post(BASE_URL+'gerenciador/usuario/excluirEmpresa', {usuarioId: usuarioId, empresaId: empresaId},
				function(data){
					if(data.success == 'false')
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
					else
						messageBox("<?=lang('registroExcluido')?>", novoEmpresa);
				}, 'json');	
		}
	}

	function salvarPerfis(){
		var perfisUsuario = '';
		var perfisUsuarioGrid = getSelectedRows("gridPerfil");
		for(var i = 0; i < perfisUsuarioGrid.length; i++){
			if(perfisUsuario == '')
				perfisUsuario = perfisUsuarioGrid[i];
			else
				perfisUsuario += ',' + perfisUsuarioGrid[i];
		}
		$("#txtPerfis").val(perfisUsuario);
		$.post(BASE_URL+'gerenciador/usuario/salvarPerfis',
				{empresaId: $('#cmbEmpresa').val(), perfisId: $("#txtPerfis").val(), usuarioId: $('#txtCodigo').val()},
				function(data){
					if(data.success == 'true')
						messageBox("<?=lang('registroGravado');?>");
					else
						messageErrorBox("<?=lang('registroNaoGravado');?>");
				},'json');
	}
	
	function marcarDesmarcarTodos(){
		if(programasChecked)
			programasChecked = false;
		else
			programasChecked = true;
		
		var programas_acessos = $('input[name="programas_acessos[]"]').get();
		console.log('total = '+programas_acessos.length);
		for(var i =0; i < programas_acessos.length; i++) {
			console.log(programas_acessos[i].id);
			$("#"+programas_acessos[i].id).attr('checked', programasChecked);
		}
	}
	
	function fazerLoginComo(){
		location.href = BASE_URL+'gerenciador/usuario/fazerLoginComo/'+$('#txtCodigo').val();
	}

</script>