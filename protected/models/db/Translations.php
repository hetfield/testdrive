<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.sukhov
 * Date: 24.07.13
 * Time: 12:24
 * To change this template use File | Settings | File Templates.
 *
 * @property integer $ID
 * @property string $Category
 * @property string $Key
 * @property string $LangAr
 * @property string $LangEn
 * @property string $LangEs
 * @property string $LangId
 * @property string $LangMy
 * @property string $LangRu
 * @property string $LangCn
 * @property string $LangAz
 */

class Translations extends CActiveRecord
{
    /** @var TranslationsForm $form */
    public $form;
    public $textField;
    public $Category;
    public $Key;

    public $CategoryNames = array(
        'accounts' => 'accounts',
        'calc' => 'calc',
        'clientform' => 'clientform',
        'contests' => 'contests',
        'financial' => 'financial',
        'informers' => 'informers',
        'ism' => 'ism',
        'main' => 'main',
        'misc' => 'misc',
        'notice' => 'notice',
        'notify' => 'notify',
        'other' => 'other',
        'pamm' => 'pamm',
        'partner' => 'partner',
        'registration' => 'registration',
        'requests' => 'requests',
        'services' => 'services',
        'tournaments' => 'tournaments',
        'widgets' => 'widgets',
        'yii' => 'yii',
    );


    public static function model($className=__CLASS__)
    {
        return parent::model($className);

    }

    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('ID',$this->ID);
        $criteria->compare('Category',$this->Category);
//        $criteria->compare('Key',$this->Key,true);
        $criteria->compare('LangEn',$this->LangEn,true);
        $criteria->compare('LangAr',$this->LangAr,true);
        $criteria->compare('LangEs',$this->LangEs,true);
        $criteria->compare('LangId',$this->LangId,true);
        $criteria->compare('LangMy',$this->LangMy,true);
        $criteria->compare('LangRu',$this->LangRu,true);
        $criteria->compare('LangCn',$this->LangCn,true);
        $criteria->compare('LangAz',$this->LangAz,true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>'15',
                'route' => 'translations/index'
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
            array('ID, Category, Key, LangRu, LangEn, LangAr, LangId, LangEs, LangMy, LangCn, LangAz', 'safe', 'on'=>'search'),
            array('Key', 'required'),
        );
    }

    public function tableName()
    {
        return 'translations';
    }

    public function getCategoryNames()
    {
        return $this->CategoryNames[$this->CategoryNames];
    }

    public function getColumns()
    {
        $langs = array(
            'ar' => array(
                'name' => 'LangAr',
                'htmlOptions' => array('style' => 'max-width: 100px'),
                'type' => 'html',
            ),
            'id' => array(
                'name' => 'LangId',
                'htmlOptions' => array('style' => 'max-width: 100px'),
                'type' => 'html',
            ),
            'es' => array(
                'name' => 'LangEs',
                'htmlOptions' => array('style' => 'max-width: 100px'),
                'type' => 'html',
            ),
            'my' => array(
                'name' => 'LangMy',
                'htmlOptions' => array('style' => 'max-width: 100px'),
                'type' => 'html',
            ),
            'cn' => array(
                'name' => 'LangCn',
                'htmlOptions' => array('style' => 'max-width: 100px'),
                'type' => 'html',
            ),
            'az' => array(
                'name' => 'LangAz',
                'htmlOptions' => array('style' => 'max-width: 100px'),
                'type' => 'html',
            ),
        );

        $columns = array(
            array(
                'name' => 'ID',
                'htmlOptions' => array('style'=>'width: 50px; text-align: center;'),
            ),
            array(
                'name'=>'Category',
                //'value'=>'$data->Category',
                'filter' => $this->CategoryNames,
                'htmlOptions'=>array('style'=>'width: 70px; text-align: center;'),
            ),
            array(
                'name' => 'LangRu',
                'htmlOptions' => array('style' => 'max-width: 100px'),
                'type' => 'html',
            ),
            array(
                'name' => 'LangEn',
                'htmlOptions' => array('style' => 'max-width: 100px'),
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
        return $columns;
    }
}