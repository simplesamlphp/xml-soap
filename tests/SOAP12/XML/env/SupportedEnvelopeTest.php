<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML\env;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\XML\env\AbstractSoapElement;
use SimpleSAML\SOAP12\XML\env\SupportedEnvelope;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\env\SupportedEnvelopeTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(SupportedEnvelope::class)]
#[CoversClass(AbstractSoapElement::class)]
final class SupportedEnvelopeTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = SupportedEnvelope::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/SOAP12/env_SupportedEnvelope.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $supportedEnvelope = new SupportedEnvelope('ssp:Chunk');

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($supportedEnvelope),
        );
    }
}
