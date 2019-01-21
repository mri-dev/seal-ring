<?
namespace MailManager;

/**
* class MailManagerException
* @package MailManager
* @version 1.0
*/
class MailManagerException extends \Exception
{
	// Debug, error hibaüzenet megjelenítése
	const OUTPUT_ERROR = 1;
	// Alapértelmezett sima üzenet megjelenítése
	const OUTPUT_ALERT = 0;

	public function __construct($message, $mode = false, $code = 0, Exception $previous = null) {

		if ( !$mode || $mode === self::OUTPUT_ALERT ) {
			parent::__construct($message, $code, $previous);
		}elseif( $mode === self::OUTPUT_ERROR ){
			parent::__construct(__NAMESPACE__.':<br>'.$message.' <br> Dropped @ '.parent::getFile().':'.parent::getLine(), $code, $previous);
		}

    }
	
}
?>