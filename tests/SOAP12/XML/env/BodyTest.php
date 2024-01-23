<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML\env;

use DOMElement;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Exception\ProtocolViolationException;
use SimpleSAML\SOAP12\XML\env\Body;
use SimpleSAML\SOAP12\XML\env\Code;
use SimpleSAML\SOAP12\XML\env\Fault;
use SimpleSAML\SOAP12\XML\env\Reason;
use SimpleSAML\SOAP12\XML\env\Text;
use SimpleSAML\SOAP12\XML\env\Value;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\env\BodyTest
 *
 * @covers \SimpleSAML\SOAP12\XML\env\Body
 * @covers \SimpleSAML\SOAP12\XML\env\AbstractSoapElement
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
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Body::class;

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/soap-envelope-1.2.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/SOAP12/env_Body.xml'
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

        $body = new Body(null, [new Chunk(self::$BodyContent)], [$domAttr]);
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
        $body = new Body(null, [], []);
        $this->assertEquals(
            '<env:Body xmlns:env="http://www.w3.org/2003/05/soap-envelope/"/>',
            strval($body)
        );
        $this->assertTrue($body->isEmptyElement());
    }


    /**
     */
    public function testMarshallingWithFaultAndContent(): void
    {
        $this->expectException(ProtocolViolationException::class);
        new Body(
            new Fault(new Code(new Value('env:Sender')), new Reason([new Text('en', 'Something is wrong')])),
            [new Chunk(self::$BodyContent)],
            [],
        );
    }
}
