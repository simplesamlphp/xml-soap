<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env_200305;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\XML\env_200305\AbstractSoapElement;
use SimpleSAML\SOAP\XML\env_200305\Subcode;
use SimpleSAML\SOAP\XML\env_200305\Value;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\Builtin\QNameValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env_200305\SubcodeTest
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
            new Value(
                QNameValue::fromString('{https://www.w3schools.com/prices}m:SomethingNotFromSpec'),
            ),
            new Subcode(
                new Value(
                    QNameValue::fromString('{https://www.w3schools.com/prices}m:MessageTimeout'),
                ),
            ),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($subcode),
        );
    }
}
