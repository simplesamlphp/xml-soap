<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\XML\env\Subcode;
use SimpleSAML\SOAP\XML\env\Value;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env\SubcodeTest
 *
 * @covers \SimpleSAML\SOAP\XML\env\Subcode
 * @covers \SimpleSAML\SOAP\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
final class SubcodeTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = Subcode::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/env_Subcode.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $subcode = new Subcode(new Value('m:SomethingNotFromSpec'), new Subcode(new Value('m:MessageTimeout')));

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($subcode)
        );
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $subcode = Subcode::fromXML($this->xmlRepresentation->documentElement);
        $this->assertEquals('m:SomethingNotFromSpec', $subcode->getValue()->getContent());

        $secondary = $subcode->getSubcode();
        $this->assertEquals('m:MessageTimeout', $secondary?->getValue()->getContent());
    }
}
