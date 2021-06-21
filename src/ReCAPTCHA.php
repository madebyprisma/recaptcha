<?php

namespace AdairCreative {
	use SilverStripe\Forms\FieldList;
	use SilverStripe\Forms\TextField;
    use SilverStripe\Core\Config\Configurable;
    use SilverStripe\Core\Config\Config;
    use SilverStripe\View\Requirements;

	class ReCAPTCHA {
		use Configurable;
		
		public static function field() {
			$app = Config::inst()->get(ReCAPTCHA::class, "app_key");

			if (!$app) throw "ReCAPTCHA app key has not been defined";

			return TextField::create("CaptchaToken", "")->setAttribute('required', 'true')->setAttribute("data-key", $app);
		}

		/**
		 * @depricated
		 * Use `ReCAPTCHA::field()` instead
		 */
		public static function addField(FieldList &$fieldList) {
			$fieldList->add(ReCAPTCHA::field());
		}

		public static function importJavascript() {
			Requirements::javascript("/resources/vendor/adair-creative/recaptcha/dist/ReCAPTCHA.js");
		}

		public static function importCSS() {
			Requirements::css("/resources/vendor/adair-creative/recaptcha/dist/ReCAPTCHA.css");
		}

		/**
		 * @param string $token
		 * @return bool
		 */
		public static function verify($token) {
			$secret = Config::inst()->get(ReCAPTCHA::class, "secret_key");

			if (!$secret) throw "ReCAPTCHA secret key has not been defined";

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
			curl_setopt($ch, CURLOPT_POSTFIELDS, [
				"secret" => $secret,
				"response" => $token
			]);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			return json_decode(curl_exec($ch))->success;
		}
	}
}
