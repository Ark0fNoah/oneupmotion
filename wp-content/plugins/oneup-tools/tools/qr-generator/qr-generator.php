<?php
/**
 * QR generator tool bootstrap.
 *
 * @package OneUpTools
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// The first real QR renderer lives in assets/js/qr-generator.js so it can render and download client-side SVGs without external services.
// TODO: Add optional server-side rendering later if generated QR payloads need to be stored.
