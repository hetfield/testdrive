<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.sukhov
 * Date: 06.08.13
 * Time: 11:01
 * To change this template use File | Settings | File Templates.
 */

$langs = array(
    'en' => array(
        'name' => 'StatusEn',
        'htmlOptions'=>array('style'=>'width: 70px; text-align: center;'),
        'value' => function ($data){
            $status = $data->StatusEn;
            /** @var DeadLines $deadline */
            $deadline = DeadLines::model()->findByAttributes(array('TextID' => $data->TextId));
            $deadlineToString = explode(' ',$deadline->LangEn);
            if ($status == 0){
                $color = 'important';
            } elseif ($status == 1){
                $color = 'warning';
            } else {
                $color = 'success';
            }
            return '<p><span class="badge badge-'.$color.'">'.$status.'</span></p><p><span class="badge">DeadLine:<br>'.$deadlineToString[0].'<br>'.$deadlineToString[1].'</span></p>';
        },
        'type' => 'html',
    ),
    'es' => array(
        'name' => 'StatusEs',
        'htmlOptions'=>array('style'=>'width: 70px; text-align: center;'),
        'value' => function ($data){
            $status = $data->StatusEs;
            $deadline = DeadLines::model()->findByAttributes(array('TextID' => $data->TextId));
            $deadlineToString = explode(' ',$deadline->LangEs);
            if ($status == 0){
                $color = 'important';
            } elseif ($status == 1){
                $color = 'warning';
            } else {
                $color = 'success';
            }
            return '<p><span class="badge badge-'.$color.'">'.$status.'</span></p><p><span class="badge">DeadLine:<br>'.$deadlineToString[0].'<br>'.$deadlineToString[1].'</span></p>';
        },
        'type' => 'html',
    ),
    'cn' => array(
        'name' => 'StatusCn',
        'htmlOptions'=>array('style'=>'width: 70px; text-align: center;'),
        'value' => function ($data){
            $status = $data->StatusCn;
            $deadline = DeadLines::model()->findByAttributes(array('TextID' => $data->TextId));
            $deadlineToString = explode(' ',$deadline->LangCn);
            if ($status == 0){
                $color = 'important';
            } elseif ($status == 1){
                $color = 'warning';
            } else {
                $color = 'success';
            }
            return '<p><span class="badge badge-'.$color.'">'.$status.'</span></p><p><span class="badge">DeadLine:<br>'.$deadlineToString[0].'<br>'.$deadlineToString[1].'</span></p>';
        },
        'type' => 'html',
    ),
    'az' => array(
        'name' => 'StatusAz',
        'htmlOptions'=>array('style'=>'width: 70px; text-align: center;'),
        'value' => function ($data){
            $status = $data->StatusAz;
            $deadline = DeadLines::model()->findByAttributes(array('TextID' => $data->TextId));
            $deadlineToString = explode(' ',$deadline->LangAz);
            if ($status == 0){
                $color = 'important';
            } elseif ($status == 1){
                $color = 'warning';
            } else {
                $color = 'success';
            }
            return '<p><span class="badge badge-'.$color.'">'.$status.'</span></p><p><span class="badge">DeadLine:<br>'.$deadlineToString[0].'<br>'.$deadlineToString[1].'</span></p>';
        },
        'type' => 'html',
    ),
    'ar' => array(
        'name' => 'StatusAr',
        'htmlOptions'=>array('style'=>'width: 70px; text-align: center;'),
        'value' => function ($data){
            $status = $data->StatusAr;
            $deadline = DeadLines::model()->findByAttributes(array('TextID' => $data->TextId));
            $deadlineToString = explode(' ',$deadline->LangAr);
            if ($status == 0){
                $color = 'important';
            } elseif ($status == 1){
                $color = 'warning';
            } else {
                $color = 'success';
            }
            return '<p><span class="badge badge-'.$color.'">'.$status.'</span></p><p><span class="badge">DeadLine:<br>'.$deadlineToString[0].'<br>'.$deadlineToString[1].'</span></p>';
        },
        'type' => 'html',
    ),
    'id' => array(
        'name' => 'StatusId',
        'htmlOptions'=>array('style'=>'width: 70px; text-align: center;'),
        'value' => function ($data){
            $status = $data->StatusId;
            $deadline = DeadLines::model()->findByAttributes(array('TextID' => $data->TextId));
            $deadlineToString = explode(' ',$deadline->LangId);
            if ($status == 0){
                $color = 'important';
            } elseif ($status == 1){
                $color = 'warning';
            } else {
                $color = 'success';
            }
            return '<p><span class="badge badge-'.$color.'">'.$status.'</span></p><p><span class="badge">DeadLine:<br>'.$deadlineToString[0].'<br>'.$deadlineToString[1].'</span></p>';
        },
        'type' => 'html',
    ),
    'my' => array(
        'name' => 'StatusMy',
        'htmlOptions'=>array('style'=>'width: 70px; text-align: center;'),
        'value' => function ($data){
            $status = $data->StatusMy;
            $deadline = DeadLines::model()->findByAttributes(array('TextID' => $data->TextId));
            $deadlineToString = explode(' ',$deadline->LangMy);
            if ($status == 0){
                $color = 'important';
            } elseif ($status == 1){
                $color = 'warning';
            } else {
                $color = 'success';
            }
            return '<p><span class="badge badge-'.$color.'">'.$status.'</span></p><p><span class="badge">DeadLine:<br>'.$deadlineToString[0].'<br>'.$deadlineToString[1].'</span></p>';
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
            $deadline = DeadLines::model()->findByAttributes(array('TextID' => $data->TextId));
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
                'label' => 'Edit text',
                'url' => 'Yii::app()->createUrl("textstatustranslations/update", array("id"=>$data->TextId))',
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
            'update' => array(
                'label' => 'Edit text',
            ),
        ),
    ),
);

$columns = array(
    array(
        'name' => 'TextId',
        'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
    ),
    'Title',
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

