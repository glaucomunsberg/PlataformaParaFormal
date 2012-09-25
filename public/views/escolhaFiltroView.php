<?=$this->load->view("../../static/_views/headerPublicView");?>

<div class="escolhaMensagem"><?=lang('escolhaMensagem');?></div>
<div class='escolhaCmb'>
    <?=form_label('lblEscolha', lang('escolhaDescubra'), 80);?>
    <?=form_combo('cmbCidadeParaformal', @$cmbCidades, '', 150);?>
</div>

<?=$this->load->view("../../static/_views/footerPublicView");?>
<script>
function init(){
		$('#cmbCidadeParaformal').change(redirect);
	}
function redirect(){
    location.href = BASE_URL+'public/escolha/exibir/'+$('#cmbCidadeParaformal').val();
}
</script>