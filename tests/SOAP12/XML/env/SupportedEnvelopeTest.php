<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML\env;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\XML\env\SupportedEnvelope;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\env\SupportedEnvelopeTest
 *
 * @covers \SimpleSAML\SOAP12\XML\env\SupportedEnvelope
 * @covers \SimpleSAML\SOAP12\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
final class SupportedEnvelopeTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = SupportedEnvelope::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 5) . '/resources/xml/SOAP12/env_SupportedEnvelope.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $supportedEnvelope = new SupportedEnvelope('ssp:Chunk');

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($supportedEnvelope)
        );
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $supportedEnvelope = SupportedEnvelope::fromXML($this->xmlRepresentation->documentElement);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($supportedEnvelope)
        );
    }
}
