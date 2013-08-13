<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class TranslationEditForm extends CFormModel
{
	public $Languages = array();
    public $redactor;
    public $Status = '1';
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('Languages, redactor', 'safe'),
            array('Status', 'required'),
		);
	}

    public function setRadioBtnActive()
    {
        if (Yii::app()->user->getState('Role') == 'T')
            $lang = array();
            $lang = json_decode(Yii::app()->user->getState('Languages'));
            $this->Languages = $lang[0];
        if (Yii::app()->user->getState('Role') == 'A')
            $this->Languages = 'en';
    }
}

