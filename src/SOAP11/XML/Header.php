<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP11\XML;

use DOMElement;
use SimpleSAML\SOAP11\Assert\Assert;
use SimpleSAML\XML\{ExtendableAttributesTrait, ExtendableElementTrait};
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\XML\Enumeration\NamespaceEnum;

/**
 * Class representing a SOAP-ENV:Header element.
 *
 * @package simplesaml/xml-soap
 */
final class Header extends AbstractSoapElement implements SchemaValidatableElementInterface
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;
    use SchemaValidatableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NamespaceEnum::Other;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NamespaceEnum::Other;


    /**
     * Initialize a SOAP-ENV:Header
     *
     * @param list<\SimpleSAML\XML\SerializableElementInterface> $children
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
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
     * @return static
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'Header', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, Header::NS, InvalidDOMElementException::class);

        return new static(
            self::getChildElementsFromXML($xml),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Convert this Header to XML.
     *
     * @param \DOMElement|null $parent The element we should add this header to.
     * @return \DOMElement This Header-element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        /** @psalm-var \SimpleSAML\XML\SerializableElementInterface $child */
        foreach ($this->getElements() as $child) {
            $child->toXML($e);
        }

        return $e;
    }
}
