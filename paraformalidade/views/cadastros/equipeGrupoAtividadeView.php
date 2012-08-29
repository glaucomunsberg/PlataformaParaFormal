<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>
	<?=begin_TabPanel('tabPonte');?>
		<?=begin_Tab(lang('equipeGrupoAtividadeFiltro'));?>
			<?=begin_form('paraformalidade/cadastros/equipeGrupoAtividade/salvar', 'formEquipeGrupoAtividade');?>
				<?=form_hidden('txtGrupoAtividadeId', @$grupo_atividade->id);?>
                                <?=form_hidden('txtGrupoPessoaId', '');?>

                                <?=form_label('lblEquipe', lang('equipeGrupoAtividadeParticipante'), 100);?>
                                <?=form_textFieldAutoComplete('txtPessoaId', BASE_URL . 'paraformalidade/cadastros/equipeGrupoAtividade/buscarParticipante', @$grupo_atividade->cidade_id, @$grupo_atividade_cidade->nome, 400) ?>
                                <?=new_line();?>

                                <?=form_label('lblTipoLocal', lang('equipeGrupoAtividadeResponsavelGeral'), 100);?>
                                <?=form_combo('cmbResponsavel', @$cmbResponsavel, '', 150, '');?>
                                <?=new_line();?>
                                <?=new_line();?>
                                
			<?=end_form();?>
	<?=end_TabPanel();?>

        <?=begin_JqGridPanel('gridEquipeGrupoAtividade', 'auto', '', base_url().'paraformalidade/cadastros/equipeGrupoAtividade/listaEquipeGruposAtividades/', array('sortname'=> 'responsavel,nome', 'autowidth'=> true, 'pager'=> true, 'autoload'=>false, 'caption'=>lang('equipeGrupoAtividadeEquipe')));?>
                <?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                <?=addJqGridColumn('nome', lang('equipeGrupoAtividadeNome'), 80, 'center', array('sortable'=>true));?>
                <?=addJqGridColumn('responsavel', lang('equipeGrupoAtividadeResponsavel'), 20, 'center', array('sortable'=>true));?>
        <?=end_JqGridPanel();?>
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
    
        function init(){
            pesquisar();
        }
	function ajuda(){
    	window.open ('<?=WIKI;?>Equipe Grupo de Atividade');
        }
        
	function pesquisar(){
               gridEquipeGrupoAtividade.addParam('txtGrupoAtividadeId', $('#txtGrupoAtividadeId').val());
               gridEquipeGrupoAtividade.load();
        }
        
	function novo(){
		$('#txtGrupoPessoaId').val('');
                $('#txtPessoaId').val('');
                $('#searchtxtPessoaId').val('');
                cmbResponsavel.setValueCombo('');
                pesquisar();
	}

	function listaGrupoAtividade(){
		location.href = BASE_URL+'paraformalidade/cadastros/equipeGrupoAtividade/';
	}

	function salvar(){
		formEquipeGrupoAtividade_submit();
	}
        
        function gridEquipeGrupoAtividade_click(id){
                $.post(BASE_URL+'paraformalidade/cadastros/equipeGrupoAtividade/editar/'+id, {id:id}, 
                function(data){
                      $('#txtPessoaId').val(data.pessoa.id);
                      $('#searchtxtPessoaId').val(data.pessoa.nome);
                      cmbResponsavel.setValueCombo(data.grupo_ativiade_equipe.responsavel);
                      txtGrupoPessoaId.val(data.grupo_ativiade_equipe.id)
                });                
	}
	
	function formEquipeGrupoAtividade_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
	
                            messageBox(data.success.message, pesquisar);
			}
	    }
	} 

	function excluir(){		
		if(getSelectedRows('gridEquipeGrupoAtividade').length == 0)
			messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
		else
			messageConfirm('<?=lang('excluirRegistros')?>', excluirEquipeGrupoAtividade);
	}
	
	function excluirEquipeGrupoAtividade(confirmaExclusao){
		if(confirmaExclusao){
			var pontes
			var ponteGrid = getSelectedRows('gridEquipeGrupoAtividade');
			for(var i = 0; i < ponteGrid.length; i++)
				if( pontes == '')
					 pontes = NotaTiposGrid[i];
				else
					 pontes += ',' + ponteGrid[i];

			$.post(BASE_URL+'paraformalidade/cadastros/equipeGrupoAtividade/excluir/', {id:  pontes}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", limpa);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
                                        novo();
				});
		}
	}
	
        function limpa(){
        	$('#txtGrupoPessoaId').val('');
                $('#txtPessoaId').val('');
                $('#searchtxtPessoaId').val('');
                cmbResponsavel.setValueCombo('');
                pesquisar();
        }
</script>