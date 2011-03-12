<?php

class MyTabCloud_Action
{
	// Fonction qui va logger une action
	public static function logAction($user, $action, $type, $resource) {
		$mapper = new Application_Model_ActionMapper();
		$mapper->save($user, $action, $type, $resource);
	}
}
	