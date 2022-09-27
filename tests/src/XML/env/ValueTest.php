<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\XML\env\Value;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env\ValueTest
 *
 * @covers \SimpleSAML\SOAP\XML\env\Value
 * @covers \SimpleSAML\SOAP\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
final class ValueTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = Value::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/env_Value.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $value = new Value(Value::NS_PREFIX . ':Sender');

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($value)
        );
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $value = Value::fromXML($this->xmlRepresentation->documentElement);
        $this->assertEquals(Value::NS_PREFIX . ':Sender', $value->getContent());
    }
}
