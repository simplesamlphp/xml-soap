<?php

namespace SimpleSAML\SOAP\XML\env;

use DOMAttr;
use DOMElement;
use DOMNameSpaceNode;
use SimpleSAML\Assert\Assert;
use SimpleSAML\SOAP\XML\QNameStringElementTrait;
use SimpleSAML\XML\Exception\InvalidDOMElementException;

/**
 * Class representing a env:Value element.
 *
 * @package simplesaml/xml-soap
 */
final class Value extends AbstractSoapElement
{
    use QNameStringElementTrait;


    /**
     * Initialize a env:Value
     *
     * @param string $qname
     * @param string|null $namespaceUri
     */
    public function __construct(string $qname, ?string $namespaceUri = null)
    {
        $this->setContent($qname);
        $this->setContentNamespaceUri($namespaceUri);
    }
}
