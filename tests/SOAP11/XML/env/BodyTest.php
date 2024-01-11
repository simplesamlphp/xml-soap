<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP11\XML\env;

use DOMElement;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Exception\ProtocolViolationException;
use SimpleSAML\SOAP11\XML\env\Body;
use SimpleSAML\SOAP11\XML\env\Fault;
use SimpleSAML\SOAP11\XML\env\FaultCode;
use SimpleSAML\SOAP11\XML\env\FaultString;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP11\XML\env\BodyTest
 *
 * @covers \SimpleSAML\SOAP11\XML\env\Body
 * @covers \SimpleSAML\SOAP11\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
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

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/soap-envelope-1.1.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/SOAP11/env_Body.xml'
        );

        self::$BodyContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>'
        )->documentElement;
    }


    /**
     */
    public function testMarshalling(): void
    {
        $domAttr = new Attribute('urn:test:something', 'test', 'attr1', 'testval1');

        $body = new Body([new Chunk(self::$BodyContent)], [$domAttr]);
        $this->assertFalse($body->isEmptyElement());

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($body)
        );
    }


    /**
     */
    public function testMarshallingWithNoContent(): void
    {
        $body = new Body([], []);
        $this->assertEquals(
            '<env:Body xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"/>',
            strval($body)
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
                new Fault(new FaultCode('env:Sender'), new FaultString('Something is wrong')),
                new Fault(new FaultCode('env:Sender'), new FaultString('It is broken')),
            ],
            [],
        );
    }
}
