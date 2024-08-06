<?php

// src/Utils/DateTimeUtils.php

namespace App\Utils;

class DateTimeUtils
{
    /**
     * Converts a date input to a DateTime object.
     *
     * @param string|int|null $dateInput The date input, which can be an ISO 8601 string, a timestamp, or null.
     * @return \DateTime|null The DateTime object or null if the input is invalid.
     */
    public static function convertToDateTime($dateInput): ?\DateTime
    {
        if (is_null($dateInput)) {
            return null;
        }

        // Check if the input is a timestamp
        if (is_numeric($dateInput)) {
            return (new \DateTime())->setTimestamp($dateInput);
        }

        // Check if the input is a valid ISO 8601 date string
        try {
            return new \DateTime($dateInput);
        } catch (\Exception $e) {
            return null;
        }
    }
}
