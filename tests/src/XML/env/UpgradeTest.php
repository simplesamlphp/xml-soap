<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\XML\env\SupportedEnvelope;
use SimpleSAML\SOAP\XML\env\Upgrade;
use SimpleSAML\Test\XML\SchemaValidationTestTrait;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env\UpgradeTest
 *
 * @covers \SimpleSAML\SOAP\XML\env\Upgrade
 * @covers \SimpleSAML\SOAP\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
final class UpgradeTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = Upgrade::class;

        $this->schema = dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/schemas/soap-envelope.xsd';

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/env_Upgrade.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $upgrade = new Upgrade([new SupportedEnvelope('env:SupportedEnvelope')]);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($upgrade)
        );
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $upgrade = Upgrade::fromXML($this->xmlRepresentation->documentElement);
        $this->assertEquals('env:SupportedEnvelope', $upgrade->getSupportedEnvelope()[0]->getQName());
    }
}
