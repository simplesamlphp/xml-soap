<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML\env;

use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\XML\env\NotUnderstood;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\env\NotUnderstoodTest
 *
 * @covers \SimpleSAML\SOAP12\XML\env\NotUnderstood
 * @covers \SimpleSAML\SOAP12\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
final class NotUnderstoodTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = NotUnderstood::class;

        $this->schema = dirname(__FILE__, 5) . '/resources/schemas/soap-envelope-1.2.xsd';

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 5) . '/resources/xml/SOAP12/env_NotUnderstood.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $notUnderstood = new NotUnderstood('ssp:Chunk', 'urn:x-simplesamlphp:namespace');

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($notUnderstood)
        );
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $notUnderstood = NotUnderstood::fromXML($this->xmlRepresentation->documentElement);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($notUnderstood)
        );
    }
}
