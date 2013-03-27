<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'imprimir','pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabPontes');?>
		<?=begin_Tab(lang('grupoAtividadeFiltro'));?>
			<?=form_hidden('txtGrupoAtividadeId', @$grupo_atividade->id);?>
                        <?=form_label('lblPessoa', lang('equipeGrupoAtividadePessoa'), 80);?>
                        <?=form_textFieldAutoComplete('txtPessoaId', BASE_URL . 'paraformalidade/cadastros/equipesGruposAtividades/buscarPessoa', '', '', 300) ?>
                        <?=new_line();?>

                        <?=form_label('lblTipo', lang('equipeGrupoAtividadeTipoParticipacao'), 80);?>
			<?=form_combo("cmbParticipacao", @$tipo_participacao, '', 200) ?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
	<?=begin_JqGridPanel('gripEquipeGruposAtividades', 'auto', '', base_url().'paraformalidade/cadastros/equipesGruposAtividades/listaEquipe/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true, 'caption'=>lang('equipeGrupoAtividadeLista')));?>
		<?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
		<?=addJqGridColumn('nome', lang('equipeGrupoAtividadePessoa'), 80, 'left', array('sortable'=>true));?>
                <?=addJqGridColumn('descricao', lang('equipeGrupoAtividadeCoordenador'), 10, 'center', array('sortable'=>true));?>
		<?=addJqGridColumn('dt_cadastro', lang('equipeGrupoAtividadeDtCadastro'), 10, 'center', array('sortable'=>true));?>
	<?=end_JqGridPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
    
	function ajuda(){
            window.open ('<?=WIKI;?>Equipe Grupos de Atividade');
        }
        
	function pesquisar(){
               gripEquipeGruposAtividades.addParam('txtGrupoAtividadeId', $('#txtGrupoAtividadeId').val());
               gripEquipeGruposAtividades.load();
        }
        
        function novo(){
            $('#txtPessoaId').val('');
            $('#searchtxtPessoaId').val('');
            $('#cmbCoordenador').select('')
            
	}
        
        function excluir(){
            var colaborador
            var equipeGrid = getSelectedRows('gripEquipeGruposAtividades');
                for(var i = 0; i < equipeGrid.length; i++)
                    if( colaborador == '')
                        colaborador = equipeGrid[i];
                    else
                        colaborador += ',' + equipeGrid[i];

		$.post(BASE_URL+'paraformalidade/cadastros/equipesGruposAtividades/excluir/', {id: colaborador}, 
                    function(data){
                        if(data.success)
                            messageBox("<?=lang('registroExcluido')?>", pesquisar);
                        else
                            messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
        }
	function salvar(){
             $.ajax(
                    {
                            method: "get",
                            data: { pessoa_id: $('#txtPessoaId').val(), grupo_atividade_id: $('#txtGrupoAtividadeId').val(), tipo_participacao: $('#cmbParticipacao').val() },
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

</script>