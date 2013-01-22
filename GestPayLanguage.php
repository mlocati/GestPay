<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'GestPay.php';

/** Helper class to manage GestPay languages. */
class GestPayLanguage {
	/** Italian.
	* @var int
	*/
	const IT = 1;
	/** English.
	* @var int
	*/
	const EN = 2;
	/** Spanish.
	* @var int
	*/
	const ES = 3;
	/** French.
	* @var int
	*/
	const FR = 4;
	/** German.
	* @var int
	*/
	const DE = 5;
	/** Checks if a value is a valid language ID.
	* @param int|mixed $value The value to be checked (will be set to int if it's a valid numeric language ID).
	* @param bool $includeDismissed [default: false] Also accepts dismissed currencies?
	* @return boolean
	*/
	public static function IsValid(&$value) {
		if(is_numeric($value)) {
			$c = @intval($value);
			$all = self::getAll();
			if(array_search($c, $all) !== false) {
				$value = $c;
				return true;
			}
		}
		return false;
	}
	/** Returns all the available language IDs.
	* @return array[int]
	*/
	public static function getAll($includeDismissed = false) {
		return array(
			self::IT,
			self::EN,
			self::ES,
			self::FR,
			self::DE
		);
	}
	/** Returns the ISO 639-1 code numeric code of a language.
	* @param int $language One of the GestPayCurrency::... constants
	* @return int|null Returns null if $language is not valid.
	*/
	public static function getIsoCode($language) {
		if(is_numeric($language)) {
			switch(@intval($language)) {
				case self::IT:
					return 'it';
				case self::EN:
					return 'en';
				case self::ES:
					return 'es';
				case self::FR:
					return 'fr';
				case self::DE:
					return 'de';
			}
		}
		return null;
	}
	/** Returns the name of a currency.
	* @param int $currency One of the GestPayCurrency::... constants
	* @return string Returns an empty string if $currency is not valid.
	*/
	public static function getName($language) {
		if(is_numeric($language)) {
			switch(@intval($language)) {
				case self::IT:
					return t('Italian');
				case self::EN:
					return t('English');
				case self::ES:
					return t('Spanish');
				case self::FR:
					return t('French');
				case self::DE:
					return t('German');
			}
		}
		return '';
	}
}
