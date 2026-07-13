<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP11\Utils;

use Dom;
use SimpleSAML\SOAP11\Constants as C;

/**
 * Compilation of utilities for XPath.
 *
 * @package simplesamlphp/xml-soap
 */
class XPath extends \SimpleSAML\XPath\XPath
{
    /**
     * Get a Dom\XPath object that can be used to search for SAML elements.
     *
     * @param \Dom\Node $node The document to associate to the Dom\XPath object.
     * @param bool $autoregister Whether to auto-register all namespaces used in the document
     *
     * @return \Dom\XPath A Dom\XPath object ready to use in the given document, with several
     *   saml-related namespaces already registered.
     */
    public static function getXPath(Dom\Node $node, bool $autoregister = false): Dom\XPath
    {
        $xp = parent::getXPath($node, $autoregister);

        $xp->registerNamespace('env11', C::NS_SOAP_ENV);
        $xp->registerNamespace('enc11', C::NS_SOAP_ENC);

        return $xp;
    }
}
