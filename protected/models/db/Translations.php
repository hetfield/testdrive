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
 * @property string $isConfirmed
 */

class Translations extends CActiveRecord
{
    /** @var TranslationsForm $form */
    public $form;
    public $textField;
    public $Category;
    public $Key;
    public $RKey = 'en';
    public $NColumns = '';

    public $columnsForCookies = array(
        0 => 'ar',
        1 => 'id',
        2 => 'es',
        3 => 'my',
        4 => 'cn',
        5 => 'az',
    );

    public $Columns = array(
        'ar' => 'Lang Ar',
        'id' => 'Lang Id',
        'es' => 'Lang Es',
        'my' => 'Lang My',
        'cn' => 'Lang Cn',
        'az' => 'Lang Az',
    );

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
        'office' => 'office',
        'other' => 'other',
        'pamm' => 'pamm',
        'partner' => 'partner',
        'registration' => 'registration',
        'requests' => 'requests',
        'services' => 'services',
        'signals' => 'signals',
        'tournaments' => 'tournaments',
        'widgets' => 'widgets',
        'yii' => 'yii',
        'all' => 'all'
    );


    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function attributeLabels()
    {
        return array(
            'NColumns' => 'Select columns to dislpay:  ',
            'Category' => 'Category:'
        );
    }

    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('ID',$this->ID);
        $criteria->compare('Category', Yii::app()->user->getState('Category'));
