<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML\env;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\XML\env\AbstractSoapElement;
use SimpleSAML\SOAP12\XML\env\Subcode;
use SimpleSAML\SOAP12\XML\env\Value;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\env\SubcodeTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(Subcode::class)]
#[CoversClass(AbstractSoapElement::class)]
final class SubcodeTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Subcode::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/SOAP12/env_Subcode.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $subcode = new Subcode(new Value('m:SomethingNotFromSpec'), new Subcode(new Value('m:MessageTimeout')));

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($subcode),
        );
    }
}
