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
                $recordText->LangRu = htmlspecialchars($_POST[$modelName]['textForTranslation']);
                $recordText->Text = htmlspecialchars($_POST[$modelName]['textForTranslation']);
                $newDeadLine = new DeadLines();
                $newTextStatusTranslations = new TextStatusTranslations();
                foreach ($_POST[$modelName]['calendar'] as $key => $deadline){
                    if ($key == 'LangAr' ||
                        $key == 'LangEn' ||
                        $key == 'LangEs' ||
                        $key == 'LangCn' ||
                        $key == 'LangMy' ||
                        $key == 'LangId' ||
                        $key == 'LangAz'){
                        $newDeadLine->$key = $deadline;
                    }
                }

                /** @var PHPMailer $phpMailer */
                $phpMailer = new PHPMailer();

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
                $phpMailer->AddAddress('d.sukhov@mfxbroker.com', 'D.Sukhov');
                $phpMailer->AddAddress('translations@mfxbroker.com', 'translations@mfxbroker.com');// Add a recipient

                $phpMailer->IsHTML(true);                                  // Set email format to HTML

                $phpMailer->Subject = 'Тема письма';
                $phpMailer->Body    = 'This is the HTML message body <b>in bold!</b>';
                $phpMailer->AltBody = 'This is the body in plain text for non-HTML mail clients';

                if(!$phpMailer->Send()) {
                    echo 'Message could not be sent.';
                    echo 'Mailer Error: ' . $phpMailer->ErrorInfo;
                    exit;
                }

                try{
                    if (!$recordText->save()){
                        throw new CException('Error during model saving.');
                    }

                    $newDeadLine->TextID = $recordText->getPrimaryKey();
                    if (!$newDeadLine->save()){
                        throw new CException('Error during model saving.');
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
                    if (!$newTextStatusTranslations->save()){
                        throw new CException('Error during model saving.');
                    }
                    Yii::app()->user->setFlash('success', 'New text for translation added');
                }catch (CException $exception){
                    Yii::app()->user->setFlash('error', "New text didn't add");
                }


            }
        }

        $this->render('task',array(
            'model'=>$model,
        ));
    }


}