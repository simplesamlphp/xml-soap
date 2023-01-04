<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML\env;

use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\XML\env\Reason;
use SimpleSAML\SOAP12\XML\env\Text;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\env\ReasonTest
 *
 * @covers \SimpleSAML\SOAP12\XML\env\Reason
 * @covers \SimpleSAML\SOAP12\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
final class ReasonTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = Reason::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/SOAP12/env_Reason.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $reason = new Reason([
            new Text('en', 'It\'s broken'),
            new Text('nl', 'Het is stuk'),
        ]);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($reason)
        );
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $reason = Reason::fromXML($this->xmlRepresentation->documentElement);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($reason)
        );
    }
}
