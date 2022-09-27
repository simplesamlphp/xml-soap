<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\XML\env\SupportedEnvelope;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env\SupportedEnvelopeTest
 *
 * @covers \SimpleSAML\SOAP\XML\env\SupportedEnvelope
 * @covers \SimpleSAML\SOAP\XML\env\AbstractSoapElement
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
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/env_SupportedEnvelope.xml'
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
        $this->assertEquals('ssp:Chunk', $supportedEnvelope->getQName());
    }
}
