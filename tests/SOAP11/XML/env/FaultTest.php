<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP11\XML\env;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as C;
use SimpleSAML\SOAP11\XML\env\Detail;
use SimpleSAML\SOAP11\XML\env\Fault;
use SimpleSAML\SOAP11\XML\env\FaultActor;
use SimpleSAML\SOAP11\XML\env\FaultCode;
use SimpleSAML\SOAP11\XML\env\FaultString;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP11\XML\env\FaultTest
 *
 * @covers \SimpleSAML\SOAP11\XML\env\Fault
 * @covers \SimpleSAML\SOAP11\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
final class FaultTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = Fault::class;

        $this->schema = dirname(__FILE__, 6) . '/schemas/soap-envelope-1.1.xsd';

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 5) . '/resources/xml/SOAP11/env_Fault.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $fault = new Fault(
            new FaultCode('env:Sender'),
            new FaultString('Something went wrong'),
            new FaultActor('urn:x-simplesamlphp:namespace'),
            new Detail([
                new Chunk(DOMDocumentFactory::fromString(
                    '<m:MaxTime xmlns:m="http://www.example.org/timeouts">P5M</m:MaxTime>'
                )->documentElement)
            ]),
        );

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($fault)
        );
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $fault = Fault::fromXML($this->xmlRepresentation->documentElement);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($fault)
        );
    }
}
