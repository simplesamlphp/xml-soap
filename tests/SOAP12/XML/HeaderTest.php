<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\XML\AbstractSoapElement;
use SimpleSAML\SOAP12\XML\Header;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\HeaderTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(Header::class)]
#[CoversClass(AbstractSoapElement::class)]
final class HeaderTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    private static DOMElement $headerContent;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Header::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/env/200305/Header.xml',
        );

        self::$headerContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>',
        )->documentElement;
    }


    /**
     */
    public function testMarshalling(): void
    {
        $domAttr = new Attribute('urn:test:something', 'test', 'attr1', StringValue::fromString('testval1'));

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
            '<env:Header xmlns:env="http://www.w3.org/2003/05/soap-envelope"/>',
            strval($header),
        );
        $this->assertTrue($header->isEmptyElement());
    }
}
