<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env;

use DOMDocument;
use DOMElement;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\XML\env\Body;
use SimpleSAML\SOAP\XML\env\Envelope;
use SimpleSAML\SOAP\XML\env\Header;
use SimpleSAML\Test\XML\SchemaValidationTestTrait;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\XML\Chunk;
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
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;

    /** @var \DOMElement $bodyContent */
    private DOMElement $bodyContent;

    /** @var \DOMElement $headerContent */
    private DOMElement $headerContent;

    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = Envelope::class;

        $this->schema = dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/schemas/soap-envelope.xsd';

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/env_Envelope.xml',
        );

        $this->bodyContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>'
        )->documentElement;

        $this->headerContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>'
        )->documentElement;
    }


    /**
     */
    public function testMarshalling(): void
    {
        $domAttr = $this->xmlRepresentation->createAttributeNS('urn:test:something', 'test:attr1');
        $domAttr->value = 'testval1';

        $body = new Body([new Chunk($this->bodyContent)], [$domAttr]);
        $header = new Header([new Chunk($this->headerContent)], [$domAttr]);

        $envelope = new Envelope($body, $header, [$domAttr]);

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

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($envelope),
        );
    }
}
