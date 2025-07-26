<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP11\XML;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\XML\AbstractSoapElement;
use SimpleSAML\SOAP11\XML\Header;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\{Chunk, DOMDocumentFactory};
use SimpleSAML\XML\TestUtils\{SchemaValidationTestTrait, SerializableElementTestTrait};
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP11\XML\HeaderTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(Header::class)]
#[CoversClass(AbstractSoapElement::class)]
final class HeaderTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;

    /** @var \DOMElement $headerContent */
    private static DOMElement $headerContent;


    /**
     */
    protected function setUp(): void
    {
        self::$testedClass = Header::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/env/200106/Header.xml',
        );

        self::$headerContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>',
        )->documentElement;
    }


    /**
     */
    public function testMarshalling(): void
    {
        $domAttr = new XMLAttribute('urn:test:something', 'test', 'attr1', StringValue::fromString('testval1'));

        $header = new Header([new Chunk(self::$headerContent)], [$domAttr]);
        $this->assertFalse($header->isEmptyElement());

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($header),
        );
    }


    /**
     */
    public function testMarshallingWithNoContent(): void
    {
        $header = new Header([], []);
        $this->assertEquals(
            '<SOAP-ENV:Header xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"/>',
            strval($header),
        );
        $this->assertTrue($header->isEmptyElement());
    }
}
