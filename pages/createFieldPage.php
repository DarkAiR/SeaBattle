<?php
require_once 'basePage.php';

class CreateFieldPage extends BasePage
{
	// Редактирование поля
	public function actionIndex()
	{
		$screen = new PlainPhpView();
		$content = $screen->fetch( 'createField/createField.php' );

		$this->_mainPage->assign( 'content', $content );
	}


	// Сохранение комнаты (ajax)
	public function actionSaveField()
	{
		$field = HttpUtils::getPost( 'field', null );
		if( $field === null )
			throw new Exception( 'Field not found in request' );

		$params = array(
			'field' => $field,
		);
		$res = App::instance()->api( 'saveField', $params );
		// Т.к. это ajax запрос, то обрабатывать результат не нужно
	}
}