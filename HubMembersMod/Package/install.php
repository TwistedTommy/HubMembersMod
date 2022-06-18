<?php
if (!defined('SMF') && file_exists(dirname(__FILE__) . '/SSI.php'))
    require_once(dirname(__FILE__) . '/SSI.php');
elseif (!defined('SMF'))
    die('<b>Error:</b> Cannot install - please verify you put this in the same place as SMF\'s index.php.');

// Insert the hooks
$hooks = array(
	'integrate_pre_include' => '$sourcedir/HubMembersMod.php',
	'integrate_register' => 'HubMemberRegister',
	'integrate_activate' => 'HubMemberActivate',
	'integrate_reset_pass' => 'HubMemberResetPass'
);
//	'integrate_delete_member' => 'HubMemberDelreg',
//	'integrate_nick_change' => 'HubMemberNickChange',

foreach ($hooks as $hook => $func)
	add_integration_function($hook, $func);
?>