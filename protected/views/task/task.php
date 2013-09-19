<?php
$this->pageTitle=Yii::app()->name . ' - Task';
$this->breadcrumbs=array(
    'Task',
);
?>

<?php if (Yii::app()->user->hasFlash('success') || Yii::app()->user->hasFlash('Esuccess')) : ?>
    <div class="flash-success">
        <?= Yii::app()->user->getFlash('success')."<br>";  ?>
        <?= Yii::app()->user->getFlash('Esuccess'); ?>
    </div>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error') || Yii::app()->user->hasFlash('Eerror')) : ?>
    <div class="flash-error">
        <?= Yii::app()->user->getFlash('error'); ?>
        <?= Yii::app()->user->getFlash('Eerror'); ?>
    </div>
<?php endif; ?>

<?php /** @var Users $currentUser */ ?>


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

    <div class="titleArea">
        <?= $form->textFieldRow($model, 'title', array('class'=>'span3', 'maxlength' => '100')); ?>
    </div>

    <br>

    <div>
        <?= $form->dropDownListRow($model, 'customer', array(
            'e.lozovaya@mfxbroker.com,Екатерина Лозовая' => 'Екатерина Лозовая',
            'd.kulagin@mfxbroker.com,Денис Кулагин' => 'Денис Кулагин',
            's.maslov@mfxbroker.com,Степа Маслов' => 'Степа Маслов',
            'e.fentisov@mfxbroker.com,Егор Финтисов' => 'Егор Фентисов',
            'd.sukhov@mfxbroker.com,Дмитрий Сухов' => 'Дмитрий Сухов',
            'v.zubkov@mfxbroker.com,Валерий Зубков' => 'Валерий Зубков',
        )); ?>
    </div>
    <br>

<!--    <div class="redactorArea">-->
<!--        --><?php
//        $this->widget('ImperaviRedactorWidget', array(
//            // You can either use it for model attribute
//            'model' => $model,
//            'attribute' => 'textForTranslation',
//
//            // or just for input field
//            'name' => 'my_input_name',
//
//            // Some options, see http://imperavi.com/redactor/docs/
//            'options' => array(
//                'lang' => 'en',
//                'buttons' => array('html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
//                    'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
//                    'table', '|',
//                    'fontcolor', 'backcolor', '|', 'alignment', '|', 'horizontalrule', '|', 'underline',
//                    'alignleft', 'aligncenter', 'alignright', 'justify'),
//                'iframe' => true,
//                //'css' => 'wym.css',
//                'minHeight' => 200,
//            ),
//        ));
//        ?>
<!--    </div>-->

    <br />

    <div class="checkboxesTask">
        <label style="margin-bottom: 20px" for="TaskForm_languages">Languages</label>
        <input id="ytTaskForm_languages" type="hidden" value="" name="TaskForm[languages]" />
        <table>
            <tr>
                <td style="width: 50px;">
                    <input TaskForm_languages_1" value="en" type="checkbox" name="TaskForm[languages][]" />
                    <label style="display: inline;" for="TaskForm_languages_1">En</label>
                </td>
                <td>
                    <input style="width: 145px;" type="datetime" name="TaskForm[calendar][LangEn]" value="<?= date("Y-m-d H:i", mktime(0, 0, 0, date("m"), date("d")+1, date("Y"))); ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <input id="TaskForm_languages_3" value="es" type="checkbox" name="TaskForm[languages][]" />
                    <label style="display: inline;" for="TaskForm_languages_3">Sp</label></label>
                </td>
                <td>
                    <input style="width: 145px;" type="datetime" name="TaskForm[calendar][LangEs]" value="<?= date("Y-m-d H:i", mktime(0, 0, 0, date("m"), date("d")+1, date("Y"))); ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <input id="TaskForm_languages_5" value="cn" type="checkbox" name="TaskForm[languages][]" />
                    <label style="display: inline;" for="TaskForm_languages_5">Cn</label></label>
                </td>
                <td>
                    <input style="width: 145px;" type="datetime" name="TaskForm[calendar][LangCn]" value="<?= date("Y-m-d H:i", mktime(0, 0, 0, date("m"), date("d")+1, date("Y"))); ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <input id="TaskForm_languages_8" value="az" type="checkbox" name="TaskForm[languages][]" />
                    <label style="display: inline;" for="TaskForm_languages_8">Az</label></label>
                </td>
                <td>
                    <input style="width: 145px;" type="datetime" name="TaskForm[calendar][LangAz]" value="<?= date("Y-m-d H:i", mktime(0, 0, 0, date("m"), date("d")+1, date("Y"))); ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <input id="TaskForm_languages_0" value="ar" type="checkbox" name="TaskForm[languages][]" />
                    <label style="display: inline;" for="TaskForm_languages_0">Ar</label></label>
                </td>
                <td>
                    <input style="width: 145px;" type="datetime" name="TaskForm[calendar][LangAr]" value="<?= date("Y-m-d H:i", mktime(0, 0, 0, date("m"), date("d")+2, date("Y"))); ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <input id="TaskForm_languages_2" value="id" type="checkbox" name="TaskForm[languages][]" />
                    <label style="display: inline;" for="TaskForm_languages_2">Id</label></label>
                </td>
                <td>
                    <input style="width: 145px;" type="datetime" name="TaskForm[calendar][LangId]" value="<?= date("Y-m-d H:i", mktime(0, 0, 0, date("m"), date("d")+2, date("Y"))); ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <input id="TaskForm_languages_4" value="my" type="checkbox" name="TaskForm[languages][]" />
                    <label style="display: inline;" for="TaskForm_languages_4">My</label></label>
                </td>
                <td>
                    <input style="width: 145px;" type="datetime" name="TaskForm[calendar][LangMy]" value="<?= date("Y-m-d H:i", mktime(0, 0, 0, date("m"), date("d")+2, date("Y"))); ?>">
                </td>
            </tr>
        </table>
    </div>

    <div class="row buttons">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'label'=>'Next',
            'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size'=>'small', // null, 'large', 'small' or 'mini'
        )); ?>
    </div>

    <?php $this->endWidget(); ?>


</div><!-- form -->
