<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.sukhov
 * Date: 25.07.13
 * Time: 12:02
 * To change this template use File | Settings | File Templates.
 */
class TaskForm extends CFormModel
{
    public $textForTranslation;
    public $languages = array();
    public $calendar = array();
    public $title;

    public function rules()
    {
        return array(
            array('textForTranslation, languages, calendar, title', 'required'),
        );
    }



    public function attributeLabels()
    {
        return array(
            'task'=>'',
        );
    }

}