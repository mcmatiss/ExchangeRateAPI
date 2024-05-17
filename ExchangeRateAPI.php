<?php
// Full name of the currencies
$allCurrencies = file_get_contents(
    "https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies.json"
);
$allCurrencies = json_decode($allCurrencies);
// Currency list with EUR as base currency:
$eurBaseCurrency = file_get_contents(
    "https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/eur.json"
);
$eurBaseCurrency = json_decode($eurBaseCurrency);

$baseAmount = "";
$baseCurrency = "";
$userInputCurrency = readline("Enter the amount and currency: ");
for ($i = 0, $j = 0; $i < strlen($userInputCurrency); $i++) {
    if (
        $userInputCurrency[$i] === " " &&
        $i !== strlen($userInputCurrency) - 1
    ) {
        $i++;
        $j = 1;
    }
    if ($j === 0) {
        $baseAmount = $baseAmount . $userInputCurrency[$i];
    } else {
        $baseCurrency = $baseCurrency . $userInputCurrency[$i];
    }
}
$baseCurrency = trim(strtolower($baseCurrency));
$baseAmount = (float) $baseAmount;
if ($baseAmount == 0 || $baseCurrency === "") {
    exit("\nInvalid input!\n");
}

$userInputConversionCurrency = readline("Enter the conversion currency: ");
$userInputConversionCurrency = trim(strtolower($userInputConversionCurrency));
$result = 0;
foreach ($eurBaseCurrency->eur as $currency => $value) {
    if ($baseCurrency === $currency) {
        $result = $value;
        break;
    }
}
if ($result === 0) {
    exit("\nCurrency not found!\n");
}
$conversion = ($baseAmount * 100) / $result;
$result = 0;
foreach ($eurBaseCurrency->eur as $currency => $value) {
    if ($userInputConversionCurrency === $currency) {
        $result = $value;
        break;
    }
}
if ($result === 0) {
    exit("\nConversion currency not found!\n");
}
$conversion = ($conversion * $result) / 100;

foreach ($allCurrencies as $currency => $fullName) {
    if ($baseCurrency === $currency) {
        $baseCurrency = $fullName;
    }
    if ($userInputConversionCurrency === $currency) {
        $userInputConversionCurrency = $fullName;
    }
}
exit(
    "\n$baseAmount $baseCurrency = " .
    number_format($conversion, 2) .
    " $userInputConversionCurrency\n"
);