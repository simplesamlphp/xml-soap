<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\XML\AbstractSoapElement;
use SimpleSAML\SOAP12\XML\Detail;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\{Chunk, DOMDocumentFactory};
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\DetailTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(Detail::class)]
#[CoversClass(AbstractSoapElement::class)]
final class DetailTest extends TestCase
{
    use SerializableElementTestTrait;

    /** @var \DOMElement $DetailContent */
    private static DOMElement $DetailContent;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Detail::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml//env/200305/Detail.xml',
        );

        self::$DetailContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>',
        )->documentElement;
    }


    /**
     */
    public function testMarshalling(): void
    {
        $domAttr = new Attribute('urn:test:something', 'test', 'attr1', StringValue::fromString('testval1'));

        $detail = new Detail([new Chunk(self::$DetailContent)], [$domAttr]);
        $this->assertFalse($detail->isEmptyElement());

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($detail),
        );
    }


    /**
     */
    public function testMarshallingWithNoContent(): void
    {
        $detail = new Detail([], []);
        $this->assertEquals(
            '<env:Detail xmlns:env="http://www.w3.org/2003/05/soap-envelope"/>',
            strval($detail),
        );
        $this->assertTrue($detail->isEmptyElement());
    }
}
