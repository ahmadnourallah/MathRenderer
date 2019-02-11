<?php
class MathRenderer {

	private static $moduleLoaded = false;
	
	public static function onRegistration() {

		Hooks::register( 'ParserFirstCallInit', __CLASS__ . '::setup' );

	}

	public static function setup( Parser $parser ) {

		$parser->setHook( 'math', __CLASS__ . '::renderMath' );

	}

	public static function charCodeAt($str, $index) {

		list(, $result) = unpack('N', mb_convert_encoding($str{$index}, 'UCS-4BE', 'UTF-8'));
		return $result;

	}

	public static function wrs_urlencode($clearString) {

		$output = '';
		$x = 0;
		$regex = '/(^[a-zA-Z0-9_.]*)/';

		$clearString_length = strlen($clearString);

		while ($x < $clearString_length) {
			preg_match($regex, substr($clearString, $x), $matches);
			if (is_null($matches) === false && count($matches) > 1 && $matches[1] != '') {
				$output .= $matches[1];
				$x += strlen($matches[1]);
			} else {
				$charCode = self::charCodeAt($clearString, $x);
				$hexVal = (string)dechex($charCode);
				$output .= '%' . (strlen($hexVal) < 2 ? '0': '') . strtoupper($hexVal);
				++$x;
			}
		}
		return $output;

	}

	public static function wrs_mathmlEntities($mathml) {

		$toReturn = '';
		
		for ($i = 0; $i < strlen($mathml); ++$i) {

			if (self::charCodeAt($mathml, $i) > 128) {
				$toReturn .= '&#' . self::charCodeAt($mathml, $i) . ';';
			} else {
				$toReturn .= $mathml{$i};
			}
		}


		return $toReturn;
	}

	public static function encodeURIComponent($str) {

    	$revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
    	return strtr(rawurlencode($str), $revert);

	}

	public static function renderMath($equation, array $args, Parser $parser, PPFrame $frame ) {

		global $wgMRUseMML, $wgMRMathTypeService, $wgMROptions;

		if (!array_key_exists('dir', $args)) $args['dir'] = 'left';
		if (!array_key_exists('mode', $args)) $args['mode'] = 'display';

		$src = $wgMRMathTypeService . "?";

		if (!$wgMRUseMML && !$args['mml'] || $args['latex']) {

			$src .= 'latex=' . self::encodeURIComponent($equation);

		} else if ($wgMRUseMML && !$args['latex'] || $args['mml']) {
		
			$src .= "mml=" . self::wrs_urlencode(self::wrs_mathmlEntities('<math dir="' . $args['dir'] . '">' . $equation . '</math>'));
		
		} 

		$mode = $args['mode'];

		unset($args['dir']); unset($args['mode']); unset($args['mml']); unset($args['latex']);

		foreach ($args as $key => $value) $wgMROptions[$key] = $value;		
		foreach ($wgMROptions as $key => $value) $src .= "&" . $key . "=" . $value;

		$result = "<img class='mr-equation' src='${src}' style='";
		$result .= $mode === 'display' ? "display: block; margin: 10px auto;" : "none";
		$result .= "'/>";

		return [$result, 'markerType'=>'nowiki'];

	}
}