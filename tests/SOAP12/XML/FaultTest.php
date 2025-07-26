<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\Constants as C;
use SimpleSAML\SOAP12\XML\AbstractSoapElement;
use SimpleSAML\SOAP12\XML\Code;
use SimpleSAML\SOAP12\XML\Detail;
use SimpleSAML\SOAP12\XML\Fault;
use SimpleSAML\SOAP12\XML\Node;
use SimpleSAML\SOAP12\XML\Reason;
use SimpleSAML\SOAP12\XML\Role;
use SimpleSAML\SOAP12\XML\Subcode;
use SimpleSAML\SOAP12\XML\Text;
use SimpleSAML\SOAP12\XML\Value;
use SimpleSAML\XML\{Chunk, DOMDocumentFactory};
use SimpleSAML\XML\TestUtils\{SchemaValidationTestTrait, SerializableElementTestTrait};
use SimpleSAML\XML\Type\LangValue;
use SimpleSAML\XMLSchema\Type\{AnyURIValue, QNameValue, StringValue};

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\FaultTest
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
                    QNameValue::fromString('{' . C::NS_SOAP_ENV . '}env:Sender'),
                ),
                new SubCode(
                    new Value(
                        QNameValue::fromString('{http://www.example.org/timeouts}m:MessageTimeout'),
                    ),
                ),
            ),
            new Reason([
                new Text(
                    LangValue::fromString('en'),
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
