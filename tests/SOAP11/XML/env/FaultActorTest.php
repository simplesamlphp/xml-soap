<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP11\XML\env;

use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\XML\env\FaultActor;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP11\XML\env\FaultActorTest
 *
 * @covers \SimpleSAML\SOAP11\XML\env\FaultActor
 * @covers \SimpleSAML\SOAP11\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
final class FaultActorTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = FaultActor::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 5) . '/resources/xml/SOAP11/env_FaultActor.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $faultActor = new FaultActor('urn:x-simplesamlphp:namespace');

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($faultActor)
        );
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $faultActor = FaultActor::fromXML($this->xmlRepresentation->documentElement);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($faultActor)
        );
    }
}
