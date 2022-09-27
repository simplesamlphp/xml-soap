<?php

namespace SimpleSAML\SOAP\XML\env;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\SOAP\XML\Text;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * Class representing a env:Reason element.
 *
 * @package simplesaml/xml-soap
 */
final class Reason extends AbstractSoapElement
{
    /** @var \SimpleSAML\SOAP\XML\Text[] */
    protected array $text;


    /**
     * Initialize a env:Reason
     *
     * @param \SimpleSAML\SOAP\XML\Text[] $text
     */
    public function __construct(array $text)
    {
        $this->setText($text);
    }


    /**
     * @return \SimpleSAML\SOAP\XML\Text[]
     */
    public function getText(): array
    {
        return $this->text;
    }


    /**
     * @param \SimpleSAML\SOAP\XML\Text $text
     */
    private function setText(array $text): void
    {
        Assert::allIsInstanceOf($text, Text::class, SchemaViolationException::class);
        Assert::minCount(1, $text, SchemaViolationException::class);
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

        foreach ($this->text as $text) {
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
        Assert::same($xml->localName, 'Text', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, Text::NS, InvalidDOMElementException::class);

        $text = Text::getChildrenOfClass($xml);
        Assert::minCount(1, $text, SchemaViolationException::class);

        return new static($text);
    }
}
