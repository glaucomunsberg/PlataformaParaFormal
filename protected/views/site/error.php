<?php
$this->pageTitle=Yii::app()->name . Yii::t('lang','erroCod'). $code;
$this->breadcrumbs=array(
	'Error',
);
?>
<div class="error">
    <table width="100%" border="0" align="center">
      <tr>
        <td align="center"><h1> <?php echo Yii::t('lang','erroCod'). $code ?> </h1></td>
      </tr>
      <tr>
        <td align="center"><img src="images/geral/erro.jpg" width="570" height="380" /></td>
      </tr>
      <tr>
        <td><?php echo Yii::t('lang','erroNotifiqueDesenvolvedor')?></td>
      </tr>
    </table>
</div>
