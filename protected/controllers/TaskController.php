<?php

class TaskController extends Controller
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
        $modelName = 'TaskForm';
        $model = new TaskForm;

        if (isset($_POST[$modelName])){

            $model->setAttributes($_POST[$modelName]);
            if ($model->validate()){

                $recordText = new TextTranslations;
                $recordText->Title = htmlspecialchars($_POST[$modelName]['title']);
                $recordText->Customer = htmlspecialchars($_POST[$modelName]['customer']);

                $newDeadLine = new DeadLines();

                try{
                    if (!$recordText->save()){
                        throw new CException('Error during model saving.');
                    }


//                    $mailArray = array(
//                        'LangAr' => array(
//                            'email' => 'ahmedsaied44@gmail.com',
//                            'name' => 'Mado Saied'
//                        ),
//                        'LangEn' => array(
//                            'email' => 'e.fentisov@mfxbroker.com',
//                            'name' => 'Егор Фентисов'
//                        ),
//                        'LangEs' => array(
//                            'email' => 'iria_me9@hotmail.com',
//                            'name' => 'Iria Martinez Espinar'
//                        ),
//                        'LangCn' => array(
//                            'email' => 'huayu@masterforex.org',
//                            'name' => 'huayu@masterforex.org',
//                        ),
//                        'LangMy' => array(
//                            'email' => 'kamnfx@gmail.com',
//                            'name' => 'Jeff Nash'
//                        ),
//                        'LangId' => array(
//                            'email' => 'juliana_djulie@yahoo.com',
//                            'name' => 'Juliana Saja'
//                        ),
//                        'LangAz' => array(
//                            'email' => '',
//                            'name' => ''
//                        ),
//                    );

                    $newTextStatusTranslations = new TextStatusTranslations();

//                    include (realpath(dirname(__FILE__).'/../components/Phpmailer.php'));
//                    include (realpath(dirname(__FILE__).'/../components/Smtp.php'));
//                    /** @var PHPMailer $phpMailer */

                    foreach ($_POST[$modelName]['calendar'] as $key => $deadline){
                        if ($key == 'LangAr' ||
                            $key == 'LangEn' ||
                            $key == 'LangEs' ||
                            $key == 'LangCn' ||
                            $key == 'LangMy' ||
                            $key == 'LangId' ||
                            $key == 'LangAz'){
                            $newDeadLine->$key = $deadline;

//                            if (isset($mailArray[$key]) && $mailArray[$key]['email'] != ''){
//
//                                $phpMailer = new PHPMailer();
//
//                                $phpMailer->CharSet="utf8";
//                                $phpMailer->IsSMTP();
//                                $phpMailer->Port       = 587;
//                                $phpMailer->SMTPSecure = true;
//                                $phpMailer->Host = 'smtp.mfxbroker.com';//'smtp.mfxbroker.com';
//                                $phpMailer->Username = 'translations@mfxbroker.com';                            // SMTP username
//                                $phpMailer->Password = 'aiutsraghuy545#';                           // SMTP password
//                                $phpMailer->SMTPSecure = 'tls';
//                                $phpMailer->SMTPAuth   = true;
//                                $phpMailer->From = 'translations@mfxbroker.com';
//                                $phpMailer->FromName = 'MasterForex';
//                                $phpMailer->IsHTML(true);
//                                $phpMailer->Subject = 'New Task from MasterForex';
//
//                                if ($key == 'LangAr' || $key == 'LangMy' || $key == 'LangId'){
//                                    $phpMailer->Body    = 'Hello! <br>Please translate text with title "'.$_POST[$modelName]['title'].'" and Text Id = '.$recordText->getPrimaryKey().'. Deadline: '.$deadline.'. <br>You can do this on website <a href="http://translations.masterforex.com/">http://translations.masterforex.com/</a>.<br>Thank you!';
//                                    $phpMailer->AltBody = 'Hello! Please translate text with title "'.$_POST[$modelName]['title'].'" and Text Id = '.$recordText->getPrimaryKey().'. Deadline: '.$deadline.'. You can do this on website http://translations.masterforex.com/. Thank you!';
//                                } else {
//                                    $phpMailer->Body    = 'Добрый день!<br>Просьба перевести тест c заголовком "'.$_POST[$modelName]['title'].'" и Text Id = '.$recordText->getPrimaryKey().' до '.$deadline.' на сайте <a href="http://translations.masterforex.com/">http://translations.masterforex.com/</a>.<br>Спасибо!';
//                                    $phpMailer->AltBody = 'Добрый день! Просьба перевести тест c заголовком "'.$_POST[$modelName]['title'].'" и Text Id = '.$recordText->getPrimaryKey().' до '.$deadline.' на сайте http://translations.masterforex.com/. Спасибо!';
//                                }
//
//                                $phpMailer->AddAddress($mailArray[$key]['email'], $mailArray[$key]['name']);
//
//                                try{
//                                    if (!$phpMailer->Send()){
//                                        throw new CException('Error during email sending.');
//                                    }
//
//                                    Yii::app()->user->setFlash('Esuccess', 'Emails sent successfully');
//                                }catch (CException $exception){
//                                    Yii::app()->user->setFlash('Eerror', 'Failed to send Emails');
//
//                                }
//                            }
                        }
//                        unset($phpMailer);
                    }



                    $newDeadLine->TextID = $recordText->getPrimaryKey();
                    try{
                        if (!$newDeadLine->save()){
                            throw new CException('Error during deadline saving.');
                        }

                        $newTextStatusTranslations->TextId = $recordText->getPrimaryKey();
                        $newTextStatusTranslations->Title = htmlspecialchars($_POST[$modelName]['title']);
                        // Status = 0 - нет переводов
                        // Status = 1 - текст в процессе перевода
                        // Status = 2 - перевод готов
                        $newTextStatusTranslations->StatusAr = 0;
                        $newTextStatusTranslations->StatusCn = 0;
                        $newTextStatusTranslations->StatusEn = 0;
                        $newTextStatusTranslations->StatusEs = 0;
                        $newTextStatusTranslations->StatusId = 0;
                        $newTextStatusTranslations->StatusMy = 0;
                        $newTextStatusTranslations->StatusAz = 0;
                        // Status общий boolean: 1 или >0 - переводы готовы, 0 - переводы не готовы или какой-то из них
                        $newTextStatusTranslations->Status = 0;
                        try{
                            if (!$newTextStatusTranslations->save()){
                                throw new CException('Error during status saving.');
                            }
                            Yii::app()->user->setFlash('Ssuccess', 'Status added');
                        }catch (CException $exception){
                            Yii::app()->user->setFlash('Serror', "New status didn't save");
                        }


                        Yii::app()->user->setFlash('Dsuccess', 'Deadline added');
                    }catch (CException $exception){
                        Yii::app()->user->setFlash('Derror', 'Deadline not added');
                    }

                    Yii::app()->user->setFlash('success', 'New task for translation added');
                }catch (CException $exception){
                    Yii::app()->user->setFlash('error', "New text didn't add");
                }
                $this->redirect(Yii::app()->createUrl('uploadtask/index', array('id' => $recordText->getPrimaryKey())));
            }
        }

        $this->render('task',array(
            'model'=>$model,
        ));
    }


}
