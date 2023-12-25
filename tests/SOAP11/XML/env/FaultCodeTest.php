<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP11\XML\env;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\XML\env\FaultCode;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP11\XML\env\FaultCodeTest
 *
 * @covers \SimpleSAML\SOAP11\XML\env\FaultCode
 * @covers \SimpleSAML\SOAP11\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
final class FaultCodeTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = FaultCode::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/SOAP11/env_FaultCode.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $faultCode = new FaultCode('env:Sender');

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($faultCode)
        );
    }
}
