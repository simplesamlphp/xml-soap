<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP11\XML\env;

use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\XML\env\FaultString;
use SimpleSAML\SOAP11\XML\env\Text;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP11\XML\env\FaultStringTest
 *
 * @covers \SimpleSAML\SOAP11\XML\env\FaultString
 * @covers \SimpleSAML\SOAP11\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
final class FaultStringTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = FaultString::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/SOAP11/env_FaultString.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $faultString = new FaultString('Something went wrong');

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($faultString)
        );
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $faultString = FaultString::fromXML($this->xmlRepresentation->documentElement);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($faultString)
        );
    }
}
