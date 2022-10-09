<?php

namespace SimpleSAML\SOAP\XML\env;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\StringElementTrait;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * Class representing a env:Node element.
 *
 * @package simplesaml/xml-soap
 */
final class Node extends AbstractSoapElement
{
    use StringElementTrait;


    /**
     * Initialize a env:Node
     *
     * @param string $node
     */
    public function __construct(string $node)
    {
        $this->setContent($node);
    }


    /**
     * Validate the content of the element.
     *
     * @param string $content  The value to go in the XML textContent
     * @throws \Exception on failure
     * @return void
     */
    protected function validateContent(string $content): void
    {
        Assert::validURI($content, SchemaViolationException::class); // Covers the empty string
    }
}
