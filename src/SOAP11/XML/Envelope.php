<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP11\XML;

use Dom;
use SimpleSAML\SOAP11\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\MissingElementException;
use SimpleSAML\XMLSchema\Exception\TooManyElementsException;
use SimpleSAML\XMLSchema\XML\Constants\NS;

use function array_last;

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
    public const string XS_ANY_ELT_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;


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
     * @param \Dom\Element $xml The XML element we should load
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(Dom\Element $xml): static
    {
        Assert::same($xml->localName, 'Envelope', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, Envelope::NS, InvalidDOMElementException::class);

        $body = Body::getChildrenOfClass($xml);
        Assert::count($body, 1, 'Must contain exactly one Body', MissingElementException::class);

        $header = Header::getChildrenOfClass($xml);
        Assert::maxCount($header, 1, 'Cannot process more than one Header element.', TooManyElementsException::class);

        return new static(
            array_last($body),
            array_last($header),
            self::getChildElementsFromXML($xml),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Convert this Envelope to XML.
     *
     * @param \Dom\Element|null $parent The element we should add this envelope to.
     */
    public function toXML(?Dom\Element $parent = null): Dom\Element
    {
        $e = $this->instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        if ($this->getHeader() !== null && !$this->getHeader()->isEmptyElement()) {
            $this->getHeader()->toXML($e);
        }

        $this->getBody()->toXML($e);

        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
