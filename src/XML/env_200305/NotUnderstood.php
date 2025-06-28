<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP\XML\env_200305;

use DOMElement;
use SimpleSAML\SOAP\Assert\Assert;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XMLSchema\Exception\{InvalidDOMElementException, MissingAttributeException};
use SimpleSAML\XMLSchema\Type\Builtin\QNameValue;

/**
 * Class representing a env:NotUnderstood element.
 *
 * @package simplesaml/xml-soap
 */
final class NotUnderstood extends AbstractSoapElement implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;

    /**
     * Initialize a soap:NotUnderstood
     *
     * @param \SimpleSAML\XMLSchema\Type\Builtin\QNameValue $qname
     */
    public function __construct(
        protected QNameValue $qname,
    ) {
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\Builtin\QNameValue
     */
    public function getQName(): QNameValue
    {
        return $this->qname;
    }


    /*
     * Convert XML into a NotUnderstood element
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'NotUnderstood', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);
        Assert::notNull($xml->hasAttribute('qname'), MissingAttributeException::class);

        return new static(
            QNameValue::fromDocument($xml->getAttribute('qname'), $xml),
        );
    }


    /**
     * Convert this NotUnderstood to XML.
     *
     * @param \DOMElement|null $parent The element we should add this Body to.
     * @return \DOMElement This NotUnderstood-element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        if (!$e->lookupPrefix($this->getQName()->getNamespaceURI()->getValue())) {
            $namespace = new XMLAttribute(
                'http://www.w3.org/2000/xmlns/',
                'xmlns',
                $this->getQName()->getNamespacePrefix()->getValue(),
                $this->getQName()->getNamespaceURI(),
            );
            $namespace->toXML($e);
        }

        $e->setAttribute('qname', strval($this->getQName()->getValue()));

        return $e;
    }
}
