<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.sukhov
 * Date: 24.07.13
 * Time: 12:24
 * To change this template use File | Settings | File Templates.
 *
 * @property integer $ID
 * @property integer $TextId
 * @property string $Title
 * @property integer $StatusEn
 * @property integer $StatusEs
 * @property integer $StatusCn
 * @property integer $StatusMy
 * @property integer $StatusId
 * @property integer $StatusAr
 * @property integer $StatusAz
 * @property boolean $Status
 */

class TextStatusTranslations extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static $mailTranslators = array(
//        'en' => array(
//            'email' => 'translations@mfxbroker.com',
//            'name' => 'Егор Фентисов'
//        ),
//        'es' => array(
//            'email' => 'translations@mfxbroker.com',
//            'name' => 'Iria Martinez Espinar'
//        ),
//        'cn' => array(
//            'email' => 'translations@mfxbroker.com',
//            'name' => 'huayu@masterforex.org',
//        ),
//        'az' => array(
//            'email' => 'translations@mfxbroker.com',
//            'name' => 'e.zhidkov@mfxbroker.com'
//        ),
//        'ar' => array(
//            'email' => 'translations@mfxbroker.com',
//            'name' => 'Mado Saied'
//        ),
//        'my' => array(
//            'email' => 'translations@mfxbroker.com',
//            'name' => 'Jeff Nash'
//        ),
//        'id' => array(
//            'email' => 'translations@mfxbroker.com',
//            'name' => 'Juliana Saja'
//        ),
        'en' => array(
            'email' => 'e.fentisov@mfxbroker.com',
            'name' => 'Егор Фентисов'
        ),
        'es' => array(
            'email' => 'iria_me9@hotmail.com',
            'name' => 'Iria Martinez Espinar'
        ),
        'cn' => array(
            'email' => 'huayu@masterforex.org',
            'name' => 'huayu@masterforex.org',
        ),
        'az' => array(
            'email' => 'e.zhidkov@mfxbroker.com',
            'name' => 'e.zhidkov@mfxbroker.com'
        ),
        'ar' => array(
            'email' => 'ahmedsaied44@gmail.com',
            'name' => 'Mado Saied'
        ),
        'my' => array(
            'email' => 'kamnfx@gmail.com',
            'name' => 'Jeff Nash'
        ),
        'id' => array(
            'email' => 'juliana_djulie@yahoo.com',
            'name' => 'Juliana Saja'
        ),
    );

    public function search()
    {
        if (Yii::app()->user->getState('Role') == 'A'){
            $visible = $this->Status;
        } else {
            $visible = '<2';
        }

        $criteria=new CDbCriteria;

        $criteria->compare('TextId',$this->TextId,true);
        $criteria->compare('Title',$this->Title,true);
        $criteria->compare('StatusEn',$this->StatusEn,true);
        $criteria->compare('StatusEs',$this->StatusEs,true);
        $criteria->compare('StatusCn',$this->StatusCn,true);
        $criteria->compare('StatusMy',$this->StatusMy,true);
        $criteria->compare('StatusId',$this->StatusId,true);
        $criteria->compare('StatusAr',$this->StatusAr,true);
        $criteria->compare('StatusAz',$this->StatusAz,true);
        $criteria->compare('Status', $visible,true);
//        $criteria->compare('Status',$this->Status,true);
//        $criteria->compare('Status','<2',true);


        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'TextId DESC',
            ),
            'pagination' => array(
                'pageSize'=>'10',
            ),
        ));
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('TextId, Title, StatusEn, StatusEs, StatusCn, StatusMy, StatusId, StatusAr, StatusAz, Status', 'safe', 'on'=>'search'),
        );
    }

    public function tableName()
    {
        return 'textstatustranslations';
    }




}