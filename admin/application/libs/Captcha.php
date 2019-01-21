<?
	class Captcha{
		private static $public_key 	= CAPTCHA_PUBLIC_KEY;
		private static $private_key = CAPTCHA_PRIVATE_KEY;
		private static $libFile 	= 'recaptchalib';
		
		static function show(){
			self::build();
			return recaptcha_get_html(self::$public_key);
		}
		
		private static function build(){
			require_once LIBS.self::$libFile.'.php';
		}
		
		static function verify(){
			self::build();
			
			$privatekey = self::$private_key;
			
			$resp = recaptcha_check_answer ($privatekey,
											$_SERVER["REMOTE_ADDR"],
											$_POST["recaptcha_challenge_field"],
											$_POST["recaptcha_response_field"]);

			  if (!$resp->is_valid) {
				return false;
			  } else {
				return true;
			  }
		}
	}
?>