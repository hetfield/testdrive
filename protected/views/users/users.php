<?php
/* @var $this UsersController */
/* @var $model UsersForm */
/* @var $form CActiveForm  */
//Yii::app()->clientScript->registerScript('adjust_currencies_ready', <<<JS
//
//$('.languages label.check input[checked=checked]').parent().addClass("active");
//JS
//    , CClientScript::POS_READY);
//
//

$this->pageTitle=Yii::app()->name . ' - User Management';
$this->breadcrumbs=array(
    'User Management',
);
?>

<h1>User Management</h1>


<?php if (Yii::app()->user->hasFlash('success')) : ?>
    <div class="flash-success">
        <?= Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error')) : ?>
    <div class="flash-error">
        <?= Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>


    <?php foreach ($users as $currentUser): ?>
<?php /** @var Users $currentUser */ ?>
<?php $model = $currentUser->form; ?>

<div class="form">
    <?php
    $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        array(
            'id'=>'users-form',
            'htmlOptions' => array(
                'class'=>'user_form',
            )
        )
    );
    ?>
    <?= $form->errorSummary($model, 'Пожалуйста, исправьте ошибки заполнения ({count}):', array('{count}'=>count($model->getErrors()))); ?>
    <table>
        <tr>
            <td>
                <h3>User: <?= $currentUser->Username ?></h3>
                <div class="user_data">
                    <p> <?=$form->labelEx($model, 'username') ?> <br />
                        <?=$form->textField($currentUser, 'username', array('value' => $currentUser->Username)); ?>
                        <?=$form->error($currentUser, 'username'); ?></p>
                    <p> <?=$form->labelEx($model, 'email') ?> <br />
                        <?=$form->textField($currentUser, 'email', array('value' => $currentUser->Email)); ?>
                        <?=$form->error($currentUser, 'email'); ?></p>
                    <p> <?=$form->labelEx($model, 'password') ?> <br />
                        <?=$form->textField($currentUser, 'password', array('value' => '')); ?>
                        <?=$form->error($currentUser, 'password'); ?></p>
                </div>
            </td>
            <td>
                <?php $currentUser->Languages = json_decode($currentUser->Languages); ?>
                <div class="languages">
                    <p>
                        <?=$form->checkBoxListInlineRow($currentUser,'Languages', $languages); ?>
                        <?=$form->error($model, 'languages'); ?></p>
                </div>
            </td>
        </tr>
    </table>

    <div class="row buttons">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'label'=>'Save',
            'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size'=>'small', // null, 'large', 'small' or 'mini'
        )); ?>
    </div>

    <?php $this->endWidget(); ?>

<?php endforeach; ?>
</div><!-- form -->
