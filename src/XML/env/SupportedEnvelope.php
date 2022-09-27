<?php

namespace SimpleSAML\SOAP\XML\env;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;

/**
 * Class representing a env:SupportedEnvelope element.
 *
 * @package simplesaml/xml-soap
 */
final class SupportedEnvelope extends AbstractSoapElement
{
    /**
     * The qname attribute
     *
     * @var string
     */
    protected string $qname;

    /**
     * Initialize a soap:SupportedEnvelope
     *
     * @param string $qname
     */
    public function __construct(string $qname)
    {
        $this->setQName($qname);
    }


    /**
     * @return string
     */
    public function getQName(): string
    {
        return $this->qname;
    }


    /**
     * @param string $qname
     */
    private function setQName(string $qname): void
    {
        $this->qname = $qname;
    }


    /**
     * Convert XML into an SupportedEnvelope element
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'SupportedEnvelope', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, SupportedEnvelope::NS, InvalidDOMElementException::class);

        $qname = self::getAttribute($xml, 'qname');

        return new static($qname);
    }


    /**
     * Convert this SupportedEnvelope to XML.
     *
     * @param \DOMElement|null $parent The element we should add this SupportedEnvelope to.
     * @return \DOMElement This SupportedEnvelope-element.
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->setAttribute('qname', $this->qname);

        return $e;
    }
}
