<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML\env;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\XML\env\AbstractSoapElement;
use SimpleSAML\SOAP12\XML\env\Node;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\env\NodeTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(Node::class)]
#[CoversClass(AbstractSoapElement::class)]
final class NodeTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Node::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/SOAP12/env_Node.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $node = new Node('urn:x-simplesamlphp:namespace');

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($node),
        );
    }
}
