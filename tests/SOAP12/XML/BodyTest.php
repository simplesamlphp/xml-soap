<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\Constants as C;
use SimpleSAML\SOAP12\Exception\ProtocolViolationException;
use SimpleSAML\SOAP12\XML\AbstractSoapElement;
use SimpleSAML\SOAP12\XML\Body;
use SimpleSAML\SOAP12\XML\Code;
use SimpleSAML\SOAP12\XML\Fault;
use SimpleSAML\SOAP12\XML\Reason;
use SimpleSAML\SOAP12\XML\Text;
use SimpleSAML\SOAP12\XML\Value;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XML\Type\LangValue;
use SimpleSAML\XMLSchema\Type\QNameValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\BodyTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(Body::class)]
#[CoversClass(AbstractSoapElement::class)]
final class BodyTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


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
                        QNameValue::fromString('{' . C::NS_SOAP_ENV . '}env:Sender'),
                    ),
                ),
                new Reason([
                    new Text(
                        LangValue::fromString('en'),
                        StringValue::fromString('Something is wrong'),
                    ),
                ]),
            ),
            [new Chunk(self::$BodyContent)],
            [],
        );
    }
}
