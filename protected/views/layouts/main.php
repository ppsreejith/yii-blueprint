<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php 
		$cs = Yii::app()->getClientScript();
  		$cs->registerCoreScript('jquery');
		$cs->registerCssFile(Yii::app()->baseUrl.'/css/styles.css');
		$cs->registerScriptFile(Yii::app()->baseUrl.'/js/ajaxFile.js');
	?>
</head>

<body>
<div id="loading"><?php echo Yii::t('main','Loading');?></div>
<div id="mainmenu" > 
<?php $this->renderPartial('/includes/menu');?>
</div>
<div class="container" id="page">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>