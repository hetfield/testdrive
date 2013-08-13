<?php

class UsersController extends Controller
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
        $modelName = 'Users';
        $users = Users::model()->findAllByAttributes(array(
            'Role' => 'T'
        ));


        /** @var  $record Users*/


        foreach ($users as &$user) {
            /** @var Users $user  */
            $user->form = new UsersForm();
        }

        $languages = array(
            'ar' => 'Arabic',
            'en' => 'English',
//            'ru' => 'Russian',
            'id' => 'Indonesian',
            'es' => 'Spanish',
            'my' => 'Malaysian',
            'cn' => 'Chinese',
            'az' => 'Azerbaijani'
        );

        /** @var UsersForm $model */
        $model = new UsersForm();

        if (isset($_POST[$modelName])){
            $model->setAttributes($_POST[$modelName]);

            if ($model->validate()){
                $record = Users::model()->findByAttributes(array('Username'=>$_POST[$modelName]['username']));
                /** @var  $record Users*/
                try {
                    if (!$record){
                        throw new CException('Error during model saving.');
                    }

                    Yii::app()->user->setFlash('success', 'Changes successfully saved');
                } catch (CException $exception) {
                    Yii::app()->user->setFlash('error', "Changes didn't save");
                }
                if ($record){
                    $record->Email = $_POST[$modelName]['email'];
                    if ($_POST[$modelName]['password'] != ''){
                        $record->Password = crypt($_POST[$modelName]['password'], 'newsaltfortest');
                    }
                    $record->Languages = json_encode($_POST[$modelName]['Languages']);
                    $record->save();
                }

                $this->redirect('/users');
            }

        }



        $this->render('users',array(
                'users' => $users,
                'languages' => $languages,
            )
        );
    }
}