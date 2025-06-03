<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env_200305;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as C;
use SimpleSAML\SOAP\Exception\ProtocolViolationException;
use SimpleSAML\SOAP\XML\env_200305\AbstractSoapElement;
use SimpleSAML\SOAP\XML\env_200305\Body;
use SimpleSAML\SOAP\XML\env_200305\Code;
use SimpleSAML\SOAP\XML\env_200305\Fault;
use SimpleSAML\SOAP\XML\env_200305\Reason;
use SimpleSAML\SOAP\XML\env_200305\Text;
use SimpleSAML\SOAP\XML\env_200305\Value;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\{Chunk, DOMDocumentFactory};
use SimpleSAML\XML\TestUtils\{SchemaValidationTestTrait, SerializableElementTestTrait};
use SimpleSAML\XML\Type\{LanguageValue, QNameValue, StringValue};

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env_200305\BodyTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(Body::class)]
#[CoversClass(AbstractSoapElement::class)]
final class BodyTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;

    /** @var \DOMElement $BodyContent */
    private static DOMElement $BodyContent;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Body::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/env/200305/Body.xml',
        );

        self::$BodyContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>',
        )->documentElement;
    }


    /**
     */
    public function testMarshalling(): void
    {
        $domAttr = new XMLAttribute('urn:test:something', 'test', 'attr1', StringValue::fromString('testval1'));

        $body = new Body(null, [new Chunk(self::$BodyContent)], [$domAttr]);
        $this->assertFalse($body->isEmptyElement());

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($body),
        );
    }


    /**
     */
    public function testMarshallingWithNoContent(): void
    {
        $body = new Body(null, [], []);
        $this->assertEquals(
            '<env:Body xmlns:env="http://www.w3.org/2003/05/soap-envelope"/>',
            strval($body),
        );
        $this->assertTrue($body->isEmptyElement());
    }


    /**
     */
    public function testMarshallingWithFaultAndContent(): void
    {
        $this->expectException(ProtocolViolationException::class);
        new Body(
            new Fault(
                new Code(
                    new Value(
                        QNameValue::fromString('{' . C::NS_SOAP_ENV_12 . '}env:Sender'),
                    ),
                ),
                new Reason([
                    new Text(
                        LanguageValue::fromString('en'),
                        StringValue::fromString('Something is wrong'),
                    ),
                ]),
            ),
            [new Chunk(self::$BodyContent)],
            [],
        );
    }
}
