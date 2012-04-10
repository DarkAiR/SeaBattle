<?php
class App
{
	private static $_instance = null;
	private static $_config = null;
	
	private $_userId = null;
	private $_user = null;

	private $_scripts = array();		// Список подключаемых скриптов
	private $_css = array();			// Список подключаемых css

	private $_errors = array();			// Ошибки в ходе рендера
	private $_apiError = null;			// Ошибка API


	public function __construct()
	{
		$this->_userId = isset( $_COOKIE['id'] )? $_COOKIE['id'] : null;
	}


	// Получить сущность
	public static function instance()
	{
		if( self::$_instance === null )
			self::$_instance = new App();
		return self::$_instance;
	}


	// Получить конфиг
	public static function config()
	{
		if( self::$_config === null )
			self::$_config = new Config();
		return self::$_config;
	}


	// Добавить ошибку
	public function addError( $str )
	{
		$this->_errors[] = $str;
	}


	// Получить список ошибок
	public function getErrors()
	{
		return $this->_errors;
	}


	// Есть ли ошибки?
	public function isErrorsExists()
	{
		return !empty($this->_errors);
	}


	// Получить Id пользователя
	public function getUserId()
	{
		return $this->_userId;
	}


	// Получить пользователя
	public function getUser()
	{
		if( $this->_user === null )
		{
			$userId = $this->getUserId();
			if( !empty($userId) )
			{
				$q = new UserQuery();
				$this->_user = $q->findOneById( $userId );
				if( empty($this->_user) )
					App::instance()->addError( 'Не найден пользователь!' );
			}
		}
		return $this->_user;
	}


	// Получить Id пользователя
	public function getApiErrors()
	{
		return array( $this->_apiError );
	}


	// Добавить скрипт
	public function addScript( $url )
	{
		if( in_array( $url, $this->_scripts ) )
			return;
		$this->_scripts[] = $url;
	}


	// Подключить скрипты
	private function includeScripts()
	{
		foreach( $this->_scripts as $val )
			echo '<script type="text/javascript" src="js/'.$val.'"></script>';
		$this->_scripts = array();
	}


	// Добавить css
	public function addCss( $url )
	{
		if( in_array( $url, $this->_css ) )
			return;
		$this->_css[] = $url;
	}


	// Подключить css
	private function includeCss()
	{
		foreach( $this->_css as $val )
			echo '<link rel="stylesheet" href="css/'.$val.'" type="text/css">';
		$this->_css = array();
	}


	// Запустить
	public function run()
	{
		$con = Propel::getConnection('propel');
		$con->useDebug(true);

/*		$res = App::instance()->api( 'getRooms' );
		var_dump( $res );

		echo $con->getLastExecutedQuery();
		return;*/

		// Загружаем базовые CSS
		$this->addCss( 'reset.css' );
		$this->addCss( 'main.css' );

		try
		{
			$mainPage = new PlainPhpView();

			$routeArr = RouteUtils::getRoute();
			$page   = $routeArr['page'];
			$action = $routeArr['action'];

			$pageName = RouteUtils::getPageByRoute( $page, $action );

			switch( $page )
			{
				case 'mainPage':
					require 'pages/mainPage.php';
					$pageObj = new MainPage( $mainPage, $page, $action );
					$pageObj->show();
					break;

				case 'registration':
					require 'pages/registrationPage.php';
					$pageObj = new RegistrationPage( $mainPage, $page, $action );
					$pageObj->show();
					break;

				case 'createField':
					require 'pages/createFieldPage.php';
					$pageObj = new CreateFieldPage( $mainPage, $page, $action );
					$pageObj->show();
					break;

				case 'rooms':
					require 'pages/roomsPage.php';
					$pageObj = new RoomsPage( $mainPage, $page, $action );
					$pageObj->show();
					break;
			}

			$this->includeCss();
			$this->includeScripts();

			if( !empty($this->_errors) )
				$mainPage->assign( 'errors', $this->_errors );

			// Если вызвали ajax-запросом, то формируем правильный JSON
			$isAjax = HttpUtils::getPost('isAjax', false);
			if( $isAjax )
				ob_clean();

			print $mainPage->fetch( $pageName );
			//var_dump( $_POST );
			var_dump( $page );
			var_dump( $action );

			if( $isAjax )
			{
				$res = array(
					'data' => ob_get_clean(),
				);
				echo json_encode($res);
				exit();	// Выходим, иначе будет не валидный JSON в ответе
			}
		}
		catch( Exception $e )
		{
			echo $con->getLastExecutedQuery();
			throw $e;
		}
		echo $con->getLastExecutedQuery();
	}


	// Вызов методов API
	public function api( $method, $params=array() )
	{
		$this->_apiError = null;

		$salt = 'darkair';
		$auth = md5(md5($method.serialize($params).$salt));

		$p['auth']   = $auth;
		$p['uid']    = $this->getUserId();
		$p['method'] = $method;
		$p['params'] = serialize( $params );

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, self::config()->apiUrl );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $p );
		$res = curl_exec( $ch );
		curl_close( $ch );

		if( get_magic_quotes_gpc() )
			$res = stripslashes($res);

		$resEnd = unserialize( $res );

		if( isset( $resEnd['error'] ) )
		{
			// Если вызвали ajax-запросом, то падаем с исключением
			if( HttpUtils::getPost('isAjax', false) == true )
				throw new Exception( $resEnd['error'] );

			$this->_apiError = $resEnd['error'];
			return false;
		}
		if( !isset($resEnd['data']) )
		{
			// Если вызвали ajax-запросом, то падаем с исключением
			if( HttpUtils::getPost('isAjax', false) == true )
				throw new Exception( $res );

			$this->_apiError = $res;
			return false;
		}

		return $resEnd['data'];
	}
}
?>