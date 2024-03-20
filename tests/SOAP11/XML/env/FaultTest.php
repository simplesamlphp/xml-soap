<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP11\XML\env;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\XML\env\AbstractSoapElement;
use SimpleSAML\SOAP11\XML\env\Detail;
use SimpleSAML\SOAP11\XML\env\Fault;
use SimpleSAML\SOAP11\XML\env\FaultActor;
use SimpleSAML\SOAP11\XML\env\FaultCode;
use SimpleSAML\SOAP11\XML\env\FaultString;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP11\XML\env\FaultTest
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

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/soap-envelope-1.1.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/SOAP11/env_Fault.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $fault = new Fault(
            new FaultCode('env:Sender'),
            new FaultString('Something went wrong'),
            new FaultActor('urn:x-simplesamlphp:namespace'),
            new Detail([
                new Chunk(DOMDocumentFactory::fromString(
                    '<m:MaxTime xmlns:m="http://www.example.org/timeouts">P5M</m:MaxTime>'
                )->documentElement)
            ]),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($fault)
        );
    }
}
