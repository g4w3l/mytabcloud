<?php

/**
 * Classe MyTabCloud_Friendship
 * Gestion des amitiés
 */
class MyTabCloud_Friendship
{
	const NO_FRIENDSHIP = 0;
	const PENDING_REQUEST = 1;
	const FRIENDSHIP = 2;
	const FRIENDSHIP_REQUESTED = 3;
	
	// Fonction qui va créer une demande d'amitié de user 1 vers user 2
	public static function askFriendship($user1, $user2) {
		$mapper = new Application_Model_FriendshipMapper();
		$mapper->ask($user1, $user2);
	}
	
	// Fonction qui retourne le statut d'amitié entre user 1 et user 2
	public static function friendshipRequested($user1, $user2) {
		$mapper = new Application_Model_FriendshipMapper();
		return $mapper->fetchStatus($user1, $user2);
	}
}
	