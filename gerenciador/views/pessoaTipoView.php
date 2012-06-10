<?=$this->load->view("../../static/_views/headerGlobalView");?>
    <?= path_bread($path_bread) ?>
	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel();?>
		<?=begin_Tab(lang('tipoPessoaTipo'));?>
			<?=begin_form('gerenciador/pessoaTipo/salvar', 'formPessoaTipo');?>
                                <?=form_hidden('txtPessoaTipoId', @$pessoa_tipo->id);?>
				<?=form_label('lblNome', lang('tipoPessoa'), 80);?>
				<?=form_textField('txtPessoaTipo', @$pessoa_tipo->tipo, 300, '');?>
				<?=new_line();?>

			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel()?>

<script type="text/javascript">
    function ajuda(){
    	window.open ('<?=WIKI;?>Pessoa_Tipo');
    }
    
    function novo(){
        location.href = BASE_URL+'gerenciador/pessoaTipo/novo';
    }
    
    function salvar(){
	formPessoaTipo_submit();
        location.href = BASE_URL+'gerenciador/pessoaTipo/';
    }
    
    function listaPessoaTipo(){
	location.href = BASE_URL+'gerenciador/pessoaTipo/';
    }
    
    function excluir(){
	if($('#txtPessoaTipoId').val() == ''){
		messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
	}else{
		messageConfirm('<?=lang('excluirRegistros')?>', excluirPessoaTipo);
            }
	}

	function excluirPessoaTipo(confirmaExclusao){
            if(confirmaExclusao){
                $.post(BASE_URL+'gerenciador/pessoaTipo/excluir/', {id: $('#txtPessoaTipoId').val()}, 
                function(data){
			if(data.success)
                        	messageBox("<?=lang('registroExcluido')?>", listaPessoaTipo);
			else
					messageErrorBox("<?=lang('registroNaoExcluido')?>");
			});
		}
	}
</script>

<?=$this->load->view("../../static/_views/footerGlobalView")?>