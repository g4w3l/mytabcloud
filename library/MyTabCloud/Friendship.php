<?php

class MyTabCloud_Friendship
{
	const NO_FRIENDSHIP = 0;
	const PENDING_REQUEST = 1;
	const FRIENDSHIP = 2;
	
	// Fonction qui va logger une action
	public static function askFriendship($user1, $user2) {
		$mapper = new Application_Model_FriendshipMapper();
		$mapper->ask($user1, $user2);
	}
	
	public static function friendshipRequested($user1, $user2) {
		$mapper = new Application_Model_FriendshipMapper();
		return $mapper->fetchStatus($user1, $user2);
	}
}
	