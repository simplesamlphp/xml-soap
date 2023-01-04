<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP11\XML\env;

use DOMDocument;
use DOMElement;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\XML\env\Detail;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP11\XML\env\DetailTest
 *
 * @covers \SimpleSAML\SOAP11\XML\env\Detail
 * @covers \SimpleSAML\SOAP11\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
final class DetailTest extends TestCase
{
    use SerializableElementTestTrait;

    /** @var \DOMElement $DetailContent */
    private DOMElement $DetailContent;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = Detail::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/SOAP11/env_Detail.xml'
        );

        $this->DetailContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>'
        )->documentElement;
    }


    /**
     */
    public function testMarshalling(): void
    {
        $domAttr = $this->xmlRepresentation->createAttributeNS('urn:test:something', 'test:attr1');
        $domAttr->value = 'testval1';

        $detail = new Detail([new Chunk($this->DetailContent)], [$domAttr]);
        $this->assertFalse($detail->isEmptyElement());

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($detail)
        );
    }


    /**
     */
    public function testMarshallingWithNoContent(): void
    {
        $detail = new Detail([], []);
        $this->assertEquals(
            '<detail/>',
            strval($detail)
        );
        $this->assertTrue($detail->isEmptyElement());
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $detail = Detail::fromXML($this->xmlRepresentation->documentElement);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($detail)
        );
    }
}
