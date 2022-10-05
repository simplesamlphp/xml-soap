<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP;

use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\Assert;
use SimpleSAML\SOAP\Constants as C;
use SimpleSAML\Test\SOAP\QNameStringlement;
use SimpleSAML\Test\XML\SerializableElementTestTrait;
use SimpleSAML\XML\AbstractElement;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\Exception\SchemaViolationException;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\XML\QNameStringElementTraitTest
 *
 * @covers \SimpleSAML\XML\QNameStringElementTrait
 *
 * @package simplesamlphp\xml-soap
 */
final class QNameStringElementTraitTest extends TestCase
{
    use SerializableElementTestTrait;

    /**
     */
    public function setup(): void
    {
        $this->testedClass = QNameStringElement::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(__FILE__))) . '/resources/xml/ssp_QNameStringElement.xml',
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $qnameElement = new QNameStringElement('env:Sender', C::NS_SOAP_ENV);

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($qnameElement)
        );
    }


    /**
     */
    public function testMarshallingInvalidQualifiedNameThrowsException(): void
    {
        $this->expectException(SchemaViolationException::class);

        new QNameStringElement('0:Sender', C::NS_SOAP_ENV);
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $qnameElement = QNameStringElement::fromXML($this->xmlRepresentation->documentElement);

        $this->assertEquals('env:Sender', $qnameElement->getContent());
        $this->assertEquals(C::NS_SOAP_ENV, $qnameElement->getContentNamespaceUri());
    }
}
