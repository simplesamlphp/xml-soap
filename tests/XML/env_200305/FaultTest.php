<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env_200305;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\Constants as C;
use SimpleSAML\SOAP\XML\env_200305\AbstractSoapElement;
use SimpleSAML\SOAP\XML\env_200305\Code;
use SimpleSAML\SOAP\XML\env_200305\Detail;
use SimpleSAML\SOAP\XML\env_200305\Fault;
use SimpleSAML\SOAP\XML\env_200305\Node;
use SimpleSAML\SOAP\XML\env_200305\Reason;
use SimpleSAML\SOAP\XML\env_200305\Role;
use SimpleSAML\SOAP\XML\env_200305\Subcode;
use SimpleSAML\SOAP\XML\env_200305\Text;
use SimpleSAML\SOAP\XML\env_200305\Value;
use SimpleSAML\XML\{Chunk, DOMDocumentFactory};
use SimpleSAML\XML\TestUtils\{SchemaValidationTestTrait, SerializableElementTestTrait};
use SimpleSAML\XML\Type\{AnyURIValue, LanguageValue, QNameValue, StringValue};

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env_200305\FaultTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(Fault::class)]
#[CoversClass(AbstractSoapElement::class)]
final class FaultTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Fault::class;

        self::$schemaFile = dirname(__FILE__, 4) . '/tests/resources/schemas/simplesamlphp.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/env/200305/Fault.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $fault = new Fault(
            new Code(
                new Value(
                    QNameValue::fromString('{' . C::NS_SOAP_ENV_12 . '}env:Sender'),
                ),
                new SubCode(
                    new Value(
                        QNameValue::fromString('{http://www.example.org/timeouts}m:MessageTimeout'),
                    ),
                ),
            ),
            new Reason([
                new Text(
                    LanguageValue::fromString('en'),
                    StringValue::fromString('Sender Timeout'),
                ),
            ]),
            new Node(
                AnyURIValue::fromString('urn:x-simplesamlphp:namespace'),
            ),
            new Role(
                AnyURIValue::fromString('urn:x-simplesamlphp:namespace'),
            ),
            new Detail([
                new Chunk(DOMDocumentFactory::fromString(
                    '<m:MaxTime xmlns:m="http://www.example.org/timeouts">P5M</m:MaxTime>',
                )->documentElement),
            ]),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($fault),
        );
    }
}
