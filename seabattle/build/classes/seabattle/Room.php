<?php



/**
 * Skeleton subclass for representing a row from the 'room' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.seabattle
 */
class Room extends BaseRoom
{
	// Состояния комнаты
	const STATE_WAIT = 0;		// (default) Ожидание игроков
	const STATE_PLAY = 1;		// Комната запущена в игру

	// Максимальное количество игроков в комнате
	const MAX_USERS = 2;
} // Room
