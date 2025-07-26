<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP11\XML;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\XML\AbstractSoapElement;
use SimpleSAML\SOAP11\XML\FaultString;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP11\XML\FaultStringTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(FaultString::class)]
#[CoversClass(AbstractSoapElement::class)]
final class FaultStringTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = FaultString::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/env/200106/FaultString.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $faultString = new FaultString(
            StringValue::fromString('Something went wrong'),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($faultString),
        );
    }
}
