<?php

namespace SimpleSAML\SOAP\XML\soap;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\XMLStringElementTrait;

/**
 * Class representing a soap:Value element.
 *
 * @package simplesaml/xml-soap
 */
final class Value extends AbstractSoapElement
{
    use XML StringElementTrait;


    /**
     * Initialize a soap:Value
     *
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->setContent($content);
    }


    /**
     * Validate the content of the element.
     *
     * @param string $content  The value to go in the XML textContent
     * @throws \SimpleSAML\Assert\AssertionFailedException on failure
     * @return void
     */
    protected function validateContent(string $content): void
    {
        Assert::notWhitespaceOnly($content);
    }


    /**
     * Convert XML into a Value
     *
     * @param \DOMElement $xml The XML element we should load
     * @return self
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): object
    {
        Assert::same($xml->localName, 'Value', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, Value::NS, InvalidDOMElementException::class);

        return new self($xml->textContent);
    }
}
