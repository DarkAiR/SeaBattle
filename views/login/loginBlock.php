<form method="post">
	Логин: <input type="text" name="login" /><br/>
	Пароль:<input type="password" name="password" /><br/>
	<input type="hidden" name="route" value="<?= RouteUtils::makeRoute('mainPage', 'login') ?>" />
	<input type="submit" value="Войти" />
</form>

<form method="post">
	<input type="hidden" name="route" value="<?= RouteUtils::makeRoute('registration') ?>" />
	<input type="submit" value="Зарегистрироваться" />
</form>
