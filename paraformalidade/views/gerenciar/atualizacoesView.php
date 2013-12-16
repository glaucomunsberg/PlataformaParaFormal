<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar','novo'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabPonte');?>
		<?=begin_Tab(lang('atualizacaoInformacoes'));?>
			<?=begin_form('paraformalidade/gerenciar/atualizacoes/salvar', 'formAtualizacao');?>
				<?=form_hidden('txtParaformalidadeId', @$paraformalidade->id);?>
                                <?=form_hidden('txtAtualizacaoId', @$atualizacao->id);?>
                                <?
                                    $mudanca = false;
                                    if(@$atualizacao->geo_latitude != '' && @$atualizacao->geo_longitude != ''){
                                        $mudanca = true;
                                        echo form_label('lblParaformlaidade', lang('atualizacaoLocAtual'), 120); 
                                        echo form_MapWithMarker('marcadorParaformalidade', $paraformalidade->geo_latitude, $paraformalidade->geo_longitude, '370', '250', 'map', true, true);
                                        echo form_button('btnLocalizacao', 'Atualizar', 'trocarLocalizacao()');
                                        echo form_label('lblParaformlaidadeLocalizacao', lang('atualizacaoLocEnviada'), 120);
                                        echo form_textField('txtAtualizacaoLati', @$atualizacao->geo_latitude, 150, '','','',true);
                                        echo form_textField('txtAtualizacaoLong', @$atualizacao->geo_longitude, 150, '','','',true);
                                        echo new_line();
                                    }
                                    
                                    if(@$atualizacao->upload_id != ''){
                                        $mudanca = true;
                                        ?>
                                            <div style="float: left;">
                                                <?= form_label('lblImagem', lang('atualizacaoImgAtual'), 120); ?>
                                                <img id="imagem_paraformal" src="<?=base_url().'archives/'.$paraformalidade->nome_gerado; ?>" style="display: block; float: left; margin-right: 5px; width: 300px;" class="ui-widget ui-state-default ui-corner-tl ui-corner-bl ui-button-icon-only"/>
                                            </div>
                                            <?=form_button('btnTrocar', 'Atualizar', 'trocarImagem()');?>
                                            <div>
                                                <?= form_label('lblImagem', '', 75); ?>
                                                <img id="imagem_atualizacao" src="<?=base_url().'archives/'.@$atualizacao->nome_gerado; ?>" style="display: block; float: left; margin-right: 5px; width: 300px;" class="ui-widget ui-state-default ui-corner-tl ui-corner-bl ui-button-icon-only"/>
                                            </div>
                                        <?
                                    }
                                    if(!$mudanca){
                                        echo '<p><b>'.@$atualizacao->pessoa_nome.'</b> não adicionou informações de gelocalizão ou imagem. Por favor descarte essa atualização.<p>';
                                    }
                                
                                ?>
                                
			<?=end_form();?>
		<?=end_Tab();?>
                <?=begin_Tab('Enviado Por');?>
                    <?=form_label('lblPessoa', lang('atualizacaoPessoa'), 80); ?>
                    <?= form_textField('txtNome', @$atualizacao->pessoa_nome, 300, '', '', '', true); ?>
                    <?= new_line() ?>

                    <?= form_label('lblPessoaEmail', lang('atualizacaoPessoaEmail'), 80); ?>
                    <?= form_textField('txtEmail', @$atualizacao->pessoa_email, 300, '', '', '', true); ?>
                    <?= new_line() ?>

                    <?=form_label('lblDenuncia', lang('atualizacaoJustificativa'), 80); ?>
                    <?= form_textarea('txtJustificativa', @$atualizacao->descricao, 300) ?>
                    <?= new_line() ?>

                    <?= form_label('lblRevisado', lang('atualizacaoRevisado'), 80); ?>
                    <?= form_combo('cmbRevisado', @$revisado, (@$atualizacao->revisor_id == '0')?'N':'S', 80, ''); ?>
                    <?= new_line(); ?>
                <?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
            window.open ('<?=WIKI;?>Atualização');
        }
        
	function listaAtualizacoes(){
            location.href = BASE_URL+'paraformalidade/gerenciar/atualizacoes/';
	}

	function salvar(){
            formAtualizacao_submit();
	}
        
        function excluir(){
		if($('#txtAtualizacaoId').val() == ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('excluirRegistros')?>', excluirAtualizacao);
		}
	}

	function excluirAtualizacao(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+'paraformalidade/gerenciar/atualizacoes/excluir/', {id: $('#txtAtualizacaoId').val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", listaAtualizacoes);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}
	
	function formAtualizacao_callback(data){
            if(data.error != undefined){
                messageErrorBox(data.error.message, data.error.field);
            } else {
                if(data.success != undefined) {
                    $('#txtAtualizacaoId').val(data.denuncia.id);
                    messageBox(data.success.message, listaAtualizacoes);
                }
            }
	} 

</script>