<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env;

use DOMDocument;
use DOMElement;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\XML\env\Header;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env\HeaderTest
 *
 * @covers \SimpleSAML\SOAP\XML\env\Header
 * @covers \SimpleSAML\SOAP\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
final class HeaderTest extends TestCase
{
    use SerializableElementTestTrait;

    /** @var \DOMElement $headerContent */
    private DOMElement $headerContent;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = Header::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/env_Header.xml'
        );

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

        $header = new Header([new Chunk($this->headerContent)], [$domAttr]);
        $this->assertFalse($header->isEmptyElement());

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($header)
        );
    }


    /**
     */
    public function testMarshallingWithNoContent(): void
    {
        $header = new Header([], []);
        $this->assertEquals(
            '<env:Header xmlns:env="http://www.w3.org/2003/05/soap-envelope"/>',
            strval($header)
        );
        $this->assertTrue($header->isEmptyElement());
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $header = Header::fromXML($this->xmlRepresentation->documentElement);

        $elements = $header->getElements();
        $this->assertFalse($header->isEmptyElement());
        $this->assertCount(1, $elements);

        $attributes = $header->getAttributesNS();
        $this->assertCount(1, $attributes);

        $attribute = end($attributes);
        $this->assertEquals('test:attr1', $attribute['qualifiedName']);
        $this->assertEquals('urn:test:something', $attribute['namespaceURI']);
        $this->assertEquals('testval1', $attribute['value']);
    }
}
