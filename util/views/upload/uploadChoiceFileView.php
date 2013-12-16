<?=$this->load->view("../../static/_views/headerGlobalView");?>

<?= begin_TabPanel('tabUpload'); ?>
<div>

    <?= begin_Tab(lang('uploadTab1')); ?>
    <div>
        <?= begin_form('util/upload/enviarArquivo', 'formUploadFile', array('enctype' => 'multipart/form-data',)); ?>
        <div>
            <?= form_hidden('paramUploadAllowedTypes', @$allowed_types); ?>
            <input type="file" name="userfile" id="userfile" size="32" style="display: block; float: left; margin-bottom: 5px; margin-right: 5px;"/>
        </div>
        <?= end_form(); ?>
        <?= new_line(); ?>
        <?= form_hidden('paramUploadId', $objectId); ?>
        <?= form_hidden('paramUploadName', $objectName); ?>
    </div>
    <?= end_Tab(); ?>
</div>
<?= end_TabPanel(); ?>

<?= begin_ToolBar(array('imprimir', 'abrir', 'ajuda', 'pesquisar', 'voltar-pagina', 'novo', 'excluir', 'salvar')); ?>
<div>
    <?= addButtonToolBar(lang('uploadLimpar'), 'limparArquivo()', 'btnLimparArquivo', 'ui-icon-document'); ?>
    <?= addButtonToolBar(lang('uploadIniciar'), 'iniciarUpload()', 'btnIniciarUpload', 'ui-icon-transferthick-e-w'); ?>
</div>
<?= end_ToolBar(); ?>

<?=$this->load->view("../../static/_views/footerGlobalView");?>

<script type="text/javascript">

    var completeUpload = false;
    var errorUpload = false;

    function limparArquivo() {
        $('#userfile').val('');
    }

    function iniciarUpload() {
        formUploadFile_submit();
    }

    function formUploadFile_callback(data) {
        $("#btnLimparArquivo").button('enable');
        $("#btnIniciarUpload").button('enable');
        if (!data.success) {
            errorUpload = true;
            completeUpload = false;
            messageErrorBox(data.error.message);
        } else {
            errorUpload = false;
            completeUpload = true;
            if ($("#paramUploadId").val() != '') {
                var paramUploadId = $("#paramUploadId").val();
                var paramUploadName = $("#paramUploadName").val();

                window.parent.document.getElementById(paramUploadId).value = data.uploads[0].id;
                window.parent.document.getElementById(paramUploadName).value = data.uploads[0].nome_original;
                try {
                    if ($.isFunction(<?= (@$methodReturn == '' ? 'none' : 'window.parent.'.@$methodReturn); ?>)) {
						<?= (@$methodReturn == '' ? 'none' : 'window.parent.'.@$methodReturn) . '();'; ?>
                    }
                } catch (err) {
                }
                parent.closeWindowSelf();
            }
        }
    }

</script>