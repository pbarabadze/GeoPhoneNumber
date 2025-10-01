<?php

namespace Pbarabadze\GeoPhoneNumber;

use Exception;
use InvalidArgumentException;
use RuntimeException;

class GeoPhoneNumber
{
    /** @var array The phone number ranges for different providers */
    private $ranges;

    /**
     * GeoPhoneNumber constructor.
     * Initializes the phone number ranges from the configuration file.
     */
    public function __construct()
    {
        $this->ranges = require __DIR__ . '/../config/geo_phone_ranges.php';
    }

    /**
     * Get the provider name for a given phone number.
     *
     * This method checks the given phone number and returns the provider name
     * based on predefined ranges. If no provider is found, an exception is thrown.
     *
     * @param int|string $phoneNumber The phone number to be checked
     * @return string The name of the provider
     * @throws RuntimeException If no provider is found for the phone number
     */
    public function getProvider($phoneNumber): string
    {
        $phoneNumber = $this->normalizeNumber($phoneNumber);

        foreach ($this->ranges as $provider => $ranges) {
            foreach ($ranges as $range) {
                if ($phoneNumber >= $range['start'] && $phoneNumber <= $range['end']) {
                    return $provider;
                }
            }
        }

        throw new RuntimeException("Provider not found for phone number: {$phoneNumber}");
    }

    /**
     * Check if a number belongs to Magti.
     *
     * @param int|string $phoneNumber The phone number to be checked
     * @return bool True if the number belongs to Magti, false otherwise
     * @throws Exception
     */
    public function isMagti($phoneNumber): bool
    {
        return $this->getProvider($phoneNumber) === 'Magti';
    }

    /**
     * Check if a number belongs to Silknet.
     *
     * @param int|string $phoneNumber The phone number to be checked
     * @return bool True if the number belongs to Silknet, false otherwise
     * @throws Exception
     */
    public function isSilknet($phoneNumber): bool
    {
        return $this->getProvider($phoneNumber) === 'Silknet';
    }

    /**
     * Check if a number belongs to Cellfie.
     *
     * @param int|string $phoneNumber The phone number to be checked
     * @return bool True if the number belongs to Cellfie, false otherwise
     * @throws Exception
     */
    public function isCellfie($phoneNumber): bool
    {
        return $this->getProvider($phoneNumber) === 'Cellfie';
    }

    /**
     * Format a phone number in different styles.
     *
     * The phone number is parsed and formatted according to the specified style.
     * Supported styles: "international", "national", "e164".
     *
     * @param int|string $phoneNumber The phone number to be formatted
     * @param string $format The desired format (optional, default is 'international')
     * @return string|null The formatted phone number, or null if parsing fails
     */
    public function formatNumber($phoneNumber, string $format = 'international'): ?string
    {
        $parsed = $this->parseNumber($phoneNumber);
        if (!$parsed) {
            return null;
        }

        $formats = [
            'national' => "{$parsed['prefix']} {$parsed['main']}",
            'e164' => "+995{$parsed['prefix']}{$parsed['main']}",
            'international' => "+995 {$parsed['prefix']} {$parsed['main']}",
            'rfc3966' => "tel:+995-{$parsed['prefix']}-{$parsed['main']}",
            'compact' => "995{$parsed['prefix']}{$parsed['main']}",
        ];

        return $formats[$format] ?? $formats['international'];
    }

    /**
     * Parse a phone number into components.
     *
     * This method breaks down the phone number into its main and full components.
     * If the number is invalid or too short, an exception is thrown.
     *
     * @param int|string $phoneNumber The phone number to be parsed
     * @return array An associative array with 'main' (main part) and 'full' (complete phone number)
     * @throws InvalidArgumentException If the phone number is invalid or too short
     */
    public function parseNumber($phoneNumber): array
    {
        $normalized = $this->normalizeNumber($phoneNumber);

        if (strlen($normalized) < 9) {
            throw new InvalidArgumentException("Phone number is too short after normalization: {$normalized}");
        }

        return [
            'main'   => substr($normalized, 6), // Extract the main part of the number
            'prefix' => substr($normalized, 3, 3),
            'full'   => $normalized, // The full normalized phone number
        ];
    }

    /**
     * Normalize phone numbers by removing non-numeric characters and ensuring the country code.
     *
     * This method ensures the phone number is normalized to a valid 12-character string.
     * If the number is invalid, an exception is thrown.
     *
     * @param int|string $phoneNumber The phone number to be normalized
     * @return string The normalized phone number
     * @throws InvalidArgumentException If the phone number is invalid
     */
    private function normalizeNumber($phoneNumber): string
    {
        // Remove non-numeric characters
        $phoneNumber = preg_replace('/\D/', '', (string)$phoneNumber);

        // Ensure the phone number starts with the Georgian country code '995'
        if (strpos($phoneNumber, '995') !== 0) {
            $phoneNumber = '995' . $phoneNumber;
        }

        // Validate that the phone number length is 12 characters
        if (strlen($phoneNumber) !== 12) {
            throw new InvalidArgumentException("Invalid phone number length: {$phoneNumber}. Expected 12 characters.");
        }

        return $phoneNumber;
    }
}
