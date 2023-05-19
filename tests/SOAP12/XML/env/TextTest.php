<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML\env;

use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\XML\env\Text;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\env\TextTest
 *
 * @covers \SimpleSAML\SOAP12\XML\env\Text
 * @covers \SimpleSAML\SOAP12\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
final class TextTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = Text::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/SOAP12/env_Text.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $text = new Text('en', 'It\'s broken');

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($text)
        );
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $text = Text::fromXML($this->xmlRepresentation->documentElement);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($text)
        );
    }
}
