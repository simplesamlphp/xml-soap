<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP11\XML\env;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\XML\env\AbstractSoapElement;
use SimpleSAML\SOAP11\XML\env\FaultActor;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP11\XML\env\FaultActorTest
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
            dirname(__FILE__, 4) . '/resources/xml/SOAP11/env_FaultActor.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $faultActor = new FaultActor('urn:x-simplesamlphp:namespace');

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($faultActor)
        );
    }
}
