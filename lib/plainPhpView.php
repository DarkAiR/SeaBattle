<?php
class PlainPhpView
{
	public $template_dir = 'views';
	protected $_vars = array();

	public function __construct($template_dir = '')
	{
		$this->template_dir = $template_dir ? $template_dir : $this->template_dir;
	}

	public function assign($var_name, $var_value)
	{
		$this->_vars[$var_name] = $var_value;
	}

	public function fetch($template)
	{
		$reporting = error_reporting(E_ALL & ~E_NOTICE);
		extract($this->_vars);
		ob_start();
		include $this->template_dir.'/'.$template;
		ini_set('error_reporting', $reporting);
		return ob_get_clean();
	}

	public function getVar($var)
	{
		return isset($this->_vars[$var]) ? $this->_vars[$var] : false;
	}

	public function loadBlock( $name, $params=array() )
	{
		$block = new PlainPhpView();
		foreach( $params as $key=>$val )
			$block->assign( $key, $val );
		echo $block->fetch( $name );
	}

	public function addScript( $name )
	{
		App::instance()->addScript( $name );
	}

	public function addCss( $name )
	{
		App::instance()->addCss( $name );
	}

	/**
	 * Создание AJAX-запроса
	 */
	public function createAjaxSubmit( $onDataPreparation=null, $onSuccess=null, $onError=null )
	{

	}
}