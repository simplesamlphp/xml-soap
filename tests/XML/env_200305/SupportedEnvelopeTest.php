<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env_200305;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\XML\env_200305\AbstractSoapElement;
use SimpleSAML\SOAP\XML\env_200305\SupportedEnvelope;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\Builtin\QNameValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env_200305\SupportedEnvelopeTest
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
            dirname(__FILE__, 3) . '/resources/xml/env/200305/SupportedEnvelope.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $supportedEnvelope = new SupportedEnvelope(
            QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:Chunk'),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($supportedEnvelope),
        );
    }
}
