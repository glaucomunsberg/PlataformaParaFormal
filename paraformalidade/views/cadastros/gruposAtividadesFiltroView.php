<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabPontes');?>
		<?=begin_Tab(lang('grupoAtividadeFiltro'));?>
			<?=form_label('lblDescricao', lang('grupoAtividadeDescricao'), 80);?>
			<?=form_textField('txtDescricao', '', 300, '');?>
                        <?=new_line();?>

                        <?=form_label('lblCidade', lang('grupoAtividadeCidade'), 80);?>
                        <?= form_textFieldAutoComplete('txtGrupoAtividadeCidadeId', BASE_URL . 'paraformalidade/cadastros/gruposAtividades/buscarCidade', '', '', 300) ?>
                        <?=new_line();?>
                        
                        <?=form_label('lblDtInicio', lang('grupoAtividadeData'), 80);?>
			<?=form_dateField('Dt_Ocorrencia');?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gridGrupoAtividade', 'auto', '', base_url().'paraformalidade/cadastros/gruposAtividades/listaGruposAtividades/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('grupoAtividadeLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                <?=addJqGridColumn('nomecidade', lang('grupoAtividadeCidade'), 20, 'left', array('sortable'=>true));?>
                <?=addJqGridColumn('descricao', lang('grupoAtividadeDescricao'), 70, 'left', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_ocorrencia', lang('grupoAtividadeDtCadastro'), 10, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
    
	function ajuda(){
            window.open ('<?=WIKI;?>Grupos de Atividade');
        }
        
	function pesquisar(){
               gridGrupoAtividade.addParam('txtDescricao', $('#txtDescricao').val());
               gridGrupoAtividade.addParam('Dt_Ocorrencia', $('#Dt_Ocorrencia').val());
               gridGrupoAtividade.addParam('txtGrupoAtividadeCidadeId', $('#txtGrupoAtividadeCidadeId').val());
               gridGrupoAtividade.load();
        }
	
	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastros/gruposAtividades/novo/';
	}
 
	
	function gridGrupoAtividade_click(id){
		location.href = BASE_URL+'paraformalidade/cadastros/gruposAtividades/editar/'+id;
	}

	function excluir(){		
		if(getSelectedRows('gridGrupoAtividade').length == 0)
			messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
		else
			messageConfirm('<?=lang('excluirRegistros')?>', excluirGrupoAtividade);
	}
	
	function excluirGrupoAtividade(confirmaExclusao){
		if(confirmaExclusao){
			var pontes
			var ponteGrid = getSelectedRows('gridGrupoAtividade');
			for(var i = 0; i < ponteGrid.length; i++)
				if( pontes == '')
					 pontes = NotaTiposGrid[i];
				else
					 pontes += ',' + ponteGrid[i];

			$.post(BASE_URL+'paraformalidade/cadastros/gruposAtividades/excluir/', {id:  pontes}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", pesquisar);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}		

</script>