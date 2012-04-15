<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('salvar', 'abrir', 'imprimir'));?>
	<?=end_ToolBar();?>
	
	<?=begin_TabPanel(50);?>
		<?=begin_Tab(lang('usuarioFiltro'));?>
			<?=form_label('lblNome', lang('usuarioNome'), 80);?>
			<?=form_textField('txtNome', '', 300, '');?>
			<?=new_line();?>

			<?=form_label('lblLogin', lang('usuarioLogin'), 80);?>
			<?=form_textField('txtLogin', '', 150, '');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

	<?=begin_JqGridPanel('gridUsuario', 'auto', '', base_url().'gerenciador/usuario/listaUsuarios', array('sortname'=> 'nome', 'autowidth'=> true, 'toppager' => true, 'rowNum' => 25, 'pager'=> true, 'caption'=>'Lista de Usuários'));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('nome', 'Nome', 300, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('login', 'Login', 150, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('email', 'Email', 200, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', 'Dt. cadastro', 100, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	
	function pesquisar(){		
		gridUsuario.addParam('nome', $("#txtNome").val());
		gridUsuario.addParam('login', $("#txtLogin").val());
		gridUsuario.load();
	}

	function novo(){
		location.href = BASE_URL+'gerenciador/usuario/novo';
	}

	function gridUsuario_click(id){
		location.href = BASE_URL+'gerenciador/usuario/editar/'+id;
	}
	
	function excluir(){
		if(getSelectedRows('gridUsuario').length == 0){
			messageErrorBox('Nenhum registro selecionado');
		}else{
			messageConfirm('Deseja excluir os registros selecionados ?', confirmaExcluir);
		}
	}
	
	function confirmaExcluir(confirma){
		window.alert(confirma);
	}

</script>