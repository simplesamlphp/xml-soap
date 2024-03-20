<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP11\XML\env;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\XML\env\AbstractSoapElement;
use SimpleSAML\SOAP11\XML\env\FaultString;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP11\XML\env\FaultStringTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(FaultString::class)]
#[CoversClass(AbstractSoapElement::class)]
final class FaultStringTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = FaultString::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/SOAP11/env_FaultString.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $faultString = new FaultString('Something went wrong');

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($faultString)
        );
    }
}
