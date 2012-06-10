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

                                <?=form_MapWithMarker('marcador', @$grupo_atividade->geocode_origem_lat, @$grupo_atividade->geocode_origem_lng, '260', '250', 'map', true, true)?>
                                <?=new_line();?>
                                
			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Grupos Atividades');
        }

	function novo(){
		location.href = BASE_URL+'paraformalidade/cadastros/grupoAtividade/novo/';
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