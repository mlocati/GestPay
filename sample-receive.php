<?php
/* A test script to show how to build the URL that the customer have to visit to do pay. */

$shopLogin = 'your shop login';
$useSSL = true;
$testServer = true;

require_once 'GestPay.php';

try {
	$gestPay = new GestPay($shopLogin, $useSSL, $testServer);

	$encryptedString = $gestPay->encrypt(array(
		'currency' => GestPayCurrency::EUR,
		'amount' => 123.45,
		'transactionID' => 'Your transaction identifier',
		'buyerName' => 'John Doe',
		'buyerEmail' => 'john@doe.com',
		'language' => GestPayLanguage::EN
	));

	$paymentUrl = $gestPay->getPaymentURL($encryptedString);
}
catch(Exception $x) {
	echo 'An error occurred: ' . $x->getMessage();
	die();
}

?>
To accomplish the payment, the customer should go to the following web page: <?php echo $paymentUrl; ?>
