<?php
/** @var TbActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'verticalForm',
    'htmlOptions'=>array('class'=>'well'),
)); ?>
    <br>

    <!--<?//= $form->radioButtonListInlineRow($model, 'Languages', $langsToEdit); ?>-->

    <div class="uplod">
        <?= $form->fileFieldRow($model, 'Document'); ?>
    </div>


    <div class="forSubmit">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'label'=>'Save',
            'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size'=>'small', // null, 'large', 'small' or 'mini'
        )); ?>
    </div>

<?php $this->endWidget(); ?>