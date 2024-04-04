<?php

declare(strict_types=1);

namespace MLocati\Nexi\Test\Cases;

use MLocati\Nexi\Entity\Error;
use MLocati\Nexi\Entity\Errors;
use PHPUnit\Framework\TestCase;

class CloneTest extends TestCase
{
    public function testCloning(): void
    {
        $expectedJson = '{"errors":[{"code":"01","description":"ZeroOne"}]}';
        $error = new Error();
        $error
            ->setCode('01')
            ->setDescription('ZeroOne')
        ;
        $errors = new Errors();
        $errors->setErrors([$error]);
        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($errors));
        $errorsClone = clone $errors;
        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($errorsClone));
        $this->assertEquals($errors, $errorsClone);
        $this->assertNotSame($errors, $errorsClone);
        $this->assertEquals($errors->getErrors(), $errorsClone->getErrors());
        $this->assertNotSame($errors->getErrors(), $errorsClone->getErrors());
        $error->setCode('02');
        $this->assertNotEquals($errors, $errorsClone);
        $this->assertNotEquals($errors->getErrors(), $errorsClone->getErrors());
    }
}
