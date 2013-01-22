<?php

if(!function_exists('t')) { function t($str) { return $str; } };

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'GestPayException.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'GestPayCurrency.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'GestPayLanguage.php';

/** Class to manage Banca Sella communication. */
class GestPay {
	/** Parameters separator in request/response to/from remote server.
	* @var string
	*/
	const ENCRYPT_SEPARATOR = '*P1*';
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
	/** Sets the shop login.
	* @param string $value The shop login
	*/
	public function setShopLogin($value) {
		$this->_shopLogin = is_string($value) ? $value : '';
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
	*	<li>int <b>currency</b> [required] One of the GestPayCurrency:: constants.
	*	<li>float <b>amount</b> [required] The transaction amount.
	*	<li>string <b>transactionID</b> [required] An identifier attributed to the transaction by the merchant.</li>
	*	<li>string <b>cvv</b> [optional] The value of CVV2 / CVc2 / 4DBC code of credit card.
	*	<li>string <b>buyerName</b> [optional] Buyer's name.
	*	<li>string <b>buyerEmail</b> [optional] Buyer's email address.
	*	<li>string <b>language</b> [optional] The language id.
	*	<li>string <b>customInfo</b> [optional] Custom information.
	* </ul>
	* @throws GestPayException Throws a GestPayException in case of errors.
	*/
	public function encrypt($data) {
		if(!strlen($this->getShopLogin())) {
			throw GestPayException::fromCode(GestPayException::INVALID_SHOPLOGIN);
		}
		if(!is_array($data)) {
			throw GestPayException::generic(sprintf(t('The variable %s must be an array in %s:%s'), '$data', __CLASS__, __FUNCTION__));
		}
		if((!array_key_exists('currency', $data)) || (!GestPayCurrency::IsValid($data['currency'], true))) {
			throw GestPayException::fromCode(GestPayException::CURRENCY_NOT_VALID);
		}
		if((!array_key_exists('amount', $data)) || (!is_numeric($data['amount'])) || (($data['amount'] = @floatval($data['amount'])) <= 0.0)) {
			throw GestPayException::fromCode(GestPayException::AMOUNT_NOT_VALID);
		}
		if((!array_key_exists('transactionID', $data)) || (!strlen($data['transactionID'] = @strval($data['transactionID'])))) {
			throw GestPayException::fromCode(GestPayException::INVALID_TRANSACTIONID);
		}
		if(array_key_exists('language', $data) && (!is_null($data['language'])) && ($data['language'] !== '')) {
			if(!GestPayLanguage::IsValid($data['language'])) {
				throw GestPayException::fromCode(GestPayException::LANGUAGE_NOT_VALID);
			}
		}
		$fields = array();
		foreach(array('cvv' => 'PAY1_CVV', 'currency' => 'PAY1_UICCODE', 'amount' => 'PAY1_AMOUNT', 'transactionID' => 'PAY1_SHOPTRANSACTIONID', 'buyerName' => 'PAY1_CHNAME', 'buyerEmail' => 'PAY1_CHEMAIL', 'language' => 'PAY1_IDLANGUAGE') as $dataKey => $outKey) {
			if(array_key_exists($dataKey, $data)) {
				self::addEncrypt($fields, $outKey, $data[$dataKey]);
				unset($data[$dataKey]);
			}
		}
		if(array_key_exists('customInfo', $data)) {
			$value = $data['customInfo'];
			self::addEncrypt($fields, '', $data['customInfo']);
			unset($data['customInfo']);
		}
		$url = $this->getUseSSL() ? 'https://' : 'http://';
		$url .= $this->getTest() ? 'testecomm.sella.it' : 'ecomms2s.sella.it';
		$url .= $this->getUseSSL() ? '/CryptHTTPS/Encrypt.asp' : '/CryptHTTP/Encrypt.asp';
		$url .= '?a=' . urlencode($this->getShopLogin());
		$url .= '&b=' . implode(self::ENCRYPT_SEPARATOR, $fields);
		$url .= '&c=' . urlencode(self::VERSION);
		$response = $this->ExecWeb($url);
		$encrypted = '';
		if(preg_match('%#cryptstring#(.*)#/cryptstring#%s', $response, $m)) {
			$encrypted = trim($m[1]);
		}
		if(!strlen($encrypted)) {
			throw GestPayException::fromCode(GestPayException::EMPTY_RESPONSE);
		}
	}
	/** Adds a field to the values to be enctypted.
	* @param array $fields [in/out] The fields array to be updated.
	* @param string $key The field name (empty string for customInfo).
	* @param mixed $value The value to be added.
	*/
	private static function addEncrypt(&$fields, $key, $value) {
		if((is_string($value) && strlen($value)) || is_int($value) || is_float($value)) {
			$value = strval($value);
			//$value = preg_replace('/[ \t]+/', '§', $value);
			$fields[] = (strlen($key) ? "$key=" : '') . urlencode($value);
		}
	}
	/** Decrypt an encrypted string.
	* @param string $cryptedString
	* @return array The array may contain the following keys:<ul>
	*	<li>int <b>currency</b> Currency ID (should be one of the GestPayCurrency:: constants).</li>
	*	<li>float <b>amount</b> Transaction amount.</li>
	*	<li>string <b>transactionID</b> The identifier attributed to the transaction by the merchant.</li>
	*	<li>string <b>buyerName</b> Buyer's name and surname.</li>
	*	<li>string <b>buyerEmail</b> Buyer's email address.</li>
	*	<li>string <b>transactionResult</b> Transaction result.</li>
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
	*	<li><b>3dLevel</b> Level of authentication for VBV Visa/Mastercard Securecode transactions (should be FULL or HALF).</li>
	* </ul>
	* @throws GestPayException Throws a GestPayException in case of errors.
	 */
	public function decrypt($cryptedString) {
		if(!(is_string($cryptedString) && strlen($cryptedString))) {
			throw GestPayException::fromCode(GestPayException::INVALID_DECRYPT_STRING);
		}
		if(!strlen($this->getShopLogin())) {
			throw GestPayException::fromCode(GestPayException::INVALID_SHOPLOGIN);
		}
		$url = $this->getUseSSL() ? 'https://' : 'http://';
		$url .= $this->getTest() ? 'testecomm.sella.it' : 'ecomms2s.sella.it';
		$url .= $this->getUseSSL() ? '/CryptHTTPS/Decrypt.asp' : '/CryptHTTP/Decrypt.asp';
		$url .= '?a=' . urlencode($this->getShopLogin());
		$url .= '&b=' . urlencode($cryptedString);
		$url .= '&c=' . urlencode(self::VERSION);
		$response = $this->ExecWeb($url);
		$decryptedString = '';
		if($decrypted('%#decryptstring#(.*)#/decryptstring#%s', $response, $m)) {
			$encrypted = trim($m[1]);
		}
		if(!strlen($decryptedString)) {
			throw GestPayException::fromCode(GestPayException::EMPTY_RESPONSE);
		}
		$dectypted = array();
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
			'PAY1_3DLEVEL' => '3dLevel'
		);
		foreach(explode(self::SEPARATOR, $dectypted) as $chunk) {
			$outSet = false;
			foreach($tags as $tagIn => $tagOut) {
				$s = $tagIn . '=';
				if(stripos($chunk, $s) === 0) {
					$dectypted[$tagOut] = (strlen($chunk) == strlen($s)) ? '' : substr($chunk, 1 + strlen($s));
					switch($tagOut) {
						case 'currency':
							GestPayCurrency::IsValid($dectypted[$tagOut], true);
							break;
						case 'amount':
							if(is_numeric($dectypted[$tagOut]) && ($v = @floatval($dectypted[$tagOut]))) {
								$dectypted[$tagOut] = $v;
							}
							break;
						case 'errorCode':
						case 'alertCode':
						case 'expMonth':
						case 'expYear':
							if(is_numeric($dectypted[$tagOut])) {
								$dectypted[$tagOut] = intval($dectypted[$tagOut]);
							}
							break;
						case 'language':
							GestPayLanguage::IsValid($dectypted[$tagOut], true);
							break;
						case 'vbv':
							if($dectypted[$tagOut] === 'OK') {
								$dectypted[$tagOut] = true;
							}
							elseif($dectypted[$tagOut] === 'KO') {
								$dectypted[$tagOut] = false;
							}
							break;
					}
					$outSet = true;
					break;
				}
			}
			if(!$outSet) {
				if(strlen(trim($chunk))) {
					$dectypted['customInfo'] = (isset($dectypted['customInfo']) ? "\n" : '') . trim($chunk);
				}
			}
		}
		if(empty($dectypted)) {
			throw GestPayException::fromCode(GestPayException::EMPTY_RESPONSE);
		}
		return $decrypted;
	}
	private function ExecWeb($url)
	{
		if(function_exists('curl_init')) {
			$hCurl = @curl_init($url);
			if(!$hCurl) {
				throw GestPayException::generic(sprintf(t('The PHP function %s failed'), 'curl'));
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
					throw GestPayException::generic($msg);
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
						throw GestPayException::generic($errMessage);
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
						throw GestPayException::generic(t('Generic socket error'));
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
					$httpCode =  0;
					if(preg_match('%(^|\n)HTTP/[\d\.]+ (\d+)%i', $headers, $m)) {
						$httpCode = @intval($m[2]);
					}
					if(($httpCode == 0) || ($httpCode >= 400)) {
						throw new Exception(t('HTTP error: %s'), $httpCode);
					}
				}
			}
			if(!$useSocket) {
				throw GestPayException::generic(t('cURL and socket non available in PHP'));
			}
		}
		if(preg_match('|#error#(.*)#/error#|s', $response, $m)) {
			$error = (count($m) > 1) ? trim($m[1]) : '';
			if(preg_match('|^(\d+)-(.*)$|s', $error, $m)) {
				$errorCode = @intval($m[1]);
				if($errorCode != 0) {
					$errorMessage = (count($m) > 2) ? trim($m[2]) : '';
					throw GestPayException::fromCode($errorCode, strlen($errorMessage) ? $errorMessage : true);
				}
			}
			throw GestPayException::generic(strlen($error) ? $error : t('Unknown error in response'));
		}
		return $response;
	}
}

