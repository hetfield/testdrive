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

        switch ($lang){
            case 'en':
                $changeStatus->StatusEn = $status;
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

        if ($changeStatus->StatusEn == 2 &&
            $changeStatus->StatusEs == 2 &&
            $changeStatus->StatusCn == 2 &&
            $changeStatus->StatusMy == 2 &&
            $changeStatus->StatusId == 2 &&
            $changeStatus->StatusAr == 2 //&&
            //$changeStatus->StatusAz == 2
        ){
            $changeStatus->Status = 2;
            //отправка письма заказчику
            include (realpath(dirname(__FILE__).'/../components/Phpmailer.php'));
            include (realpath(dirname(__FILE__).'/../components/Smtp.php'));

            $phpMailer = new PHPMailer();

            $phpMailer->CharSet="utf8";
            $phpMailer->IsSMTP();
            $phpMailer->Port       = 587;
            $phpMailer->SMTPSecure = true;
            $phpMailer->Host = 'smtp.mfxbroker.com';//'smtp.mfxbroker.com';
            $phpMailer->Username = 'translations@mfxbroker.com';                            // SMTP username
            $phpMailer->Password = 'aiutsraghuy545#';                           // SMTP password
            $phpMailer->SMTPSecure = 'tls';
            $phpMailer->SMTPAuth   = true;
            $phpMailer->From = 'translations@mfxbroker.com';
            $phpMailer->FromName = 'MasterForex';
            $phpMailer->IsHTML(true);
            $phpMailer->Subject = 'Переводы готовы по Text Id = '.$textId;

            /** @var TextTranslations $translations */
            $translations = TextTranslations::model()->findByPk($textId);

            $phpMailer->Body    = 'Переводы которые были Вами заказаны:<br><br>
                Текст на английском языке:<br><br>'.htmlspecialchars_decode($translations->LangEn).'<br><br>
                Текст на испанском языке:<br><br>'.htmlspecialchars_decode($translations->LangEs).'<br><br>
                Текст на китайском языке:<br><br>'.htmlspecialchars_decode($translations->LangCn).'<br><br>
                Текст на малазийском языке:<br><br>'.htmlspecialchars_decode($translations->LangMy).'<br><br>
                Текст на индонезийском языке:<br><br>'.htmlspecialchars_decode($translations->LangId).'<br><br>
                Текст на арабском языке:<br><br>'.htmlspecialchars_decode($translations->LangAr).'<br><br>
                Текст на азербайджанском:<br><br>'.htmlspecialchars_decode($translations->LangAz).'<br><br>
            ';

            $customer = explode(',', $translations->Customer);
            $phpMailer->AddAddress($customer[0], $customer[1]);

            $phpMailer->Send();
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
            $path = Yii::app()->basePath.'\translations\\';
            if (!is_dir($path.$id)){
                mkdir($path.$id);
            }
            $path .= $id.'\\';
            $model->attributes = $post[$modelName];
            $model->Document = CUploadedFile::getInstance($model,'Document');
            $docName = explode('.',CUploadedFile::getInstance($model,'Document'));
            $parts = count($docName);
            $model->TextId = $id;
            if ($model->validate()){
                $model->Document->saveAs($path.$id.'id_'.$lang.'.'.$docName[$parts-1]);
                $model->Document = $id.'id_'.$lang.'.'.$docName[$parts-1];
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
