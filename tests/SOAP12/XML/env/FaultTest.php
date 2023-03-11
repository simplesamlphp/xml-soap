<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML\env;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as C;
use SimpleSAML\SOAP12\XML\env\Code;
use SimpleSAML\SOAP12\XML\env\Detail;
use SimpleSAML\SOAP12\XML\env\Fault;
use SimpleSAML\SOAP12\XML\env\Node;
use SimpleSAML\SOAP12\XML\env\Reason;
use SimpleSAML\SOAP12\XML\env\Role;
use SimpleSAML\SOAP12\XML\env\Subcode;
use SimpleSAML\SOAP12\XML\env\Text;
use SimpleSAML\SOAP12\XML\env\Value;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\env\FaultTest
 *
 * @covers \SimpleSAML\SOAP12\XML\env\Fault
 * @covers \SimpleSAML\SOAP12\XML\env\AbstractSoapElement
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

        $this->schema = dirname(__FILE__, 6) . '/schemas/soap-envelope-1.2.xsd';

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 5) . '/resources/xml/SOAP12/env_Fault.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $fault = new Fault(
            new Code(
                new Value('env:Sender'),
                new SubCode(new Value('m:MessageTimeout', 'http://www.example.org/timeouts'))
            ),
            new Reason([new Text('en', 'Sender Timeout')]),
            new Node('urn:x-simplesamlphp:namespace'),
            new Role('urn:x-simplesamlphp:namespace'),
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
