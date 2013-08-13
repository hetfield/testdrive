<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.sukhov
 * Date: 24.07.13
 * Time: 12:24
 * To change this template use File | Settings | File Templates.
 *
 * @property integer $ID
 * @property string $LangEn
 * @property string $LangEs
 * @property string $LangCn
 * @property string $LangMy
 * @property string $LangId
 * @property string $LangAr
 * @property string $TextID
 */

class DeadLines extends CActiveRecord
{

    public static function model($className=__CLASS__)
    {
        return parent::model($className);

    }

    public function tableName()
    {
        return 'deadlines';
    }

}