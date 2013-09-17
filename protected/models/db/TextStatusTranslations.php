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

    public function search()
    {
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
//        $criteria->compare('Status','<2',true);
        $criteria->compare('Status',$this->Status,true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
            'pagination'=>array(
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

//    public function getCategoryNames()
//    {
//        return $this->CategoryNames[$this->CategoryNames];
//    }


}