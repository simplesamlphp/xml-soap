<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP11\XML;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\XML\AbstractSoapElement;
use SimpleSAML\SOAP11\XML\FaultActor;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP11\XML\FaultActorTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(FaultActor::class)]
#[CoversClass(AbstractSoapElement::class)]
final class FaultActorTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = FaultActor::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/env/200106/FaultActor.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $faultActor = new FaultActor(
            AnyURIValue::fromString('urn:x-simplesamlphp:namespace'),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($faultActor),
        );
    }
}
