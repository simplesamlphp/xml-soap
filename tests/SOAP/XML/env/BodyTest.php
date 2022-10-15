<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env;

use DOMDocument;
use DOMElement;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\XML\env\Body;
use SimpleSAML\Test\XML\SchemaValidationTestTrait;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env\BodyTest
 *
 * @covers \SimpleSAML\SOAP\XML\env\Body
 * @covers \SimpleSAML\SOAP\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
final class BodyTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;

    /** @var \DOMElement $BodyContent */
    private DOMElement $BodyContent;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = Body::class;

        $this->schema = dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/schemas/soap-envelope.xsd';

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/env_Body.xml'
        );

        $this->BodyContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>'
        )->documentElement;
    }


    /**
     */
    public function testMarshalling(): void
    {
        $domAttr = $this->xmlRepresentation->createAttributeNS('urn:test:something', 'test:attr1');
        $domAttr->value = 'testval1';

        $body = new Body([new Chunk($this->BodyContent)], [$domAttr]);
        $this->assertFalse($body->isEmptyElement());

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($body)
        );
    }


    /**
     */
    public function testMarshallingWithNoContent(): void
    {
        $body = new Body([], []);
        $this->assertEquals(
            '<env:Body xmlns:env="http://www.w3.org/2003/05/soap-envelope"/>',
            strval($body)
        );
        $this->assertTrue($body->isEmptyElement());
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $body = Body::fromXML($this->xmlRepresentation->documentElement);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($body)
        );
    }
}
