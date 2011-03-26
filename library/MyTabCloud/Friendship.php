<?php

class MyTabCloud_Friendship
{
	// Fonction qui va logger une action
	public static function askFriendship($user1, $user2) {
		$mapper = new Application_Model_FriendshipMapper();
		$mapper->ask($user1, $user2);
	}
}
	