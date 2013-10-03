<?php
class TranslationsController extends Controller
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

        $modelName = 'Translations';

        $model = new Translations('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Translations'])){
            $model->attributes=$_GET['Translations'];

        }

        if (isset($_POST[$modelName]) && !isset($_POST[$modelName]['ChooseCategory']) && !isset($_POST[$modelName]['NColumns'])) {

            /** @var  $record Translations*/
            $record = new Translations();
            $record->Category = htmlspecialchars($_POST[$modelName]['Category']);
            if ($_POST['Translations']['RKey'] == 'ru'){
                $record->LangRu = htmlspecialchars($_POST[$modelName]['textField']);
            } else {
                $record->LangEn = htmlspecialchars($_POST[$modelName]['textField']);
            }
            $record->Key = htmlspecialchars($_POST[$modelName]['textField']);

            try {
                if (!$record->validate()){
                    throw new CException('Error during model saving.');
                }
                try {
                    if (!$record->save()){
                        throw new CException('Error during model saving.');

                    }
                    Yii::app()->user->setFlash('success', 'Changes successfully saved');
                } catch (CException $exception) {
                    Yii::app()->user->setFlash('error', "Some error during save");
                }

            } catch (CException $exception) {
                Yii::app()->user->setFlash('Berror', "Text Field can't be blank");
            }
        };

        if (isset($_POST[$modelName]['ChooseCategory'])){
            if ($_POST[$modelName]['ChooseCategory'] == 'all'){
                Yii::app()->user->setState('Category', $model->Category);
            } else {
                Yii::app()->user->setState('Category', $_POST[$modelName]['ChooseCategory']);
            }
        }

        if (isset($_POST[$modelName]['NColumns']) && Yii::app()->user->getState('Role') == 'A'){
            Yii::app()->user->setState('Columns', $_POST[$modelName]['NColumns']);
        }
        if (Yii::app()->user->getState('Columns') === NULL && Yii::app()->user->getState('Role') == 'A'){
            Yii::app()->user->setState('Columns', $model->columnsForCookies);
        }
        $model->NColumns = Yii::app()->user->getState('Columns');


        $this->render('translations',array(
            'model'=>$model,
        ));

        //ежедневное уведомление переводчиков о неготовых переводах фраз
        $path = Yii::app()->basePath;
        $file = $path.DIRECTORY_SEPARATOR.'today';
        if (is_file($file)){
            $today = date('Y-m-d');
            $fileDate = file_get_contents($file);
            if ($fileDate < $today){
                $model->sendNoticeToTranslators();
                file_put_contents($file, $today);
            }
        } else {
            $today = date('Y-m-d');
            file_put_contents($file, $today);
            $model->sendNoticeToTranslators();
        }
        // end
    }

    public function actionSave()
    {
        if (!Yii::app()->user->isGuest){
            if (isset($_POST) && $_POST["lang"] == 'Is Confirmed'){
                $translation = Translations::model()->findByAttributes(array('ID' => $_POST["id"]));
                $translation->isConfirmed = htmlspecialchars($_POST["text"]);
                $translation->save();
                echo 'done!';
            } elseif (isset($_POST)){
                /** @var Translations $translation */
                $translation = Translations::model()->findByAttributes(array('ID' => $_POST["id"]));
                $attribute = $_POST["lang"];
                switch ($attribute) {
                    case "Lang Ru":
                        $translation->LangRu = htmlspecialchars($_POST["text"]);
                        break;
                    case "Lang En":
                        $translation->LangEn = htmlspecialchars($_POST["text"]);
                        break;
                    case "Lang Ar":
                        $translation->LangAr = htmlspecialchars($_POST["text"]);
                        break;
                    case "Lang Id":
                        $translation->LangId = htmlspecialchars($_POST["text"]);
                        break;
                    case "Lang Es":
                        $translation->LangEs = htmlspecialchars($_POST["text"]);
                        break;
                    case "Lang My":
                        $translation->LangMy = htmlspecialchars($_POST["text"]);
                        break;
                    case "Lang Cn":
                        $translation->LangCn = htmlspecialchars($_POST["text"]);
                        break;
                    case "Lang Az":
                        $translation->LangAz = htmlspecialchars($_POST["text"]);
                        break;
                }
                $translation->save();
            }
        }
    }


//    public function actionNewBase()
//    {
//        set_time_limit(0);
//        $records = Translations::model()->findAllByAttributes(array('LangEn' => ''));
//        foreach ($records as $record){
//            $record->LangEn = $record->Key;
//            if (!$record->save()){
//                var_dump(1);
//            }
//        }
//        /** @var Translations $record */
//        $records = Translations::model()->findAllByAttributes(array('LangRu' => ''));
//        foreach ($records as $record){
//            $record->LangRu = $record->Key;
//            if (!$record->save()){
//                var_dump(1);
//            }
//        }
//    }



}