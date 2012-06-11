<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabParaformalidade');?>
		<?=begin_Tab(lang('ponteFiltro'));?>
			<?=begin_form('paraformalidade/cadastros/grupoAtividade/salvar', 'formGrupoAtividade');?>
				<?=form_hidden('txtGrupoAtividadeId', @$grupo_atividade->id);?>
                                <?=form_hidden('txtLatOrigem', @$grupo_atividade->geocode_origem_lat); ?>
                                <?=form_hidden('txtLngOrigem', @$grupo_atividade->geocode_origem_lng); ?>

                                <?=begin_JqGridPanel('gridParaformalidades', 'auto', '', base_url().'paraformalidade/cadastros/paraformalidade/listaParaformalidades/', array('sortname'=> 'descricao', 'autowidth'=> true, 'pager'=> true));?>
                                        <?=addJqGridColumn('id', 'ID', 0, 'right', array('sortable'=>true, 'hidden'=> true));?>
                                        <?=addJqGridColumn('descricao', lang('paraformalidadesDescricao'), 15, 'left', array('sortable'=>true));?>
                                        <?=addJqGridColumn('nome', lang('paraformalidadesColaborador'), 10, 'left', array('sortable'=>true));?>
                                        <?=addJqGridColumn('tipo_registro_atividade', lang('paraformalidadesTipoRegistroAtividade'), 10, 'center', array('sortable'=>true));?>
                                        <?=addJqGridColumn('tipo_local', lang('paraformalidadesTipoLocal'), 10, 'center', array('sortable'=>true));?>
                                        <?=addJqGridColumn('tipo_condicao_ambiental', lang('paraformalidadesTipoCondicaoAmbiental'), 10, 'center', array('sortable'=>true));?>
                                        <?=addJqGridColumn('tipo_elemento_descricao', lang('paraformalidadesTipoElemento'), 10, 'center', array('sortable'=>true));?>
                                        <?=addJqGridColumn('tipo_ponte', lang('paraformalidadesTipoPonte'), 10, 'center', array('sortable'=>true));?>
                                        <?=addJqGridColumn('dt_cadastro', lang('grupoAtividadeDtCadastro'), 5, 'center', array('sortable'=>true));?>      
                                <?=end_JqGridPanel();?>
                                <?=new_line();?>
                                <div id="editarNovo" style="display:block">
                                    <div style="float: left;">
                                        <?=form_label('lblColorador', lang('paraformalidadesImagemPequena'), 110);?>
					<? if(@$grupo_atividade->imagem_id == '') {?>
						<img id="img_foto_carteira" src="<?=IMG;?>/default_avatar.jpg" style="display: block; float: left; margin-right: 5px; width: 100px;"/>
					<? }else{?>
						<img id="img_foto_carteira" src="<?=BASE_URL;?>util/download/arquivo/<?=$pessoa->nome_gerado;?>/3x4" style="display: block; float: left; margin-right: 5px; width: 100px;"/>
					<? }?>
                                    </div>
                                    <?=new_line();?>
                                    
                                    <?=form_label('lblColorador', lang('paraformalidadesEnviarImagem'), 110);?>
                                    <?=form_file('arquivoImportacao', '', '', '');?>
                                    <?=new_line();?>

                                    <?=form_label('lblColorador', lang('paraformalidadesColaborador'), 110);?>
                                    <?=form_textFieldAutoComplete('txtColaboradorId', BASE_URL . 'paraformalidade/cadastrosBasicos/colaborador/buscarColaborador', @$paraformalidade->colaboradorId, @$paraformalidade->colaboradorNome, 365) ?>
                                    <?=new_line();?>

                                    <?=form_label('lblTipoRegistroAtividade', lang('paraformalidadesRegistroAtividade'), 110);?>
                                    <?=form_combo('cmbTipoRegistroAtividade', @$tipo_registros_atividades, '', 150, '');?>
                                    <?=new_line();?>
                                    
                                    <?=form_label('lblTipoLocal', lang('paraformalidadesLocal'), 110);?>
                                    <?=form_combo('cmbTipoLocal', @$tipo_local, '', 150, '');?>
                                    <?=new_line();?>
                                    
                                    <?=form_label('lblTipoCondicoesAmbientais', lang('paraformalidadesCondicaoAmbiental'), 110);?>
                                    <?=form_combo('cmbTipoCondicaoAmbiental', @$tipo_condicoes_ambientais, '', 150, '');?>
                                    <?=new_line();?>
                                    
                                    <?=form_label('lblTipoElementoSituacao', lang('paraformalidadesElementoSituacao'), 110);?>
                                    <?=form_combo('cmbTipoElementoSituacao', @$tipo_elemento_situacao, '', 150, '');?>
                                    <?=new_line();?>
                                    
                                    <?=form_label('lblTipoPonte', lang('paraformalidadesPonte'), 110);?>
                                    <?=form_combo('cmbTipoPonte', @$tipo_ponte, '', 150, '');?>
                                    <?=new_line();?>
                                    
                                    <?=form_label('lblTipoPonte', lang('paraformalidadesLocalizacao'), 110);?>
                                    <?=form_MapWithMarker('marcador', @$grupo_atividade->geocode_origem_lat, @$grupo_atividade->geocode_origem_lng, '260', '250', 'map', true, true)?>
                                    <?=new_line();?>
                                </div>
			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
        (function(){
            //Funcao anonima e de sempre execução
        })();
        
	function ajuda(){
                window.open ('<?=WIKI;?>Grupos Atividades');
        }
        
        function finishUploadarquivoImportacao(){
            console.log('arquivo enviado com sucesso');		
	}

	function novo(){
		//location.href = BASE_URL+'paraformalidade/cadastros/grupoAtividade/novo/';
                var state = document.getElementById('editarNovo').style.display;
                if (state == 'block') {
                    document.getElementById('editarNovo').style.display = 'none';
                } else {
                    document.getElementById('editarNovo').style.display = 'block';
                }
 
                //$('editarNovo').show("slow");
	}

	function listaGrupoAtividade(){
		location.href = BASE_URL+'paraformalidade/cadastros/grupoAtividade/';
	}

	function salvar(){
		formGrupoAtividade_submit();
	}
	
	function formGrupoAtividade_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else {
			if(data.success != undefined) {
				$('#txtGrupoAtividadeId').val(data.grupo_atividade.id);
                        messageBox(data.success.message, listaGrupoAtividade);
			}
	    }
	} 

	function excluir(){
		if($('#txtPonteId').val() == ''){
			messageErrorBox("<?=lang('nenhumRegistroSelecionado')?>");
		}else{
			messageConfirm('<?=lang('excluirRegistros')?>', excluirGrupoAtividade);
		}
	}

	function excluirGrupoAtividade(confirmaExclusao){
		if(confirmaExclusao){
			$.post(BASE_URL+'paraformalidade/cadastros/grupoAtividade/excluir/', {id: $('#txtGrupoAtividadeId').val()}, 
				function(data){
					if(data.success)
						messageBox("<?=lang('registroExcluido')?>", listaGrupoAtividade);
					else
						messageErrorBox("<?=lang('registroNaoExcluido')?>");
				});
		}
	}	
        
        function form_MapWithRoute_position(origem, destino, total, caminhos ){
            $('#txtLatOrigem').val(origem.lat());
            $('#txtLngOrigem').val(origem.lng());
            $('#txtLatDestino').val(destino.lat());
            $('#txtLngDestino').val(destino.lng());
            $('#txtRotaEmKm').val(total);

        }
</script>