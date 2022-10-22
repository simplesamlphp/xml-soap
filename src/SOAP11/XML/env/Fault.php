<?php

declare(strict_types=1);

namespace SimpleSAML\SOAP11\XML\env;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\TooManyElementsException;

/**
 * Class representing a env:Fault element.
 *
 * @package simplesaml/xml-soap
 */
final class Fault extends AbstractSoapElement
{
    /**
     * The faultcode element
     *
     * @var \SimpleSAML\SOAP11\XML\env\FaultCode
     */
    protected FaultCode $faultCode;

    /**
     * The faultstring element
     *
     * @var \SimpleSAML\SOAP11\XML\env\FaultString
     */
    protected FaultString $faultString;

    /**
     * The faultactor element
     *
     * @var \SimpleSAML\SOAP11\XML\env\FaultActor|null
     */
    protected ?FaultActor $faultActor;

    /**
     * The detail element
     *
     * @var \SimpleSAML\SOAP11\XML\env\Detail|null
     */
    protected ?Detail $detail;


    /**
     * Initialize a env:Fault
     *
     * @param \SimpleSAML\SOAP11\XML\env\FaultCode $faultCode
     * @param \SimpleSAML\SOAP11\XML\env\FaultString $faultString
     * @param \SimpleSAML\SOAP11\XML\env\FaultActor|null $faultActor
     * @param \SimpleSAML\SOAP11\XML\env\Detail|null $detail
     */
    public function __construct(
        FaultCode $faultCode,
        FaultString $faultString,
        ?FaultActor $faultActor = null,
        ?Detail $detail = null
    ) {
        $this->setFaultCode($faultCode);
        $this->setFaultString($faultString);
        $this->setFaultActor($faultActor);
        $this->setDetail($detail);
    }


    /**
     * @return \SimpleSAML\SOAP11\XML\env\FaultCode
     */
    public function getFaultCode(): FaultCode
    {
        return $this->faultCode;
    }


    /**
     * @param \SimpleSAML\SOAP11\XML\env\FaultCode $faultCode
     */
    protected function setFaultCode(FaultCode $faultCode): void
    {
        $this->faultCode = $faultCode;
    }


    /**
     * @return \SimpleSAML\SOAP11\XML\env\FaultString
     */
    public function getFaultString(): FaultString
    {
        return $this->faultString;
    }


    /**
     * @param \SimpleSAML\SOAP11\XML\env\FaultString $faultString
     */
    protected function setFaultString(FaultString $faultString): void
    {
        $this->faultString = $faultString;
    }


    /**
     * @return \SimpleSAML\SOAP11\XML\env\FaultActor|null
     */
    public function getFaultActor(): ?FaultActor
    {
        return $this->faultActor;
    }


    /**
     * @param \SimpleSAML\SOAP11\XML\env\FaultActor|null $faultActor
     */
    protected function setFaultActor(?FaultActor $faultActor): void
    {
        $this->faultActor = $faultActor;
    }


    /**
     * @return \SimpleSAML\SOAP11\XML\env\Detail|null
     */
    public function getDetail(): ?Detail
    {
        return $this->detail;
    }


    /**
     * @param \SimpleSAML\SOAP11\XML\env\Detail|null $detail
     */
    protected function setDetail(?Detail $detail): void
    {
        $this->detail = $detail;
    }


    /**
     * Convert XML into an Fault element
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'Fault', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, Fault::NS, InvalidDOMElementException::class);

        $faultCode = FaultCode::getChildrenOfClass($xml);
        Assert::count($faultCode, 1, 'Must contain exactly one faultcode', MissingElementException::class);

        $faultString = FaultString::getChildrenOfClass($xml);
        Assert::count($faultString, 1, 'Must contain exactly one faultstring', MissingElementException::class);

        $faultActor = FaultActor::getChildrenOfClass($xml);
        Assert::maxCount(
            $faultActor,
            1,
            'Cannot process more than one faultactor element.',
            TooManyElementsException::class
        );

        $detail = Detail::getChildrenOfClass($xml);
        Assert::maxCount($detail, 1, 'Cannot process more than one detail element.', TooManyElementsException::class);

        return new self(
            array_pop($faultCode),
            array_pop($faultString),
            array_pop($faultActor),
            array_pop($detail)
        );
    }


    /**
     * Convert this Fault to XML.
     *
     * @param \DOMElement|null $parent The element we should add this fault to.
     * @return \DOMElement This Fault-element.
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        $this->getFaultCode()->toXML($e);
        $this->getFaultString()->toXML($e);
        $this->getFaultActor()?->toXML($e);

        if ($this->getDetail() !== null && !$this->getDetail()->isEmptyElement()) {
            $this->getDetail()->toXML($e);
        }

        return $e;
    }
}
