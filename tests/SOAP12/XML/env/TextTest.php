<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML\env;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\XML\env\AbstractSoapElement;
use SimpleSAML\SOAP12\XML\env\Text;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\env\TextTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(Text::class)]
#[CoversClass(AbstractSoapElement::class)]
final class TextTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Text::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/SOAP12/env_Text.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $text = new Text('en', 'It\'s broken');

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($text),
        );
    }
}
