<?php
class RouteUtils
{
	// Сопоставление действиям основных шаблонов
	private static $_rules = array
	(
		'mainPage' => array(
			'index'  => 'mainPage.php',
			'login'  => 'mainPage.php',
			'logout' => 'mainPage.php',
		),
		'registration' => array(
			'index' => 'registrationPage.php',
		),
		'rooms' => array(
			'index'      => 'roomsPage.php',
			'createRoom' => 'roomsPage.php',
			'enterRoom'  => 'roomsPage.php',
			'leaveRoom'  => 'roomsPage.php',
			'getRooms'   => 'roomsPage.php',
		),
		'createField' => array(
			'index'     => 'createFieldPage.php',
			'saveField' => 'createFieldPage.php',
		),
	);

	public static function getRoute( $route=null )
	{
		if( $route == null )
			$route = HttpUtils::getPost( 'route', null );

		$res = array(
			'page' => 'mainPage',
			'action' => 'index'
		);
		if( $route != null )
		{
			list( $page, $action ) = explode("/", $route, 2);
			$res['page'] = $page;
			$res['action'] = $action;
		}

		return $res;
	}


	public static function makeRoute( $page, $action=null )
	{
		if( $action==null )
			$action = 'index';
		return $page.'/'.$action;
	}


	public static function getPageByRoute( $page, $action )
	{
		$template = ( isset(self::$_rules[$page]) && isset(self::$_rules[$page][$action]) )
			? self::$_rules[$page][$action]
			: self::$_rules['mainPage']['index'];
		return $template;
	}


	public static function redirect( $page, $action, $params=array() )
	{
		$route = self::makeRoute( $page, $action );

		if( !is_array($params) )
			$params = array();
		$params['route'] = $route;

		echo '<form name="redirect_form" method="post" action="index.php">';
		foreach( $params as $key=>$val )
			echo '<input type="hidden" name="'.$key.'" value="'.$val.'">';
		echo '</form>';
		echo '<script type="text/javascript">redirect_form.submit();</script>';
	}
}
?>