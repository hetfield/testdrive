<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{

        /** @var UserAccounts $table */

        if (Yii::app()->user->isGuest){
            $this->redirect(Yii::app()->createUrl('site/login'));
        } else {
            $this->redirect(Yii::app()->createUrl('translations/index'));
        }
//        $table = new Users();
//        $table->Username = 'e.fentisov';
//        $table->Password = crypt('e.fentisov', 'newsaltfortest');
//        $table->Email = 'e.fentisov@mfxbroker.com';
//        $table->Role = 'T';
//        $table->save();
//        $table = new Users();
//        $table->Username = 'huayu';
//        $table->Password = crypt('huayu', 'newsaltfortest');
//        $table->Email = 'huayu@masterforex.org';
//        $table->Role = 'T';
//        $table->save();
//        $table = new Users();
//        $table->Username = 'iria_me9';
//        $table->Password = crypt('iria_me9', 'newsaltfortest');
//        $table->Email = 'iria_me9@hotmail.com';
//        $table->Role = 'T';
//        $table->save();
//        $table = new Users();
//        $table->Username = 'juliana_djulie';
//        $table->Password = crypt('juliana_djulie', 'newsaltfortest');
//        $table->Email = 'juliana_djulie@yahoo.com';
//        $table->Role = 'T';
//        $table->save();
//        $table = new Users();
//        $table->Username = 'kamnfx';
//        $table->Password = crypt('kamnfx', 'newsaltfortest');
//        $table->Email = 'kamnfx@gmail.com';
//        $table->Role = 'T';
//        $table->save();
//        $table = new Users();
//        $table->Username = 'ahmedsaied44';
//        $table->Password = crypt('ahmedsaied44', 'newsaltfortest');
//        $table->Email = 'ahmedsaied44@gmail.com';
//        $table->Role = 'T';
//        $table->save();




        Yii::log("Started", 'error');
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
        $model = new LoginForm();
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

    public function actionTranslations()
    {
        $model = new TranslationsForm();
        $this->render('translations',array('model'=>$model));
    }

    public function actionUsers()
    {
        $model = new UsersForm();
        $this->render('users',array('model'=>$model));
    }
}