<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\XML\AbstractSoapElement;
use SimpleSAML\SOAP12\XML\Text;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XML\Type\LangValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\TextTest
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
            dirname(__FILE__, 3) . '/resources/xml/env/200305/Text.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $text = new Text(
            LangValue::fromString('en'),
            StringValue::fromString('It\'s broken'),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($text),
        );
    }
}
