<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP11\XML;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\Constants as C;
use SimpleSAML\SOAP11\XML\AbstractSoapElement;
use SimpleSAML\SOAP11\XML\FaultCode;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP11\XML\FaultCodeTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(FaultCode::class)]
#[CoversClass(AbstractSoapElement::class)]
final class FaultCodeTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = FaultCode::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/env/200106/FaultCode.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $faultCode = FaultCode::fromString('{' . C::NS_SOAP_ENV . '}env:Sender');

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($faultCode),
        );
    }
}
