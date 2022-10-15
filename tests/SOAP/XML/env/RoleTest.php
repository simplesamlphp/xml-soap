<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP\XML\env;

use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP\XML\env\Role;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SOAP\XML\env\RoleTest
 *
 * @covers \SimpleSAML\SOAP\XML\env\Role
 * @covers \SimpleSAML\SOAP\XML\env\AbstractSoapElement
 *
 * @package simplesamlphp/xml-soap
 */
final class RoleTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = Role::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/env_Role.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $role = new Role('urn:x-simplesamlphp:namespace');

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($role)
        );
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $role = Role::fromXML($this->xmlRepresentation->documentElement);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($role)
        );
    }
}
