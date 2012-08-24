<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('abrir', 'salvar', 'imprimir', 'excluir' ));?>
	<?=end_ToolBar();?>

	<?=begin_TabPanel('tabPontes');?>
		<?=begin_Tab(lang('galeriaDoParaformalSee'));?>
			<?=form_gallery('nome',@$cmbImagens);?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>
	
<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script>
	function ajuda(){
    	window.open ('<?=WIKI;?>Galeria da Paraformalidade');
        }	

</script>