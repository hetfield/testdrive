<?php
/** @var  $model Translations*/

// 1 - админ или переводчик ru\en, 3 - переводчик
if (Yii::app()->user->getState('Role') != 'A'){
    $role = 2;
} else {
    $role = 0;
}
if (Yii::app()->user->getState('Role') == 'T' && Yii::app()->user->getState('Languages') == '["en"]') {
    $role = 1;
}
Yii::app()->clientScript->registerScript('adjust_currencies_ready', <<<JS
var tableTranslition;
$('body').bind('mousedown',function(){
$('.table tr').each(function(k)
	{
        if(k > 1)
            $(this).find('td').each( function(k){
                    if (k > {$role}) {
                        var lang = $(this).closest('table').find('tr').eq(0).find('th').eq(k).find('a').html();
                        lang = lang.split('<');
                        lang = lang[0];
                        $(this).attr('lang',lang);
                        $(this).bind('click',function(){
                            var id = $(this).closest('tr').find('td').eq(0).html();
                            var lang = $(this).attr('lang');
                            var width = $(this).width();
                            var text = $(this).html();
                            var height = $(this).height();
                            if (text.indexOf('<textarea') == -1){

                                if (lang != "Lang Ar" )
                                    $(this).html('<textarea style="width: '+width+'px; height: '+height+'px; margin: 0px; padding: 0px;">'+$(this).html()+'</textarea>');
                                else
                                    $(this).html('<textarea style="width: '+width+'px; height: '+height+'px; margin: 0px; padding: 0px;" dir="rtl">'+$(this).html()+'</textarea>');

                                $(this).find('textarea').attr('data-lang',lang);
                                $(this).find('textarea').attr('data-id',id);
                                $(this).find('textarea').focus();
                                $(this).find('textarea').bind('focusout',
                                    function(){
                                        var text = $(this).val();
                                        var lang = $(this).attr('data-lang');
                                        var id = $(this).attr('data-id');
                                        $.ajax({
											url: '?r=translations/save',
											type: 'POST',
											data: {'id':id,'lang':lang,'text':text},
											success:  function(res) {
                                            console.log(res);
                                        }
										});
										$(this).parent().html(text);
										$(this).css('width','');
								});
                            }
                        })
					}
                })
	})
});

$('.addedbtn .btn').click(function(){
        if ($('#formAddText').is(':visible')) {
                $('#formAddText').hide("slow",function(){
                    $(".addedbtn .btn").html("Add phrase");
            });
        }else{
                $('#formAddText').show("slow",function(){
                    $(".addedbtn .btn").html("Hide form");
            });
        }
});

JS
    , CClientScript::POS_READY);

$this->pageTitle = Yii::app()->name . ' - Translations';
$this->breadcrumbs = array(
    'Translations',
);
?>

<?php if (Yii::app()->user->hasFlash('success')) : ?>
    <div class="flash-success">
        <?= Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error')) : ?>
    <div class="flash-error">
        <?= Yii::app()->user->getFlash('error'); ?>
        <?= Yii::app()->user->getFlash('Berror'); ?>
    </div>
<?php endif; ?>

<?php if (Yii::app()->user->getState('Role') == 'A'): ?>
    <div class="addedbtn">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'label'=>'Add phrase',
            'type'=>'', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size'=>'small', // null, 'large', 'small' or 'mini'
        )); ?>
    </div>

<div id="formAddText" style="width: 410px;">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'verticalForm',
        'htmlOptions'=>array('class'=>'well'),
    )); ?>


    <div class="textField">
        <?= $form->textAreaRow($model, 'textField', array('class'=>'span4', 'rows'=>5, 'required' => 'required')); ?>
    </div>
    <div class="btn-toolbar">
        <?= $form->dropDownList($model,'Category',array(
            'accounts' => 'accounts',
            'calc' => 'calc',
            'clientform' => 'clientform',
            'contests' => 'contests',
            'informers' => 'informers',
            'ism' => 'ism',
            'main' => 'main',
            'misc' => 'misc',
            'notice' => 'notice',
            'notify' => 'notify',
            'other' => 'other',
            'pamm' => 'pamm',
            'partner' => 'partner',
            'requests' => 'requests',
            'services' => 'services',
            'tournaments' => 'tournaments',
            'widgets' => 'widgets',
            'yii' => 'yii',
        )); ?>
    </div>


    <div>
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'label'=>'Save',
            'type'=>'', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size'=>'small', // null, 'large', 'small' or 'mini'

        )); ?>
    </div>

    <?php $this->endWidget(); ?>
    <?php endif; ?>
</div><!-- form -->

<br />
<br />

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'htmlOptions'=>array(
        'class'=>'well',
        'style' => 'width: 245px; float: right; margin-top: -80px;',
    ),
    'type' => 'inline',
)); ?>

<?= $form->label($model,'Category'); ?>
<select style="width: 120px;" name="Translations[ChooseCategory]" id="Translations_Category">
    <?php foreach ($model->CategoryNames as $category) : ?>
        <option <?php Yii::app()->user->getState('Category') == $category ? print('selected="selected"') : (Yii::app()->user->getState('Category') == $model->Category && $category == 'all') ? print('selected="selected"') : '' ?> value="<?= $category ?>"><?= $category ?></option>
    <?php endforeach; ?>
</select>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'submit',
    'label'=>'Submit',
    'type'=>'', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'

)); ?>

<?php $this->endWidget(); ?>



<div id="translatorsTable">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type'=>'striped bordered condensed',
        'dataProvider'=>$model->search(),
        'template'=>"{pager}{summary}\n{items}\n{pager}",
        'filter' => $model,
        'columns'=>$model->getColumns(),
        'enableSorting' => true,
    )); ?>
</div>