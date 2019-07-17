<?php
	class Translator {
		public $langData;

		public function __construct($lang) {
			$sanitizedLang = "fr";

			if ($lang == "en") {
				$sanitizedLang = $lang;
			}
			require_once($_SERVER['DOCUMENT_ROOT'] . "/lang/" . $sanitizedLang . ".php");

			$this->langData = $langData;
		}

		public function read($page, $node) {
			$value = "TEXT_NOT_FOUND";

			if (!empty($this->langData[$page][$node])) {
				$value = $this->langData[$page][$node];
			}

			return $value;
		}
	}
?>