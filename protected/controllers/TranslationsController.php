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


        if (isset($_POST[$modelName])) {

            /** @var  $record Translations*/
            $record = new Translations();
            $record->Category = htmlspecialchars($_POST[$modelName]['Category']);
            $record->LangRu = htmlspecialchars($_POST[$modelName]['textField']);
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

        $this->render('translations',array(
            'model'=>$model,
            'columns' => $model->getColumns(),

        ));
    }

    public function actionSave()
    {
        if (!Yii::app()->user->isGuest){
            if (isset($_POST)){
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