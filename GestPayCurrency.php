<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'GestPay.php';

/** Helper class to manage GestPay currencies. */
class GestPayCurrency {
	/** US dollar.
	* @var int
	*/
	const USD = 1;
	/** GB pound.
	* @var int
	*/
	const GBP = 2;
	/** Swiss franc.
	* @var int
	*/
	const CHF = 3;
	/** Danish krone.
	* @var int
	*/
	const DKK = 7;
	/** Norwegian krone.
	* @var int
	*/
	const NOK = 8;
	/** Swedish krona.
	* @var int
	*/
	const SEK = 9;
	/** Canadian dollar.
	* @var int
	*/
	const CAD = 12;
	/** Italian lira (dismissed: use EUR).
	* @var int
	*/
	const ITL = 18;
	/** Japanese Yen.
	* @var int
	*/
	const JPY = 71;
	/** Hong Kong dollar.
	* @var int
	*/
	const HKD = 103;
	/** Brazilian real.
	* @var int
	*/
	const BRL = 234;
	/** Euro.
	* @var int
	*/
	const EUR = 242;
	/** Checks if a value is a valid currency ID.
	* @param int|mixed $value The value to be checked (will be set to int if it's a valid numeric currency ID).
	* @param bool $includeDismissed [default: false] Also accepts dismissed currencies?
	* @return boolean
	*/
	public static function IsValid(&$value, $includeDismissed = false) {
		if(is_numeric($value)) {
			$c = @intval($value);
			$all = self::getAll($includeDismissed);
			if(array_search($c, $all) !== false) {
				$value = $c;
				return true;
			}
		}
		return false;
	}
	/** Returns all the available cyrrency IDs.
	* @param bool $includeDismissed [default: false] Set to true to receive also the dismissed currencies.
	* @return array[int]
	*/
	public static function getAll($includeDismissed) {
		$all = array(
			self::USD,
			self::GBP,
			self::CHF,
			self::DKK,
			self::NOK,
			self::SEK,
			self::CAD,
			self::JPY,
			self::HKD,
			self::BRL,
			self::EUR
		);
		if($includeDismissed) {
			$all[] = self::ITL;
		}
		return $all;
	}
	/** Returns the ISO-4217 numeric code of a currency.
	* @param int $currency One of the GestPayCurrency::... constants
	* @return int|null Returns null if $currency is not valid.
	*/
	public static function getIsoCodeNum($currency) {
		if(is_numeric($currency)) {
			switch(@intval($currency)) {
				case self::USD:
					return 840;
				case self::GBP:
					return 826;
				case self::CHF:
					return 756;
				case self::DKK:
					return 208;
				case self::NOK:
					return 578;
				case self::SEK:
					return 752;
				case self::CAD:
					return 124;
				case self::ITL:
					return 380;
				case self::JPY:
					return 392;
				case self::HKD:
					return 344;
				case self::BRL:
					return 986;
				case self::EUR:
					return 978;
			}
		}
		return null;
	}
	/** Returns the GestPay currency code from the ISO-4217 numeric code.
	* @param int $currency The ISO-4217 numeric code of the currency.
	* @return int|null Returns null if $currency is not a valid GestPay currency, one of the GestPayCurrency::... constants otherwise.
	*/
	public static function fromIsoCodeNum($currency) {
		if(is_numeric($currency)) {
			$currency = @intval($currency);
			foreach(self::getAll(true) as $gestPayID) {
				if(self::getIsoCodeNum($gestPayID) === $currency) {
					return $gestPayID;
				}
			}
		}
		return null;
	}
	/** Returns the ISO-4217 alphabetic code of a currency.
	* @param int $currency One of the GestPayCurrency::... constants
	* @return string Returns an empty string if $currency is not valid.
	*/
	public static function getIsoCodeAlpha($currency) {
		if(is_numeric($currency)) {
			switch(@intval($currency)) {
				case self::USD:
					return 'USD';
				case self::GBP:
					return 'GBP';
				case self::CHF:
					return 'CHF';
				case self::DKK:
					return 'DKK';
				case self::NOK:
					return 'NOK';
				case self::SEK:
					return 'SEK';
				case self::CAD:
					return 'CAD';
				case self::ITL:
					return 'ITL';
				case self::JPY:
					return 'JPY';
				case self::HKD:
					return 'HKD';
				case self::BRL:
					return 'BRL';
				case self::EUR:
					return 'EUR';
			}
		}
		return '';
	}
	/** Returns the GestPay currency code from the ISO-4217 alphabetic code.
	* @param string $currency The ISO-4217 alphabetic code of the currency.
	* @return int|null Returns null if $currency is not a valid GestPay currency, one of the GestPayCurrency::... constants otherwise.
	*/
	public static function fromIsoCodeAlpha($currency) {
		$currency = is_string($currency) ? strtoupper($currency) : '';
		if(strlen($currency)) {
			foreach(self::getAll(true) as $gestPayID) {
				if(self::getIsoCodeAlpha($gestPayID) === $currency) {
					return $gestPayID;
				}
			}
		}
		return null;
	}
	/** Returns the name of a currency.
	* @param int $currency One of the GestPayCurrency::... constants
	* @return string Returns an empty string if $currency is not valid.
	*/
	public static function getName($currency) {
		if(is_numeric($currency)) {
			switch(@intval($currency)) {
				case self::USD:
					return t('US dollar');
				case self::GBP:
					return t('GB pound');
				case self::CHF:
					return t('Swiss franc');
				case self::DKK:
					return t('Danish krone');
				case self::NOK:
					return t('Norwegian krone');
				case self::SEK:
					return t('Swedish krona');
				case self::CAD:
					return t('Canadian dollar');
				case self::ITL:
					return t('Italian lira');
				case self::JPY:
					return t('Japanese Yen');
				case self::HKD:
					return t('Hong Kong dollar');
				case self::BRL:
					return t('Brazilian real');
				case self::EUR:
					return t('Euro');
			}
		}
		return '';
	}
	/** Returns the symbol of a currency.
	* @param int $currency One of the GestPayCurrency::... constants
	* @return string Returns an empty string if $currency is not valid.
	*/
	public static function getSymbol($currency) {
		if(is_numeric($currency)) {
			switch(@intval($currency)) {
				case self::USD:
					return '$';
				case self::GBP:
					return t('£');
				case self::CHF:
					return t('Fr');
				case self::DKK:
					return t('kr');
				case self::NOK:
					return t('kr');
				case self::SEK:
					return t('kr');
				case self::CAD:
					return t('$');
				case self::ITL:
					return t('₤');
				case self::JPY:
					return t('¥');
				case self::HKD:
					return t('HK$');
				case self::BRL:
					return t('R$');
				case self::EUR:
					return t('€');
			}
		}
		return '';
	}
}
