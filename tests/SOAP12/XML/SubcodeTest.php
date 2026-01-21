<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\XML\AbstractSoapElement;
use SimpleSAML\SOAP12\XML\Subcode;
use SimpleSAML\SOAP12\XML\Value;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\SubcodeTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(Subcode::class)]
#[CoversClass(AbstractSoapElement::class)]
final class SubcodeTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Subcode::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/env/200305/Subcode.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $subcode = new Subcode(
            Value::fromString('{https://www.w3schools.com/prices}m:SomethingNotFromSpec'),
            new Subcode(
                Value::fromString('{https://www.w3schools.com/prices}m:MessageTimeout'),
            ),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($subcode),
        );
    }
}
