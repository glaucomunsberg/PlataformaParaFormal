<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'ajuda', 'pesquisar'));?>
	<?=end_ToolBar();?>
	
	<?=begin_TabPanel(217);?>
		<?=begin_Tab(lang('pessoaTituloTab'));?>
			<?=begin_form('gerenciador/pessoa/salvar');?>
				<?=form_label('lblCodigo', 'Código', 80);?>
				<?=form_textField('txtCodigo', @$pessoa->id, 40, '', 4, array('readonly' => 'true', 'style' => 'text-align:right;',));?> 
				<?=new_line();?>
				
				<?=form_label('lblNome', lang('pessoaNome'), 80);?>
				<?=form_textField('txtNome', @$pessoa->nome, 300, '');?>
				<?=new_line();?>
				
				<?=form_label('lblDtCadastro', lang('pessoaDtCadastro'), 80);?>
				<?=form_dateField('dtCadastro', @$pessoa->dt_cadastro, array('disabled'=>'true'));?>
				<?=new_line();?>
				
				<?=form_label('lblTituloGrupo', lang('pessoaGrupo'), 80, array('style' => 'font-weight: bold;',));?>
				<?=new_line();?>
				
			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel()?>
	
<?=$this->load->view("../../static/_views/footerGlobalView")?>

<script type="text/javascript">

	function gridGrupos_init(){
		$j.post("<?= base_url();?>gerenciador/pessoa/listaGruposPessoa", {pessoaId: <?=@$pessoa->id;?>},
			function(data){
				var gruposPessoa = new Array();
				for(var i = 0 ; i < data.pessoaGrupos.length ; i++) {
					gruposPessoa[i] = dsgridGrupos.getById(data.pessoaGrupos[i].grupo_id);
				}
				gridGrupos.getSelectionModel().selectRecords(gruposPessoa);				
			});		
	}
	

	function novo(){
		location.href = '<?=base_url()."gerenciador/pessoa/novo"?>';
	}

	function salvar(){
		var gruposUsuario = '';
		var gruposUsuarioGrid = gridGrupos.getSelectionModel().getSelections();
		for(var i = 0; i < gruposUsuarioGrid.length; i++){
			if(gruposUsuario == '')
				gruposUsuario = gruposUsuarioGrid[i].id;
			else
				gruposUsuario += ',' + gruposUsuarioGrid[i].id;
		}
		document.getElementById('txtGrupos').value = gruposUsuario;
		formDefault_submit();
	}
	
	function formDefault_callback(data){
		if(data.error != undefined){
				messageBox(data.error.message,293,90, data.error.field);
		} else {
			if(data.sucess != undefined) {
	      		document.getElementById("txtCodigo").value = data.pessoa.id;
	      		document.getElementById("dtCadastro").value = data.pessoa.dt_cadastro;
	      		messageBox(data.sucess.message,280,90, atualizaFiltro);
			}
	    }
	}
	
	function excluir(){
		if(document.getElementById("txtCodigo").value == ""){
			messageBox("<?=lang('nenhumRegistroSelecionado')?>", 250, 80);
		}else{
			messageConfirm("<?=lang('excluirRegistro')?>", 370, 80, excluirPessoa);							
		}
	}
	
	function excluirPessoa(confirmaExclusao){
		if(confirmaExclusao){
			$j.post("<?= base_url();?>gerenciador/pessoa/excluir", {id: document.getElementById("txtCodigo").value}, atualizaFiltro);			
			messageBox("<?=lang('registroExcluido')?>", 250, 80, novo);
		}
	}		
	
	function atualizaFiltro(){
		parent.pesquisar();
	}
</script>