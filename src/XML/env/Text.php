<?php

namespace SimpleSAML\SOAP\XML\env;

use DOMAttr;
use DOMElement;
use DOMNameSpaceNode;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Constants as C;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\LocalizedStringElementTrait;

/**
 * Class representing a env:Text element.
 *
 * @package simplesaml/xml-soap
 */
final class Text extends AbstractSoapElement
{
    use LocalizedStringElementTrait;


    /**
     * Initialize a env:Text
     *
     * @param string $language
     * @param string $content
     */
    public function __construct(string $language, string $content)
    {
        $this->setContent($content);
        $this->setLanguage($language);
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
}
