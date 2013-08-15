<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.sukhov
 * Date: 14.08.13
 * Time: 17:27
 * To change this template use File | Settings | File Templates.
 */

class UploadtaskController extends Controller
{
    public function __construct($id, $module = null){
        parent::__construct($id, $module = null);

        if (Yii::app()->user->isGuest){
            $this->redirect('/site/login');
        } elseif (Yii::app()->user->getState('Role') != 'A'){
            $this->redirect('/');
        }
    }

    public function actionIndex()
    {
        /** @var Uploadtask $modelName */
        $modelName = 'Uploadtask';
        $model = new $modelName();

        $path = Yii::app()->basePath.'\documents\\';

        if(isset($_POST[$modelName])){
            $model->attributes=$_POST[$modelName];
            $model->Document = CUploadedFile::getInstance($model,'Document');
            if ($model->validate()){
                if ($model->save()){
                    $model->Document->saveAs($path.$model->Document);
                    $this->redirect(Yii::app()->createUrl('uploadtask/index'));
                }
            }
        }

        $this->render('uploadtask', array('model'=>$model));
    }

    public function actionDownload()
    {
        if (isset($_GET)){
            $file = Yii::app()->basePath.'\documents\\'.$_GET['document'];
            Yii::app()->request->sendFile(basename($file),file_get_contents($file));
        }
    }
}