<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

<!--     <script type="text/javascript" src="--><?php //echo Yii::app()->request->baseUrl; ?><!--/js/jquery-2.0.3.min.js"></script>-->

    <link href="<?= Yii::app()->request->baseUrl; ?>/js/jquery-ui-1.9.2.custom/css/ui-lightness/jquery-ui-1.9.2.custom.css" rel="stylesheet">
    <script src="<?= Yii::app()->request->baseUrl; ?>/js/jquery-ui-1.9.2.custom/js/jquery-1.8.3.js"></script>
    <script src="<?= Yii::app()->request->baseUrl; ?>/js/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js"></script>


    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

    <div id="header">
        <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
    </div><!-- header -->

    <?php $this->widget('bootstrap.widgets.TbNavbar', array(
        'type'=>'', // null or 'inverse'
        'brand'=>'MasterForex Translations',
        'brandUrl'=>'/',
        'collapse'=>true, // requires bootstrap-responsive.css
        'items'=>array(
            array(
                'class'=>'bootstrap.widgets.TbMenu',
                'items'=>array(
                    //array('label' => 'Home', 'url'=>array('/site/index')),
                    //array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                    //array('label'=>'Contact', 'url'=>array('/site/contact')),
                    array('label' => 'Login', 'url'=>array('/site/login/'), 'visible'=>Yii::app()->user->isGuest),
                    array('label' => 'Translate Phrases', 'url' => array('/translations/index'), 'visible' => !Yii::app()->user->isGuest),
                    array('label' => 'Text Translation', 'url' => array('/textstatustranslations/index'), 'visible' => (Yii::app()->user->getState('Role') == 'T')),
                    //array('label' => 'Task', 'url' => array('/task/index'), 'visible' => (Yii::app()->user->getState('Role') == 'A')),
                    //array('label' => 'Statuses', 'url' => array('/textstatustranslations/index'), 'visible' => (Yii::app()->user->getState('Role') == 'A')),
                    array('label'=>'Translations', 'url'=>'#', 'visible' => (Yii::app()->user->getState('Role') == 'A'), 'items'=>array(
                        array('label'=>'Translations Status', 'url'=>'/textstatustranslations/index'),
                        array('label'=>'New Task', 'url'=>'/task'),
                        ),
                    ),
                    //array('label' => 'User Management', 'url' => array('/users/index'), 'visible' => (Yii::app()->user->getState('Role') == 'A')),
                    array('label' => 'Upload Task', 'url' => array('/uploadtask/index'), 'visible' => (Yii::app()->user->getState('Role') == 'A')),
                    array('label' => 'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),

                ),
            ),
        ),
    )); ?>

    <?php if(isset($this->breadcrumbs)):?>
        <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
    <?php endif?>

    <?php echo $content; ?>

    <div class="clear"></div>

    <div id="footer">
        Copyright &copy; <?php echo date('Y'); ?> by MasterForex<br/>
        All Rights Reserved.<br/>
    </div><!-- footer -->

</div><!-- page -->

</body>
</html>
