<?php

namespace SimpleSAML\SOAP\XML\env;

use DOMAttr;
use DOMElement;
use DOMNameSpaceNode;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\XMLStringElementTrait;

/**
 * Class representing a env:Value element.
 *
 * @package simplesaml/xml-soap
 */
final class Value extends AbstractSoapElement
{
    use XMLStringElementTrait;

    /** @var \DOMAttr|null */
    protected $node = null;


    /**
     * Initialize a env:Value
     *
     * @param string $content
     * @param DOMAttr|null $node
     */
    public function __construct(string $content, ?DOMAttr $node = null)
    {
        $this->setContent($content);
        $this->setNode($node);
    }


    /**
     * @return \DOMAttr|null
     */
    public function getNode(): ?DOMAttr
    {
        return $this->node;
    }


    /**
     * @param \DOMAttr|null $node
     */
    private function setNode(?DOMAttr $node)
    {
        $this->node = $node;
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
     * Convert this element to XML.
     *
     * @param \DOMElement|null $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->textContent = $this->getContent();

        if ($this->node !== null) {
            if (!($e->hasAttribute($this->node->localName))) {
               $e->setAttributeNode($this->getNode());
            }
        }

        return $e;
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

        @list($prefix, $localName) = preg_split('/:/', $xml->textContent, 2);
        if ($localName === null) {
            // We don't have a prefixed value here
            $prefix = null;
            $localName = $xml->textContent;
        }

        $node = null;
        if ($prefix !== null) {
            $node = $xml->ownerDocument->documentElement->getAttributeNode('xmlns:' . $prefix);
            if ($node !== false) {
                $node = new DOMAttr('xmlns:' . $prefix, $node->namespaceURI);
            } else {
                $node = null;
            }
        }

        return new self($xml->textContent, $node);
    }
}
