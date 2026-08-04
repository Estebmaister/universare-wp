<?php
/**
 * Must-use plugin loaded on every request.
 * Use for small site-wide tweaks that should deploy with Git.
 *
 * @package Universare
 */

defined( 'ABSPATH' ) || exit;

// Example: disable XML-RPC if not needed.
// add_filter( 'xmlrpc_enabled', '__return_false' );
