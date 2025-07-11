<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env_200305;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as C;
use SimpleSAML\SOAP\XML\env_200305\AbstractSoapElement;
use SimpleSAML\SOAP\XML\env_200305\Code;
use SimpleSAML\SOAP\XML\env_200305\Subcode;
use SimpleSAML\SOAP\XML\env_200305\Value;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\Builtin\QNameValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env_200305\CodeTest
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
            new Value(QNameValue::fromString('{' . C::NS_SOAP_ENV_12 . '}env:Sender')),
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
