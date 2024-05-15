<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Service;

use MLocati\Nexi\XPayWeb\Exception;

trait QueryEntityTrait
{
    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\XPayWeb\Service\QueryEntityInterface
     */
    public function getQuerystring(): string
    {
        $data = (array) $this->_getRawData();
        $params = array_map(
            static function ($value) {
                $type = gettype($value);
                switch ($type) {
                    case 'boolean':
                        return $value ? '1' : '0';
                    case 'integer':
                    case 'double':
                    case 'string':
                        return $value;
                }
                throw new Exception\WrongFieldType('querystring', 'scalar', $value);
            },
            $data
        );

        return http_build_query($params, '', '&', PHP_QUERY_RFC3986);
    }
}
