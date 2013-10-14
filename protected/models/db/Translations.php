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
 * @property string $LangGe
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
        6 => 'ge',
    );

    public $Columns = array(
        'ar' => 'Lang Ar',
        'id' => 'Lang Id',
        'es' => 'Lang Es',
        'my' => 'Lang My',
        'cn' => 'Lang Cn',
        'az' => 'Lang Az',
        'ge' => 'Lang Ge',
    );

    public $CategoryNames = array();

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
        $criteria->compare('Key',$this->Key,true);
        $criteria->compare('LangEn',$this->LangEn,true);
        $criteria->compare('LangAr',$this->LangAr,true);
        $criteria->compare('LangEs',$this->LangEs,true);
        $criteria->compare('LangId',$this->LangId,true);
        $criteria->compare('LangMy',$this->LangMy,true);
        $criteria->compare('LangRu',$this->LangRu,true);
        $criteria->compare('LangCn',$this->LangCn,true);
        $criteria->compare('LangAz',$this->LangAz,true);
        $criteria->compare('LangGe',$this->LangGe,true);
        $criteria->compare('isConfirmed',$this->isConfirmed);
        $criteria->compare('Category',$this->Category);

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
            array('ID, Category, Key, LangRu, LangEn, LangAr, LangId, LangEs, LangMy, LangCn, LangAz, LangGe isConfirm', 'safe', 'on'=>'search'),
            array('Key', 'required'),
        );
    }

    public function tableName()
    {
        return 'translations';
    }

    public function fillCategoryNames()
    {
        $category_list = Translations::model()->findAll(array(
            'select' => 'Category',
            'group' => 'Category',
            'distinct'=>true,
        ));

        foreach ($category_list as $category){
            $category_array[$category->Category] = $category->Category;
        }
        $category_array['all'] = 'all';
        $this->CategoryNames = $category_array;
    }

    public function getColumns()
    {
        $langs = array(
            'ar' => array(
                'name' => 'LangAr',
                'htmlOptions' => array('style' => 'max-width: 100px; text-align: right;', 'dir' => 'rtl'),
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
            'ge' => array(
                'name' => 'LangGe',
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

        if ($this->NColumns == '' && Yii::app()->user->getState('Role') == 'A'){
            $langs = array();
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
                'name' => 'Key',
                'htmlOptions' => array('style' => 'max-width: 100px'),
                'type' => 'raw',
            );
            array_push($columns, $data);
            $data = array(
                'name' => 'Category',
                'htmlOptions' => array('style' => 'max-width: 100px'),
                'type' => 'raw',
            );
            array_push($columns, $data);
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
            $data = array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'htmlOptions' => array('style'=>'width: 50px; text-align: center;'),
                'header' => 'Buttons',
                'buttons' => array(
                    'update' => array(
                        'visible' => 'false',
                    ),
                    'view' => array(
                        'visible' => 'false',
                    ),
                    'delete' => array(
                        'url' => 'Yii::app()->createUrl("translations/delete", array("id"=>$data->ID))',
                    ),
                ),
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

        $quote = '"';
        $quote = htmlspecialchars(htmlspecialchars($quote, ENT_QUOTES), ENT_QUOTES);

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
                Вы можете воспользоваться поиском, набрав номер Id в столбце с названием "Id" в этом же разделе сайта.
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

    public function saveValueIsConfirmed($id, $value)
    {
        $translations = $this->model()->findByAttributes(array('ID' => $id));
        $translations->isConfirmed = htmlspecialchars($value, ENT_QUOTES);
        $translations->save();
    }

    public function saveTranslation($id, $lang, $text)
    {
        $translation = $this->model()->findByAttributes(array('ID' => $id));
        switch ($lang) {
            case "Lang Ru":
                $translation->LangRu = htmlspecialchars($text, ENT_QUOTES);
                break;
            case "Lang En":
                $translation->LangEn = htmlspecialchars($text, ENT_QUOTES);
                break;
            case "Lang Ar":
                $translation->LangAr = htmlspecialchars($text, ENT_QUOTES);
                break;
            case "Lang Id":
                $translation->LangId = htmlspecialchars($text, ENT_QUOTES);
                break;
            case "Lang Es":
                $translation->LangEs = htmlspecialchars($text, ENT_QUOTES);
                break;
            case "Lang My":
                $translation->LangMy = htmlspecialchars($text, ENT_QUOTES);
                break;
            case "Lang Cn":
                $translation->LangCn = htmlspecialchars($text, ENT_QUOTES);
                break;
            case "Lang Az":
                $translation->LangAz = htmlspecialchars($text, ENT_QUOTES);
                break;
            case "Lang Ge":
                $translation->LangGe = htmlspecialchars($text, ENT_QUOTES);
                break;
            case "Key":
                $translation->Key = htmlspecialchars($text, ENT_QUOTES);
                break;
        }
        $translation->save();
    }



}