<?php
Yii::import('ext.imperavi-redactor-widget.ImperaviRedactorWidget');
$countLangs = count(json_decode(Yii::app()->user->getState('Languages')));


Yii::app()->clientScript->registerScript('adjust_currencies_ready', <<<JS

$('.radio [name="TranslationEditForm[Languages]"]').click(function(){
    var obj = $(this);
    console.log(obj.val());
        $.ajax({
            url: '/textstatustranslations/showtext/',
		    type: 'POST',
		    data: {'lang':obj.val(), 'id':{$id}},
		    success:  function(result) {
		        console.log(result);
                $('form .redactor_box iframe').contents().find('body').html(result);
            }
	    });
});

$('.radio [checked="checked"][name="TranslationEditForm[Languages]"]').trigger('click');



JS
    , CClientScript::POS_READY);

$insideOptionsRedactor = array(
    'lang' => 'en',
    'buttons' => array('html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
        'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
        'table', '|',
        'fontcolor', 'backcolor', '|', 'alignment', '|', 'horizontalrule', '|', 'underline',
        'alignleft', 'aligncenter', 'alignright', 'justify'),
    'iframe' => true,
    //'css' => 'wym.css',
    'minHeight' => 200,

);

$optionsRedactor = array(
    // You can either use it for model attribute
    'model' => $model,
    'attribute' => 'redactor',

    // or just for input field
    'name' => 'my_input_name',
    'htmlOptions' => array('value' => $result),

    // Some options, see http://imperavi.com/redactor/docs/
    'options' => $insideOptionsRedactor,
);

$langList = json_decode(Yii::app()->user->getState('Languages'));
if ($langList[0] == 'ar'){
    $insideOptionsRedactor = $insideOptionsRedactor + array('direction' => 'rtl');
    //var_dump($insideOptionsRedactor); die;
}

/** @var TextTranslations $textForTranslation */
$textForTranslation = TextTranslations::model()->findByPk($id);
$text = htmlspecialchars_decode($textForTranslation->Text);


?>

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

<div class="textForTranslation">
    <?= $text ?>
</div>


<?php
/** @var TbActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'verticalForm',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<?php if ($countLangs != 1): ?>
    <?php
    $langsToEdit = array();
    $langs = array(
        'en' => 'LangEn',
        'es' => 'LangEs',
        'cn' => 'LangCn',
        'my' => 'LangMy',
        'id' => 'LangId',
        'ar' => 'LangAr',
        'az' => 'LangAz',
    );
    foreach ($langs as $lang => $data){
        if(Yii::app()->user->getState('Role') != 'T'){
            $langsToEdit = $langsToEdit + array($lang => $data);
        } else {
            $userLanguages = json_decode(Yii::app()->user->getState('Languages'));
            foreach ($userLanguages as $userLanguage){
                if ($userLanguage == $lang){
                    $langsToEdit = $langsToEdit + array($lang => $data);
                }
            }
        }
    }
    /** @var TranslationEditForm $model */
    $model->setRadioBtnActive();

    ?>
    <?= $form->radioButtonListInlineRow($model, 'Languages', $langsToEdit); ?>
<!--    <?//= $form->dropDownListRow($model,'Languages', $langsToEdit) ?>-->
<?php endif; ?>

    <div class="redactorArea">
        <?php
        $this->widget('ImperaviRedactorWidget', $optionsRedactor);
        ?>
    </div>
    <br />

    <div>
        <?= $form->radioButtonListRow($model, 'Status', array(
            '1' => 'Save with status "Translation is not ready yet"',
            '2' => 'Save with status "Translation is ready"',
        )) ?>
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