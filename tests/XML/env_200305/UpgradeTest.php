<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env_200305;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\XML\env_200305\AbstractSoapElement;
use SimpleSAML\SOAP\XML\env_200305\SupportedEnvelope;
use SimpleSAML\SOAP\XML\env_200305\Upgrade;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\{SchemaValidationTestTrait, SerializableElementTestTrait};
use SimpleSAML\XMLSchema\Type\Builtin\QNameValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env_200305\UpgradeTest
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
