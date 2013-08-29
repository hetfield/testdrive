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
            $path = Yii::app()->basePath.DIRECTORY_SEPARATOR.'documents'.DIRECTORY_SEPARATOR;
            $model->attributes=$_POST[$modelName];
            $model->Document = CUploadedFile::getInstance($model,'Document');
            $docName = explode('.',CUploadedFile::getInstance($model,'Document'));
            $parts = count($docName);
            $model->TextId = $id;
            if ($model->validate()){
                try {
                    if (!$model->save()){
                        throw new CException('Error during file saving.');
                    }
                    $model->Document->saveAs($path.$id.'.'.$docName[$parts-1]);

                    /** @var TextTranslations $task */
                    $task = TextTranslations::model()->findByPk($id);
                    $taskTo = json_decode($task->TaskTo);

                    $englishText = false;
                    foreach ($taskTo as $translator){
                        if ($translator == 'en') $englishText = true;
                    }
                    if ($englishText){
                        $mailArray = array(
                            'en' => array(
                                'email' => 'translations@mfxbroker.com',
                                'name' => 'Егор Фентисов'
                            ),
//                            'en' => array(
//                                'email' => 'e.fentisov@mfxbroker.com',
//                                'name' => 'Егор Фентисов'
//                            ),
//                            'es' => array(
//                                'email' => 'iria_me9@hotmail.com',
//                                'name' => 'Iria Martinez Espinar'
//                            ),
//                            'cn' => array(
//                                'email' => 'huayu@masterforex.org',
//                                'name' => 'huayu@masterforex.org',
//                            ),
//                            'az' => array(
//                                'email' => 'e.zhidkov@mfxbroker.com',
//                                'name' => 'e.zhidkov@mfxbroker.com'
//                            ),
                        );
                    } else {
                        $mailArray = array(
                            'ar' => array(
                                'email' => 'translations@mfxbroker.com',
                                'name' => 'Mado Saied'
                            ),
//                            'ar' => array(
//                                'email' => 'ahmedsaied44@gmail.com',
//                                'name' => 'Mado Saied'
//                            ),
//                            'es' => array(
//                                'email' => 'iria_me9@hotmail.com',
//                                'name' => 'Iria Martinez Espinar'
//                            ),
//                            'cn' => array(
//                                'email' => 'huayu@masterforex.org',
//                                'name' => 'huayu@masterforex.org',
//                            ),
//                            'my' => array(
//                                'email' => 'kamnfx@gmail.com',
//                                'name' => 'Jeff Nash'
//                            ),
//                            'id' => array(
//                                'email' => 'juliana_djulie@yahoo.com',
//                                'name' => 'Juliana Saja'
//                            ),
//                            'az' => array(
//                                'email' => 'e.zhidkov@mfxbroker.com',
//                                'name' => 'e.zhidkov@mfxbroker.com'
//                            ),
                        );
                    }


                    include_once (Yii::app()->basePath.'/components/Mailer.php');
                    include_once (Yii::app()->basePath.'/components/Smtp.php');

                    foreach ($taskTo as $translator){
                        if (isset($mailArray[$translator])){
                            $deadline = DeadLines::model()->findByAttributes(array('TextID' => $id));

                            $mailer = new Mailer();

                            $subject = 'New Task "'.$task->Title.'"';
                            if ($translator == 'ar' || $translator == 'my' || $translator == 'id'){
                                $deadlineKey = array(
                                    'ar' => 'LangAr',
                                    'my' => 'LangMy',
                                    'id' => 'LangId',
                                );
                                $body    = 'Hello! <br>Please translate text with title "'.$task->Title.'" and Text Id = '.$task->ID.'. Deadline: '.$deadline->$deadlineKey[$translator].'. <br>You can do this on website <a href="http://translations.masterforex.com/">http://translations.masterforex.com/</a> in section Text Translation.<br>Do not answer to this message, please attach your translation in this programme: http://translations.masterforex.com/.<br>Thank you!';
                                $altBody = 'Hello!
                                Please translate text with title "'.$task->Title.'" and Text Id = '.$task->ID.'. Deadline: '.$deadline->$deadlineKey[$translator].'.
                                You can do this on website http://translations.masterforex.com/ in section Text Translation.
                                Do not answer to this message, please attach your translation in this programme: http://translations.masterforex.com/.
                                Thank you!';
                            } else {
                                $deadlineKey = array(
                                    'en' => 'LangEn',
                                    'cn' => 'LangCn',
                                    'es' => 'LangEs',
                                    'az' => 'LangAz',
                                );
                                $body    = 'Добрый день!<br>Просьба перевести тест c заголовком "'.$task->Title.'" и Text Id = '.$task->ID.' до '.$deadline->$deadlineKey[$translator].' на сайте <a href="http://translations.masterforex.com/">http://translations.masterforex.com/</a> в разделе Text Translation.<br>Не отвечайте на это сообщение. Загрузите ваш перевод на сайте, указанном выше.<br>Спасибо!';
                                $altBody = 'Добрый день!
                                Просьба перевести тест c заголовком "'.$task->Title.'" и Text Id = '.$task->ID.' до '.$deadline->$deadlineKey[$translator].' на сайте http://translations.masterforex.com/ в разделе Text Translation.
                                Не отвечайте на это сообщение. Загрузите ваш перевод на сайте, указанном выше.
                                Спасибо!';
                            }
                            $attachments = array(
                                array(
                                    'path' => $path.$id.'.'.$docName[$parts-1],
                                    'file' => $id.'.'.$docName[$parts-1],
                                ),
                            );
                            $addresses = array(
                                array(
                                    'email' => $mailArray[$translator]['email'],
                                    'name' => $mailArray[$translator]['name'],
                                ),
                            );


                            try{
                                if (!$mailer->NewMail($subject, $addresses, $body, $altBody, $attachments)){
                                    throw new CException('Error during email sending.');
                                }

                                Yii::app()->user->setFlash('Esuccess', 'Emails sent successfully');
                            }catch (CException $exception){
                                Yii::app()->user->setFlash('Eerror', 'Failed to send Emails');

                            }
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
            $file = Yii::app()->basePath.DIRECTORY_SEPARATOR.'documents'.DIRECTORY_SEPARATOR.$_GET['document'];
            Yii::app()->request->sendFile(basename($file),file_get_contents($file));
        }
    }
}