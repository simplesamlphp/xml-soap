<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML\env;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\XML\env\AbstractSoapElement;
use SimpleSAML\SOAP12\XML\env\NotUnderstood;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\env\NotUnderstoodTest
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

        self::$schemaFile = dirname(__FILE__, 5) . '/resources/schemas/soap-envelope-1.2.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/SOAP12/env_NotUnderstood.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $notUnderstood = new NotUnderstood('ssp:Chunk', 'urn:x-simplesamlphp:namespace');

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($notUnderstood),
        );
    }
}
