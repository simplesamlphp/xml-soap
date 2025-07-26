<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP12\XML;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP12\XML\AbstractSoapElement;
use SimpleSAML\SOAP12\XML\Role;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP12\XML\RoleTest
 *
 * @package simplesamlphp/xml-soap
 */
#[CoversClass(Role::class)]
#[CoversClass(AbstractSoapElement::class)]
final class RoleTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Role::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/env/200305/Role.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $role = new Role(
            AnyURIValue::fromString('urn:x-simplesamlphp:namespace'),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($role),
        );
    }
}
