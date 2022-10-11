<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as C;
use SimpleSAML\SOAP\XML\env\Code;
use SimpleSAML\SOAP\XML\env\Detail;
use SimpleSAML\SOAP\XML\env\Fault;
use SimpleSAML\SOAP\XML\env\Node;
use SimpleSAML\SOAP\XML\env\Reason;
use SimpleSAML\SOAP\XML\env\Role;
use SimpleSAML\SOAP\XML\env\Subcode;
use SimpleSAML\SOAP\XML\env\Text;
use SimpleSAML\SOAP\XML\env\Value;
use SimpleSAML\Test\XML\SchemaValidationTestTrait;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env\FaultTest
 *
 * @covers \SimpleSAML\SOAP\XML\env\Fault
 * @covers \SimpleSAML\SOAP\XML\env\AbstractSoapElement
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

        $this->schema = dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/schemas/soap-envelope.xsd';

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/env_Fault.xml'
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

        $code = $fault->getCode();
        $this->assertEquals('env:Sender', $code->getValue()->getContent());

        $subcode = $code->getSubcode();
        $this->assertEquals('m:MessageTimeout', $subcode?->getValue()->getContent());

        $reason = $fault->getReason();
        $this->assertEquals('en', $reason->getText()[0]->getLanguage());
        $this->assertEquals('Sender Timeout', $reason->getText()[0]->getContent());

        $this->assertEquals('urn:x-simplesamlphp:namespace', $fault->getNode()?->getContent());
        $this->assertEquals('urn:x-simplesamlphp:namespace', $fault->getRole()?->getContent());

        $detail = $fault->getDetail();
        $this->assertNotNull($detail);
        $this->assertCount(1, $detail->getElements());
    }
}
