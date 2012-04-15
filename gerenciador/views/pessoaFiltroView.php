<?= $this->load->view("../../static/_views/headerGlobalView"); ?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('salvar', 'abrir', 'imprimir', 'ajuda', 'novo', 'excluir'));?>	
	<?=end_ToolBar();?>
	
	<?=begin_TabPanel(45);?>
		<?=begin_Tab(lang('pessoaFiltro'));?>
			<?=form_label('lblNome', lang('pessoaNome'), 80);?>
			<?=form_textField('txtNome', '', 300, '');?>
			<?=new_line();?>
			<?=form_label('lblNome', lang('pessoaCpf'), 80);?>
			<?=form_textField('txtCpf', '', 110, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

	<?=begin_GridPanel('gridPessoa', '', '', base_url().'gerenciador/pessoa/listaPessoas', true, true);?>
		<?=addColumn('nome', lang('pessoaNome'), 400, true, 'left');?>
		<?=addColumn('cpf', lang('pessoaCpf'), 110, true, 'center');?>
		<?=addColumn('dt_cadastro', lang('pessoaDtCadastro'), 100, true, 'center');?>
	<?=end_GridPanel();?>

<?= $this->load->view("../../static/_views/footerGlobalView"); ?>

<script>
	function pesquisar(){
		var nomePessoa = document.getElementById("txtNome").value;
		var cpf = document.getElementById("txtCpf").value;
		dsgridPessoa.baseParams.nomePessoa = nomePessoa;
		dsgridPessoa.baseParams.cpf = cpf;
		dsgridPessoa.load({params:{start:0, limit:15}});
	}
	
	function retornoConfirma(exclui){
		if(exclui){
			excluir();
		}
	}
	
	function gridPessoa_dblClick(id){
		openWindow('<?=lang('pessoaTitulo');?>', '<?=base_url()."gerenciador/pessoa/buscar/"?>'+id, 500, 300);
	}
	
	function gridPessoa_click(id){}
	
	function excluirEmpresas(confirmaExclusao){
		if(confirmaExclusao){
			var count = gridPessoa.getSelectionModel().getCount();
			var pessoas = gridPessoa.getSelectionModel().getSelections();
			for(var i=0; i < count; i++){
				$j.post("<?= base_url();?>gerenciador/pessoa/excluir", {id: pessoas[i].id});
				dsgridPessoa.remove(pessoas[i]);
			}
			messageBox("<?=lang('registroExcluido')?>", 250, 80);
		}
	}
	
	function excluir(){
		var count = gridPessoa.getSelectionModel().getCount();
		if(count > 0){
			messageConfirm("<?=lang('excluirRegistros')?>", 370, 80, excluirPessoas);
		}else{
			messageBox("<?=lang('nenhumRegistroSelecionado')?>", 250, 80);
		}
	}
</script>