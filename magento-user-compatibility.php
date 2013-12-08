<?php
/*
Plugin Name: Magento user compatibility
Plugin URI: http://curlybracket.net/2013/12/05/magento-user-compatibility/
Description: Magento user password rehasher
Author: Ulrike Uhlig
Version: 1.0
Author URI: http://curlybracket.net
*/

/*  Copyright 2013  Ulrike Uhlig  (email : u@curlybracket.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * @param string $user
 * @param string $username
 * @param string $password
 * @return Results of authenticating via wp_authenticate_username_password(), using the username found when looking up via email. Adds new WP hased password to database if a former Magento user identifies correctly.
 */

function magento_pw_rehash( $user, $username, $password ) {
	global $wpdb;
	require_once( ABSPATH . 'wp-includes/class-phpass.php');

	// login via email or username. short piece of code from Beau Lebens' WP Email Login
	$user = get_user_by( 'email', $username );
	if ( isset( $user, $user->user_login, $user->user_status ) && 0 == (int) $user->user_status ) {
		$username = $user->user_login;
	}

	// This is the hashing function of Magento : http://www.magentogarden.com/blog/how-are-passwords-encrypted-in-magento.html
    $wp_hashed_pw = $user->user_pass; // password stored in WPDB imported from customer base of Magento or new pw
    $plaintext_pw = $password;
    $oldpw = explode(':', $wp_hashed_pw);

    // if this is true, it means that the user's password in the DB is an old Magento password
    // if the password is correct, we rehash and update it
    if (md5($oldpw[1].$plaintext_pw) == $oldpw[0]) {
        wp_set_password( $plaintext_pw, $user->id );
    }

	return wp_authenticate_username_password( null, $username, $password );
}
remove_filter( 'authenticate', 'wp_authenticate_username_password', 20, 3 );
add_filter( 'authenticate', 'magento_pw_rehash', 20, 3 );
?>
