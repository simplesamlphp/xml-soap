<?php

namespace SimpleSAML\SOAP\XML\soap;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\TooManyElementsException;
use SimpleSAML\XML\ExtendableAttributesTrait;

/**
 * Class representing a soap:Envelope element.
 *
 * @package simplesaml/xml-soap
 */
final class Envelope extends AbstractSoapElement
{
    use ExtendableAttributesTrait;

    /**
     * The Header element
     *
     * @var \SimpleSAML\SOAP\XML\soap\Header|null
     */
    protected ?Header $header;

    /**
     * The Body element
     *
     * @var \SimpleSAML\SOAP\XML\soap\Body
     */
    protected Body $body;


    /**
     * Initialize a soap:Envelope
     *
     * @param \SimpleSAML\SOAP\XML\soap\Body $body
     * @param \SimpleSAML\SOAP\XML\soap\Header|null $header
     * @param \DOMAttr[] $namespacedAttributes
     */
    public function __construct(Body $body, ?Header $header = null, array $namespacedAttributes = [])
    {
        $this->setBody($body);
        $this->setHeader($header);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\SOAP\XML\soap\Body
     */
    public function getBody(): Body
    {
        return $this->body;
    }


    /**
     * @param \SimpleSAML\SOAP\XML\soap\Body $body
     */
    protected function setBody(Body $body): void
    {
        $this->body = $body;
    }


    /**
     * @return \SimpleSAML\SOAP\XML\soap\Header|null
     */
    public function getHeader(): ?Header
    {
        return $this->header;
    }


    /**
     * @param \SimpleSAML\SOAP\XML\soap\Header|null $header
     */
    protected function setHeader(?Header $header): void
    {
        $this->header = $header;
    }


    /**
     * Convert XML into an Envelope element
     *
     * @param \DOMElement $xml The XML element we should load
     * @return self
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): self
    {
        Assert::same($xml->localName, 'Envelope', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, Envelope::NS, InvalidDOMElementException::class);

        $body = Body::getChildrenOfClass($xml);
        Assert::count($body, 1, 'Must contain exactly one Body', MissingElementException::class);

        $header = Header::getChildrenOfClass($xml);
        Assert::maxCount($header, 1, 'Cannot process more than one Header element.', TooManyElementsException::class);

        return new self(
            array_pop($body),
            empty($header) ? null : array_pop($header),
            self::getAttributesNSFromXML($xml)
        );
    }


    /**
     * Convert this Envelope to XML.
     *
     * @param \DOMElement|null $parent The element we should add this envelope to.
     * @return \DOMElement This Envelope-element.
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $e->setAttributeNS($attr['namespaceURI'], $attr['qualifiedName'], $attr['value']);
        }

        if ($this->header !== null) {
            $this->header->toXML($e);
        }

        $this->body->toXML($e);

        return $e;
    }
}
