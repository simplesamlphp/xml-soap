<?php

namespace SimpleSAML\SOAP\XML\env;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\Constants as C;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\ExtendableAttributesTrait;

/**
 * Class representing a env:Header element.
 *
 * @package simplesaml/xml-soap
 */
final class Header extends AbstractSoapElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const NAMESPACE = C::XS_ANY_NS_ANY;


    /**
     * Initialize a env:Header
     *
     * @param \SimpleSAML\XML\Chunk[] $children
     * @param \DOMAttr[] $namespacedAttributes
     */
    public function __construct(array $children = [], array $namespacedAttributes = [])
    {
        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->elements) && empty($this->namespacedAttributes);
    }


    /*
     * Convert XML into an Header element
     *
     * @param \DOMElement $xml The XML element we should load
     * @return self
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): self
    {
        Assert::same($xml->localName, 'Header', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, Header::NS, InvalidDOMElementException::class);

        $children = [];
        foreach ($xml->childNodes as $child) {
            if (!($child instanceof DOMElement)) {
                continue;
            }

            $children[] = new Chunk($child);
        }

        return new self(
            $children,
            self::getAttributesNSFromXML($xml)
        );
    }


    /**
     * Convert this Header to XML.
     *
     * @param \DOMElement|null $parent The element we should add this header to.
     * @return \DOMElement This Header-element.
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $e->setAttributeNS($attr['namespaceURI'], $attr['qualifiedName'], $attr['value']);
        }

        foreach ($this->elements as $child) {
            $e->appendChild($e->ownerDocument->importNode($child->toXML(), true));
        }

        return $e;
    }
}
