<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as C;
use SimpleSAML\SOAP\XML\env\Code;
use SimpleSAML\SOAP\XML\env\Subcode;
use SimpleSAML\SOAP\XML\env\Value;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env\CodeTest
 *
 * @covers \SimpleSAML\SOAP\XML\env\Code
 * @covers \SimpleSAML\SOAP\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
final class CodeTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = Code::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/env_Code.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $code = new Code(
            new Value('env:Sender', C::NS_SOAP_ENV),
            new Subcode(
                new Value('m:SomethingNotFromSpec', 'http://www.example.org/timeouts'),
                new Subcode(new Value('m:MessageTimeout', 'http://www.example.org/timeouts')),
            ),
        );

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($code)
        );
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $code = Code::fromXML($this->xmlRepresentation->documentElement);

        $value = $code->getValue();
        $this->assertEquals('env:Sender', $value->getContent());

        $subcode = $code->getSubcode();
        $this->assertNotNull($subcode);
        $this->assertEquals('m:SomethingNotFromSpec', $subcode->getValue()->getContent());

        $secondary = $subcode->getSubcode();
        $this->assertEquals('m:MessageTimeout', $secondary?->getValue()->getContent());
    }
}
