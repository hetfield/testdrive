<div>
    <?php
    $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        array(
            'id' => 'upload-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        )
    );
    ?>
</div>

<div>
    <?= $form->fileFieldRow($model, 'Document'); ?>
</div>

<div>
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'label'=>'Upload',
        'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size'=>'small', // null, 'large', 'small' or 'mini'
    ));
    ?>
</div>

<?php $this->endWidget(); ?>


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