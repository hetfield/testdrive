<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.sukhov
 * Date: 06.08.13
 * Time: 11:01
 * To change this template use File | Settings | File Templates.
 */



function value_content($data, $translation, $attrLang, $attrStatus){
    $status = $data->$attrStatus;
    /** @var DeadLines $deadline */
    $deadline = DeadLines::model()->findByAttributes(array('TextID' => $data->TextId));

    $link = '';
    $docTypes = array('doc','docx','xls','xlsx');
    $path = Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'translations'.DIRECTORY_SEPARATOR.$data->TextId.DIRECTORY_SEPARATOR;
    foreach ($docTypes as $docType){
        if (is_file($path.$data->TextId.'_'.$translation.'.'.$docType)){
            $link = '<br><a href="/translations/'.$data->TextId.'/'.$data->TextId.'_'.$translation.'.'.$docType.'">file</a>';
        }
    }

    $check = '';
    /** @var TextTranslations $textTo */
    $textTo = TextTranslations::model()->findByPk($data->TextId);
    $textTo = json_decode($textTo->TaskTo);
    foreach ($textTo as $value){
        if ($value == $translation){
            $check = '<br /><img src="/images/check.png" />';
        }
    }


    $deadlineToArray = explode(' ',$deadline->$attrLang);
    if ($status == 0){
        $color = 'important';
    } elseif ($status == 1){
        $color = 'warning';
    } else {
        $color = 'success';
    }
    return '<p><span class="badge badge-'.$color.'">'.$status.'</span></p><p><span class="badge">DeadLine:<br>'.$deadlineToArray[0].'<br>'.$deadlineToArray[1].'</span>'.$check.$link.'</p>';
}


$langs = array(
    'en' => array(
        'name' => 'StatusEn',
        'htmlOptions'=>array('style'=>'width: 70px; text-align: center;'),
        'value' => function($data){
            return value_content($data,'en','LangEn','StatusEn');
        },
        'type' => 'html',
    ),
    'es' => array(
        'name' => 'StatusEs',
        'htmlOptions'=>array('style'=>'width: 70px; text-align: center;'),
        'value' => function($data){
            return value_content($data,'es','LangEs','StatusEs');
        },
        'type' => 'html',
    ),
    'cn' => array(
        'name' => 'StatusCn',
        'htmlOptions'=>array('style'=>'width: 70px; text-align: center;'),
        'value' => function($data){
            return value_content($data,'cn','LangCn','StatusCn');
        },
        'type' => 'html',
    ),
    'az' => array(
        'name' => 'StatusAz',
        'htmlOptions'=>array('style'=>'width: 70px; text-align: center;'),
        'value' => function($data){
            return value_content($data,'az','LangAz','StatusAz');
        },
        'type' => 'html',
    ),
    'ar' => array(
        'name' => 'StatusAr',
        'htmlOptions'=>array('style'=>'width: 70px; text-align: center;'),
        'value' => function($data){
            return value_content($data,'ar','LangAr','StatusAr');
        },
        'type' => 'html',
    ),
    'id' => array(
        'name' => 'StatusId',
        'htmlOptions'=>array('style'=>'width: 70px; text-align: center;'),
        'value' => function($data){
            return value_content($data,'id','LangId','StatusId');
        },
        'type' => 'html',
    ),
    'my' => array(
        'name' => 'StatusMy',
        'htmlOptions'=>array('style'=>'width: 70px; text-align: center;'),
        'value' => function($data){
            return value_content($data,'my','LangMy','StatusMy');
        },
        'type' => 'html',
    ),
);

$status = array(
    array(
        'name' => 'Status',
        'htmlOptions'=>array('style'=>'width: 70px; text-align: center;'),
        'value' => function ($data){
            $status = $data->Status;
            //$deadline = DeadLines::model()->findByAttributes(array('TextID' => $data->TextId));
            if ($status == 0){
                $color = 'important';
            } elseif ($status == 1){
                $color = 'warning';
            } else {
                $color = 'success';
            }
            return '<span class="badge badge-'.$color.'">'.$status.'</span>';
        },
        'type' => 'html',
    ),
);

$buttonsA = array(
    array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'htmlOptions' => array('style'=>'width: 50px; text-align: center;'),
        'header' => 'Buttons',
        'buttons' => array(
            'update' => array(
                'label' => 'Upload Translation',
                'url' => 'Yii::app()->createUrl("textstatustranslations/update", array("id"=>$data->TextId))',
                'visible' => 'false',
            ),
            'view' => array(
                'visible' => 'false',
            ),
            'delete' => array(
                'url' => 'Yii::app()->createUrl("textstatustranslations/delete", array("id"=>$data->TextId))',
            ),
        ),
    ),
);

