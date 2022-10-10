<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP\XML\env;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * Class representing a env:Upgrade element.
 *
 * @package simplesaml/xml-soap
 */
final class Upgrade extends AbstractSoapElement
{
    /** @var \SimpleSAML\SOAP\XML\env\SupportedEnvelope[] */
    protected array $supportedEnvelope;


    /**
     * Initialize a env:Upgrade
     *
     * @param \SimpleSAML\SOAP\XML\env\SupportedEnvelope[] $supportedEnvelope
     */
    public function __construct(array $supportedEnvelope)
    {
        $this->setSupportedEnvelope($supportedEnvelope);
    }


    /**
     * @return \SimpleSAML\SOAP\XML\env\SupportedEnvelope[]
     */
    public function getSupportedEnvelope(): array
    {
        return $this->supportedEnvelope;
    }


    /**
     * @param \SimpleSAML\SOAP\XML\env\SupportedEnvelope $supportedEnvelope
     */
    private function setSupportedEnvelope(array $supportedEnvelope): void
    {
        Assert::allIsInstanceOf($supportedEnvelope, SupportedEnvelope::class, SchemaViolationException::class);
        Assert::minCount($supportedEnvelope, 1, SchemaViolationException::class);
        $this->supportedEnvelope = $supportedEnvelope;
    }


    /**
     * Convert this element to XML.
     *
     * @param \DOMElement|null $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        foreach ($this->supportedEnvelope as $supportedEnvelope) {
            $supportedEnvelope->toXML($e);
        }

        return $e;
    }

    /**
     * Convert XML into a Upgrade
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'Upgrade', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, Upgrade::NS, InvalidDOMElementException::class);

        $supportedEnvelope = SupportedEnvelope::getChildrenOfClass($xml);
        Assert::minCount($supportedEnvelope, 1, SchemaViolationException::class);

        return new static($supportedEnvelope);
    }
}
