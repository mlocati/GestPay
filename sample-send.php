<?php
/* A test script that receives the server2server response from the GestPay server. */

$shopLogin = 'your shop login';
$useSSL = true;
$testServer = true;

require_once 'GestPay.php';

if(!$params = GestPay::readParams()) {
	die('Parameters not received');
}

$data = $gestPay->decrypt($params['b']);

echo 'Your transaction identifier is: ' . $data['transactionID'] . "\n";

if($data['transactionResult'] === true) {
	echo "Transaction succesfull\n";
}
elseif (is_null( $data['transactionResult'])) {
	echo "Transaction delayed\n";
}
else {
	echo "Transaction failed\n";
	echo "Error description: " . $data['errorDescription'] . "\n";
}
