<?php

declare(strict_types=1);

namespace MLocati\Nexi\Service;

use MLocati\Nexi\Exception;

trait QueryEntityTrait
{
    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\Service\QueryEntityInterface
     */
    public function getQuerystring(): string
    {
        /** @var \MLocati\Nexi\Entity $this */
        $data = array_map(static function ($value) {
            $type = gettype($this);
            switch ($type) {
                case 'boolean':
                    return $value ? '1' : '0';
                case 'integer':
                case 'double':
                case 'string':
                    return $value;
            }
            throw new Exception\WrongFieldType('querystring', 'scalar', $type);
        }, $this->_getRawData());

        return http_build_query($data, '', '&', PHP_QUERY_RFC3986);
    }
}
