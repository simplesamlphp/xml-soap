<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP11\XML;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\Constants as C;
use SimpleSAML\SOAP11\XML\AbstractSoapElement;
use SimpleSAML\SOAP11\XML\Detail;
use SimpleSAML\SOAP11\XML\Fault;
use SimpleSAML\SOAP11\XML\FaultActor;
use SimpleSAML\SOAP11\XML\FaultCode;
use SimpleSAML\SOAP11\XML\FaultString;
use SimpleSAML\XML\{Chunk, DOMDocumentFactory};
use SimpleSAML\XML\TestUtils\{SchemaValidationTestTrait, SerializableElementTestTrait};
use SimpleSAML\XMLSchema\Type\{AnyURIValue, QNameValue, StringValue};

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP11\XML\FaultTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(Fault::class)]
#[CoversClass(AbstractSoapElement::class)]
final class FaultTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Fault::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/env/200106/Fault.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $fault = new Fault(
            new FaultCode(
                QNameValue::fromString('{' . C::NS_SOAP_ENV . '}SOAP-ENV:Sender'),
            ),
            new FaultString(
                StringValue::fromString('Something went wrong'),
            ),
            new FaultActor(
                AnyURIValue::fromString('urn:x-simplesamlphp:namespace'),
            ),
            new Detail([
                new Chunk(DOMDocumentFactory::fromString(
                    '<m:MaxTime xmlns:m="http://www.example.org/timeouts">P5M</m:MaxTime>',
                )->documentElement),
            ]),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($fault),
        );
    }
}
