GestPay
=======

PHP implementation of GestPay (Banca Sella)

Usage
=====

To encrypt a string:
```php
include 'GestPay.php';
$gestPay = new GestPay('YourShopLogin');
$gestPay->encode($dataToEncode);
```

To decrypt a string:
```php
include 'GestPay.php';
$gestPay = new GestPay('YourShopLogin');
$gestPay->decode($encodedString);
```


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/mlocati/gestpay/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

