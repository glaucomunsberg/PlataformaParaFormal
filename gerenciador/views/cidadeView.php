<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('imprimir', 'abrir', 'pesquisar', 'excluir'));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabCidadeFiltro');?>
		<?=begin_Tab(lang('cidadeFiltro'));?>
			<?=begin_form('gerenciador/cidade/salvar', 'formCidade');?>
                            <?=form_hidden('txtCidadeId', @$cidade->id);?>
                            <?=form_hidden('txtCidadeLat', @$cidade->lat);?>
                            <?=form_hidden('txtCidadeLng', @$cidade->lng);?>

                            <?=form_label('lblNome', lang('cidadeCidade'), 80);?>
                            <?=form_textField('txtCidade', @$cidade->nome, 300, '');?>
                            <?=new_line();?>

                            <?=form_label('lblCmbEstado', lang('cidadeEstado'), 80);?>
                            <?=form_combo('cmbEstado', @$estados, @$cidade->unidade_federativa_id, 150);?>
                            <?=new_line();?>

                            <?=form_label('lblTipoPonte', lang('cidadeLocalizacao'), 80);?>
                            <?=form_MapWithMarker('marcador', @$cidade->lat, @$cidade->lng, '370', '250', 'map', true, true, '4')?>
                            <?=new_line();?>

			<?=end_form();?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>

	function ajuda(){
                window.open ('<?=WIKI;?>Cidades');
        }

	function novo(){
		location.href = BASE_URL+'gerenciador/cidade/novo/';
	}

	function listaCidades(){
		location.href = BASE_URL+'gerenciador/cidade/';
	}

	function salvar(){
		formCidade_submit();
	}
        
        function form_MapWithMarker_position(lat,longi){
            $('#txtCidadeLat').val(lat);
            $('#txtCidadeLng').val(longi);
        }
        
        function form_MapWithMarker_setPosicao($latitude,$longitude) {
            var latlng = new google.maps.LatLng($latitude, $longitude);
            window.marker.setPosition(latlng);
        }
	
	function formCidade_callback(data){
		if(data.error != undefined){
			messageErrorBox(data.error.message, data.error.field);
		} else if(data.success != undefined) {
                        txtCidadeId.val(data.cidade.id);
                        messageBox(data.success.message, listaCidades);
                }
	} 	
</script>