<?php

declare(strict_types=1);

namespace MLocati\Nexi\Exception;

use MLocati\Nexi\Exception;

/**
 * Exception thrown when decoding a JSON string failed
 */
class InvalidJson extends Exception
{
    /**
     * @var string
     */
    private $invalidJson;

    public function __construct(string $invalidJson, ?string $message = null, ?int $code = null)
    {
        $this->invalidJson = $invalidJson;
        if ($code === null) {
            $code = json_last_error();
            if (!is_int($code)) {
                $code = null;
            }
        }
        if ($message === null) {
            $message = 'Unable to parse the string as JSON';
            $why = trim((string) json_last_error_msg());
            if ($why === '') {
                if ($code !== null && $code !== JSON_ERROR_NONE) {
                    $why = "Error code: {$code}";
                }
            }
            if ($why !== '') {
                $message .= " ({$why})";
            }
        }
        parent::__construct($message, $code ?? 0);
    }

    /**
     * Get the string that couldn't be decoded as JSON.
     */
    public function getInvalidJson(): string
    {
        return $this->invalidJson;
    }
}
