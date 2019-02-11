<?php
if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'MathRenderer' );
	wfWarn(
		'Deprecated PHP entry point used for MathRenderer extension. Please use wfLoadExtension ' .
		'instead, see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);
	return true;
} else {
	die( 'This version of the MathRenderer extension requires MediaWiki 1.25+' );
}
