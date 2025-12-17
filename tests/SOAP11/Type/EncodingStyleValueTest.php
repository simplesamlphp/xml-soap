<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP11\Type;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\Type\EncodingStyleValue;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;

/**
 * Class \SimpleSAML\Test\SOAP11\Type\EncodingStyleValueTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(EncodingStyleValue::class)]
final class EncodingStyleValueTest extends TestCase
{
    /**
     */
    #[DataProvider('provideEncodingStyle')]
    public function testEncodingStyleValue(string $encodingStyle, bool $shouldPass): void
    {
        try {
            EncodingStyleValue::fromString($encodingStyle);
            $this->assertTrue($shouldPass);
        } catch (SchemaViolationException $e) {
            $this->assertFalse($shouldPass);
        }
    }


    /**
     * @return array<string, array{0: string, 1: bool}>
     */
    public static function provideEncodingStyle(): array
    {
        return [
            'one value' => ['urn:x-simplesamlphp:namespace', true],
            'multiple spaces and newlines' => [
                "urn:x-simplesamlphp:namespace1  urn:x-simplesamlphp:namespace2 \n urn:x-simplesamlphp:namespace3",
                true,
            ],
            'empty string' => ['""', true],
            'empty list' => ['', false],
        ];
    }
}
