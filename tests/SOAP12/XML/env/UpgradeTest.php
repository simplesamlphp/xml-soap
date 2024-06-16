<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML\env;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\XML\env\AbstractSoapElement;
use SimpleSAML\SOAP12\XML\env\SupportedEnvelope;
use SimpleSAML\SOAP12\XML\env\Upgrade;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\env\UpgradeTest
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

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/soap-envelope-1.2.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/SOAP12/env_Upgrade.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $upgrade = new Upgrade([new SupportedEnvelope('env:SupportedEnvelope')]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($upgrade),
        );
    }
}
