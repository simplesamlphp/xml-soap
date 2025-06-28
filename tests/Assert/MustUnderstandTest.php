<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\Assert;

use PHPUnit\Framework\Attributes\{CoversClass, DataProvider};
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\SOAP\Assert\Assert;

/**
 * Class \SimpleSAML\Test\SOAP\Assert\MustUnderstandTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(Assert::class)]
final class MustUnderstandTest extends TestCase
{
    /**
     * @param boolean $shouldPass
     * @param string $mustUnderstand
     */
    #[DataProvider('provideInvalidMustUnderstand')]
    #[DataProvider('provideValidMustUnderstand')]
    public function testValidMustUnderstand(bool $shouldPass, string $mustUnderstand): void
    {
        try {
            Assert::validMustUnderstand($mustUnderstand);
            $this->assertTrue($shouldPass);
        } catch (AssertionFailedException $e) {
            $this->assertFalse($shouldPass);
        }
    }


    /**
     * @return array<string, array{0: true, 1: string}>
     */
    public static function provideValidMustUnderstand(): array
    {
        return [
            'one' => [true, '1'],
            'zero' => [true, '0'],
        ];
    }


    /**
     * @return array<string, array{0: false, 1: string}>
     */
    public static function provideInvalidMustUnderstand(): array
    {
        return [
            'true' => [false, 'true'],
            'false' => [false, 'false'],
            'vrai' => [false, 'vrai'],
            'faux' => [false, 'faux'],
        ];
    }
}
