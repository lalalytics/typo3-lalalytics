<?php

declare(strict_types=1);

namespace Z7\Lalalytics\Domain\Model;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class Event extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    protected string $type = '';
    protected string $selector = '';
    protected string $name = '';
    protected string $description = '';
    protected string $tags = '';
    protected string $attribute = '';
    protected string $site = '';

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function getTags(): string
    {
        return $this->tags;
    }

    public function getTagsList(): array
    {
        return match($this->tags) {
            '' => [],
            default => explode(',', $this->tags)
        };
    }

    public function setTags(string $tags)
    {
        $this->tags = $tags;
    }

    public function getSelector(): string
    {
        return $this->selector;
    }

    public function setSelector(string $selector)
    {
        $this->selector = $selector;
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }

    public function setAttribute(string $attribute)
    {
        $this->attribute = $attribute;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function getSite(): string
    {
        return $this->site;
    }

    public function setSite(string $site)
    {
        $this->site = $site;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'sel' => $this->getSelector(),
            'name' => $this->getName(),
            'tags' => $this->getTags() ? GeneralUtility::trimExplode(',', $this->getTags()) : null,
            'attr' => $this->getAttribute()
        ];
    }
}
