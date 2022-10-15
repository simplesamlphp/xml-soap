<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP\XML\env;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;

use function preg_split;

/**
 * Class representing a env:NotUnderstood element.
 *
 * @package simplesaml/xml-soap
 */
final class NotUnderstood extends AbstractSoapElement
{
    /** @var string $qname */
    protected string $qname;

    /** @var string|null */
    protected ?string $namespaceUri;


    /**
     * Initialize a env:NotUnderstood
     *
     * @param string $qname
     * @param string|null $namespaceUri
     */
    public function __construct(string $qname, ?string $namespaceUri = null)
    {
        $this->setQName($qname);
        $this->setContentNamespaceUri($namespaceUri);
    }


    /**
     * @return string
     */
    public function getQName(): string
    {
        return $this->qname;
    }


    /**
     * @param string $qname
     */
    private function setQName(string $qname): void
    {
        Assert::validQName($qname);
        $this->qname = $qname;
    }


    /**
     * Set the namespaceUri.
     *
     * @param string|null $namespaceUri
     */
    protected function setContentNamespaceUri(?string $namespaceUri): void
    {
        Assert::nullOrValidURI($namespaceUri, SchemaViolationException::class);
        $this->namespaceUri = $namespaceUri;
    }


    /**
     * Get the namespace URI.
     *
     * @return string|null
     */
    public function getContentNamespaceUri(): ?string
    {
        return $this->namespaceUri;
    }



    /**
     * Splits a QName into an array holding the prefix (or null if no prefix is available) and the localName
     *
     * @param string $qName  The qualified name
     * @return array{null|string, string}
     */
    private static function parseQName(string $qName): array
    {
        Assert::validQName($qName);

        @list($prefix, $localName) = preg_split('/:/', $qName, 2);
        if ($localName === null) {
            $prefix = null;
            $localName = $qName;
        }

        Assert::nullOrValidNCName($prefix);
        Assert::validNCName($localName);

        return [$prefix, $localName];
    }


    /**
     * Convert XML into a NotUnderstood
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'NotUnderstood', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, NotUnderstood::NS, InvalidDOMElementException::class);

        /** @psalm-var string $qname */
        $qname = self::getAttribute($xml, 'qname');

        list($prefix, $localName) = self::parseQName($qname);
        /** @psalm-suppress PossiblyNullArgument */
        $namespace = $xml->lookupNamespaceUri($prefix);

        return new static($qname, $namespace);
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

        list($prefix, $localName) = self::parseQName($this->getQName());
        $namespaceUri = $this->getContentNamespaceUri();
        /** @psalm-suppress RedundantConditionGivenDocblockType */
        if ($namespaceUri !== null && $prefix !== null) {
            /** @psalm-suppress TypeDoesNotContainNull */
            if ($e->lookupNamespaceUri($prefix) === null && $e->lookupPrefix($namespaceUri) === null) {
                // The namespace is not yet available in the document - insert it
                $e->setAttribute('xmlns:' . $prefix, $namespaceUri);
            }
        }

        $e->setAttribute('qname', ($prefix === null) ? $localName : ($prefix . ':' . $localName));

        return $e;
    }
}
