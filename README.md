# GeoPhoneNumber

GeoPhoneNumber is a PHP package that helps you determine the provider (Magti, Silknet, Cellfie) for a given phone number
in Georgia. The package normalizes, parses, and formats phone numbers, and it can check if the number belongs to a
specific provider.

## Features

- Normalize phone numbers by removing non-numeric characters and ensuring the country code.
- Parse phone numbers to extract parts (`main` (6-digit national format) and `full` 12 digit, international format).
- Determine the phone number provider (`Magti`, `Silknet`, or `Cellfie`).
- Format phone numbers in different styles (`international (e164)`, and `national (6-digit)`).
- Handle invalid phone numbers and missing providers with clear error messages.

## Requirements

- `PHP 7.4` or higher

## Installation

To install GeoPhoneNumber via Composer, run the following command:

```bash
composer require pbarabadze/geo-phone-number
```

## Usage

Here’s an example of how to use the package:

```php
<?php

require 'vendor/autoload.php';

use Pbarabadze\GeoPhoneNumber\GeoPhoneNumber;

$numbers = [
    '123456', // invalid
    '123456789', // No Provider found
    '995591123456', // Magti
    '577123456', // Silknet
    '577 12 34 56', // Silknet
    '577-12-34-56', // Silknet
    '995 577-12-34-56', // Silknet
    '+995_577-12-34-56', // Silknet
    '995555123456', // Silknet
    '995568123456', // Cellfie
    '995999999999', // No Provider
];

foreach ($numbers as $number) {
    $geoPhoneNumber = new GeoPhoneNumber();
    
    try {
        // Normalize and parse the number once
        $parsedNumber = $geoPhoneNumber->parseNumber($number);
        $provider = $geoPhoneNumber->getProvider($number);
        
        if ($provider) {
            // Check the provider
            if ($geoPhoneNumber->isMagti($number)) {
                echo "It's Magti" . PHP_EOL;
            } else if ($geoPhoneNumber->isCellfie($number)) {
                echo "It's Cellfie" . PHP_EOL;
            } else if ($geoPhoneNumber->isSilknet($number)) {
                echo "It's Silknet" . PHP_EOL;
            }
            
            // Output the provider and full number
            echo "The provider for " . $parsedNumber['full'] . " is: $provider" . PHP_EOL;
        }
    } catch (\InvalidArgumentException $e) {
        // Handle an invalid phone number case
        echo "Number is incorrect: $number" . PHP_EOL;
    } catch (\RuntimeException $e) {
        // Handle no provider found case
        echo "No provider found for " . $number . PHP_EOL;
    }
}
```

### Functions

#### `getProvider($phoneNumber): string`

Returns the provider name (`Magti`, `Silknet`, or `Cellfie`) for the given phone number.

- Throws `RuntimeException` if no provider is found for the number.
- Throws `InvalidArgumentException` if the phone number is invalid.

#### `isMagti($phoneNumber): bool`

Returns `true` if the phone number belongs to Magti, `false` otherwise.

#### `isSilknet($phoneNumber): bool`

Returns `true` if the phone number belongs to Silknet, `false` otherwise.

#### `isCellfie($phoneNumber): bool`

Returns `true` if the phone number belongs to Cellfie, `false` otherwise.

#### `formatNumber($phoneNumber, string $format = 'international'): ?string`

Formats a phone number in different styles: `international (e164)` and `national`.

- Options for `$format`:
    - `international`: Formats the number in international format (`+995577430057`).
    - `national`: Formats the number in national format (`577430057`).
    - `default`: Formats the number in E.164 format (`+995577430057`).

Returns the formatted number, or `null` if the number is invalid.

#### `parseNumber($phoneNumber): array`

Parses a phone number into its components.

- Returns an array with `main` (the main part of the number) and `full` (the full normalized phone number).
- Throws `InvalidArgumentException` if the phone number is too short or invalid.

#### `normalizeNumber($phoneNumber): string`

Normalizes a phone number by removing non-numeric characters and ensuring it starts with the correct country code (`995` for Georgia).

- Throws `InvalidArgumentException` if the phone number length is not exactly 12 characters after normalization.

## Error Handling

- **Invalid Argument**: If a phone number is invalid (e.g., too short, contains invalid characters), an `InvalidArgumentException` is thrown.
- **No Provider Found**: If no provider is found for a given phone number, a `RuntimeException` is thrown.

## License

This package is licensed under the MIT License. See the [LICENSE](LICENSE) file for more information.
