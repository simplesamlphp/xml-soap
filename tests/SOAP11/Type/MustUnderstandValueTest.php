<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP11\Type;

use PHPUnit\Framework\Attributes\{CoversClass, DataProvider, DataProviderExternal, DependsOnClass};
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\Constants as C;
use SimpleSAML\SOAP11\Type\MustUnderstandValue;
use SimpleSAML\Test\SOAP11\Assert\MustUnderstandTest;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;

/**
 * Class \SimpleSAML\Test\SOAP11\Type\MustUnderstandValueTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(MustUnderstandValue::class)]
final class MustUnderstandValueTest extends TestCase
{
    /**
     * @param boolean $shouldPass
     * @param string $mustUnderstand
     */
    #[DataProvider('provideInvalidMustUnderstand')]
    #[DataProvider('provideValidMustUnderstand')]
    #[DataProviderExternal(MustUnderstandTest::class, 'provideValidMustUnderstand')]
    #[DependsOnClass(MustUnderstandTest::class)]
    public function testMustUnderstand(bool $shouldPass, string $mustUnderstand): void
    {
        try {
            MustUnderstandValue::fromString($mustUnderstand);
            $this->assertTrue($shouldPass);
        } catch (SchemaViolationException $e) {
            $this->assertFalse($shouldPass);
        }
    }


    /**
     * Test helpers
     */
    public function testHelpers(): void
    {
        $x = MustUnderstandValue::fromBoolean(false);
        $this->assertFalse($x->toBoolean());

        $y = MustUnderstandValue::fromString('1');
        $this->assertTrue($y->toBoolean());

        //
        $mustUnderstand = MustUnderstandValue::fromString('1');
        $attr = $mustUnderstand->toAttribute();

        $this->assertEquals($attr->getNamespaceURI(), C::NS_SOAP_ENV);
        $this->assertEquals($attr->getNamespacePrefix(), 'SOAP-ENV');
        $this->assertEquals($attr->getAttrName(), 'mustUnderstand');
        $this->assertEquals($attr->getAttrValue(), '1');
    }


    /**
     * @return array<string, array{0: true, 1: string}>
     */
    public static function provideValidMustUnderstand(): array
    {
        return [
            'whitespace collapse true' => [true, " 1 \n"],
            'whitespace collapse false' => [true, " 0 \n"],
        ];
    }


    /**
     * @return array<string, array{0: false, 1: string}>
     */
    public static function provideInvalidMustUnderstand(): array
    {
        return [
            'vrai' => [false, 'vrai'],
            'faux' => [false, 'faux'],
        ];
    }
}
