<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env_200305;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\XML\env_200305\AbstractSoapElement;
use SimpleSAML\SOAP\XML\env_200305\Body;
use SimpleSAML\SOAP\XML\env_200305\Envelope;
use SimpleSAML\SOAP\XML\env_200305\Header;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\{Chunk, DOMDocumentFactory};
use SimpleSAML\XML\TestUtils\{SchemaValidationTestTrait, SerializableElementTestTrait};
use SimpleSAML\XMLSchema\Type\Builtin\StringValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env_200305\EnvelopeTest
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
