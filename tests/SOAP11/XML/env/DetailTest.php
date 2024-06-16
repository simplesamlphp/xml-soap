<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP11\XML\env;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\XML\env\AbstractSoapElement;
use SimpleSAML\SOAP11\XML\env\Detail;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP11\XML\env\DetailTest
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
            dirname(__FILE__, 4) . '/resources/xml/SOAP11/env_Detail.xml',
        );

        self::$DetailContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>',
        )->documentElement;
    }


    /**
     */
    public function testMarshalling(): void
    {
        $domAttr = new Attribute('urn:test:something', 'test', 'attr1', 'testval1');

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
            '<detail/>',
            strval($detail),
        );
        $this->assertTrue($detail->isEmptyElement());
    }
}
