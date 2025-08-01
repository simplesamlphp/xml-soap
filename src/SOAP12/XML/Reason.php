<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP12\XML;

use DOMElement;
use SimpleSAML\SOAP12\Assert\Assert;
use SimpleSAML\XML\Constants as C;
use SimpleSAML\XMLSchema\Exception\{InvalidDOMElementException, SchemaViolationException};

/**
 * Class representing a env:Reason element.
 *
 * @package simplesaml/xml-soap
 */
final class Reason extends AbstractSoapElement
{
    /**
     * Initialize a env:Reason
     *
     * @param \SimpleSAML\SOAP12\XML\Text[] $text
     */
    public function __construct(
        protected array $text,
    ) {
        Assert::maxCount($text, C::UNBOUNDED_LIMIT);
        Assert::minCount($text, 1, SchemaViolationException::class);
        Assert::allIsInstanceOf($text, Text::class, SchemaViolationException::class);
    }


    /**
     * @return \SimpleSAML\SOAP12\XML\Text[]
     */
    public function getText(): array
    {
        return $this->text;
    }


    /**
     * Convert this element to XML.
     *
     * @param \DOMElement|null $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        foreach ($this->getText() as $text) {
            $text->toXML($e);
        }

        return $e;
    }

    /**
     * Convert XML into a Value
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'Reason', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, Reason::NS, InvalidDOMElementException::class);

        $text = Text::getChildrenOfClass($xml);
        Assert::minCount($text, 1, SchemaViolationException::class);

        return new static($text);
    }
}
