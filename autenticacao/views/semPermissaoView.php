<?= $this->load->view("../../static/_views/headerGlobalView"); ?>
<?= $this->load->view("../../static/_views/footerGlobalView"); ?>
<script>
	function init(){
		messageBox("<?=$mensagem?>", 400, 100, voltarInicio);
	}
	
	function voltarInicio(){
		location.href = BASE_URL+'dashboard/inicio';
	}
</script>