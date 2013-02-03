<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'imprimir','pesquisar' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabPontes');?>
		<?=begin_Tab(lang('grupoAtividadeFiltro'));?>
			<?=form_hidden('txtGrupoAtividadeId', @$grupo_atividade->id);?>
                        <?=form_label('lblCidade', lang('equipeGrupoAtividadePessoa'), 80);?>
                        <?=form_textFieldAutoComplete('txtPessoaId', BASE_URL . 'paraformalidade/cadastros/equipesGruposAtividades/buscarPessoa', '', '', 300) ?>
                        <?=new_line();?>
                        
                        <?=form_label('lblDtInicio', lang('equipeGrupoAtividadeCoordenador'), 80);?>
			<?=form_combo("cmbCoordenador", $coordenador, '', 90) ?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gripEquipeGruposAtividades', 'auto', '', base_url().'paraformalidade/cadastros/equipesGruposAtividades/listaEquipe/', array('sortname'=> 'coordenador', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('equipeGrupoAtividadeLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('nome', lang('equipeGrupoAtividadePessoa'), 80, 'left', array('sortable'=>true));?>
                <?=addJqGridColumn('coordenador', lang('equipeGrupoAtividadeCoordenador'), 10, 'center', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('equipeGrupoAtividadeDtCadastro'), 10, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
    
	function ajuda(){
            window.open ('<?=WIKI;?>Grupos de Atividade');
        }
        
	function pesquisar(){
               gripEquipeGruposAtividades.addParam('txtGrupoAtividadeId', $('#txtGrupoAtividadeId').val());
               gripEquipeGruposAtividades.load();
        }
	
	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastros/equipesGruposAtividades/editar/'+$('#txtGrupoAtividadeId').val();
	}
 
	function salvar(){
             $.ajax(
                    {
                            method: "get",
                            data: { pessoa_id: $('#txtPessoaId').val(), grupo_atividade_id: $('#txtGrupoAtividadeId').val(), coordenador: $('#cmbCoordenador').val() },
                            url: BASE_URL+"paraformalidade/cadastros/equipesGruposAtividades/inserir/",
                            beforeSend: function(){
                                $("#carregando").show();
                            },
                            // O que deve acontecer quando o processo estiver completo
                            complete: function(){
                                $("#carregando").hide();
                            },
                            // Se houve sucesso vamos carregar o resultado para o argumento
                            // "conteudo" para utilizá-lo onde desejarmos
                            success: function(conteudo){
                                if(conteudo)
                                    messageBox("<?=lang('registroExcluido')?>", pesquisar);
                                else
                                    messageErrorBox("<?=lang('registroNaoExcluido')?>");
                            }
                        }
                    );
        }

	function excluir(){		
		if(getSelectedRows('gripEquipeGruposAtividades').length == 0)
			messageErrorBox('<?=lang('nenhumRegistroSelecionado')?>');
		else
			messageConfirm('<?=lang('excluirRegistros')?>', excluirGrupoAtividade);
	}
	
	function excluirGrupoAtividade(confirmaExclusao){
		if(confirmaExclusao){
			var pontes
			var ponteGrid = getSelectedRows('gripEquipeGruposAtividades');
			for(var i = 0; i < ponteGrid.length; i++)
				if( pontes == '')
					 pontes = NotaTiposGrid[i];
				else
					 pontes += ',' + ponteGrid[i];

			$.post(BASE_URL+'paraformalidade/cadastros/equipesGruposAtividades/excluir/', {id:  pontes}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", pesquisar);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}		

</script>