<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env_200106;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as C;
use SimpleSAML\SOAP\XML\env_200106\AbstractSoapElement;
use SimpleSAML\SOAP\XML\env_200106\FaultCode;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XML\Type\QNameValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env_200106\FaultCodeTest
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
        $faultCode = new FaultCode(QNameValue::fromString('{' . C::NS_SOAP_ENV_11 . '}env:Sender'));

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($faultCode),
        );
    }
}
