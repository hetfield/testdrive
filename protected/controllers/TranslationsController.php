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
        $model->fillCategoryNames();

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
    }

    public function actionSave()
    {
        if (!Yii::app()->user->isGuest){
            $model = new Translations();
            if (isset($_POST) && $_POST["lang"] == 'Is Confirmed'){
                $model->saveValueIsConfirmed($_POST["id"], $_POST["text"]);
            } elseif (isset($_POST)){
                $model->saveTranslation($_POST["id"], $_POST["lang"], $_POST["text"]);
            }
        }
    }

    public function actionDelete()
    {
        if (Yii::app()->user->getState('Role') == 'A'){
            if ($_GET['id']){
                Translations::model()->deleteByPk($_GET['id']);
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