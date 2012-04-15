<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cidades-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('lang', 'camposCom')?> <span class="required">*</span> <?php echo Yii::t('lang', 'saoObrigatorios')?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,Yii::t('lang', 'cidadeNome')); ?>
		<?php echo $form->textField($model,'descricao',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'descricao'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,Yii::t('lang', 'cidadeLongitude')); ?>
		<?php echo $form->textField($model,'longitude',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'longitude'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,Yii::t('lang', 'cidadeLatitude')); ?>
		<?php echo $form->textField($model,'latitude',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'latitude'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('lang', 'cidadeCriar') : Yii::t('lang', 'cidadeDeletar')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->