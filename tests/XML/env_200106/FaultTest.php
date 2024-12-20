<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env_200106;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\XML\env_200106\AbstractSoapElement;
use SimpleSAML\SOAP\XML\env_200106\Detail;
use SimpleSAML\SOAP\XML\env_200106\Fault;
use SimpleSAML\SOAP\XML\env_200106\FaultActor;
use SimpleSAML\SOAP\XML\env_200106\FaultCode;
use SimpleSAML\SOAP\XML\env_200106\FaultString;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env_200106\FaultTest
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
            new FaultCode('SOAP-ENV:Sender'),
            new FaultString('Something went wrong'),
            new FaultActor('urn:x-simplesamlphp:namespace'),
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
