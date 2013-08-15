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

//                    $phpMailer = new PHPMailer();
//
//                    $phpMailer->CharSet="utf8";
//                    $phpMailer->IsSMTP();
//                    $phpMailer->Port       = 587;
//                    $phpMailer->SMTPSecure = true;
//                    $phpMailer->Host = 'smtp.mfxbroker.com';//'smtp.mfxbroker.com';
//                    $phpMailer->Username = 'translations@mfxbroker.com';                            // SMTP username
//                    $phpMailer->Password = 'aiutsraghuy545#';                           // SMTP password
//                    $phpMailer->SMTPSecure = 'tls';
//                    $phpMailer->SMTPAuth   = true;
//                    $phpMailer->From = 'translations@mfxbroker.com';
//                    $phpMailer->FromName = 'MasterForex';
//                    $phpMailer->IsHTML(true);
//                    $phpMailer->Subject = 'New Task from MasterForex';
//
//                    if ($key == 'LangAr' || $key == 'LangMy' || $key == 'LangId'){
//                        $phpMailer->Body    = 'Hello! <br>Please translate text with title "'.$_POST[$modelName]['title'].'" and Text Id = '.$recordText->getPrimaryKey().'. Deadline: '.$deadline.'. <br>You can do this on website <a href="http://translations.masterforex.com/">http://translations.masterforex.com/</a>.<br>Thank you!';
//                        $phpMailer->AltBody = 'Hello! Please translate text with title "'.$_POST[$modelName]['title'].'" and Text Id = '.$recordText->getPrimaryKey().'. Deadline: '.$deadline.'. You can do this on website http://translations.masterforex.com/. Thank you!';
//                    } else {
//                        $phpMailer->Body    = 'Добрый день!<br>Просьба перевести тест c заголовком "'.$_POST[$modelName]['title'].'" и Text Id = '.$recordText->getPrimaryKey().' до '.$deadline.' на сайте <a href="http://translations.masterforex.com/">http://translations.masterforex.com/</a>.<br>Спасибо!';
//                        $phpMailer->AltBody = 'Добрый день! Просьба перевести тест c заголовком "'.$_POST[$modelName]['title'].'" и Text Id = '.$recordText->getPrimaryKey().' до '.$deadline.' на сайте http://translations.masterforex.com/. Спасибо!';
//                    }
//
//                    $phpMailer->AddAddress($mailArray[$key]['email'], $mailArray[$key]['name']);
//
//                    try{
//                        if (!$phpMailer->Send()){
//                            throw new CException('Error during email sending.');
//                        }
//
//                        Yii::app()->user->setFlash('Esuccess', 'Emails sent successfully');
//                    }catch (CException $exception){
//                        Yii::app()->user->setFlash('Eerror', 'Failed to send Emails');
//
//                    }
//                }
//                        unset($phpMailer);


                    $model->Document->saveAs($path.$model->Document);
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