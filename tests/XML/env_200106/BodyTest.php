<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env_200106;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as C;
use SimpleSAML\SOAP\Exception\ProtocolViolationException;
use SimpleSAML\SOAP\XML\env_200106\AbstractSoapElement;
use SimpleSAML\SOAP\XML\env_200106\Body;
use SimpleSAML\SOAP\XML\env_200106\Fault;
use SimpleSAML\SOAP\XML\env_200106\FaultCode;
use SimpleSAML\SOAP\XML\env_200106\FaultString;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\{Chunk, DOMDocumentFactory};
use SimpleSAML\XML\TestUtils\{SchemaValidationTestTrait, SerializableElementTestTrait};
use SimpleSAML\XMLSchema\Type\Builtin\{QNameValue, StringValue};

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env_200106\BodyTest
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
    protected function setUp(): void
    {
        self::$testedClass = Body::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/env/200106/Body.xml',
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

        $body = new Body([new Chunk(self::$BodyContent)], [$domAttr]);
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
        $body = new Body([], []);
        $this->assertEquals(
            '<SOAP-ENV:Body xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"/>',
            strval($body),
        );
        $this->assertTrue($body->isEmptyElement());
    }


    /**
     */
    public function testMarshallingWithMultipleFaults(): void
    {
        $this->expectException(ProtocolViolationException::class);
        new Body(
            [
                new Fault(
                    new FaultCode(
                        QNameValue::fromString('{' . C::NS_SOAP_ENV_11 . '}SOAP-ENV:Sender'),
                    ),
                    new FaultString(
                        StringValue::fromString('Something is wrong'),
                    ),
                ),
                new Fault(
                    new FaultCode(
                        QNameValue::fromString('{' . C::NS_SOAP_ENV_11 . '}SOAP-ENV:Sender'),
                    ),
                    new FaultString(
                        StringValue::fromString('It is broken'),
                    ),
                ),
            ],
            [],
        );
    }
}
