<?php

if(!function_exists('t')) { function t($str) { return $str; } };

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'GestPayException.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'GestPayCurrency.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'GestPayLanguage.php';

/** Class to manage Banca Sella communication. */
class GestPay {
	/** When using test server shall the amount be set to a minimal amount?
	* This is useful to not exceed the monthly limit of authorizable amount of the credit card.
	* @var bool
	*/
	public static $useTinyAmountForTest = true;
	/** Parameters separator in request/response to/from remote server.
	* @var string
	*/
	const SEPARATOR = '*P1*';
	/** Communication-level version in request/response to/from remote server.
	* @var string
	*/
	const VERSION = '3.0';
	/** Shop login.
	* @var string
	*/
	private $_shopLogin;
	/** Use SSL (https)?
	* @var bool
	*/
	private $_useSSL;
	/** Use test server?
	* @var bool
	*/
	private $_test;
	/** Initializes the instance.
	* @param string $shopLogin The shop login.
	* @param bool $useSSL [default: false] Use SSL (https)?
	* @param bool $test [default: false] Use the test server?
	*/
	public function __construct($shopLogin, $useSSL = false, $test = false) {
		$this->setShopLogin($shopLogin);
		$this->setUseSSL($useSSL);
		$this->setTest($test);
	}
	/** Returns the root URL for the current SSL/test settings.
	* @param bool $forceSSL [default: false] Set to true if you the SSL root url even if instance is not configured to use SSL.
	* @return string
	*/
	private function getRootURL($forceSSL = false) {
		return (($forceSSL || $this->getUseSSL()) ? 'https://' : 'http://') . ($this->getTest() ? 'testecomm.sella.it' : 'ecomms2s.sella.it');
	}
	/** Sets the shop login.
	* @param string $value The shop login
	*/
	public function setShopLogin($value) {
		$this->_shopLogin = is_string($value) ? trim($value) : '';
	}
	/** Gets the shop login.
	* @return string
	*/
	public function getShopLogin() {
		return $this->_shopLogin;
	}
	/** Use SSL (https)?
	* @param bool $value true to use the SSL (https), false to use http.
	*/
	public function setUseSSL($value) {
		$this->_useSSL = empty($value) ? false : true;
	}
	/** Is SSL (https) used?
	* @return bool
	*/
	public function getUseSSL() {
		return $this->_useSSL;
	}
	/** Use test server?
	* @param bool $value true to use the test server, false to use the production server.
	*/
	public function setTest($value) {
		$this->_test = empty($value) ? false : true;
	}
	/** Is the test server used?
	* @return bool
	*/
	public function getTest() {
		return $this->_test;
	}
	/** Encodes the specified data.
	* @param array $data An array with these values:<ul>
	*	<li>int <b>currency</b> [required] The currency id [one of the GestPayCurrency:: constants].</li>
	*	<li>float <b>amount</b> [required] The transaction amount [from 0.01 to 9,999,999.99].</li>
	*	<li>string <b>transactionID</b> [required] An identifier attributed to the transaction by the merchant [maximum length: 50 characters].</li>
	*	<li>int <b>language</b> [optional] The language [one of the GestPayLanguage:: constants].</li>
	*	<li>string <b>buyerName</b> [optional] Buyer's name [maximum length: 50 characters].</li>
	*	<li>string <b>buyerEmail</b> [optional] Buyer's email address [maximum length: 50 characters].</li>
	*	<li>string <b>cardNumber</b> [optional] Buyer's credit card number [maximum length: 20 characters].</li>
	*	<li>int <b>expMonth</b> [optional] Buyer's credit card expiration month [1... 12].</li>
	*	<li>int <b>expYear</b> [optional] Buyer's credit card expiration year [0... 99 or 2000... 2099].</li>
	*	<li>string <b>cvv</b> [optional] The value of CVV2 / CVc2 / 4DBC code of credit card [3 or 4 characters].</li>
	*	<li>string <b>customInfo</b> [optional] Custom information [maximum length: 1000 characters].</li>
	* </ul>
	* @throws GestPayException Throws a GestPayException in case of errors.
	*/
	public function encrypt($data) {
		if(!strlen($this->getShopLogin())) {
			throw GestPayException::fromCode(GestPayException::INVALID_SHOPLOGIN, __FILE__, __LINE__);
		}
		if(!is_array($data)) {
			throw GestPayException::generic(sprintf(t('The variable %s must be an array in %s:%s'), '$data', __CLASS__, __FUNCTION__), __FILE__, __LINE__);
		}
		foreach(array_keys($data) as $key) {
			$value = $data[$key];
			if(is_string($value)) {
				$data[$key] = $value = trim($value);
				if(!strlen($value)) {
					unset($data[$key]);
				}
			}
			elseif(!(is_int($value) || is_float($value))) {
				unset($data[$key]);
			}
		}
		if((!array_key_exists('currency', $data)) || (!GestPayCurrency::IsValid($data['currency'], true))) {
			throw GestPayException::fromCode(GestPayException::CURRENCY_NOT_VALID, __FILE__, __LINE__);
		}
		if((!array_key_exists('amount', $data)) || (!is_numeric($data['amount'])) || (($data['amount'] = @floatval($data['amount'])) <= 0.0)) {
			throw GestPayException::fromCode(GestPayException::AMOUNT_NOT_VALID, __FILE__, __LINE__);
		}
		if((!array_key_exists('transactionID', $data)) || (!strlen(@strval($data['transactionID'])))) {
			throw GestPayException::fromCode(GestPayException::INVALID_TRANSACTIONID, __FILE__, __LINE__);
		}
		if(array_key_exists('language', $data) && (!GestPayLanguage::IsValid($data['language']))) {
			throw GestPayException::fromCode(GestPayException::LANGUAGE_NOT_VALID, __FILE__, __LINE__);
		}
		if(array_key_exists('expMonth', $data)) {
			if(!is_numeric($data['expMonth'])) {
				throw GestPayException::fromCode(GestPayException::INVALID_EXPIRATION_MONTH, __FILE__, __LINE__);
			}
			$data['expMonth'] = @intval($data['expMonth']);
			if(($data['expMonth'] < 1) || ($data['expMonth'] > 12)) {
				throw GestPayException::fromCode(GestPayException::INVALID_EXPIRATION_MONTH, __FILE__, __LINE__);
			}
		}
		if(array_key_exists('expYear', $data)) {
			if(!is_numeric($data['expYear'])) {
				throw GestPayException::fromCode(GestPayException::INVALID_EXPIRATION_YEAR, __FILE__, __LINE__);
			}
			$data['expYear'] = @intval($data['expYear']);
			if(($data['expYear'] >= 2000) && ($data['expYear'] < 2100)) {
				$data['expYear'] -= 2000;
			}
			if(($data['expYear'] < 0) || ($data['expYear'] > 99)) {
				throw GestPayException::fromCode(GestPayException::INVALID_EXPIRATION_YEAR, __FILE__, __LINE__);
			}
		}
		$fields = array();
		$tags = array(
			'currency' => 'PAY1_UICCODE',
			'amount' => 'PAY1_AMOUNT',
			'transactionID' => 'PAY1_SHOPTRANSACTIONID',
			'language' => 'PAY1_IDLANGUAGE',
			'buyerName' => 'PAY1_CHNAME',
			'buyerEmail' => 'PAY1_CHEMAIL',
			'cardNumber' => 'PAY1_CARDNUMBER',
			'expMonth' => 'PAY1_EXPMONTH',
			'expYear' => 'PAY1_EXPYEAR',
			'cvv' => 'PAY1_CVV'
		);
		foreach($tags as $dataKey => $outKey) {
			if(array_key_exists($dataKey, $data)) {
				$value = strval($data[$dataKey]);
				switch($dataKey) {
					case 'amount':
						if($this->getTest() && self::$useTinyAmountForTest) {
							$value = '0.12';
						}
						break;
				}
				$fields[] = "$outKey=" . self::encodeFieldValue($value);
			}
		}
		if(array_key_exists('customInfo', $data)) {
			$value = $data['customInfo'];
			while(strlen($value) > 300) {
				$fields[] = self::encodeFieldValue(substr($value, 0, 300));
				$value = substr($value, 300);
			}
			$fields[] = self::encodeFieldValue($value);
		}
		$url = $this->getRootURL();
		$url .= $this->getUseSSL() ? '/CryptHTTPS/Encrypt.asp' : '/CryptHTTP/Encrypt.asp';
		$url .= '?a=' . urlencode($this->getShopLogin());
		$url .= '&b=' . implode(self::SEPARATOR, $fields);
		$url .= '&c=' . urlencode(self::VERSION);
		$response = self::callRemote($url);
		$encrypted = '';
		if(preg_match('%#cryptstring#(.*)#/cryptstring#%s', $response, $m)) {
			$encrypted = trim($m[1]);
		}
		if(!strlen($encrypted)) {
			throw GestPayException::fromCode(GestPayException::EMPTY_RESPONSE, __FILE__, __LINE__);
		}
		return $encrypted;
	}
	/** Decrypt an encrypted string.
	* @param string $cryptedString
	* @return array The array may contain the following keys:<ul>
	*	<li>int <b>currency</b> Currency ID (should be one of the GestPayCurrency:: constants).</li>
	*	<li>float|null <b>amount</b> Transaction amount.</li>
	*	<li>string <b>transactionID</b> The identifier attributed to the transaction by the merchant.</li>
	*	<li>string <b>buyerName</b> Buyer's name and surname.</li>
	*	<li>string <b>buyerEmail</b> Buyer's email address.</li>
	*	<li>bool|null <b>transactionResult</b> Transaction result (true: transaction was ok; false: transaction failed; null: transaction suspended, for example for a bank transfer).</li>
	*	<li>string <b>authorizationCode</b> Transaction authorisation code.</li>
	*	<li>string <b>bankTransactionID</b> Identifier attributed to the transaction by GestPay.</li>
	*	<li>string <b>country</b> Nationality of institute issuing card.</li>
	*	<li>bool <b>vbv</b> Flag for Verified by Visa transactions.</li>
	*	<li>int <b>errorCode</b> Error code.</li>
	*	<li>string <b>errorDescription</b> Error description.</li>
	*	<li>int <b>alertCode</b> Alert code.</li>
	*	<li>string <b>alertDescription</b> Alert description in chosen language.</li>
	*	<li>string <b>cardNumber</b> Credit cart number.</li>
	*	<li>int <b>expMonth</b> Credit card expiration month.</li>
	*	<li>int <b>expYear</b> Credit card expiration year.</li>
	*	<li>int <b>language</b> Language ID (should be one of the GestPayLanguage:: constants).</li>
	*	<li>string <b>3dLevel</b> Level of authentication for VBV Visa/Mastercard Securecode transactions (should be FULL or HALF).</li>
	*	<li>string <b>otp</b> One time password.</li>
	* </ul>
	* @throws GestPayException Throws a GestPayException in case of errors.
	*/
	public function decrypt($cryptedString) {
		if(!(is_string($cryptedString) && strlen($cryptedString))) {
			throw GestPayException::fromCode(GestPayException::INVALID_DECRYPT_STRING, __FILE__, __LINE__);
		}
		if(!strlen($this->getShopLogin())) {
			throw GestPayException::fromCode(GestPayException::INVALID_SHOPLOGIN, __FILE__, __LINE__);
		}
		$url = $this->getRootURL();
		$url .= $this->getUseSSL() ? '/CryptHTTPS/Decrypt.asp' : '/CryptHTTP/Decrypt.asp';
		$url .= '?a=' . urlencode($this->getShopLogin());
		$url .= '&b=' . urlencode($cryptedString);
		$url .= '&c=' . urlencode(self::VERSION);
		$response = self::callRemote($url);
		$decryptedString = '';
		if(preg_match('%#decryptstring#(.*)#/decryptstring#%s', $response, $m)) {
			$decryptedString = trim($m[1]);
		}
		if(!strlen($decryptedString)) {
			throw GestPayException::fromCode(GestPayException::EMPTY_RESPONSE, __FILE__, __LINE__);
		}
		$decrypted = array();
		$tags = array(
			'PAY1_UICCODE' => 'currency',
			'PAY1_AMOUNT' => 'amount',
			'PAY1_SHOPTRANSACTIONID' => 'transactionID',
			'PAY1_CHNAME' => 'buyerName',
			'PAY1_CHEMAIL' => 'buyerEmail',
			'PAY1_TRANSACTIONRESULT' => 'transactionResult',
			'PAY1_AUTHORIZATIONCODE' => 'authorizationCode',
			'PAY1_BANKTRANSACTIONID' => 'bankTransactionID',
			'PAY1_COUNTRY' => 'country',
			'PAY1_VBV' => 'vbv',
			'PAY1_ERRORCODE' => 'errorCode',
			'PAY1_ERRORDESCRIPTION' => 'errorDescription',
			'PAY1_ALERTCODE' => 'alertCode',
			'PAY1_ALERTDESCRIPTION' => 'alertDescription',
			'PAY1_CARDNUMBER' => 'cardNumber',
			'PAY1_EXPMONTH' => 'expMonth',
			'PAY1_EXPYEAR' => 'expYear',
			'PAY1_VBVRISP' => 'vbvRisp',
			'PAY1_IDLANGUAGE' => 'language',
			'PAY1_3DLEVEL' => '3dLevel',
			'PAY1_OTP' => 'otp'
		);
		foreach(explode(self::SEPARATOR, $decryptedString) as $chunk) {
			$equalsPos = strpos($chunk, '=');
			if(($equalsPos !== false) && ($equalsPos > 0) && array_key_exists($tagIn = substr($chunk, 0, $equalsPos), $tags)) {
				$tagOut = $tags[$tagIn];
				$decrypted[$tagOut] = ($equalsPos == (strlen($chunk) - 1)) ? '' : self::decodeFieldValue(substr($chunk, $equalsPos + 1));
				switch($tagOut) {
					case 'currency':
						GestPayCurrency::IsValid($decrypted[$tagOut], true);
						break;
					case 'amount':
						if(!strlen($decrypted[$tagOut])) {
							$decrypted[$tagOut] = null;
						}
						elseif(is_numeric($decrypted[$tagOut]) && preg_match('/^-?(([0-9]+)|([0-9]+\.[0-9]*)|(\.[0-9]+))$/', $decrypted[$tagOut])) {
							$decrypted[$tagOut] = @floatval($decrypted[$tagOut]);
						}
						break;
					case 'errorCode':
					case 'alertCode':
					case 'expMonth':
					case 'expYear':
						if(is_numeric($decrypted[$tagOut])) {
							$decrypted[$tagOut] = intval($decrypted[$tagOut]);
						}
						break;
					case 'language':
						GestPayLanguage::IsValid($decrypted[$tagOut], true);
						break;
					case 'vbv':
						if($decrypted[$tagOut] === 'OK') {
							$decrypted[$tagOut] = true;
						}
						elseif($decrypted[$tagOut] === 'KO') {
							$decrypted[$tagOut] = false;
						}
						break;
					case 'transactionResult':
						if($decrypted[$tagOut] === 'OK') {
							$decrypted[$tagOut] = true;
						}
						elseif($decrypted[$tagOut] === 'KO') {
							$decrypted[$tagOut] = false;
						}
						elseif($decrypted[$tagOut] === 'XX') {
							$decrypted[$tagOut] = null;
						}
						break;
				}
			}
			else {
				if(strlen(trim($chunk))) {
					if(!isset($decrypted['customInfo'])) {
						$decrypted['customInfo'] = '';
					}
					$decrypted['customInfo'] .= self::decodeFieldValue($chunk);
				}
			}
		}
		if(empty($decrypted)) {
			throw GestPayException::fromCode(GestPayException::EMPTY_RESPONSE, __FILE__, __LINE__);
		}
		return $decrypted;
	}
	/** Encodes the value of a field for the encrypt function.
	* @param string $value The value to be fixed.
	* @param return string
	*/
	private static function encodeFieldValue($value) {
		return urlencode($value);
	}
	/** Decodes a value a field for the decrypt function.
	* @param string $value The value to be fixed.
	* @param return string
	*/
	private static function decodeFieldValue($value) {
		return urldecode($value);
	}
	/** Returns the url for payments.
	* @param string $encryptedString Encrypted string built with GestPay->encrypt().
	* @return string
	*/
	public function getPaymentURL($encryptedString) {
		return $this->getRootURL(true) . '/gestpay/pagam.asp?a=' . urlencode($this->getShopLogin()) . '&b=' . $encryptedString;
	}
	/** Call remote server and returns the response.
	* @param string $url The url to call.
	* @return string
	* @throws Exception Throws an Exception in case of communication errors or if there's an error signaled by the remote server.
	*/
	private static function callRemote($url)
	{
		if(function_exists('curl_init')) {
			$hCurl = @curl_init($url);
			if(!$hCurl) {
				throw GestPayException::generic(sprintf(t('The PHP function %s failed'), 'curl'), __FILE__, __LINE__);
			}
			try {
				$ok = true;
				if($ok && (@curl_setopt($hCurl, CURLOPT_RETURNTRANSFER, true) === false)) $ok = false;
				if($ok && (@curl_setopt($hCurl, CURLOPT_SSL_VERIFYPEER, false) === false)) $ok = false;
				if($ok && (@curl_setopt($hCurl, CURLOPT_BINARYTRANSFER, true) === false)) $ok = false;
				if($ok && (@curl_setopt($hCurl, CURLOPT_FAILONERROR, false) === false)) $ok = false;
				if($ok && (@curl_setopt($hCurl, CURLOPT_FOLLOWLOCATION, true) === false)) $ok = false;
				if($ok && (@curl_setopt($hCurl, CURLOPT_HEADER, false) === false)) $ok = false;
				if($ok && ((@$response = @curl_exec($hCurl)) === false)) $ok = false;
				if($ok && ((@$info = @curl_getinfo($hCurl)) === false)) $ok = false;
				if(!$ok) {
					$msg = @curl_error($hCurl);
					if(!(is_string($msg) && strlen($msg))) {
						$errNo = @curl_errno($hCurl);
						if(!empty($errNo)) {
							$msg = sprintf(t('cURL error %d'), @intval($errNo));
						}
						else {
							$msg = t('Generic cURL error');
						}
					}
					throw GestPayException::generic($msg, __FILE__, __LINE__);
				}
			}
			catch(Exception $x) {
				@curl_close($hCurl);
				throw $x;
			}
			@curl_close($hCurl);
			if(empty($info['http_code']) || ($info['http_code'] >= 400)) {
				throw new Exception(t('HTTP error: %s'), $info['http_code']);
			}
			$response = str_replace(array("\r\n", "\r"), "\n", $response);
		}
		else {
			$useSocket = false;
			if(function_exists('fsockopen') && preg_match('%^(http|https)://([^:/]+)(:\d*)?(/.*)*$%i', $url, $m)) {
				$protocol = strtolower($m[1]);
				$host = $m[2];
				$port = ((count($m) > 3) && (strlen($m[3]) > 1)) ? @intval(substr($m[3], 1)) : 0;
				if(!$port) {
					$port = ($protocol == 'https') ? 443 : 80;
				}
				$path = '/' . (((count($m) > 4) && (strlen($m[4]) > 1)) ? substr($m[4], 1) : '');
				if(($protocol != 'https') || extension_loaded('openssl')) {
					$useSocket = true;
					if(!($hSocket = fsockopen(($protocol == 'https') ? "ssl://$host" : $host, $port, $errNo, $errMessage, 60))) {
						if(!(is_string($errMessage) && strlen($errMessage))) {
							if(!empty($errNo)) {
								$errMessage = sprintf(t('Socket error %d'), @intval($errNo));
							}
							else {
								$errMessage = t('Generic socket error');
							}
						}
						throw GestPayException::generic($errMessage, __FILE__, __LINE__);
					}
					try {
						$ok = true;
						if($ok && (@fwrite($hSocket, "GET " . $path . " HTTP/1.0\r\n\r\n") === false)) $ok = false;
						$response = '';
						while($ok && (!@feof($hSocket))) {
							$r1 = @fgets($hSocket, 128);
							if($r1 === false) {
								$ok = false;
							}
							else {
								$response .= $r1;
							}
						}
					}
					catch(Exception $x) {
						@fclose($hSocket);
						throw $x;
					}
					@fclose($hSocket);
					if(!$ok) {
						throw GestPayException::generic(t('Generic socket error'), __FILE__, __LINE__);
					}
					$response = str_replace(array("\r\n", "\r"), "\n", $response);
					$p = strpos($response, "\n\n");
					if($p === false) {
						$headers = rtrim($response, "\n") . "\n";
						$response = '';
					}
					elseif($p == 0) {
						$headers = '';
						$response = ltrim('', "\n");
					}
					else {
						$headers = substr($response, 0, $p) . "\n";
						$response = substr($response, $p + 2);
					}
					$httpCode = 0;
					if(preg_match('%(^|\n)HTTP/[\d\.]+ (\d+)%i', $headers, $m)) {
						$httpCode = @intval($m[2]);
					}
					if(($httpCode == 0) || ($httpCode >= 400)) {
						throw new Exception(t('HTTP error: %s'), $httpCode);
					}
				}
			}
			if(!$useSocket) {
				throw GestPayException::generic(t('cURL and socket non available in PHP'), __FILE__, __LINE__);
			}
		}
		if(preg_match('|#error#(.*)#/error#|s', $response, $m)) {
			$error = (count($m) > 1) ? trim($m[1]) : '';
			if(preg_match('|^(\d+)-(.*)$|s', $error, $m)) {
				$errorCode = @intval($m[1]);
				if($errorCode != 0) {
					$errorMessage = (count($m) > 2) ? trim($m[2]) : '';
					throw GestPayException::fromCode($errorCode, __FILE__, __LINE__, strlen($errorMessage) ? $errorMessage : true);
				}
			}
			throw GestPayException::generic(strlen($error) ? $error : t('Unknown error in response'), __FILE__, __LINE__);
		}
		return $response;
	}
	/** Reads the currently received parameters from the current page.
	* @return array|null Returns null if no parameters available, an array otherwise.
	*/
	public static function readParams() {
		$params = array(
			'a' => (isset($_GET['a']) && is_string($_GET['a'])) ? $_GET['a'] : null,
			'b' => (isset($_GET['b']) && is_string($_GET['b'])) ? $_GET['b'] : null
		);
		if(is_null($params['a']) || is_null($params['b'])) {
			return null;
		}
		else {
			return $params;
		}
	}
}
