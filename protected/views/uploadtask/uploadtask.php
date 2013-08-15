<?php

$this->pageTitle=Yii::app()->name . ' - Task';
$this->breadcrumbs=array(
    'Task',
);
?>

<?php if (Yii::app()->user->hasFlash('success') || Yii::app()->user->hasFlash('Esuccess')) : ?>
    <div class="flash-success">
        <?= Yii::app()->user->getFlash('success')."<br>";  ?>
        <?= Yii::app()->user->getFlash('Ssuccess')."<br>"; ?>
        <?= Yii::app()->user->getFlash('Dsuccess'); ?>
    </div>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error') || Yii::app()->user->hasFlash('Eerror')) : ?>
    <div class="flash-error">
        <?= Yii::app()->user->getFlash('error'); ?>
        <?= Yii::app()->user->getFlash('Serror'); ?>
        <?= Yii::app()->user->getFlash('Derror'); ?>
    </div>
<?php endif; ?>

    <div class="form">
        <?php
        $form = $this->beginWidget(
            'bootstrap.widgets.TbActiveForm',
            array(
                'id'=>'users-form',
                'htmlOptions' => array(
                    'class'=>'task_form',
                    'enctype' => 'multipart/form-data',
                )
            )
        );
        ?>

        <br>

        <div class="uplod">
            <?= $form->fileFieldRow($model, 'Document'); ?>
        </div>


        <div class="row buttons">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'submit',
                'label'=>'Send',
                'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'size'=>'small', // null, 'large', 'small' or 'mini'
            )); ?>
        </div>

        <?php $this->endWidget(); ?>


    </div><!-- form -->



<?php
$pathToDocuments = Yii::app()->basePath.'\documents\\';

$files = Uploadtask::model()->findAll();
?>

    <br>

<?php
/** @var Uploadtask $file */
foreach ($files as $file){
    echo '<p><a href="'.Yii::app()->createUrl('uploadtask/download', array('document' => $file->Document)).'">'.$file->Document.'</a></p>';
}
?>