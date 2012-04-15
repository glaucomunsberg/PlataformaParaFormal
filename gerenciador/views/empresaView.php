<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'ajuda', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel();?>		
		<?=begin_Tab(lang('empresaTituloTab'));?>
			<?=begin_form('gerenciador/empresa/salvar');?>
				<?=form_hidden('txtPerfis');?>

				<?=form_label('lblCodigo', 'Código', 80);?>
				<?=form_textField('txtCodigo', @$empresa->id, 40, '', 4, array('readonly' => 'true', 'style' => 'text-align:right;',));?> 
				<?=new_line();?>
				
				<?=form_label('lblNome', lang('empresaNome'), 80);?>
				<?=form_textField('txtNome', @$empresa->nome, 300, '');?>
				<?=new_line();?>
				
				<?=form_label('lblDtCadastro', lang('empresaDtCadastro'), 80);?>
				<?=form_dateField('dtCadastro', @$empresa->dt_cadastro, array('disabled'=>'true'));?>
				<?=new_line();?>
				
				<?=begin_JqGridPanel('gridPerfil', 'auto', '', base_url().'gerenciador/perfil/listaPerfis', array('sortname'=> 'nome_perfil', 'autowidth'=> true, 'caption'=> 'Lista de Módulos'));?>
					<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
					<?=addJqGridColumn('nome_perfil', lang('perfilNome'), 420, 'left', array('sortable'=>false));?>
				<?=end_JqGridPanel();?>
				
			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	
	function init(){
		if($('#txtCodigo').val() == '')
			$("#tab").tabs('disable', 1);
	}

	function gridPerfil_loadComplete(){
		var empresaId = $('#txtCodigo').val();
		$.post(BASE_URL+'gerenciador/empresa/listaPerfisEmpresa', {empresaId: empresaId},
			function(data){
				for(var i = 0; i < data.empresaPerfis.length; i++)
					$("#gridPerfil").jqGrid('setSelection', data.empresaPerfis[i].perfil_id);
			}, 'json');
	}

	function salvar(){
		var perfisEmpresa = '';
		var perfisEmpresaGrid = getSelectedRows("gridPerfil");
		for(var i = 0; i < perfisEmpresaGrid.length; i++){
			if(perfisEmpresa == '')
				perfisEmpresa = perfisEmpresaGrid[i];
			else
				perfisEmpresa += ',' + perfisEmpresaGrid[i];
		}

		$('#txtPerfis').val(perfisEmpresa);
		formDefault_submit();
	}

	function excluir(){
		if($("#txtCodigo").val() == "")
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		else
			messageConfirm("<?=lang('excluirRegistro')?>", excluirEmpresa);
	}

	function excluirEmpresa(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+'gerenciador/empresa/excluir/', {empresas: $("#txtCodigo").val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", novo);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}

	function formDefault_callback(data){
		if(data.error != undefined){
				messageErrorBox(data.error.message, data.error.field);
		}else{
			if(data.sucess != undefined) {
				$('#txtCodigo').val(data.empresa.id);
				$('#dtCadastro').val(data.empresa.dtCadastro);
				messageBox(data.sucess.message);
			}
	    }
	}	

	function novo(){		
		location.href = BASE_URL+'gerenciador/empresa/novo';
	}

</script>