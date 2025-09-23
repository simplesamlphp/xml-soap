<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\XML\AbstractSoapElement;
use SimpleSAML\SOAP12\XML\NotUnderstood;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\QNameValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\NotUnderstoodTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(NotUnderstood::class)]
#[CoversClass(AbstractSoapElement::class)]
final class NotUnderstoodTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = NotUnderstood::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/env/200305/NotUnderstood.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $notUnderstood = new NotUnderstood(
            QNameValue::fromString('{urn:x-simplesamlphp:namespace}ssp:Chunk'),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($notUnderstood),
        );
    }
}
