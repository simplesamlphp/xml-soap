<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP12\XML;

use Dom;
use SimpleSAML\SOAP12\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\MissingElementException;
use SimpleSAML\XMLSchema\Exception\TooManyElementsException;
use SimpleSAML\XMLSchema\XML\Constants\NS;

use function array_last;

/**
 * Class representing a env:Envelope element.
 *
 * @package simplesaml/xml-soap
 */
final class Envelope extends AbstractSoapElement implements SchemaValidatableElementInterface
{
    use ExtendableAttributesTrait;
    use SchemaValidatableElementTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * Initialize a env:Envelope
     *
     * @param \SimpleSAML\SOAP12\XML\Body $body
     * @param \SimpleSAML\SOAP12\XML\Header|null $header
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected Body $body,
        protected ?Header $header = null,
        array $namespacedAttributes = [],
    ) {
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\SOAP12\XML\Body
     */
    public function getBody(): Body
    {
        return $this->body;
    }


    /**
     * @return \SimpleSAML\SOAP12\XML\Header|null
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

        return $e;
    }
}
