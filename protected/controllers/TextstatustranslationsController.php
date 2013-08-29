<?php

class TextstatustranslationsController extends Controller
{
    public function __construct($id, $module = null){
        parent::__construct($id, $module = null);


        if (Yii::app()->user->isGuest){
            $this->redirect('/site/login');
        } elseif (Yii::app()->user->getState('Role') != 'T' && Yii::app()->user->getState('Role') != 'A'){
            $this->redirect('/');
        }
    }

    public function actionIndex()
    {
        $model = new TextStatusTranslations('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TextStatusTranslations']))
            $model->attributes=$_GET['TextStatusTranslations'];


        $this->render('textstatustranslations',array(
            'model'=>$model,
        ));
    }

    public function actionUpdate()
    {
        $modelName = 'TranslationEditForm';
        /** @var TranslationEditForm $model */
        $model = new $modelName;
        $result = '';
        if (isset($_GET['id']))
            $id = $_GET['id'];

        if (count(json_decode(Yii::app()->user->getState('Languages'))) == 1 && isset($_GET['id'])){


            /** @var TextTranslations $textForEdit */
            $textForEdit = TextTranslations::model()->findByPk((int)$_GET['id']);
            $langArray = json_decode(Yii::app()->user->getState('Languages'));

            switch ($langArray[0]){
                case 'en':
                    $result = htmlspecialchars_decode($textForEdit->LangEn);
                    break;
                case 'es':
                    $result = htmlspecialchars_decode($textForEdit->LangEs);
                    break;
                case 'cn':
                    $result = htmlspecialchars_decode($textForEdit->LangCn);
                    break;
                case 'my':
                    $result = htmlspecialchars_decode($textForEdit->LangMy);
                    break;
                case 'id':
                    $result = htmlspecialchars_decode($textForEdit->LangId);
                    break;
                case 'ar':
                    $result = htmlspecialchars_decode($textForEdit->LangAr);
                    break;
                case 'az':
                    $result = htmlspecialchars_decode($textForEdit->LangAz);
                    break;
            }
            if (Yii::app()->user->getState('Role') == 'T'){
                /** @var TextStatusTranslations $changeStatus */
                $this->changeStatusText($textForEdit->ID, $langArray[0], 1);
            }
        }


        if (isset($_POST[$modelName])){
            $model->setAttributes($_POST[$modelName]);



            if ($model->validate()){
                /** @var TextTranslations $newTranslation */
                $newTranslation = TextTranslations::model()->findByPk($id);
                if (count(json_decode(Yii::app()->user->getState('Languages'))) == 1){
                    $lang = json_decode(Yii::app()->user->getState('Languages'));
                    $lang = $lang[0];
                } else {
                    $lang = $_POST[$modelName]['Languages'];
                }
                switch ($lang){
                    case 'en':
                        $newTranslation->LangEn = htmlspecialchars($_POST[$modelName]['redactor']);
                        break;
                    case 'es':
                        $newTranslation->LangEs = htmlspecialchars($_POST[$modelName]['redactor']);
                        break;
                    case 'cn':
                        $newTranslation->LangCn = htmlspecialchars($_POST[$modelName]['redactor']);
                        break;
                    case 'my':
                        $newTranslation->LangMy = htmlspecialchars($_POST[$modelName]['redactor']);
                        break;
                    case 'id':
                        $newTranslation->LangId = htmlspecialchars($_POST[$modelName]['redactor']);
                        break;
                    case 'ar':
                        $newTranslation->LangAr = htmlspecialchars($_POST[$modelName]['redactor']);
                        break;
                    case 'az':
                        $newTranslation->LangAz = htmlspecialchars($_POST[$modelName]['redactor']);
                        break;
                }

                try {
                    if (!$newTranslation->save()){
                        throw new CException('Error during model saving.');
                    }

                    if ($_POST[$modelName]['Status'] == '2'){
                        $this->changeStatusText($id, $lang, 2);
                    } else {
                        $this->changeStatusText($id, $lang, 1);
                    }

                    Yii::app()->user->setFlash('success', 'Changes successfully saved');
                } catch (CException $exception) {
                    Yii::app()->user->setFlash('error', "Changes didn't save");
                }
            }
        }


        $this->render('translationedit', array(
                'model' => $model,
                'result' => $result,
                'id' => $id,
            )
        );

    }

    public function actionShowText()
    {
        if (isset($_POST['lang'])){


            $textForEdit = TextTranslations::model()->findByPk((int)$_POST['id']);

            switch ($_POST['lang']){
                case 'en':
                    echo htmlspecialchars_decode($textForEdit->LangEn);
                    break;
                case 'es':
                    echo htmlspecialchars_decode($textForEdit->LangEs);
                    break;
                case 'cn':
                    echo htmlspecialchars_decode($textForEdit->LangCn);
                    break;
                case 'my':
                    echo htmlspecialchars_decode($textForEdit->LangMy);
                    break;
                case 'id':
                    echo htmlspecialchars_decode($textForEdit->LangId);
                    break;
                case 'ar':
                    echo htmlspecialchars_decode($textForEdit->LangAr);
                    break;
                case 'az':
                    echo htmlspecialchars_decode($textForEdit->LangAz);
                    break;
            }

            if (Yii::app()->user->getState('Role') == 'T'){
                $this->changeStatusText($textForEdit->ID, $_POST['lang'], 1);
            }
        }
    }

    public function changeStatusText($textId, $lang, $status)
    {
        /** @var TextStatusTranslations $changeStatus */
        $changeStatus = TextStatusTranslations::model()->findByAttributes(array('TextId' => $textId));

        /** @var TextTranslations $getTextTo */
        $getTextTo = TextTranslations::model()->findByPk($textId);
        $textToArray = json_decode($getTextTo->TaskTo);
        $countTextTo = count($textToArray);
        $i = 0;

        switch ($lang){
            case 'en':
                $changeStatus->StatusEn = $status;
                //отправка английского перевода тем, кто переводит с английского
                if ($status == 2) {
                    foreach ($textToArray as $to) {
                        if ($to == 'ar' ||
                            $to == 'id' ||
                            $to == 'my'
                        ) {
                            /** @var DeadLines $deadline */
                            $deadline = DeadLines::model()->findByAttributes(array('TextID' => $textId));
                            switch ($to) {
                                case 'ar':
                                    $deadlineFor = $deadline->LangAr;
                                    $addresses = array(
                                        array(
                                            'email' => 'ahmedsaied44@gmail.com',
                                            'name' => 'Mado Saied',
                                        ),
                                    );
                                    break;
                                case 'id':
                                    $deadlineFor = $deadline->LangId;
                                    $addresses = array(
                                        array(
                                            'email' => 'juliana_djulie@yahoo.com',
                                            'name' => 'Juliana Saja',
                                        ),
                                    );
                                    break;
                                case 'my':
                                    $deadlineFor = $deadline->LangMy;
                                    $addresses = array(
                                        array(
                                            'email' => 'kamnfx@gmail.com',
                                            'name' => 'Jeff Nash',
                                        ),
                                    );
                                    break;
                            }
                            include_once (realpath(dirname(__FILE__).'/../components/Mailer.php'));
                            include_once (realpath(dirname(__FILE__).'/../components/Smtp.php'));
                            $mailer = new Mailer();
                            $subject = 'New Task "' . $getTextTo->Title . '"';
                            $body = 'Hello! <br>Please translate text with title "' . $getTextTo->Title . '" and Text Id = ' . $getTextTo->ID . '. Deadline: ' . $deadlineFor . '. <br>You can do this on website <a href="http://translations.masterforex.com/">http://translations.masterforex.com/</a> in section Text Translation. <br>Thank you!';
                            $altBody = 'Hello! Please translate text with title "' . $getTextTo->Title . '" and Text Id = ' . $getTextTo->ID . '. Deadline: ' . $deadlineFor . '. You can do this on website http://translations.masterforex.com/ in section Text Translation. Thank you!';
                            /** @var Uploaden $enFile */
                            $enFile = Uploaden::model()->findByAttributes(array('TextId' => $textId));
                            $partsFile = explode('.', $enFile->Document);
                            $typeFile = end($partsFile);
                            $path = Yii::app()->basePath . DIRECTORY_SEPARATOR.'translations'.DIRECTORY_SEPARATOR;
                            $attachments = array(
                                array(
                                    'path' => $path . $textId . DIRECTORY_SEPARATOR . $textId . '_en.' . $typeFile,
                                    'file' => $textId.'_en.'.$typeFile,
                                ),
                            );
                            $mailer->NewMail($subject,$addresses,$body,$altBody,$attachments);
                        }
                    }
                }
                break;
            case 'es':
                $changeStatus->StatusEs = $status;
                break;
            case 'cn':
                $changeStatus->StatusCn = $status;
                break;
            case 'my':
                $changeStatus->StatusMy = $status;
                break;
            case 'id':
                $changeStatus->StatusId = $status;
                break;
            case 'ar':
                $changeStatus->StatusAr = $status;
                break;
            case 'az':
                $changeStatus->StatusAz = $status;
                break;
        }

        foreach ($textToArray as $value){
            switch ($value){
                case 'en':
                    if ($changeStatus->StatusEn == 2) $i++;
                    break;
                case 'es':
                    if ($changeStatus->StatusEs == 2) $i++;
                    break;
                case 'cn':
                    if ($changeStatus->StatusCn == 2) $i++;
                    break;
                case 'my':
                    if ($changeStatus->StatusMy == 2) $i++;
                    break;
                case 'id':
                    if ($changeStatus->StatusId == 2) $i++;
                    break;
                case 'ar':
                    if ($changeStatus->StatusAr == 2) $i++;
                    break;
                case 'az':
                    if ($changeStatus->StatusAz == 2) $i++;
                    break;
            }
        }


        if ($countTextTo == $i){

            $changeStatus->Status = 2;

            //отправка письма заказчику
            include_once (realpath(dirname(__FILE__).'/../components/Mailer.php'));
            include_once (realpath(dirname(__FILE__).'/../components/Smtp.php'));

            $mailer = new Mailer();
            $subject = $getTextTo->Title;
            $body    = 'Переводы которые были Вами заказаны во вложениях';
            $path = Yii::app()->basePath.DIRECTORY_SEPARATOR.'translations'.DIRECTORY_SEPARATOR;
            $attachments = array();
            foreach ($textToArray as $value){
                switch ($value){
                    case 'en':
                        $tr = Uploaden::model()->findByAttributes(array('TextId' => $textId));
                        if (is_file($path.$textId.DIRECTORY_SEPARATOR.$tr->Document)) $attachments[] = $attachments + array(
                                'path' => $path.$textId.DIRECTORY_SEPARATOR.$tr->Document,
                                'file' => $tr->Document,
                            );
                        break;
                    case 'es':
                        $tr = Uploades::model()->findByAttributes(array('TextId' => $textId));
                        if (is_file($path.$textId.DIRECTORY_SEPARATOR.$tr->Document)) $attachments[] = $attachments + array(
                                'path' => $path.$textId.DIRECTORY_SEPARATOR.$tr->Document,
                                'file' => $tr->Document,
                            );
                        break;
                    case 'cn':
                        $tr = Uploadcn::model()->findByAttributes(array('TextId' => $textId));
                        if (is_file($path.$textId.DIRECTORY_SEPARATOR.$tr->Document)) $attachments[] = $attachments + array(
                                'path' => $path.$textId.DIRECTORY_SEPARATOR.$tr->Document,
                                'file' => $tr->Document,
                            );
                        break;
                    case 'my':
                        $tr = Uploadmy::model()->findByAttributes(array('TextId' => $textId));
                        if (is_file($path.$textId.DIRECTORY_SEPARATOR.$tr->Document)) $attachments[] = $attachments + array(
                                'path' => $path.$textId.DIRECTORY_SEPARATOR.$tr->Document,
                                'file' => $tr->Document,
                            );
                        break;
                    case 'id':
                        $tr = Uploadid::model()->findByAttributes(array('TextId' => $textId));
                        if (is_file($path.$textId.DIRECTORY_SEPARATOR.$tr->Document)) $attachments[] = $attachments + array(
                                'path' => $path.$textId.DIRECTORY_SEPARATOR.$tr->Document,
                                'file' => $tr->Document,
                            );
                        break;
                    case 'ar':
                        $tr = Uploadar::model()->findByAttributes(array('TextId' => $textId));
                        if (is_file($path.$textId.DIRECTORY_SEPARATOR.$tr->Document)) $attachments[] = $attachments + array(
                                'path' => $path.$textId.DIRECTORY_SEPARATOR.$tr->Document,
                                'file' => $tr->Document,
                            );
                        break;
                    case 'az':
                        $tr = Uploadaz::model()->findByAttributes(array('TextId' => $textId));
                        if (is_file($path.$textId.DIRECTORY_SEPARATOR.$tr->Document)) $attachments[] = $attachments + array(
                                'path' => $path.$textId.DIRECTORY_SEPARATOR.$tr->Document,
                                'file' => $tr->Document,
                            );
                        break;
                }
            }
            $customer = explode(',', $getTextTo->Customer);
            $addresses = array(
                array(
                    'email' => $customer[0],
                    'name' => $customer[1],
                ),
            );
            $mailer->NewMail($subject,$addresses,$body, '',$attachments);
        }
        $changeStatus->save();
    }

    public function actionDelete()
    {
        if (Yii::app()->user->getState('Role') != 'A'){
            return;
        }
        if ($_GET['id']){
            $text = TextTranslations::model()->deleteByPk($_GET['id']);
            $status = TextStatusTranslations::model()->deleteAllByAttributes(array('TextId' => $_GET['id']));
        }
    }

    public function uploadTranslation($modelName,$post,$get,$lang,$view)
    {
        $model = new $modelName;

        if (isset($get['id'])) $id = $get['id'];

        if(isset($post[$modelName]) && isset($id)){
            $path = Yii::app()->basePath.DIRECTORY_SEPARATOR.'translations'.DIRECTORY_SEPARATOR;
            if (!is_dir($path.$id)){
                mkdir($path.$id);
            }
            $path .= $id.DIRECTORY_SEPARATOR;
            $model->attributes = $post[$modelName];
            $model->Document = CUploadedFile::getInstance($model,'Document');
            $docName = explode('.',CUploadedFile::getInstance($model,'Document'));
            $parts = count($docName);
            $model->TextId = $id;
            if ($model->validate()){
                $model->Document->saveAs($path.$id.'_'.$lang.'.'.$docName[$parts-1]);
                $model->Document = $id.'_'.$lang.'.'.$docName[$parts-1];
                $model->save();
                $this->changeStatusText($id,$lang,2);
                $this->redirect(Yii::app()->createUrl("textstatustranslations/index"));
            }
        }

        $this->render($view, array(
                'model' => $model,
            )
        );
    }

    public function actionUploadar()
    {
        $this->uploadTranslation('Uploadar',$_POST,$_GET,'ar','uploadar');
    }

    public function actionUploaden()
    {
        $this->uploadTranslation('Uploaden',$_POST,$_GET,'en','uploaden');
    }

    public function actionUploades()
    {
        $this->uploadTranslation('Uploades',$_POST,$_GET,'es','uploades');
    }

    public function actionUploadcn()
    {
        $this->uploadTranslation('Uploadcn',$_POST,$_GET,'cn','uploadcn');
    }

    public function actionUploadmy()
    {
        $this->uploadTranslation('Uploadmy',$_POST,$_GET,'my','uploadmy');
    }

    public function actionUploadid()
    {
        $this->uploadTranslation('Uploadid',$_POST,$_GET,'id','uploadid');
    }

    public function actionUploadaz()
    {
        $this->uploadTranslation('Uploadaz',$_POST,$_GET,'az','uploadaz');
    }
}
