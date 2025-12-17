<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\XML\AbstractSoapElement;
use SimpleSAML\SOAP12\XML\Body;
use SimpleSAML\SOAP12\XML\Envelope;
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
 * Class \SimpleSAML\SOAP12\XML\EnvelopeTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(Envelope::class)]
#[CoversClass(AbstractSoapElement::class)]
final class EnvelopeTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    private static DOMElement $bodyContent;

    private static DOMElement $headerContent;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Envelope::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/env/200305/Envelope.xml',
        );

        self::$bodyContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>',
        )->documentElement;

        self::$headerContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>',
        )->documentElement;
    }


    /**
     */
    public function testMarshalling(): void
    {
        $domAttr = new Attribute('urn:test:something', 'test', 'attr1', StringValue::fromString('testval1'));

        $body = new Body(null, [new Chunk(self::$bodyContent)], [$domAttr]);
        $header = new Header([new Chunk(self::$headerContent)], [$domAttr]);

        $envelope = new Envelope($body, $header, [$domAttr]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($envelope),
        );
    }
}
