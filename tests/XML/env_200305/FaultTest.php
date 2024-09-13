<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env_200305;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
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
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

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

        self::$schemaFile = dirname(__FILE__, 4) . '/resources/schemas/soap-envelope-1.2.xsd';

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
                new Value('env:Sender'),
                new SubCode(new Value('m:MessageTimeout', 'http://www.example.org/timeouts')),
            ),
            new Reason([new Text('en', 'Sender Timeout')]),
            new Node('urn:x-simplesamlphp:namespace'),
            new Role('urn:x-simplesamlphp:namespace'),
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
