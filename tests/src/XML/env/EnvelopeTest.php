<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env;

use DOMDocument;
use DOMElement;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\XML\env\Body;
use SimpleSAML\SOAP\XML\env\Envelope;
use SimpleSAML\SOAP\XML\env\Header;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env\EnvelopeTest
 *
 * @covers \SimpleSAML\SOAP\XML\env\Envelope
 * @covers \SimpleSAML\SOAP\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
final class EnvelopeTest extends TestCase
{
    use SerializableElementTestTrait;

    /** @var \DOMDocument $body */
    private DOMDocument $body;

    /** @var \DOMDocument $header */
    private DOMDocument $header;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = Envelope::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/env_Envelope.xml',
        );

        $this->body = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/env_Body.xml',
        );

        $this->header = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/env_Header.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $domAttr = $this->xmlRepresentation->createAttributeNS('urn:test:something', 'test:attr1');
        $domAttr->value = 'testval1';

        $envelope = new Envelope(
            Body::fromXML($this->body->documentElement),
            Header::fromXML($this->header->documentElement),
            [$domAttr],
        );

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($envelope),
        );
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $envelope = Envelope::fromXML($this->xmlRepresentation->documentElement);

        $header = $envelope->getHeader();
        $this->assertNotNull($header);

        $body = $envelope->getBody();
        $this->assertNotNull($body);

        $attributes = $envelope->getAttributesNS();
        $this->assertCount(1, $attributes);

        $attribute = end($attributes);
        $this->assertEquals('test:attr1', $attribute['qualifiedName']);
        $this->assertEquals('urn:test:something', $attribute['namespaceURI']);
        $this->assertEquals('testval1', $attribute['value']);
    }
}
