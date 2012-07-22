<?=$this->load->view("../../static/_views/headerGlobalView");?>

	<?=path_bread($path_bread);?>

	<?=begin_ToolBar(array('novo', 'excluir', 'salvar', 'abrir', 'imprimir', 'pesquisar'))?>
	<?=end_ToolBar()?>

	<?=begin_TabPanel();?>
		<?=begin_Tab(lang('systemInfoPhp'));?>
			<?=phpinfo();?>
		<?=end_Tab();?>
                <?=begin_Tab(lang('systemInfoDB'));?>
			<?=form_label('lblNome', lang('systemInfoDBInformacao'), 100);?>
			<?=form_textField('txtSystemInfoDBInfo', @$db_version, 600, '', '','',true);?>
                        <?=new_line();?>
                        <?=form_label('lblNomeDB', lang('systemInfoDBHost'), 100);?>
                        <?=form_textField('txtSystemInfoDBHost', @$db_host, 150, '', '','',true);?>
                        <?=new_line();?>
                        <?=form_label('lblNomeDB', lang('systemInfoDBNome'), 100);?>
                        <?=form_textField('txtSystemInfoDBName', @$db_corrent, 150, '', '','',true);?>
		<?=end_Tab();?>
	<?=end_TabPanel();?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>
