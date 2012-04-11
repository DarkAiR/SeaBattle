<?php
require_once 'basePage.php';

class RoomsPage extends BasePage
{
	// Отображение списка комнат
	public function actionIndex()
	{
		if( $this->getRoomsFromServer() === false )
			$this->_mainPage->assign( 'errors', App::instance()->getApiErrors() );
		else
			$this->showRoomsList();
		
		$this->showField();
	}


	// Создание комнаты
	public function actionCreateRoom()
	{
		$res = App::instance()->api( 'createRoom' );
		if( $res === false )
		{
			$this->_mainPage->assign( 'errors', App::instance()->getApiErrors() );
		}
		else
		{
			// После создания комнаты возвращаемся на главную страницу комнат
			$this->actionIndex();
			return;
		}

		$this->showRoomsList();
		$this->showField();
	}


	// Вход в комнату
	public function actionEnterRoom()
	{
		$roomId = HttpUtils::getPost( 'roomId', null );
		if( $roomId === null )
		{
			App::instance()->addError( 'Не найден ID комнаты' );
			$this->_mainPage->assign( 'errors', App::instance()->getErrors() );
		}
		else
		{
			$res = App::instance()->api( 'enterRoom', array('roomId' => $roomId) );
			if( $res === false )
			{
				$this->_mainPage->assign( 'errors', App::instance()->getApiErrors() );
			}
			else
			{
				// После смены комнаты возвращаемся на главную страницу комнат
				$this->actionIndex();
				return;
			}
		}		

		$this->showRoomsList();
		$this->showField();
	}


	// Выход из комнаты
	public function actionLeaveRoom()
	{
		$roomId = HttpUtils::getPost( 'roomId', null );
		if( $roomId === null )
		{
			App::instance()->addError( 'Не найден ID комнаты' );
			$this->_mainPage->assign( 'errors', App::instance()->getErrors() );
		}
		else
		{
			$res = App::instance()->api( 'leaveRoom', array('roomId' => $roomId) );
			if( $res === false )
			{
				$this->_mainPage->assign( 'errors', App::instance()->getApiErrors() );
			}
			else
			{
				// После смены комнаты возвращаемся на главную страницу комнат
				$this->actionIndex();
				return;
			}
		}

		$this->showRoomsList();
		$this->showField();
	}


	// Получить список комнат (ajax)
	public function actionGetRooms()
	{
		$res = $this->getRoomsFromServer();
		if( $res === false )
			throw new GameException( 'GetRooms : Rooms not found' );

		return PlainPhpView::loadBlock( 'rooms/roomListBlock.php', array(
			'rooms' => $this->sGetRooms()
		));
	}


	// Получить список комнат с сервера
	private function getRoomsFromServer()
	{
		$res = App::instance()->api( 'getRooms' );
		if( $res === false )
			return false;

		if( $res['rooms'] === null )
			return false;

		$this->sStoreRooms( unserialize( $res['rooms'] ) );
		return $res['rooms'];
	}


	// Отображение списка комнат
	private function showRoomsList()
	{
		$screen = new PlainPhpView();
		$screen->assign( 'rooms', $this->sGetRooms() );
		$content = $screen->fetch( 'rooms/roomList.php' );
		$this->_mainPage->assign( 'roomsList', $content );
	}


	// Отображение игрового поля
	private function showField()
	{
		// Игровое поле
		$field = HttpUtils::getPost( 'field', 'nothing' );

		$screen = new PlainPhpView();
		$screen->assign( 'field', $field );
		$content = $screen->fetch( 'rooms/field.php' );
		$this->_mainPage->assign( 'field', $content );
	}


	// Запомнить комнаты
	private function sStoreRooms( &$rooms )
	{
		$_SESSION['rooms'] = $rooms;
	}


	// Получить комнаты
	private function sGetRooms()
	{
		return $_SESSION['rooms'];
	}
}
