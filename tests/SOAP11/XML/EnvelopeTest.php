<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP11\XML;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\XML\AbstractSoapElement;
use SimpleSAML\SOAP11\XML\Body;
use SimpleSAML\SOAP11\XML\Envelope;
use SimpleSAML\SOAP11\XML\Header;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\{Chunk, DOMDocumentFactory};
use SimpleSAML\XML\TestUtils\{SchemaValidationTestTrait, SerializableElementTestTrait};
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP11\XML\EnvelopeTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(Envelope::class)]
#[CoversClass(AbstractSoapElement::class)]
final class EnvelopeTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;

    /** @var \DOMElement $bodyContent */
    private static DOMElement $bodyContent;

    /** @var \DOMElement $headerContent */
    private static DOMElement $headerContent;

    /** @var \DOMElement $envelopeContent */
    private static DOMElement $envelopeContent;

    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Envelope::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/env/200106/Envelope.xml',
        );

        self::$headerContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>',
        )->documentElement;

        self::$bodyContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Pears</m:Item></m:GetPrice>',
        )->documentElement;

        self::$envelopeContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Bananas</m:Item></m:GetPrice>',
        )->documentElement;
    }


    /**
     */
    public function testMarshalling(): void
    {
        $domAttr = new XMLAttribute('urn:test:something', 'test', 'attr1', StringValue::fromString('testval1'));

        $body = new Body([new Chunk(self::$bodyContent)], [$domAttr]);
        $header = new Header([new Chunk(self::$headerContent)], [$domAttr]);

        $envelope = new Envelope($body, $header, [new Chunk(self::$envelopeContent)], [$domAttr]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($envelope),
        );
    }
}
