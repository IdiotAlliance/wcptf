<?php

/**
 * ChoosePosterForm class.
 * ChoosePosterForm is the data structure for keeping
 * user posters form data. It is used by the 'choose' action of 'OrdersList'.
 */
class ChoosePosterForm extends CFormModel
{
	public $poster;
	public function rules()
	{
		return array(
			array('poster', 'required'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'poster'=>'',
		);
	}
}
