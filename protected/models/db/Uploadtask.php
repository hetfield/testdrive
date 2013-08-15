<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.sukhov
 * Date: 24.07.13
 * Time: 12:24
 * To change this template use File | Settings | File Templates.
 *
 * @property integer $ID
 * @property string $Document
 */

class Uploadtask extends CActiveRecord
{
    public $Document;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);

    }

    public function rules()
    {
        return array(
            array('Document', 'file', 'types'=>'doc, docx'),
            array('Document', 'unique'),
        );
    }
}