=== Magento User Compatibility ===
Contributors: veganist
Tags: Magento, email, login, authentication, users, customers, hash, migrate, password
Requires at least: 2.8
Tested up to: 3.7.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin will automatically rehash the passwords of users you have beforehand imported from a Magento database to your WP database.

== Description ==

This plugin will allow you to automatically rehash the passwords of users you have beforehand imported from a Magento database to your Wordpress database.

This is useful if you are migrating a website from Magento to Wordpress.

It allows users to authenticate via their email address, like on a Magento installation.

Upon login, the plugin will check the password entered by the user, against the value stored in the database. It'll verify if the password is correct and, only in that case, it'll rehash the password using Wordpress' default hashing algorithm and insert the new password to the database. Then it'll try logging in.

In every other case, login will function normally, so if there is an error, it'll be returned.

In a while, every former Magento user you have imported to your WP DB will have their passwords securely rehashed.

Tested successfully with Magento 1.8.0.0 and Wordpress 3.7.1.

== Installation ==

0. Manually import the database of your previous Magento customer passwords.
1. Alter the database. See FAQ.
2. Unzip and upload `/magento-user-compatibility/` to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Does the plugin import the user database of my Magento installation? =

No. You will have to do this yourself manually.
The passwords of Magento customers are stored in a table called "customer_entity_varchar".
You will need to execute an SQL command on your user table too, so it can take into account Magento's long password hashs: ALTER TABLE  `wp_xxxxx` CHANGE  `user_pass`  `user_pass` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  ''

== Changelog ==

= 1.0 =
* Initial release
