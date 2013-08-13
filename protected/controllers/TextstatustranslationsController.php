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
}
