<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'GestPay.php';

/** Helper class to manage GestPay errors. */
class GestPayException extends Exception {
	/** Transaction successful.
	* @var int
	*/
	const TRANSACTION_SUCCESSFUL = 0;
	/** Invalid shop login.
	* @var int
	*/
	const INVALID_SHOPLOGIN = -546;
	/** Currency not valid.
	* @var int
	*/
	const CURRENCY_NOT_VALID = -552;
	/** Amount not valid.
	* @var int
	*/
	const AMOUNT_NOT_VALID = -553;
	/** Shop Transaction ID not valid.
	* @var int
	*/
	const INVALID_TRANSACTIONID = -554;
	/** Language not valid..
	* @var int
	*/
	const LANGUAGE_NOT_VALID = -555;
	/** Empty response.
	* @var int
	*/
	const EMPTY_RESPONSE = -556;
	/** String to decrypt not valid.
	* @var int
	*/
	const INVALID_DECRYPT_STRING = -1009;
	/** Payment page loaded successfully.
	* @var int
	*/
	const PAYMENT_PAGE_LOADED_SUCCESSFULLY = 10;
	/** Card is locked.
	* @var int
	*/
	const LOCKED_CARD_1 = 57;
	/** Confirmed amount exceeding the authorized amount.
	* @var int
	*/
	const CONFIRMED_AMOUNT_EXCEEDING_AUTHORIZED_AMOUNT = 58;
	/** Request to transfer a non-existent authorization.
	* @var int
	*/
	const REQUEST_TO_TRANSFER_NON_EXISTENT_AUTHORIZATION = 63;
	/** Pre-authorization expired.
	* @var int
	*/
	const PREAUTHORIZATION_EXPIRED = 64;
	/** Invalid currency.
	* @var int
	*/
	const INVALID_CURRENCY = 65;
	/** Pre-authorization already notified.
	* @var int
	*/
	const PREAUTHORIZATION_ALREADY_NOTIFIED = 66;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_1 = 74;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_2 = 97;
	/** Transaction aborted by the bank authorization system.
	* @var int
	*/
	const TRANSACTION_ABORTED_BY_BANK_AUTHORIZATION_SYSTEM = 100;
	/** Vendor configuration error in bank authorization system.
	* @var int
	*/
	const VENDOR_CONFIGURATION_ERROR_IN_BANK_AUTHORIZATION_SYSTEM_1 = 150;
	/** Wrong card date.
	* @var int
	*/
	const WRONG_CARD_DATE_1 = 208;
	/** Bank authorization system not available.
	* @var int
	*/
	const BANK_AUTHORIZATION_SYSTEM_NOT_AVAILABLE_1 = 212;
	/** Insufficient card cash.
	* @var int
	*/
	const INSUFFICIENT_CARD_CASH = 251;
	/** Please call company.
	* @var int
	*/
	const PLEASE_CALL_COMPANY_1 = 401;
	/** Please call company.
	* @var int
	*/
	const PLEASE_CALL_COMPANY_2 = 402;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_1 = 403;
	/** Seize card.
	* @var int
	*/
	const SEIZE_CARD_1 = 404;
	/** Authorization denied from the circuits.
	* @var int
	*/
	const AUTHORIZATION_DENIED_FROM_THE_CIRCUITS_1 = 405;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_2 = 406;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_3 = 409;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_4 = 412;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_5 = 413;
	/** Unrecognized card.
	* @var int
	*/
	const UNRECOGNIZED_CARD_1 = 414;
	/** Technical error while communicating with the international circuits.
	* @var int
	*/
	const TECHNICAL_ERROR_COMMUNICATING_WITH_INTERNATIONAL_CIRCUITS_1 = 415;
	/** Wrong pin.
	* @var int
	*/
	const WRONG_PIN = 416;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_3 = 417;
	/** Unavailable network.
	* @var int
	*/
	const UNAVAILABLE_NETWORK_1 = 418;
	/** Wrong transaction date.
	* @var int
	*/
	const WRONG_TRANSACTION_DATE_1 = 419;
	/** Wrong card date.
	* @var int
	*/
	const WRONG_CARD_DATE_2 = 420;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_6 = 430;
	/** Technical error while communicating with the international circuits.
	* @var int
	*/
	const TECHNICAL_ERROR_COMMUNICATING_WITH_INTERNATIONAL_CIRCUITS_2 = 431;
	/** Expired card.
	* @var int
	*/
	const EXPIRED_CARD_1 = 433;
	/** Authorization denied from the circuits.
	* @var int
	*/
	const AUTHORIZATION_DENIED_FROM_THE_CIRCUITS_2 = 434;
	/** Authorization denied from the circuits.
	* @var int
	*/
	const AUTHORIZATION_DENIED_FROM_THE_CIRCUITS_3 = 435;
	/** Card not enabled.
	* @var int
	*/
	const CARD_NOT_ENABLED_1 = 436;
	/** Operation not allowed.
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_1 = 437;
	/** Operation not allowed (exceeded pin attempts).
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_PIN_ATTEMPTS = 438;
	/** Unrecognized card.
	* @var int
	*/
	const UNRECOGNIZED_CARD_2 = 439;
	/** Card is locked.
	* @var int
	*/
	const LOCKED_CARD_2 = 441;
	/** Card is locked.
	* @var int
	*/
	const LOCKED_CARD_3 = 443;
	/** Amount not available.
	* @var int
	*/
	const AMOUNT_NOT_AVAILABLE_1 = 451;
	/** Expired card.
	* @var int
	*/
	const EXPIRED_CARD_2 = 454;
	/** Operation not accomplished.
	* @var int
	*/
	const OPERATION_NOT_ACCOMPLISHED_1 = 455;
	/** Unrecognized card.
	* @var int
	*/
	const UNRECOGNIZED_CARD_3 = 456;
	/** Authorization denied from the circuits.
	* @var int
	*/
	const AUTHORIZATION_DENIED_FROM_THE_CIRCUITS_4 = 457;
	/** Vendor configuration error in bank authorization system.
	* @var int
	*/
	const VENDOR_CONFIGURATION_ERROR_IN_BANK_AUTHORIZATION_SYSTEM_2 = 458;
	/** Amount not available.
	* @var int
	*/
	const AMOUNT_NOT_AVAILABLE_2 = 461;
	/** Card is locked.
	* @var int
	*/
	const LOCKED_CARD_4 = 462;
	/** Bank authorization system not available.
	* @var int
	*/
	const BANK_AUTHORIZATION_SYSTEM_NOT_AVAILABLE_2 = 468;
	/** Operation not allowed.
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_2 = 475;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_7 = 490;
	/** Technical error while communicating with the international circuits.
	* @var int
	*/
	const TECHNICAL_ERROR_COMMUNICATING_WITH_INTERNATIONAL_CIRCUITS_3 = 491;
	/** Technical error while communicating with the international circuits.
	* @var int
	*/
	const TECHNICAL_ERROR_COMMUNICATING_WITH_INTERNATIONAL_CIRCUITS_4 = 492;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_8 = 494;
	/** Operation abandoned by buyer.
	* @var int
	*/
	const OPERATION_ABANDONED_BY_BUYER = 516;
	/** Bank transfer not authorized.
	* @var int
	*/
	const BANK_TRANSFER_NOT_AUTHORIZED = 551;
	/** Bank authorization system not available.
	* @var int
	*/
	const BANK_AUTHORIZATION_SYSTEM_NOT_AVAILABLE_3 = 810;
	/** Vendor configuration error in bank authorization system.
	* @var int
	*/
	const VENDOR_CONFIGURATION_ERROR_IN_BANK_AUTHORIZATION_SYSTEM_3 = 811;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_4 = 901;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_5 = 902;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_6 = 903;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_7 = 904;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_8 = 905;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_9 = 906;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_10 = 907;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_11 = 908;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_12 = 910;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_13 = 911;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_14 = 913;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_15 = 914;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_16 = 915;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_17 = 916;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_18 = 917;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_19 = 918;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_20 = 919;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_21 = 920;
	/** Card not enabled.
	* @var int
	*/
	const CARD_NOT_ENABLED_2 = 950;
	/** Vendor configuration error in bank authorization system.
	* @var int
	*/
	const VENDOR_CONFIGURATION_ERROR_IN_BANK_AUTHORIZATION_SYSTEM_4 = 951;
	/** Wrong credit card check digit.
	* @var int
	*/
	const WRONG_CREDIT_CARD_CHECK_DIGIT_1 = 998;
	/** Operation not accomplished.
	* @var int
	*/
	const OPERATION_NOT_ACCOMPLISHED_2 = 999;
	/** Empty parameters string.
	* @var int
	*/
	const EMPTY_PARAMETERS_STRING = 1100;
	/** Invalid parameter string.
	* @var int
	*/
	const INVALID_PARAMETER_STRING = 1101;
	/** = symbol not preceded by a parameter name.
	* @var int
	*/
	const EQUALS_SYMBOL_WITHOUT_PARAMETER = 1102;
	/** Parameter string ends with a separator.
	* @var int
	*/
	const PARAMETER_STRING_ENDS_WITH_SEPARATOR = 1103;
	/** Invalid parameter name.
	* @var int
	*/
	const INVALID_PARAMETER_NAME = 1104;
	/** Invalid parameter value.
	* @var int
	*/
	const INVALID_PARAMETER_VALUE = 1105;
	/** Duplicated parameter name.
	* @var int
	*/
	const DUPLICATED_PARAMETER_NAME = 1106;
	/** Unexpected parameter name. Please check the fields and parameters configuration in Back Office.
	* @var int
	*/
	const UNEXPECTED_PARAMETER_NAME = 1107;
	/** Empty mandatory parameter.
	* @var int
	*/
	const EMPTY_MANDATORY_PARAMETER = 1108;
	/** Missing parameter.
	* @var int
	*/
	const MISSING_PARAMETER = 1109;
	/** Missing PAY1_UICCODE parameter.
	* @var int
	*/
	const MISSING_PAY1_UICCODE_PARAMETER = 1110;
	/** Invalid currency code.
	* @var int
	*/
	const INVALID_CURRENCY_CODE = 1111;
	/** Missing PAY1_AMOUNT parameter.
	* @var int
	*/
	const MISSING_PAY1_AMOUNT_PARAMETER = 1112;
	/** Amount not numeric.
	* @var int
	*/
	const AMOUNT_NOT_NUMERIC = 1113;
	/** Wrong number of decimals in amount.
	* @var int
	*/
	const WRONG_DECIMALS_NUMBEG = 1114;
	/** Missing PAY1_SHOPTRANSACTIONID parameter.
	* @var int
	*/
	const MISSING_PAY1_SHOPTRANSACTIONID_PARAMETER = 1115;
	/** PAY1_SHOPTRANSACTIONID parameter too long.
	* @var int
	*/
	const PAY1_SHOPTRANSACTIONID_TOO_LONG = 1116;
	/** Invalid language identifier.
	* @var int
	*/
	const INVALID_LANGUAGE_IDENTIFIER = 1117;
	/** Non-numeric characters in the credit card number.
	* @var int
	*/
	const NONNUMERIC_CHARACTERS_IN_THE_CREDIT_CARD_NUMBER = 1118;
	/** Wrong length of the credit card number.
	* @var int
	*/
	const WRONG_CREDIT_CARD_NUMBER_1 = 1119;
	/** Wrong credit card check digit.
	* @var int
	*/
	const WRONG_CREDIT_CARD_CHECK_DIGIT_2 = 1120;
	/** Credit card of a disabled company.
	* @var int
	*/
	const DISABLED_CREDIT_CARD_COMPANY = 1121;
	/** Expiration year without month.
	* @var int
	*/
	const EXPIRATION_YEAR_WITHOUT_MONTH = 1122;
	/** Expiration month without year.
	* @var int
	*/
	const EXPIRATION_MONTH_WITHOUT_YEAR = 1123;
	/** Invalid expiration month.
	* @var int
	*/
	const INVALID_EXPIRATION_MONTH = 1124;
	/** Invalid expiration year.
	* @var int
	*/
	const INVALID_EXPIRATION_YEAR = 1125;
	/** Expiry date exceeded.
	* @var int
	*/
	const EXPIRY_DATE_EXCEEDED = 1126;
	/** Invalid buyer email.
	* @var int
	*/
	const INVALID_BUYER_EMAIL = 1127;
	/** Parameters string too long.
	* @var int
	*/
	const PARAMETERS_STRING_TOO_LONG = 1128;
	/** Parameter value too long.
	* @var int
	*/
	const PARAMETER_VALUE_TOO_LONG = 1129;
	/** Call not accepted: missing A parameter.
	* @var int
	*/
	const MISSING_A_PARAMETER = 1130;
	/** Call not accepted: shop not recognized.
	* @var int
	*/
	const SHOP_NOT_RECOGNIZED = 1131;
	/** Call not accepted: unactive shop.
	* @var int
	*/
	const UNACTIVE_SHOP = 1132;
	/** Call not accepted: missing B parameter.
	* @var int
	*/
	const MISSING_B_PARAMETER = 1133;
	/** Call not accepted: empty B parameter.
	* @var int
	*/
	const EMPTY_B_PARAMETER = 1134;
	/** Call not accepted: other parameters in addition to A and B.
	* @var int
	*/
	const OTHER_PARAMETERS_IN_ADDITION_TO_A_AND_B = 1135;
	/** Call not accepted: transaction not started by a call to the server-to-server cryprography system.
	* @var int
	*/
	const TRANSACTION_NOT_STARTED_BY_CALL_CRYPROGRAPHY_SYSTEM = 1136;
	/** Call not accepted: transaction already processed previously.
	* @var int
	*/
	const TRANSACTION_ALREADY_PROCESSED = 1137;
	/** Call not accepted: missing credit card number or expiration.
	* @var int
	*/
	const MISSING_CREDIT_CARD_NUMBER_OR_EXPIRATION = 1138;
	/** Call not accepted: the shop doesn’t have a public payment page.
	* @var int
	*/
	const SHOP_WITHOUT_PUBLIC_PAYMENT_PAGE = 1139;
	/** Transaction abandoned by the customer.
	* @var int
	*/
	const TRANSACTION_ABANDONED_BY_CUSTOMER = 1140;
	/** Call not accepted: unacceptable parameters string.
	* @var int
	*/
	const UNACCEPTABLE_PARAMETERS_STRING = 1141;
	/** Call not accepted: invalid IP address.
	* @var int
	*/
	const INVALID_IP_ADDRESS = 1142;
	/** Transaction abandoned by the buyer.
	* @var int
	*/
	const TRANSACTION_ABANDONED_BY_BUYER = 1143;
	/** Empty nandatory field.
	* @var int
	*/
	const EMPTY_NANDATORY_FIELD = 1144;
	/** Invalid OTP.
	* @var int
	*/
	const INVALID_OTP = 1145;
	/** Amount too low.
	* @var int
	*/
	const AMOUNT_TOO_LOW = 1146;
	/** Amount too high.
	* @var int
	*/
	const AMOUNT_TOO_HIGH_1 = 1147;
	/** Invalid buyer name.
	* @var int
	*/
	const INVALID_BUYER_NAME = 1148;
	/** Missing or wrong CVV2.
	* @var int
	*/
	const MISSING_OR_WRONG_CVV2 = 1149;
	/** IPIN must have a value.
	* @var int
	*/
	const IPIN_EMPTY = 1150;
	/** Wrong parameters.
	* @var int
	*/
	const WRONG_PARAMETERS = 1151;
	/** Unable to verify the card qualification for the VBV service.
	* @var int
	*/
	const VBV_SERVICE_UNABLE_TO_VERIFY_CARD_QUALIFICATION = 1153;
	/** Call not accepted: missing TransKey.
	* @var int
	*/
	const MISSING_TRANSKEY = 1154;
	/** The ABI code does not match any of the banks in the BankPass circuit.
	* @var int
	*/
	const ABI_NOT_FOR_BANKPASS_BANKS = 1200;
	/** BankPass transaction abandoned by the buyer.
	* @var int
	*/
	const BANKPASS_TRANSACTION_ABANDONED_BY_BUYER = 1201;
	/** BankPass – Buyer authentication failed.
	* @var int
	*/
	const BANKPASS_BUYER_AUTHENTICATION_FAILED = 1202;
	/** BankPass – No available payment tool.
	* @var int
	*/
	const BANKPASS_NO_AVAILABLE_PAYMENT_TOOL = 1203;
	/** BankPass – Technical error.
	* @var int
	*/
	const BANKPASS_TECHNICAL_ERROR = 1204;
	/** BankPass Server-Server: return URL not specified.
	* @var int
	*/
	const BANKPASS_RETURN_URL_NOT_SPECIFIED = 1205;
	/** BankPass Server-Server: return URL too long (max 250 characters).
	* @var int
	*/
	const BANKPASS_RETURN_URL_TOO_LONG = 1206;
	/** BankPass Server-Server: invalid return URL (must start with http:// or https://).
	* @var int
	*/
	const BANKPASS_INVALID_RETURN_URL = 1207;
	/** BankPass Server-Server: return URL parameter not found.
	* @var int
	*/
	const BANKPASS_RETURN_URL_PARAMETER_NOT_FOUND = 1208;
	/** BankPass Server-Server: IDBankPass not found.
	* @var int
	*/
	const BANKPASS_IDBANKPASS_NOT_FOUND = 1209;
	/** BankPass Server-Server: IDBankPass not valid.
	* @var int
	*/
	const BANKPASS_IDBANKPASS_NOT_VALID = 1210;
	/** Technical error while communicating with the international circuits.
	* @var int
	*/
	const TECHNICAL_ERROR_COMMUNICATING_WITH_INTERNATIONAL_CIRCUITS_5 = 1999;
	/** Transaction excedees the maximum number of operations in the time interval.
	* @var int
	*/
	const TRANSACTION_EXCEDEES_OPERATIONS_IN_TIME_INTERVAL = 2000;
	/** Transaction excedees the maximum number of operations done by the user in the time interval.
	* @var int
	*/
	const TRANSACTION_EXCEDEES_USER_OPERATIONS_IN_TIME_INTERVAL = 2001;
	/** Transaction excedees the maximum amount in the time interval.
	* @var int
	*/
	const TRANSACTION_EXCEDEES_AMOUNT_IN_TIME_INTERVAL = 2002;
	/** Transaction excedees the maximum amount for the same user in the time interval.
	* @var int
	*/
	const TRANSACTION_EXCEDEES_USER_AMOUNT_IN_TIME_INTERVAL = 2003;
	/** Transaction contains an amount declared as not acceptable.
	* @var int
	*/
	const TRANSACTION_WITH_NOT_ACCEPTABLE_DECLARED_AMOUNT = 2004;
	/** Transaction abandoned because it’s a duplicated of a previous transaction.
	* @var int
	*/
	const TRANSACTION_ABANDONED_DUPLICATED = 2005;
	/** Wrong line length.
	* @var int
	*/
	const WRONG_LINE_LENGTH = 2006;
	/** Invalid SHOPTRANSACTIONID field.
	* @var int
	*/
	const INVALID_SHOPTRANSACTIONID_FIELD = 2007;
	/** Invalid DIVISA field.
	* @var int
	*/
	const INVALID_DIVISA_FIELD = 2008;
	/** Invalid IMPORTO field.
	* @var int
	*/
	const INVALID_IMPORTO_FIELD = 2009;
	/** Empty DATA AUTORIZZAZIONE field.
	* @var int
	*/
	const EMPTY_DATA_AUTORIZZAZIONE = 2010;
	/** Transaction does not exist.
	* @var int
	*/
	const TRANSACTION_NON_EXISTENT = 2011;
	/** Transaction is not unique.
	* @var int
	*/
	const TRANSACTION_IS_NOT_UNIQUE = 2012;
	/** More than one line for the same transaction in the file.
	* @var int
	*/
	const MORE_THAN_ONE_LINE_FOR_THE_SAME_TRANSACTION_IN_THE_FILE = 2013;
	/** You have requested a transfer for an amount in excess of the remaining availability of the transaction.
	* @var int
	*/
	const AMOUNT_EXCEEDDING_REMAINING_TRANSACTION_AVAILABILITY = 2014;
	/** Invalid BANKTRANSACTIONID field.
	* @var int
	*/
	const INVALID_BANKTRANSACTIONID_FIELD = 2015;
	/** Empty BANKTRANSACTIONID and SHOPTRANSACTIONID fields.
	* @var int
	*/
	const EMPTY_BANKTRANSACTIONID_SHOPTRANSACTIONID = 2016;
	/** Transaction can not be deleted.
	* @var int
	*/
	const TRANSACTION_CANT_BE_DELETED = 2017;
	/** Transaction can’t be diverted.
	* @var int
	*/
	const TRANSACTION_CANT_BE_DIVERTED = 2018;
	/** Transaction can’t be transferred.
	* @var int
	*/
	const TRANSACTION_CANT_BE_TRANSFERRED = 2019;
	/** Transaction not voidable.
	* @var int
	*/
	const TRANSACTION_NOT_VOIDABLE = 2020;
	/** Operation not allowed.
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_3 = 4100;
	/** Wrong length of the credit card number.
	* @var int
	*/
	const WRONG_CREDIT_CARD_NUMBER_2 = 4101;
	/** Amount not available.
	* @var int
	*/
	const AMOUNT_NOT_AVAILABLE_3 = 4102;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_9 = 4103;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_10 = 4104;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_11 = 4105;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_12 = 4106;
	/** Technical error while communicating with the international circuits.
	* @var int
	*/
	const TECHNICAL_ERROR_COMMUNICATING_WITH_INTERNATIONAL_CIRCUITS_6 = 4108;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_13 = 4109;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_14 = 4200;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_15 = 4201;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_16 = 4202;
	/** Please call company.
	* @var int
	*/
	const PLEASE_CALL_COMPANY_3 = 4203;
	/** Operation not allowed.
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_4 = 4204;
	/** Operation not allowed.
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_5 = 4205;
	/** Wrong credit card check digit. Please check the number of the credit cart.
	* @var int
	*/
	const WRONG_CREDIT_CARD_CHECK_DIGIT_3 = 4206;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_17 = 4207;
	/** Operation not allowed.
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_6 = 4208;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_18 = 4209;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_19 = 4300;
	/** Amount too high.
	* @var int
	*/
	const AMOUNT_TOO_HIGH_2 = 4301;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_20 = 4302;
	/** Operation not allowed.
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_7 = 4303;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_21 = 4304;
	/** Authorization denied from the circuits.
	* @var int
	*/
	const AUTHORIZATION_DENIED_FROM_THE_CIRCUITS_5 = 4305;
	/** Operation not allowed.
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_8 = 4306;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_22 = 4307;
	/** Operation not allowed.
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_9 = 4308;
	/** Amount too high.
	* @var int
	*/
	const AMOUNT_TOO_HIGH_3 = 4309;
	/** Wrong transaction date.
	* @var int
	*/
	const WRONG_TRANSACTION_DATE_2 = 4400;
	/** Wrong card date.
	* @var int
	*/
	const WRONG_CARD_DATE_3 = 4401;
	/** Technical error while communicating with the international circuits.
	* @var int
	*/
	const TECHNICAL_ERROR_COMMUNICATING_WITH_INTERNATIONAL_CIRCUITS_7 = 4402;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_23 = 4403;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_24 = 4404;
	/** Operation not allowed.
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_10 = 4405;
	/** Operation not allowed.
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_11 = 4406;
	/** Amount not available.
	* @var int
	*/
	const AMOUNT_NOT_AVAILABLE_4 = 4407;
	/** Operation not allowed.
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_12 = 4408;
	/** Operation not allowed.
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_13 = 4409;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_25 = 4500;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_26 = 4501;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_27 = 4502;
	/** Operation not allowed.
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_14 = 4503;
	/** Operation not allowed.
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_15 = 4504;
	/** Operation not allowed.
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_16 = 4505;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_28 = 4506;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_29 = 4507;
	/** Operation not allowed.
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_17 = 4508;
	/** Technical error.
	* @var int
	*/
	const TECHNICAL_ERROR_30 = 4604;
	/** Operation not allowed.
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_18 = 4701;
	/** Wrong card date.
	* @var int
	*/
	const WRONG_CARD_DATE_4 = 4702;
	/** Card not enabled.
	* @var int
	*/
	const CARD_NOT_ENABLED_3 = 4703;
	/** Amount not available.
	* @var int
	*/
	const AMOUNT_NOT_AVAILABLE_5 = 4704;
	/** Technical error while communicating with the international circuits.
	* @var int
	*/
	const TECHNICAL_ERROR_COMMUNICATING_WITH_INTERNATIONAL_CIRCUITS_8 = 4705;
	/** Technical error while communicating with the international circuits.
	* @var int
	*/
	const TECHNICAL_ERROR_COMMUNICATING_WITH_INTERNATIONAL_CIRCUITS_9 = 4706;
	/** Authorization denied.
	* @var int
	*/
	const AUTHORIZATION_DENIED_22 = 7400;
	/** Authorization denied from the circuits.
	* @var int
	*/
	const AUTHORIZATION_DENIED_FROM_THE_CIRCUITS_6 = 7401;
	/** Card not enabled.
	* @var int
	*/
	const CARD_NOT_ENABLED_4 = 7402;
	/** Unrecognized card.
	* @var int
	*/
	const UNRECOGNIZED_CARD_4 = 7403;
	/** Expired card.
	* @var int
	*/
	const EXPIRED_CARD_3 = 7404;
	/** Please call company.
	* @var int
	*/
	const PLEASE_CALL_COMPANY_4 = 7405;
	/** Wrong card date.
	* @var int
	*/
	const WRONG_CARD_DATE_5 = 7406;
	/** Wrong transaction date.
	* @var int
	*/
	const WRONG_TRANSACTION_DATE_3 = 7407;
	/** System error.
	* @var int
	*/
	const SYSTEM_ERROR = 7408;
	/** Unrecognized vendor.
	* @var int
	*/
	const UNRECOGNIZED_VENDOR = 7409;
	/** Invalid format.
	* @var int
	*/
	const INVALID_FORMAT = 7410;
	/** Amount not available.
	* @var int
	*/
	const AMOUNT_NOT_AVAILABLE_6 = 7411;
	/** Not transferred.
	* @var int
	*/
	const NOT_TRANSFERRED = 7412;
	/** Operation not allowed.
	* @var int
	*/
	const OPERATION_NOT_ALLOWED_19 = 7413;
	/** Unavailable network.
	* @var int
	*/
	const UNAVAILABLE_NETWORK_2 = 7414;
	/** Seize card.
	* @var int
	*/
	const SEIZE_CARD_2 = 7415;
	/** Pin attempts exceeded.
	* @var int
	*/
	const PIN_ATTEMPTS_EXCEEDED = 7416;
	/** Locked terminal.
	* @var int
	*/
	const LOCKED_TERMINAL = 7417;
	/** Terminal forcibly closed.
	* @var int
	*/
	const TERMINAL_FORCIBLY_CLOSED = 7418;
	/** Transaction not allowed.
	* @var int
	*/
	const TRANSACTION_NOT_ALLOWED = 7419;
	/** Transaction not authorized.
	* @var int
	*/
	const TRANSACTION_NOT_AUTHORIZED = 7420;
	/** Service not available on 01/01/2002.
	* @var int
	*/
	const SERVICE_NOT_AVAILABLE_ON_01012002 = 7421;
	/** Authorization not granted.
	* @var int
	*/
	const AUTHORIZATION_NOT_GRANTED_1 = 7500;
	/** Authorization not granted.
	* @var int
	*/
	const AUTHORIZATION_NOT_GRANTED_2 = 7600;
	/** Flow correctly processed.
	* @var int
	*/
	const FLOW_CORRECTLY_PROCESSED_1 = 8000;
	/** Header/footer record not found.
	* @var int
	*/
	const HEADER_FOOTER_RECORD_NOT_FOUND = 8001;
	/** Empty vendor code.
	* @var int
	*/
	const EMPTY_VENDOR_CODE = 8002;
	/** Incongruent number of rows.
	* @var int
	*/
	const INCONGRUENT_ROWS_NUMBER = 8003;
	/** Wrong file format.
	* @var int
	*/
	const WRONG_FILE_FORMAT = 8004;
	/** Vendor not enabled to the function.
	* @var int
	*/
	const VENDOR_NOT_ENABLED_TO_THE_FUNCTION = 8005;
	/** Verify By Visa.
	* @var int
	*/
	const VERIFY_BY_VISA = 8006;
	/** Unavailable function for VISA cards.
	* @var int
	*/
	const UNAVAILABLE_FUNCTION_VISA_CARDS = 8007;
	/** Unavailable function.
	* @var int
	*/
	const UNAVAILABLE_FUNCTION = 8008;
	/** Payment aborted.
	* @var int
	*/
	const PAYMENT_ABORTED = 8009;
	/** Wrong credit card number for this operation.
	* @var int
	*/
	const WRONG_CREDIT_CARD_NUMBER_FOR_OPERATION = 8010;
	/** Operation successfully acquired.
	* @var int
	*/
	const OPERATION_ACQUIRED = 8011;
	/** Authorization not found.
	* @var int
	*/
	const AUTHORIZATION_NOT_FOUND = 8012;
	/** Movement not found.
	* @var int
	*/
	const MOVEMENT_NOT_FOUND = 8013;
	/** Movement amount greater that authorized amount.
	* @var int
	*/
	const MOVEMENT_AMOUNT_GREATER_THAT_AUTHORIZED_AMOUNT = 8014;
	/** Transfer amount greather than the balance.
	* @var int
	*/
	const TRANSFER_GREATHER_THAN_BALANCE = 8015;
	/** Operation not transferred.
	* @var int
	*/
	const OPERATION_NOT_TRANSFERRED = 8016;
	/** Flow waiting to be processed.
	* @var int
	*/
	const FLOW_WAITING_TO_BE_PROCESSED = 8017;
	/** Flow correctly processed.
	* @var int
	*/
	const FLOW_CORRECTLY_PROCESSED_2 = 8018;
	/** Unavailable function for MASTERCARD cards.
	* @var int
	*/
	const UNAVAILABLE_FUNCTION_MASTERCARD_CARDS = 8021;
	/** Unavailable function for JBC cards.
	* @var int
	*/
	const UNAVAILABLE_FUNCTION_JBC_CARDS = 8022;
	/** Unavailable function for MAESTRO cards.
	* @var int
	*/
	const UNAVAILABLE_FUNCTION_MAESTRO_CARDS = 8023;
	/** UP Mobile Payment.
	* @var int
	*/
	const UP_MOBILE_PAYMENT = 8888;
	/** Unsupported browser.
	* @var int
	*/
	const UNSUPPORTED_BROWSER = 9991;
	/** Error during iFrame creation.
	* @var int
	*/
	const IFRAME_CREATION_ERROR = 9992;
	/** Step with errors.
	* @var int
	*/
	const STEP_WITH_ERRORS = 9997;
	/** Step successful.
	* @var int
	*/
	const STEP_SUCCESSFUL = 9998;
	/** Generic error.
	* @var int
	*/
	const GENERIC_ERROR = 9999;
	/** Initializes the instance.
	* @param string $message The error message.
	* @param int $code One of the GestPayException:: error codes.
	*/
	public function __construct($message, $code, $file = '', $line = null) {
		parent::__construct($message, $code);
		$file = (is_string($file) && strlen($file)) ? $file : '';
		$line = ((!empty($line)) && is_numeric($line)) ? @intval($line) : null;
		if(strlen($file)) {
			$this->file = $file;
			$this->line = is_null($line) ? 0 : $line;
		}
	}
	/** Creates a new instance of GestPayException from one of the GestPayException:: error codes.
	* @param int $code One of the GestPayException:: error codes.
	* @param string $file [default: ''] The full-path file name raising the error.
	* @param int|null $line [default: null] The line number raising the error.
	* @param string|true $onNotFoundErrorCode [default: true] What to use as message if the $code is unknown (use true to build automatically the error message).
	* @return GestPayException
	*/
	public static function fromCode($code, $file = '', $line = null, $onNotFound = true) {
		return new GestPayException(self::getErrorDescription($code, $onNotFound), $code, $file, $line);
	}
	/** Creates an instance of GestPayException for a generic error.
	* @param string $message The error message.
	* @param string $file [default: ''] The full-path file name raising the error.
	* @param int|null $line [default: null] The line number raising the error.
	* @return GestPayException
	*/
	public static function generic($message, $file = '', $line = null) {
		return new GestPayException($message, self::GENERIC_ERROR);
	}
	/** Returns the description of an error code.
	* @param int $code One of the GestPayException:: error codes.
	* @param string|true $onNotFoundErrorCode What to return if the $code is unknown (true to build automatically the error message).
	* @return unknown|string
	*/
	public static function getErrorDescription($code, $onNotFound = '') {
		if(is_numeric($code)) {
			switch(@intval($code)) {
				case self::TRANSACTION_SUCCESSFUL:
					return t('Transaction successful');
				case self::INVALID_SHOPLOGIN:
					return t('Invalid shop login');
				case self::CURRENCY_NOT_VALID:
					return t('Currency not valid');
				case self::AMOUNT_NOT_VALID:
					return t('Amount not valid');
				case self::INVALID_TRANSACTIONID:
					return t('Shop transaction ID not valid');
				case self::LANGUAGE_NOT_VALID:
					return t('Language not valid');
				case self::EMPTY_RESPONSE;
					return t('Empty response');
				case self::INVALID_DECRYPT_STRING;
					return t('String to decrypt not valid');
				case self::PAYMENT_PAGE_LOADED_SUCCESSFULLY:
					return t('Payment page loaded successfully');
				case self::LOCKED_CARD_1:
					return t('Card is locked');
				case self::CONFIRMED_AMOUNT_EXCEEDING_AUTHORIZED_AMOUNT:
					return t('Confirmed amount exceeding the authorized amount');
				case self::REQUEST_TO_TRANSFER_NON_EXISTENT_AUTHORIZATION:
					return t('Request to transfer a non-existent authorization');
				case self::PREAUTHORIZATION_EXPIRED:
					return t('Pre-authorization expired');
				case self::INVALID_CURRENCY:
					return t('Invalid currency');
				case self::PREAUTHORIZATION_ALREADY_NOTIFIED:
					return t('Pre-authorization already notified');
				case self::AUTHORIZATION_DENIED_1:
					return t('Authorization denied');
				case self::AUTHORIZATION_DENIED_2:
					return t('Authorization denied');
				case self::TRANSACTION_ABORTED_BY_BANK_AUTHORIZATION_SYSTEM:
					return t('Transaction aborted by the bank authorization system');
				case self::VENDOR_CONFIGURATION_ERROR_IN_BANK_AUTHORIZATION_SYSTEM_1:
					return t('Vendor configuration error in bank authorization system');
				case self::WRONG_CARD_DATE_1:
					return t('Wrong card date');
				case self::BANK_AUTHORIZATION_SYSTEM_NOT_AVAILABLE_1:
					return t('Bank authorization system not available');
				case self::INSUFFICIENT_CARD_CASH:
					return t('Insufficient card cash');
				case self::PLEASE_CALL_COMPANY_1:
					return t('Please call company');
				case self::PLEASE_CALL_COMPANY_2:
					return t('Please call company');
				case self::TECHNICAL_ERROR_1:
					return t('Technical error');
				case self::SEIZE_CARD_1:
					return t('Seize card');
				case self::AUTHORIZATION_DENIED_FROM_THE_CIRCUITS_1:
					return t('Authorization denied from the circuits');
				case self::TECHNICAL_ERROR_2:
					return t('Technical error');
				case self::TECHNICAL_ERROR_3:
					return t('Technical error');
				case self::TECHNICAL_ERROR_4:
					return t('Technical error');
				case self::TECHNICAL_ERROR_5:
					return t('Technical error');
				case self::UNRECOGNIZED_CARD_1:
					return t('Unrecognized card');
				case self::TECHNICAL_ERROR_COMMUNICATING_WITH_INTERNATIONAL_CIRCUITS_1:
					return t('Technical error while communicating with the international circuits');
				case self::WRONG_PIN:
					return t('Wrong pin');
				case self::AUTHORIZATION_DENIED_3:
					return t('Authorization denied');
				case self::UNAVAILABLE_NETWORK_1:
					return t('Unavailable network');
				case self::WRONG_TRANSACTION_DATE_1:
					return t('Wrong transaction date');
				case self::WRONG_CARD_DATE_2:
					return t('Wrong card date');
				case self::TECHNICAL_ERROR_6:
					return t('Technical error');
				case self::TECHNICAL_ERROR_COMMUNICATING_WITH_INTERNATIONAL_CIRCUITS_2:
					return t('Technical error while communicating with the international circuits');
				case self::EXPIRED_CARD_1:
					return t('Expired card');
				case self::AUTHORIZATION_DENIED_FROM_THE_CIRCUITS_2:
					return t('Authorization denied from the circuits');
				case self::AUTHORIZATION_DENIED_FROM_THE_CIRCUITS_3:
					return t('Authorization denied from the circuits');
				case self::CARD_NOT_ENABLED_1:
					return t('Card not enabled');
				case self::OPERATION_NOT_ALLOWED_1:
					return t('Operation not allowed');
				case self::OPERATION_NOT_ALLOWED_PIN_ATTEMPTS:
					return t('Operation not allowed (exceeded pin attempts)');
				case self::UNRECOGNIZED_CARD_2:
					return t('Unrecognized card');
				case self::LOCKED_CARD_2:
					return t('Card is locked');
				case self::LOCKED_CARD_3:
					return t('Card is locked');
				case self::AMOUNT_NOT_AVAILABLE_1:
					return t('Amount not available');
				case self::EXPIRED_CARD_2:
					return t('Expired card');
				case self::OPERATION_NOT_ACCOMPLISHED_1:
					return t('Operation not accomplished');
				case self::UNRECOGNIZED_CARD_3:
					return t('Unrecognized card');
				case self::AUTHORIZATION_DENIED_FROM_THE_CIRCUITS_4:
					return t('Authorization denied from the circuits');
				case self::VENDOR_CONFIGURATION_ERROR_IN_BANK_AUTHORIZATION_SYSTEM_2:
					return t('Vendor configuration error in bank authorization system');
				case self::AMOUNT_NOT_AVAILABLE_2:
					return t('Amount not available');
				case self::LOCKED_CARD_4:
					return t('Card is locked');
				case self::BANK_AUTHORIZATION_SYSTEM_NOT_AVAILABLE_2:
					return t('Bank authorization system not available');
				case self::OPERATION_NOT_ALLOWED_2:
					return t('Operation not allowed');
				case self::TECHNICAL_ERROR_7:
					return t('Technical error');
				case self::TECHNICAL_ERROR_COMMUNICATING_WITH_INTERNATIONAL_CIRCUITS_3:
					return t('Technical error while communicating with the international circuits');
				case self::TECHNICAL_ERROR_COMMUNICATING_WITH_INTERNATIONAL_CIRCUITS_4:
					return t('Technical error while communicating with the international circuits');
				case self::TECHNICAL_ERROR_8:
					return t('Technical error');
				case self::OPERATION_ABANDONED_BY_BUYER:
					return t('Operation abandoned by buyer');
				case self::BANK_TRANSFER_NOT_AUTHORIZED:
					return t('Bank transfer not authorized');
				case self::BANK_AUTHORIZATION_SYSTEM_NOT_AVAILABLE_3:
					return t('Bank authorization system not available');
				case self::VENDOR_CONFIGURATION_ERROR_IN_BANK_AUTHORIZATION_SYSTEM_3:
					return t('Vendor configuration error in bank authorization system');
				case self::AUTHORIZATION_DENIED_4:
					return t('Authorization denied');
				case self::AUTHORIZATION_DENIED_5:
					return t('Authorization denied');
				case self::AUTHORIZATION_DENIED_6:
					return t('Authorization denied');
				case self::AUTHORIZATION_DENIED_7:
					return t('Authorization denied');
				case self::AUTHORIZATION_DENIED_8:
					return t('Authorization denied');
				case self::AUTHORIZATION_DENIED_9:
					return t('Authorization denied');
				case self::AUTHORIZATION_DENIED_10:
					return t('Authorization denied');
				case self::AUTHORIZATION_DENIED_11:
					return t('Authorization denied');
				case self::AUTHORIZATION_DENIED_12:
					return t('Authorization denied');
				case self::AUTHORIZATION_DENIED_13:
					return t('Authorization denied');
				case self::AUTHORIZATION_DENIED_14:
					return t('Authorization denied');
				case self::AUTHORIZATION_DENIED_15:
					return t('Authorization denied');
				case self::AUTHORIZATION_DENIED_16:
					return t('Authorization denied');
				case self::AUTHORIZATION_DENIED_17:
					return t('Authorization denied');
				case self::AUTHORIZATION_DENIED_18:
					return t('Authorization denied');
				case self::AUTHORIZATION_DENIED_19:
					return t('Authorization denied');
				case self::AUTHORIZATION_DENIED_20:
					return t('Authorization denied');
				case self::AUTHORIZATION_DENIED_21:
					return t('Authorization denied');
				case self::CARD_NOT_ENABLED_2:
					return t('Card not enabled');
				case self::VENDOR_CONFIGURATION_ERROR_IN_BANK_AUTHORIZATION_SYSTEM_4:
					return t('Vendor configuration error in bank authorization system');
				case self::WRONG_CREDIT_CARD_CHECK_DIGIT_1:
					return t('Wrong credit card check digit');
				case self::OPERATION_NOT_ACCOMPLISHED_2:
					return t('Operation not accomplished');
				case self::EMPTY_PARAMETERS_STRING:
					return t('Empty parameters string');
				case self::INVALID_PARAMETER_STRING:
					return t('Invalid parameter string');
				case self::EQUALS_SYMBOL_WITHOUT_PARAMETER:
					return t('= symbol not preceded by a parameter name');
				case self::PARAMETER_STRING_ENDS_WITH_SEPARATOR:
					return t('Parameter string ends with a separator');
				case self::INVALID_PARAMETER_NAME:
					return t('Invalid parameter name');
				case self::INVALID_PARAMETER_VALUE:
					return t('Invalid parameter value');
				case self::DUPLICATED_PARAMETER_NAME:
					return t('Duplicated parameter name');
				case self::UNEXPECTED_PARAMETER_NAME:
					return t('Unexpected parameter name. Please check the fields and parameters configuration in Back Office.');
				case self::EMPTY_MANDATORY_PARAMETER:
					return t('Empty mandatory parameter');
				case self::MISSING_PARAMETER:
					return t('Missing parameter');
				case self::MISSING_PAY1_UICCODE_PARAMETER:
					return t('Missing PAY1_UICCODE parameter');
				case self::INVALID_CURRENCY_CODE:
					return t('Invalid currency code');
				case self::MISSING_PAY1_AMOUNT_PARAMETER:
					return t('Missing PAY1_AMOUNT parameter');
				case self::AMOUNT_NOT_NUMERIC:
					return t('Amount not numeric');
				case self::WRONG_DECIMALS_NUMBEG:
					return t('Wrong number of decimals in amount');
				case self::MISSING_PAY1_SHOPTRANSACTIONID_PARAMETER:
					return t('Missing PAY1_SHOPTRANSACTIONID parameter');
				case self::PAY1_SHOPTRANSACTIONID_TOO_LONG:
					return t('PAY1_SHOPTRANSACTIONID parameter too long');
				case self::INVALID_LANGUAGE_IDENTIFIER:
					return t('Invalid language identifier');
				case self::NONNUMERIC_CHARACTERS_IN_THE_CREDIT_CARD_NUMBER:
					return t('Non-numeric characters in the credit card number');
				case self::WRONG_CREDIT_CARD_NUMBER_1:
					return t('Wrong length of the credit card number');
				case self::WRONG_CREDIT_CARD_CHECK_DIGIT_2:
					return t('Wrong credit card check digit');
				case self::DISABLED_CREDIT_CARD_COMPANY:
					return t('Credit card of a disabled company');
				case self::EXPIRATION_YEAR_WITHOUT_MONTH:
					return t('Expiration year without month');
				case self::EXPIRATION_MONTH_WITHOUT_YEAR:
					return t('Expiration month without year');
				case self::INVALID_EXPIRATION_MONTH:
					return t('Invalid expiration month');
				case self::INVALID_EXPIRATION_YEAR:
					return t('Invalid expiration year');
				case self::EXPIRY_DATE_EXCEEDED:
					return t('Expiry date exceeded');
				case self::INVALID_BUYER_EMAIL:
					return t('Invalid buyer email');
				case self::PARAMETERS_STRING_TOO_LONG:
					return t('Parameters string too long');
				case self::PARAMETER_VALUE_TOO_LONG:
					return t('Parameter value too long');
				case self::MISSING_A_PARAMETER:
					return t('Call not accepted: missing A parameter');
				case self::SHOP_NOT_RECOGNIZED:
					return t('Call not accepted: shop not recognized');
				case self::UNACTIVE_SHOP:
					return t('Call not accepted: unactive shop');
				case self::MISSING_B_PARAMETER:
					return t('Call not accepted: missing B parameter');
				case self::EMPTY_B_PARAMETER:
					return t('Call not accepted: empty B parameter');
				case self::OTHER_PARAMETERS_IN_ADDITION_TO_A_AND_B:
					return t('Call not accepted: other parameters in addition to A and B');
				case self::TRANSACTION_NOT_STARTED_BY_CALL_CRYPROGRAPHY_SYSTEM:
					return t('Call not accepted: transaction not started by a call to the server-to-server cryprography system');
				case self::TRANSACTION_ALREADY_PROCESSED:
					return t('Call not accepted: transaction already processed previously');
				case self::MISSING_CREDIT_CARD_NUMBER_OR_EXPIRATION:
					return t('Call not accepted: missing credit card number or expiration');
				case self::SHOP_WITHOUT_PUBLIC_PAYMENT_PAGE:
					return t('Call not accepted: the shop doesn’t have a public payment page');
				case self::TRANSACTION_ABANDONED_BY_CUSTOMER:
					return t('Transaction abandoned by the customer');
				case self::UNACCEPTABLE_PARAMETERS_STRING:
					return t('Call not accepted: unacceptable parameters string');
				case self::INVALID_IP_ADDRESS:
					return t('Call not accepted: invalid IP address');
				case self::TRANSACTION_ABANDONED_BY_BUYER:
					return t('Transaction abandoned by the buyer');
				case self::EMPTY_NANDATORY_FIELD:
					return t('Empty nandatory field');
				case self::INVALID_OTP:
					return t('Invalid OTP');
				case self::AMOUNT_TOO_LOW:
					return t('Amount too low');
				case self::AMOUNT_TOO_HIGH_1:
					return t('Amount too high');
				case self::INVALID_BUYER_NAME:
					return t('Invalid buyer name');
				case self::MISSING_OR_WRONG_CVV2:
					return t('Missing or wrong CVV2');
				case self::IPIN_EMPTY:
					return t('IPIN must have a value');
				case self::WRONG_PARAMETERS:
					return t('Wrong parameters');
				case self::VBV_SERVICE_UNABLE_TO_VERIFY_CARD_QUALIFICATION:
					return t('Unable to verify the card qualification for the VBV service');
				case self::MISSING_TRANSKEY:
					return t('Call not accepted: missing TransKey');
				case self::ABI_NOT_FOR_BANKPASS_BANKS:
					return t('The ABI code does not match any of the banks in the BankPass circuit');
				case self::BANKPASS_TRANSACTION_ABANDONED_BY_BUYER:
					return t('BankPass transaction abandoned by the buyer');
				case self::BANKPASS_BUYER_AUTHENTICATION_FAILED:
					return t('BankPass – Buyer authentication failed');
				case self::BANKPASS_NO_AVAILABLE_PAYMENT_TOOL:
					return t('BankPass – No available payment tool');
				case self::BANKPASS_TECHNICAL_ERROR:
					return t('BankPass – Technical error');
				case self::BANKPASS_RETURN_URL_NOT_SPECIFIED:
					return t('BankPass Server-Server: return URL not specified');
				case self::BANKPASS_RETURN_URL_TOO_LONG:
					return t('BankPass Server-Server: return URL too long (max 250 characters)');
				case self::BANKPASS_INVALID_RETURN_URL:
					return t('BankPass Server-Server: invalid return URL (must start with http:// or https://)');
				case self::BANKPASS_RETURN_URL_PARAMETER_NOT_FOUND:
					return t('BankPass Server-Server: return URL parameter not found');
				case self::BANKPASS_IDBANKPASS_NOT_FOUND:
					return t('BankPass Server-Server: IDBankPass not found');
				case self::BANKPASS_IDBANKPASS_NOT_VALID:
					return t('BankPass Server-Server: IDBankPass not valid');
				case self::TECHNICAL_ERROR_COMMUNICATING_WITH_INTERNATIONAL_CIRCUITS_5:
					return t('Technical error while communicating with the international circuits');
				case self::TRANSACTION_EXCEDEES_OPERATIONS_IN_TIME_INTERVAL:
					return t('Transaction excedees the maximum number of operations in the time interval');
				case self::TRANSACTION_EXCEDEES_USER_OPERATIONS_IN_TIME_INTERVAL:
					return t('Transaction excedees the maximum number of operations done by the user in the time interval');
				case self::TRANSACTION_EXCEDEES_AMOUNT_IN_TIME_INTERVAL:
					return t('Transaction excedees the maximum amount in the time interval');
				case self::TRANSACTION_EXCEDEES_USER_AMOUNT_IN_TIME_INTERVAL:
					return t('Transaction excedees the maximum amount for the same user in the time interval');
				case self::TRANSACTION_WITH_NOT_ACCEPTABLE_DECLARED_AMOUNT:
					return t('Transaction contains an amount declared as not acceptable');
				case self::TRANSACTION_ABANDONED_DUPLICATED:
					return t('Transaction abandoned because it’s a duplicated of a previous transaction');
				case self::WRONG_LINE_LENGTH:
					return t('Wrong line length');
				case self::INVALID_SHOPTRANSACTIONID_FIELD:
					return t('Invalid SHOPTRANSACTIONID field');
				case self::INVALID_DIVISA_FIELD:
					return t('Invalid DIVISA field');
				case self::INVALID_IMPORTO_FIELD:
					return t('Invalid IMPORTO field');
				case self::EMPTY_DATA_AUTORIZZAZIONE:
					return t('Empty DATA AUTORIZZAZIONE field');
				case self::TRANSACTION_NON_EXISTENT:
					return t('Transaction does not exist');
				case self::TRANSACTION_IS_NOT_UNIQUE:
					return t('Transaction is not unique');
				case self::MORE_THAN_ONE_LINE_FOR_THE_SAME_TRANSACTION_IN_THE_FILE:
					return t('More than one line for the same transaction in the file');
				case self::AMOUNT_EXCEEDDING_REMAINING_TRANSACTION_AVAILABILITY:
					return t('You have requested a transfer for an amount in excess of the remaining availability of the transaction');
				case self::INVALID_BANKTRANSACTIONID_FIELD:
					return t('Invalid BANKTRANSACTIONID field');
				case self::EMPTY_BANKTRANSACTIONID_SHOPTRANSACTIONID:
					return t('Empty BANKTRANSACTIONID and SHOPTRANSACTIONID fields');
				case self::TRANSACTION_CANT_BE_DELETED:
					return t('Transaction can not be deleted');
				case self::TRANSACTION_CANT_BE_DIVERTED:
					return t('Transaction can’t be diverted');
				case self::TRANSACTION_CANT_BE_TRANSFERRED:
					return t('Transaction can’t be transferred');
				case self::TRANSACTION_NOT_VOIDABLE:
					return t('Transaction not voidable');
				case self::OPERATION_NOT_ALLOWED_3:
					return t('Operation not allowed');
				case self::WRONG_CREDIT_CARD_NUMBER_2:
					return t('Wrong length of the credit card number');
				case self::AMOUNT_NOT_AVAILABLE_3:
					return t('Amount not available');
				case self::TECHNICAL_ERROR_9:
					return t('Technical error');
				case self::TECHNICAL_ERROR_10:
					return t('Technical error');
				case self::TECHNICAL_ERROR_11:
					return t('Technical error');
				case self::TECHNICAL_ERROR_12:
					return t('Technical error');
				case self::TECHNICAL_ERROR_COMMUNICATING_WITH_INTERNATIONAL_CIRCUITS_6:
					return t('Technical error while communicating with the international circuits');
				case self::TECHNICAL_ERROR_13:
					return t('Technical error');
				case self::TECHNICAL_ERROR_14:
					return t('Technical error');
				case self::TECHNICAL_ERROR_15:
					return t('Technical error');
				case self::TECHNICAL_ERROR_16:
					return t('Technical error');
				case self::PLEASE_CALL_COMPANY_3:
					return t('Please call company');
				case self::OPERATION_NOT_ALLOWED_4:
					return t('Operation not allowed');
				case self::OPERATION_NOT_ALLOWED_5:
					return t('Operation not allowed');
				case self::WRONG_CREDIT_CARD_CHECK_DIGIT_3:
					return t('Wrong credit card check digit. Please check the number of the credit cart.');
				case self::TECHNICAL_ERROR_17:
					return t('Technical error');
				case self::OPERATION_NOT_ALLOWED_6:
					return t('Operation not allowed');
				case self::TECHNICAL_ERROR_18:
					return t('Technical error');
				case self::TECHNICAL_ERROR_19:
					return t('Technical error');
				case self::AMOUNT_TOO_HIGH_2:
					return t('Amount too high');
				case self::TECHNICAL_ERROR_20:
					return t('Technical error');
				case self::OPERATION_NOT_ALLOWED_7:
					return t('Operation not allowed');
				case self::TECHNICAL_ERROR_21:
					return t('Technical error');
				case self::AUTHORIZATION_DENIED_FROM_THE_CIRCUITS_5:
					return t('Authorization denied from the circuits');
				case self::OPERATION_NOT_ALLOWED_8:
					return t('Operation not allowed');
				case self::TECHNICAL_ERROR_22:
					return t('Technical error');
				case self::OPERATION_NOT_ALLOWED_9:
					return t('Operation not allowed');
				case self::AMOUNT_TOO_HIGH_3:
					return t('Amount too high');
				case self::WRONG_TRANSACTION_DATE_2:
					return t('Wrong transaction date');
				case self::WRONG_CARD_DATE_3:
					return t('Wrong card date');
				case self::TECHNICAL_ERROR_COMMUNICATING_WITH_INTERNATIONAL_CIRCUITS_7:
					return t('Technical error while communicating with the international circuits');
				case self::TECHNICAL_ERROR_23:
					return t('Technical error');
				case self::TECHNICAL_ERROR_24:
					return t('Technical error');
				case self::OPERATION_NOT_ALLOWED_10:
					return t('Operation not allowed');
				case self::OPERATION_NOT_ALLOWED_11:
					return t('Operation not allowed');
				case self::AMOUNT_NOT_AVAILABLE_4:
					return t('Amount not available');
				case self::OPERATION_NOT_ALLOWED_12:
					return t('Operation not allowed');
				case self::OPERATION_NOT_ALLOWED_13:
					return t('Operation not allowed');
				case self::TECHNICAL_ERROR_25:
					return t('Technical error');
				case self::TECHNICAL_ERROR_26:
					return t('Technical error');
				case self::TECHNICAL_ERROR_27:
					return t('Technical error');
				case self::OPERATION_NOT_ALLOWED_14:
					return t('Operation not allowed');
				case self::OPERATION_NOT_ALLOWED_15:
					return t('Operation not allowed');
				case self::OPERATION_NOT_ALLOWED_16:
					return t('Operation not allowed');
				case self::TECHNICAL_ERROR_28:
					return t('Technical error');
				case self::TECHNICAL_ERROR_29:
					return t('Technical error');
				case self::OPERATION_NOT_ALLOWED_17:
					return t('Operation not allowed');
				case self::TECHNICAL_ERROR_30:
					return t('Technical error');
				case self::OPERATION_NOT_ALLOWED_18:
					return t('Operation not allowed');
				case self::WRONG_CARD_DATE_4:
					return t('Wrong card date');
				case self::CARD_NOT_ENABLED_3:
					return t('Card not enabled');
				case self::AMOUNT_NOT_AVAILABLE_5:
					return t('Amount not available');
				case self::TECHNICAL_ERROR_COMMUNICATING_WITH_INTERNATIONAL_CIRCUITS_8:
					return t('Technical error while communicating with the international circuits');
				case self::TECHNICAL_ERROR_COMMUNICATING_WITH_INTERNATIONAL_CIRCUITS_9:
					return t('Technical error while communicating with the international circuits');
				case self::AUTHORIZATION_DENIED_22:
					return t('Authorization denied');
				case self::AUTHORIZATION_DENIED_FROM_THE_CIRCUITS_6:
					return t('Authorization denied from the circuits');
				case self::CARD_NOT_ENABLED_4:
					return t('Card not enabled');
				case self::UNRECOGNIZED_CARD_4:
					return t('Unrecognized card');
				case self::EXPIRED_CARD_3:
					return t('Expired card');
				case self::PLEASE_CALL_COMPANY_4:
					return t('Please call company');
				case self::WRONG_CARD_DATE_5:
					return t('Wrong card date');
				case self::WRONG_TRANSACTION_DATE_3:
					return t('Wrong transaction date');
				case self::SYSTEM_ERROR:
					return t('System error');
				case self::UNRECOGNIZED_VENDOR:
					return t('Unrecognized vendor');
				case self::INVALID_FORMAT:
					return t('Invalid format');
				case self::AMOUNT_NOT_AVAILABLE_6:
					return t('Amount not available');
				case self::NOT_TRANSFERRED:
					return t('Not transferred');
				case self::OPERATION_NOT_ALLOWED_19:
					return t('Operation not allowed');
				case self::UNAVAILABLE_NETWORK_2:
					return t('Unavailable network');
				case self::SEIZE_CARD_2:
					return t('Seize card');
				case self::PIN_ATTEMPTS_EXCEEDED:
					return t('Pin attempts exceeded');
				case self::LOCKED_TERMINAL:
					return t('Locked terminal');
				case self::TERMINAL_FORCIBLY_CLOSED:
					return t('Terminal forcibly closed');
				case self::TRANSACTION_NOT_ALLOWED:
					return t('Transaction not allowed');
				case self::TRANSACTION_NOT_AUTHORIZED:
					return t('Transaction not authorized');
				case self::SERVICE_NOT_AVAILABLE_ON_01012002:
					return t('Service not available on 01/01/2002.');
				case self::AUTHORIZATION_NOT_GRANTED_1:
					return t('Authorization not granted');
				case self::AUTHORIZATION_NOT_GRANTED_2:
					return t('Authorization not granted');
				case self::FLOW_CORRECTLY_PROCESSED_1:
					return t('Flow correctly processed');
				case self::HEADER_FOOTER_RECORD_NOT_FOUND:
					return t('Header/footer record not found');
				case self::EMPTY_VENDOR_CODE:
					return t('Empty vendor code');
				case self::INCONGRUENT_ROWS_NUMBER:
					return t('Incongruent number of rows');
				case self::WRONG_FILE_FORMAT:
					return t('Wrong file format');
				case self::VENDOR_NOT_ENABLED_TO_THE_FUNCTION:
					return t('Vendor not enabled to the function');
				case self::VERIFY_BY_VISA:
					return t('Verify By Visa');
				case self::UNAVAILABLE_FUNCTION_VISA_CARDS:
					return t('Unavailable function for VISA cards');
				case self::UNAVAILABLE_FUNCTION:
					return t('Unavailable function');
				case self::PAYMENT_ABORTED:
					return t('Payment aborted');
				case self::WRONG_CREDIT_CARD_NUMBER_FOR_OPERATION:
					return t('Wrong credit card number for this operation');
				case self::OPERATION_ACQUIRED:
					return t('Operation successfully acquired');
				case self::AUTHORIZATION_NOT_FOUND:
					return t('Authorization not found');
				case self::MOVEMENT_NOT_FOUND:
					return t('Movement not found');
				case self::MOVEMENT_AMOUNT_GREATER_THAT_AUTHORIZED_AMOUNT:
					return t('Movement amount greater that authorized amount');
				case self::TRANSFER_GREATHER_THAN_BALANCE:
					return t('Transfer amount greather than the balance');
				case self::OPERATION_NOT_TRANSFERRED:
					return t('Operation not transferred');
				case self::FLOW_WAITING_TO_BE_PROCESSED:
					return t('Flow waiting to be processed');
				case self::FLOW_CORRECTLY_PROCESSED_2:
					return t('Flow correctly processed');
				case self::UNAVAILABLE_FUNCTION_MASTERCARD_CARDS:
					return t('Unavailable function for MASTERCARD cards');
				case self::UNAVAILABLE_FUNCTION_JBC_CARDS:
					return t('Unavailable function for JBC cards');
				case self::UNAVAILABLE_FUNCTION_MAESTRO_CARDS:
					return t('Unavailable function for MAESTRO cards');
				case self::UP_MOBILE_PAYMENT:
					return t('UP Mobile Payment');
				case self::UNSUPPORTED_BROWSER:
					return t('Unsupported browser');
				case self::IFRAME_CREATION_ERROR:
					return t('Error during iFrame creation');
				case self::STEP_WITH_ERRORS:
					return t('Step with errors');
				case self::STEP_SUCCESSFUL:
					return t('Step successful');
				case self::GENERIC_ERROR:
					return t('Generic error');
			}
		}
		return ($onNotFound == true) ? sprintf(t('Unknown error (%s)'), $code) : $onNotFound;
	}
}
