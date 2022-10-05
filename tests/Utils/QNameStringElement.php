<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SOAP;

use SimpleSAML\SOAP\XML\QNameStringElementTrait;
use SimpleSAML\XML\AbstractElement;

/**
 * Empty shell class for testing QNameStringElement.
 *
 * @package simplesaml/xml-soap
 */
final class QNameStringElement extends AbstractElement
{
    use QNameStringElementTrait;

    /** @var string */
    public const NS = 'urn:x-simplesamlphp:namespace';

    /** @var string */
    public const NS_PREFIX = 'ssp';


    /**
     * @param string $qname
     * @param string|null $namespaceUri
     */
    public function __construct(string $qname, ?string $namespaceUri = null)
    {
        $this->setContent($qname);
        $this->setContentNamespaceUri($namespaceUri);
    }
}
