<?php

declare(strict_types=1);

namespace Dvdam\Events\Model\Utils;

/**
 * Class Validators
 */
class Validators
{
    public const MIN = 3;
    public const MAX = 200;

    /**
     * Valid string Len
     *
     * @param string $str
     * @param int $min
     * @param int $max
     * @return bool
     */
    public function notValidStrLen(string $str, int $min, int $max): bool
    {
        $len = strlen($str);
        if ($len < $min) {
            return true;
        } elseif ($len > $max) {
            return true;
        }

        return false;
    }

    /**
     * Valid not Special Characters values
     *
     * @param string $value
     * @return bool
     */
    public function notSpecialCharacters(string $value): bool
    {
        $len = strlen($value);
        if ($len > 0) {
            if (!preg_match('/^[0-9A-Za-z]*$/', $value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Valid not Only Text values
     *
     * @param string $value
     * @return bool
     */
    public function notOnlyText(string $value): bool
    {
        if (!preg_match('/^[-a-zA-Z0-9 .]+$/', $value)) {
            return true;
        }
        return false;
    }

    /**
     * Sanitize String Values
     *
     * @param string $value
     * @return string
     */
    public function sanitazeValue(string $value): string
    {
        return trim(strip_tags($value));
    }
}
