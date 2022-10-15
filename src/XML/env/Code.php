<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP\XML\env;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\SOAP\Constants as C;
use SimpleSAML\SOAP\Exception\ProtocolViolationException;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\TooManyElementsException;

/**
 * Class representing a env:Code element.
 *
 * @package simplesaml/xml-soap
 */
final class Code extends AbstractSoapElement
{
    /**
     * The Value element
     *
     * @var \SimpleSAML\SOAP\XML\env\Value
     */
    protected Value $value;

    /**
     * The Subcode element
     *
     * @var \SimpleSAML\SOAP\XML\env\Subcode|null
     */
    protected ?Subcode $subcode;


    /**
     * Initialize a soap:Code
     *
     * @param \SimpleSAML\SOAP\XML\env\Value $value
     * @param \SimpleSAML\SOAP\XML\env\Code|null $code
     */
    public function __construct(Value $value, ?Subcode $subcode)
    {
        $this->setValue($value);
        $this->setSubcode($subcode);
    }


    /**
     * @return \SimpleSAML\SOAP\XML\env\Value
     */
    public function getValue(): Value
    {
        return $this->value;
    }


    /**
     * @param \SimpleSAML\SOAP\XML\env\Value $value
     */
    protected function setValue(Value $value): void
    {
        @list($prefix, $localName) = preg_split('/:/', $value->getContent(), 2);
        if ($localName === null) {
            // We don't have a prefixed value here
            $localName = $prefix;
        }

        Assert::oneOf(
            $localName,
            C::FAULT_CODES,
            'Invalid top-level Value',
            ProtocolViolationException::class
        );
        $this->value = $value;
    }


    /**
     * @return \SimpleSAML\SOAP\XML\env\Subcode|null
     */
    public function getSubcode(): ?Subcode
    {
        return $this->subcode;
    }


    /**
     * @param \SimpleSAML\SOAP\XML\env\Subcode|null $subcode
     */
    protected function setSubcode(?Subcode $subcode): void
    {
        $this->subcode = $subcode;
    }


    /**
     * Convert XML into an Code element
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'Code', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, Code::NS, InvalidDOMElementException::class);

        $value = Value::getChildrenOfClass($xml);
        Assert::count($value, 1, 'Must contain exactly one Value', MissingElementException::class);

        // Assert that the namespace of the value matches the SOAP-ENV namespace
        @list($prefix, $localName) = preg_split('/:/', $value[0]->getContent(), 2);
        $namespace = $xml->lookupNamespaceUri($prefix);
        Assert::same($namespace, C::NS_SOAP_ENV);

        $subcode = Subcode::getChildrenOfClass($xml);
        Assert::maxCount($subcode, 1, 'Cannot process more than one Subcode element.', TooManyElementsException::class);

        return new static(
            array_pop($value),
            empty($subcode) ? null : array_pop($subcode)
        );
    }


    /**
     * Convert this Code to XML.
     *
     * @param \DOMElement|null $parent The element we should add this code to.
     * @return \DOMElement This Code-element.
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        $this->value->toXML($e);
        $this->subcode?->toXML($e);

        return $e;
    }
}
