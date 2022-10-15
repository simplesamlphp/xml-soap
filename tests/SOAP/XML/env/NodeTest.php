<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env;

use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\XML\env\Node;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env\NodeTest
 *
 * @covers \SimpleSAML\SOAP\XML\env\Node
 * @covers \SimpleSAML\SOAP\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
final class NodeTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = Node::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/env_Node.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $node = new Node('urn:x-simplesamlphp:namespace');

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($node)
        );
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $node = Node::fromXML($this->xmlRepresentation->documentElement);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($node)
        );
    }
}
