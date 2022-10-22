<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP12\XML\env;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\SOAP12\XML\env\Text;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * Class representing a env:Reason element.
 *
 * @package simplesaml/xml-soap
 */
final class Reason extends AbstractSoapElement
{
    /** @var \SimpleSAML\SOAP\XML\env\Text[] */
    protected array $text;


    /**
     * Initialize a env:Reason
     *
     * @param \SimpleSAML\SOAP\XML\env\Text[] $text
     */
    public function __construct(array $text)
    {
        $this->setText($text);
    }


    /**
     * @return \SimpleSAML\SOAP\XML\env\Text[]
     */
    public function getText(): array
    {
        return $this->text;
    }


    /**
     * @param \SimpleSAML\SOAP\XML\env\Text[] $text
     */
    private function setText(array $text): void
    {
        Assert::allIsInstanceOf($text, Text::class, SchemaViolationException::class);
        Assert::minCount($text, 1, SchemaViolationException::class);
        $this->text = $text;
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
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
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
