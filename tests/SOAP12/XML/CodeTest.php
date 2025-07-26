<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\Constants as C;
use SimpleSAML\SOAP12\XML\AbstractSoapElement;
use SimpleSAML\SOAP12\XML\Code;
use SimpleSAML\SOAP12\XML\Subcode;
use SimpleSAML\SOAP12\XML\Value;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\QNameValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\CodeTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(Code::class)]
#[CoversClass(AbstractSoapElement::class)]
final class CodeTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Code::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/env/200305/Code.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $code = new Code(
            new Value(QNameValue::fromString('{' . C::NS_SOAP_ENV . '}env:Sender')),
            new Subcode(
                new Value(QNameValue::fromString('{http://www.example.org/timeouts}m:SomethingNotFromSpec')),
                new Subcode(new Value(QNameValue::fromString('{http://www.example.org/timeouts}m:MessageTimeout'))),
            ),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($code),
        );
    }
}
