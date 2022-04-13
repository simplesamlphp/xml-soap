<?php

namespace SimpleSAML\SOAP\XML\soap;

use SimpleSAML\Assert\Assert;
use SimpleSAML\SOAP\Exception\ProtocolViolationException;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\TooManyElementsException;

/**
 * Class representing a soap:Subcode element.
 *
 * @package simplesaml/xml-soap
 */
final class Subcode extends AbstractSoapElement
{
    /**
     * The Value element
     *
     * @var \SimpleSAML\SOAP\XML\soap\Value
     */
    protected Value $value;

    /**
     * The Subcode element
     *
     * @var \SimpleSAML\SOAP\XML\soap\Subcode|null
     */
    protected ?Subcode $subcode;


    /**
     * Initialize a soap:Subcode
     *
     * @param \SimpleSAML\SOAP\XML\soap\Value $value
     * @param \SimpleSAML\SOAP\XML\soap\Code|null $code
     */
    public function __construct(Value $value, ?Subcode $subcode)
    {
        $this->setValue($value);
        $this->setSubcode($subcode);
    }


    /**
     * @return \SimpleSAML\SOAP\XML\soap\Value
     */
    public function getValue(): Value
    {
        return $this->value;
    }


    /**
     * @param \SimpleSAML\SOAP\XML\soap\Value $value
     */
    protected function setValue(Value $value): void
    {
        $this->value = $value;
    }


    /**
     * @return \SimpleSAML\SOAP\XML\soap\Subcode|null
     */
    public function getSubcode(): ?Subcode
    {
        return $this->subcode;
    }


    /**
     * @param \SimpleSAML\SOAP\XML\soap\Subcode|null $subcode
     */
    protected function setSubcode(?Subcode $subcode): void
    {
        $this->subcode = $subcode;
    }


    /**
     * Convert XML into an Subcode element
     *
     * @param \DOMElement $xml The XML element we should load
     * @return self
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): self
    {
        Assert::same($xml->localName, 'Subcode', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, Subcode::NS, InvalidDOMElementException::class);

        $value = Value::getChildrenOfClass($xml);
        Assert::count($value, 1, 'Must contain exactly one Value', MissingElementException::class);

        $subcode = Subcode::getChildrenOfClass($xml);
        Assert::maxCount($subcode, 1, 'Cannot process more than one Subcode element.', TooManyElementsException::class);

        return new self(
            array_pop($value),
            empty($subcode) ? null : array_pop($subcode)
        );
    }


    /**
     * Convert this Subcode to XML.
     *
     * @param \DOMElement|null $parent The element we should add this subcode to.
     * @return \DOMElement This Subcode-element.
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        $this->value->toXML($e);

        if ($this->subcode !== null) {
            $this->subcode->toXML($e);
        }

        return $e;
    }
}
