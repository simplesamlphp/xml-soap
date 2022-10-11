<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env;

use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\XML\env\Reason;
use SimpleSAML\SOAP\XML\env\Text;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env\ReasonTest
 *
 * @covers \SimpleSAML\SOAP\XML\env\Reason
 * @covers \SimpleSAML\SOAP\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
final class ReasonTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = Reason::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/env_Reason.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $reason = new Reason([
            new Text('en', 'It\'s broken'),
            new Text('nl', 'Het is stuk'),
        ]);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($reason)
        );
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $reason = Reason::fromXML($this->xmlRepresentation->documentElement);
        $text = $reason->getText();
        $this->assertCount(2, $text);

        $this->assertEquals('It\'s broken', $text[0]->getContent());
        $this->assertEquals('en', $text[0]->getLanguage());
        $this->assertEquals('Het is stuk', $text[1]->getContent());
        $this->assertEquals('nl', $text[1]->getLanguage());
    }
}