$forUpdateArray = array();
$translatorsLang = json_decode(Yii::app()->user->getState('Languages'));
if ($translatorsLang[0] == 'ar'){
    $forUpdateArray = $forUpdateArray + array(
            'label' => 'Upload Translation',
            'url' => 'Yii::app()->createUrl("textstatustranslations/uploadar", array("id"=>$data->TextId))',
        );
} elseif ($translatorsLang[0] == 'en'){
    $forUpdateArray = $forUpdateArray + array(
            'label' => 'Upload Translation',
            'url' => 'Yii::app()->createUrl("textstatustranslations/uploaden", array("id"=>$data->TextId))',
        );
} elseif ($translatorsLang[0] == 'es'){
    $forUpdateArray = $forUpdateArray + array(
            'label' => 'Upload Translation',
            'url' => 'Yii::app()->createUrl("textstatustranslations/uploades", array("id"=>$data->TextId))',
        );
}elseif ($translatorsLang[0] == 'cn'){
    $forUpdateArray = $forUpdateArray + array(
            'label' => 'Upload Translation',
            'url' => 'Yii::app()->createUrl("textstatustranslations/uploadcn", array("id"=>$data->TextId))',
        );
}elseif ($translatorsLang[0] == 'my'){
    $forUpdateArray = $forUpdateArray + array(
            'label' => 'Upload Translation',
            'url' => 'Yii::app()->createUrl("textstatustranslations/uploadmy", array("id"=>$data->TextId))',
        );
}elseif ($translatorsLang[0] == 'id'){
    $forUpdateArray = $forUpdateArray + array(
            'label' => 'Upload Translation',
            'url' => 'Yii::app()->createUrl("textstatustranslations/uploadid", array("id"=>$data->TextId))',
        );
}elseif ($translatorsLang[0] == 'az'){
    $forUpdateArray = $forUpdateArray + array(
            'label' => 'Upload Translation',
            'url' => 'Yii::app()->createUrl("textstatustranslations/uploadaz", array("id"=>$data->TextId))',
        );
}

$buttonsT = array(
    array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'htmlOptions' => array('style'=>'width: 50px; text-align: center;'),
        'header' => 'Buttons',
        'buttons' => array(
            'view' => array(
                'visible' => 'false',
            ),
            'delete' => array(
                'visible' => 'false',
            ),
            'update' => $forUpdateArray,
        ),
    ),
);

$columns = array(
    array(
        'name' => 'TextId',
        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
    ),
    array(
        'name' => 'Title',
        'value' => function($data){
            $docTypes = array('doc','docx','xls','xlsx');
            $file = '';
            foreach ($docTypes as $docType){
                $path = Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'documents'.DIRECTORY_SEPARATOR;
                if (is_file($path.$data->TextId.'.'.$docType)){
                    $file = '<br><a href="/documents/'.$data->TextId.'.'.$docType.'">file</a>';
                }
            }
            return $data->Title.$file;
        },
        'type' => 'html',
    ),
);

foreach ($langs as $lang => $data){
    if(Yii::app()->user->getState('Role') != 'T'){
        array_push($columns, $data);
    } else {
        $userLanguages = json_decode(Yii::app()->user->getState('Languages'));
        foreach ($userLanguages as $userLanguage){
            if ($userLanguage == $lang){
                array_push($columns, $data);
            }
        }
    }
}

if (Yii::app()->user->getState('Role') == 'A'){
    array_push($columns, $status[0]);
    array_push($columns, $buttonsA[0]);
} else {
    array_push($columns, $buttonsT[0]);
}
?>

<?php if (Yii::app()->user->hasFlash('success') || Yii::app()->user->hasFlash('Esuccess')) : ?>
    <div class="flash-success">
        <?= Yii::app()->user->getFlash('success')."<br>";  ?>
        <?= Yii::app()->user->getFlash('Esuccess'); ?>
    </div>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error') || Yii::app()->user->hasFlash('Eerror')) : ?>
    <div class="flash-error">
        <?= Yii::app()->user->getFlash('error')."<br>"; ?>
        <?= Yii::app()->user->getFlash('Eerror'); ?>
    </div>
<?php endif; ?>

<p>
<?php $this->widget('bootstrap.widgets.TbBadge', array(
    'type'=>'important', // 'success', 'warning', 'important', 'info' or 'inverse'
    'label'=>'0',
)); ?> - Translator has not yet started work on the translation
</p>
<p>
    <?php $this->widget('bootstrap.widgets.TbBadge', array(
        'type'=>'warning', // 'success', 'warning', 'important', 'info' or 'inverse'
        'label'=>'1',
    )); ?> - Translator is working on the translation
</p>
<p>
    <?php $this->widget('bootstrap.widgets.TbBadge', array(
        'type'=>'success', // 'success', 'warning', 'important', 'info' or 'inverse'
        'label'=>'2',
    )); ?> - Translator finished
</p>
<p>
    <img src="/images/check.png"> - If a task is marked with this image it means that this task needs to be translated by translator
</p>


<div id="textStatusTranslationsTable">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type'=>'striped bordered condensed',
        'dataProvider'=>$model->search(),
        'filter' => $model,
        'columns'=>$columns,
        'enableSorting' => true,
    ));
    ?>
</div>

