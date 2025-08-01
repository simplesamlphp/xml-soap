<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP11\XML;

use DOMElement;
use SimpleSAML\SOAP11\Assert\Assert;
use SimpleSAML\XML\{ExtendableAttributesTrait, ExtendableElementTrait};
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XMLSchema\Exception\{InvalidDOMElementException, MissingElementException, TooManyElementsException};
use SimpleSAML\XMLSchema\XML\Enumeration\NamespaceEnum;

/**
 * Class representing a SOAP-ENV:Envelope element.
 *
 * @package simplesaml/xml-soap
 */
final class Envelope extends AbstractSoapElement implements SchemaValidatableElementInterface
{
    use ExtendableElementTrait;
    use ExtendableAttributesTrait;
    use SchemaValidatableElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NamespaceEnum::Other;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NamespaceEnum::Other;


    /**
     * Initialize a SOAP-ENV:Envelope
     *
     * @param \SimpleSAML\SOAP11\XML\Body $body
     * @param \SimpleSAML\SOAP11\XML\Header|null $header
     * @param list<\SimpleSAML\XML\SerializableElementInterface> $children
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected Body $body,
        protected ?Header $header = null,
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\SOAP11\XML\Body
     */
    public function getBody(): Body
    {
        return $this->body;
    }


    /**
     * @return \SimpleSAML\SOAP11\XML\Header|null
     */
    public function getHeader(): ?Header
    {
        return $this->header;
    }


    /**
     * Convert XML into an Envelope element
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'Envelope', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, Envelope::NS, InvalidDOMElementException::class);

        $body = Body::getChildrenOfClass($xml);
        Assert::count($body, 1, 'Must contain exactly one Body', MissingElementException::class);

        $header = Header::getChildrenOfClass($xml);
        Assert::maxCount($header, 1, 'Cannot process more than one Header element.', TooManyElementsException::class);

        return new static(
            array_pop($body),
            empty($header) ? null : array_pop($header),
            self::getChildElementsFromXML($xml),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Convert this Envelope to XML.
     *
     * @param \DOMElement|null $parent The element we should add this envelope to.
     * @return \DOMElement This Envelope-element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        if ($this->getHeader() !== null && !$this->getHeader()->isEmptyElement()) {
            $this->getHeader()->toXML($e);
        }

        $this->getBody()->toXML($e);

        /** @psalm-var \SimpleSAML\XML\SerializableElementInterface $child */
        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