//        $criteria->compare('Key',$this->Key,true);
        $criteria->compare('LangEn',$this->LangEn,true);
        $criteria->compare('LangAr',$this->LangAr);
        $criteria->compare('LangEs',$this->LangEs);
        $criteria->compare('LangId',$this->LangId);
        $criteria->compare('LangMy',$this->LangMy);
        $criteria->compare('LangRu',$this->LangRu);
        $criteria->compare('LangCn',$this->LangCn);
        $criteria->compare('LangAz',$this->LangAz);
        $criteria->compare('isConfirmed',$this->isConfirmed);

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
            array('ID, Category, Key, LangRu, LangEn, LangAr, LangId, LangEs, LangMy, LangCn, LangAz, isConfirm', 'safe', 'on'=>'search'),
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
                'htmlOptions' => array('style' => 'max-width: 100px;', 'dir' => 'rtl'),
                'type' => 'raw',
            ),
            'id' => array(
                'name' => 'LangId',
                'htmlOptions' => array('style' => 'max-width: 100px'),
                'type' => 'raw',
            ),
            'es' => array(
                'name' => 'LangEs',
                'htmlOptions' => array('style' => 'max-width: 100px'),
                'type' => 'raw',
            ),
            'my' => array(
                'name' => 'LangMy',
                'htmlOptions' => array('style' => 'max-width: 100px'),
                'type' => 'raw',
            ),
            'cn' => array(
                'name' => 'LangCn',
                'htmlOptions' => array('style' => 'max-width: 100px'),
                'type' => 'raw',
            ),
            'az' => array(
                'name' => 'LangAz',
                'htmlOptions' => array('style' => 'max-width: 100px'),
                'type' => 'raw',
            ),
        );


        if ($this->NColumns != '' && Yii::app()->user->getState('Role') == 'A'){
            foreach($langs as $lang => $value){
                if (!is_int(array_search($lang, $this->NColumns))){
                    unset($langs[$lang]);
                }
            }
        }


        $columns = array(
            array(
                'name' => 'ID',
                'htmlOptions' => array('style'=>'width: 50px; text-align: center;'),
            ),
            array(
                'name' => 'LangRu',
                'htmlOptions' => array('style' => 'max-width: 100px'),
                'type' => 'raw',
            ),
            array(
                'name' => 'LangEn',
                'htmlOptions' => array('style' => 'max-width: 100px'),
                'type' => 'raw',
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
            $data = array(
                'name' => 'isConfirmed',
                'htmlOptions' => array('style'=>'width: 10px; text-align: center;'),
                'value' => function($data){
                    if ($data->isConfirmed == 1){
                        $show = '<div class="btn-group" data-toggle="buttons-radio"><a btnid="'.$data->ID.'" class="btn btn-success btn-mini active">Y</a><a btnid="'.$data->ID.'" class="btn btn-success btn-mini">N</a></div>';
                    } else {
                        $show = '<div class="btn-group" data-toggle="buttons-radio"><a btnid="'.$data->ID.'" class="btn btn-danger btn-mini">Y</a><a btnid="'.$data->ID.'" class="btn btn-danger btn-mini active">N</a></div>';
                    }
                    return $show;
                },
                'type' => 'raw',
            );
            array_push($columns, $data);
        }
        return $columns;
    }

    public function RKeyList()
    {
        return array(
            'en' => 'KeyEn',
            'ru' => 'KeyRu',
        );
    }

    public static function sendNoticeToTranslators()
    {
        include_once (Yii::app()->basePath.'/components/Mailer.php');
        include_once (Yii::app()->basePath.'/components/Smtp.php');

        $mailer = new Mailer();
        $Emails = TextStatusTranslations::$mailTranslators;

        $langs = array(
            'en' => 'LangEn',
            'es' => 'LangEs',
            'cn' => 'LangCn',
            'az' => 'LangAz',
            'ar' => 'LangAr',
            'id' => 'LangId',
            'my' => 'LangMy',
        );

        foreach ($langs as $lang => $value){
            $data = Translations::model()->findAllByAttributes(array(
                $value => '',
            ));

            /** @var Translations $phrase */
            $phrases = array();
            $quote = '"';
            $quote = htmlspecialchars(htmlspecialchars($quote, ENT_QUOTES), ENT_QUOTES);
            if ($lang == 'ar' || $lang == 'id' || $lang == 'my'){
                foreach($data as $phrase){
                    if ($phrase->LangEn != ''){
                        $phrases[$phrase->ID] = $phrase->LangEn;
                    } else {
                        $phrases[$phrase->ID] = $phrase->Key;
                    }
                }
                $subject = 'Translation status is available on the website  http://translations.masterforex.com/';
                $body = 'Hello, <br />
                <p>Please, don’t reply to this email, for it was sent by automatic translation software.  Translation works should be carried out on the website  http://translations.masterforex.com/</p>
                <p>You still have unaccomplished translation tasks in the Translate Phrases page.</p>
                <p>You may use the search feature by putting id number into column called ID in the same section.  Service tags such as &lt;strong/&gt;, {account} or '.$quote.' should not be translated, but left as is and be put into a relevant place in the translation.</p>
                <p>List of IDs of these translations:<br /></p>
                <p>
                <ul>';
                foreach($phrases as $id => $phrase){
                    $body .= '<li>"'.$id.'" -  translation Id, "'.$phrase.'" - translation phrase</li>';
                }
                $body .= '</ul>
                </p>
                <p>Best regards, MasterForex</p>';
            } else {
                foreach($data as $phrase){
                    if ($phrase->LangRu != ''){
                        $phrases[$phrase->ID] = $phrase->LangRu;
                    } else {
                        $phrases[$phrase->ID] = $phrase->Key;
                    }
                }
                $subject = 'Информация о состоянии переводов на сайте http://translations.masterforex.com/';
                $body = 'Здравствуйте, <br />
                <p>Отвечать на это письмо не нужно, оно отправлено автоматически программой для переводов. Переводы нужно сделать на сайте http://translations.masterforex.com/</p>
                <p>У вас еще остались не переведенные фразы в разделе Translate Phrases.</p>
                <p>
                Вы можете воспользоваться поиском, набрав номер Id в столбце с на званием "Id" в этом же разделе сайта.
                Служебные символы, к примеру, такие как &lt;strong/&gt;, {account} или '.$quote.' переводить не нужно, а оставлять как есть и вставлять в нужном месте перевода.
                </p>
                <p>Список Id этих переводов:<br /></p>
                <p>
                <ul>';
                foreach ($phrases as $id => $phrase){
                    $body .= '<li>"'.$id.'" - Id перевода, "'.$phrase.'" - фраза перевода</li>';
                }
                $body .= '</ul>
                </p>
                <p>С уважением, MasterForex.</p>';
            }
            $address = array($Emails[$lang]);
            $mailer->NewMail($subject, $address, $body);
        }
    }




}