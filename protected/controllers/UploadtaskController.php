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
        /** @var Uploadtask $model */
        $modelName = 'Uploadtask';
        $model = new $modelName();
        if (isset($_GET['id'])) $id = $_GET['id'];

        if(isset($_POST[$modelName]) && isset($id)){
            $path = Yii::app()->basePath.'\documents\\';
            $model->attributes=$_POST[$modelName];
            $model->Document = CUploadedFile::getInstance($model,'Document');
            $model->TextId = $id;
            if ($model->validate()){
                try {
                    if (!$model->save()){
                        throw new CException('Error during file saving.');
                    }
                    $model->Document->saveAs($path.$model->Document);

                    /** @var TextTranslations $task */
                    $task = TextTranslations::model()->findByPk($id);
                    $taskTo = json_decode($task->TaskTo);

                    $mailArray = array(
                        'ar' => array(
                            'email' => 'ahmedsaied44@gmail.com',
                            'name' => 'Mado Saied'
                        ),
                        'en' => array(
                            'email' => 'e.fentisov@mfxbroker.com',
                            'name' => 'Егор Фентисов'
                        ),
                        'es' => array(
                            'email' => 'iria_me9@hotmail.com',
                            'name' => 'Iria Martinez Espinar'
                        ),
                        'cn' => array(
                            'email' => 'huayu@masterforex.org',
                            'name' => 'huayu@masterforex.org',
                        ),
                        'my' => array(
                            'email' => 'kamnfx@gmail.com',
                            'name' => 'Jeff Nash'
                        ),
                        'id' => array(
                            'email' => 'juliana_djulie@yahoo.com',
                            'name' => 'Juliana Saja'
                        ),
                        'az' => array(
                            'email' => '',
                            'name' => ''
                        ),
                    );

                    include (Yii::app()->basePath.'/components/Phpmailer.php');
                    include (Yii::app()->basePath.'/components/Smtp.php');

                    foreach ($taskTo as $translator){
                        if (isset($mailArray[$translator])){
                            $phpMailer = new PHPMailer();
                            /** @var DeadLines $deadline */
                            $deadline = DeadLines::model()->findByAttributes(array('TextID' => $id));



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
                            $phpMailer->Subject = 'New Task from MasterForex';


                            if ($translator == 'ar' || $translator == 'my' || $translator == 'id'){
                                $deadlineKey = array(
                                    'ar' => 'LangAr',
                                    'my' => 'LangMy',
                                    'id' => 'LangId',
                                );
                                $phpMailer->Body    = 'Hello! <br>Please translate text with title "'.$task->Title.'" and Text Id = '.$task->ID.'. Deadline: '.$deadline->$deadlineKey[$translator].'. <br>You can do this on website <a href="http://translations.masterforex.com/">http://translations.masterforex.com/</a> in section Text Translation. <br>Thank you!';
                                $phpMailer->AltBody = 'Hello! Please translate text with title "'.$task->Title.'" and Text Id = '.$task->ID.'. Deadline: '.$deadline->$deadlineKey[$translator].'. You can do this on website http://translations.masterforex.com/ in section Text Translation. Thank you!';
                            } else {
                                $deadlineKey = array(
                                    'en' => 'LangEn',
                                    'cn' => 'LangCn',
                                    'es' => 'LangEs',
                                    'az' => 'LangAz',
                                );
                                $phpMailer->Body    = 'Добрый день!<br>Просьба перевести тест c заголовком "'.$task->Title.'" и Text Id = '.$task->ID.' до '.$deadline->$deadlineKey[$translator].' на сайте <a href="http://translations.masterforex.com/">http://translations.masterforex.com/</a> в разделе Text Translation.<br>Спасибо!';
                                $phpMailer->AltBody = 'Добрый день! Просьба перевести тест c заголовком "'.$task->Title.'" и Text Id = '.$task->ID.' до '.$deadline->$deadlineKey[$translator].' на сайте http://translations.masterforex.com/ в разделе Text Translation. Спасибо!';
                            }

                            /** @var Uploadtask $fileName */
                            $fileName = Uploadtask::model()->findByAttributes(array('TextId' => $id));
                            //var_dump($fileName->Document);die;
                            $phpMailer->AddAttachment($path.$fileName->Document, $fileName->Document);
                            $phpMailer->AddAddress($mailArray[$translator]['email'], $mailArray[$translator]['name']);
                            try{
                                if (!$phpMailer->Send()){
                                    throw new CException('Error during email sending.');
                                }

                                Yii::app()->user->setFlash('Esuccess', 'Emails sent successfully');
                            }catch (CException $exception){
                                Yii::app()->user->setFlash('Eerror', 'Failed to send Emails');

                            }
                            unset($phpMailer);
                        }
                    }


                    Yii::app()->user->setFlash('success', 'New task is sent to translators');
                    $this->redirect(Yii::app()->createUrl('textstatustranslations/index'));

                } catch (CException $exception) {
                    Yii::app()->user->setFlash('error', "The file is not saved");
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