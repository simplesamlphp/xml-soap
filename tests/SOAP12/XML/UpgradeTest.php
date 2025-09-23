<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\XML\AbstractSoapElement;
use SimpleSAML\SOAP12\XML\SupportedEnvelope;
use SimpleSAML\SOAP12\XML\Upgrade;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\QNameValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\UpgradeTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(Upgrade::class)]
#[CoversClass(AbstractSoapElement::class)]
final class UpgradeTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Upgrade::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/env/200305/Upgrade.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $upgrade = new Upgrade([
            new SupportedEnvelope(QNameValue::fromString('{' . SupportedEnvelope::NS . '}env:SupportedEnvelope')),
        ]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($upgrade),
        );
    }
}
