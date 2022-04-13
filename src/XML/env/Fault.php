<?php

namespace SimpleSAML\SOAP\XML\env;

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
     * The Code element
     *
     * @var \SimpleSAML\SOAP\XML\env\Code
     */
    protected Code $code;

    /**
     * The Reason element
     *
     * @var \SimpleSAML\SOAP\XML\env\Reason
     */
    protected Reason $reason;

    /**
     * The Node element
     *
     * @var \SimpleSAML\SOAP\XML\env\Node|null
     */
    protected ?Node $node;

    /**
     * The Role element
     *
     * @var \SimpleSAML\SOAP\XML\env\Role|null
     */
    protected ?Role $role;

    /**
     * The Detail element
     *
     * @var \SimpleSAML\SOAP\XML\env\Detail|null
     */
    protected ?Detail $detail;


    /**
     * Initialize a env:Fault
     *
     * @param \SimpleSAML\SOAP\XML\env\Code $code
     * @param \SimpleSAML\SOAP\XML\env\Reason $reason
     * @param \SimpleSAML\SOAP\XML\env\Node|null $node
     * @param \SimpleSAML\SOAP\XML\env\Role|null $role
     * @param \SimpleSAML\SOAP\XML\env\Detail|null $detail
     */
    public function __construct(
        Code $code,
        Reason $reson,
        ?Node $node = null,
        ?Role $role = null,
        ?Detail $detail = null
    ) {
        $this->setCode($code);
        $this->setReason($reason);
        $this->setNode($node);
        $this->setRole($role);
        $this->setDetail($detail);
    }


    /**
     * @return \SimpleSAML\SOAP\XML\env\Code
     */
    public function getCode(): Code
    {
        return $this->code;
    }


    /**
     * @param \SimpleSAML\SOAP\XML\env\Code $code
     */
    protected function setCode(Code $code): void
    {
        $this->code = $code;
    }


    /**
     * @return \SimpleSAML\SOAP\XML\env\Reason
     */
    public function getReason(): Reason
    {
        return $this->reason;
    }


    /**
     * @param \SimpleSAML\SOAP\XML\env\Reason $reason
     */
    protected function setReason(Reason $reason): void
    {
        $this->reason = $reason;
    }


    /**
     * @return \SimpleSAML\SOAP\XML\env\Node|null
     */
    public function getNode(): ?Node
    {
        return $this->node;
    }


    /**
     * @param \SimpleSAML\SOAP\XML\env\Node|null $node
     */
    protected function setNode(?Node $node): void
    {
        $this->node = $node;
    }


    /**
     * @return \SimpleSAML\SOAP\XML\env\Role|null
     */
    public function getRole(): ?Role
    {
        return $this->role;
    }


    /**
     * @param \SimpleSAML\SOAP\XML\env\Role|null $role
     */
    protected function setRole(?Role $role): void
    {
        $this->role = $role;
    }


    /**
     * @return \SimpleSAML\SOAP\XML\env\Detail|null
     */
    public function getDetail(): ?Detail
    {
        return $this->detail;
    }


    /**
     * @param \SimpleSAML\SOAP\XML\env\Detail|null $detail
     */
    protected function setDetail(?Detail $detail): void
    {
        $this->detail = $detail;
    }


    /**
     * Convert XML into an Fault element
     *
     * @param \DOMElement $xml The XML element we should load
     * @return self
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): self
    {
        Assert::same($xml->localName, 'Fault', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, Fault::NS, InvalidDOMElementException::class);

        $code = Code::getChildrenOfClass($xml);
        Assert::count($code, 1, 'Must contain exactly one Code', MissingElementException::class);

        $reason = Reason::getChildrenOfClass($xml);
        Assert::count($reason, 1, 'Must contain exactly one Reason', MissingElementException::class);

        $node = Node::getChildrenOfClass($xml);
        Assert::maxCount($node, 1, 'Cannot process more than one Node element.', TooManyElementsException::class);

        $role = Role::getChildrenOfClass($xml);
        Assert::maxCount($role, 1, 'Cannot process more than one Role element.', TooManyElementsException::class);

        $detail = Detail::getChildrenOfClass($xml);
        Assert::maxCount($detail, 1, 'Cannot process more than one Detail element.', TooManyElementsException::class);

        return new self(
            array_pop($code),
            array_pop($reason),
            empty($node) ? null : array_pop($node),
            empty($role) ? null : array_pop($role),
            empty($detail) ? null : array_pop($detail)
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

        $this->code->toXML($e);
        $this->reason->toXML($e);

        if ($this->node !== null) {
            $this->node->toXML($e);
        }

        if ($this->role !== null) {
            $this->role->toXML($e);
        }
        if ($this->detail !== null) {
            $this->detail->toXML($e);
        }

        return $e;
    }
}
