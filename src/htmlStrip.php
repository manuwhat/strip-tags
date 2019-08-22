<?php

namespace EZAMA{
class htmlStrip extends htmlStripHelper
{
    protected $type;

    public function __construct($html, $type = 'replace', $notAllowedTags = ['', false], $notAllowedAttributes = ['', false])
    {
        $callback = function ($v) {
            return trim(strtolower($v));
        };
        if (!$this->handleTags($notAllowedTags, $callback, function ($v) {
            return isset(self::$tags[$v]);
        })) {
            $this->allowedTags = self::$tags;
        }
        if (!$this->handleAttributes($notAllowedAttributes, $callback, function ($v) {
            return isset(self::$attributes[$v]);
        })) {
            $this->allowedAttributes = self::$attributes;
        }
        $this->type = !is_string($type) || !in_array($tmp = strtolower(trim($type)), ['remove', 'replace']) ? 'remove' : $tmp;

        $bs = new BeforeStrip($html);
        $this->is_html = $bs->isHtml();
        $this->is_php = $bs->isPHP();
        $bs = new prepareStrip($bs);
        $this->loadHTML($bs->getPrepared());
    }

    public function go($type = self::TAGS)
    {
        switch ($type) {
            case self::TAGS_AND_ATTRIBUTES:
                return self::strip($this->html, $this->type, $this->allowedTags, $this->allowedAttributes, $this->is_php);
            break;
            case self::TAGS_WITH_ATTRIBUTES:
                return self::stripTagsWithAttrs($this->html, $this->allowedTags, $this->allowedAttributes, $this->is_php);
            break;
            case self::TAGS:
                return self::strip($this->html, $this->type, $this->allowedTags, self::$attributes, $this->is_php);
            break;
            case self::ATTRIBUTES:
                return self::strip($this->html, $this->type, self::$tags, $this->allowedAttributes, $this->is_php);
            break;
            default:
                throw new invalidArgumentException('unexpected strip type');
            break;
        }
    }

    protected static function strip($domDoc, $type, $allowed_tags, $allowed_attrs, $is_php)
    {
        $firstDiv = 0;
        if (count(self::$tags) > count($allowed_tags) || count(self::$attributes) > count($allowed_attrs)) {
            foreach (new DOMNodeRecursiveIterator($domDoc->getElementsByTagName('*'))as $tag) {
                if (!isset($allowed_tags['<' . $tag->tagName . '>'])) {
                    if (self::skipUsefull($tag, $firstDiv)) {
                        continue;
                    }
                    self::replaceOrRemove($tag, $type);
                } else {
                    self::stripAttributes($tag, $allowed_attrs);
                }
            }

            self::handleComments($domDoc, $allowed_tags);
        }

        return self::handlePhp($is_php, $domDoc, $allowed_tags);
    }

    protected static function skipUsefull($tag, &$firstDiv)
    {
        if ($tag->tagName === 'div' && !$firstDiv) {
            $firstDiv++;

            return true;
        }
        if ($tag->tagName === 'doctypetag') {
            return true;
        }
    }

    private static function replaceOrRemove($tag, $type)
    {
        if ($type === 'remove') {
            $tag->parentNode->removeChild($tag);
        } else {
            if (!in_array(strtolower($tag->tagName), ['php', 'style', 'script'])) {
                $elem = $tag->parentNode;
                $childNodes = $tag->childNodes;
                while ($childNodes->length > 0) {
                    $elem->insertBefore($childNodes->item(0), $tag);
                }
                $elem->removeChild($tag);
            } else {
                $tag->parentNode->removeChild($tag);
            }
        }
    }

    protected static function stripTagsWithAttributes($domDoc, &$allowed_tags, &$allowed_attrs, $is_php)
    {
        if (count(self::$attributes) > count($allowed_attrs)) {
            foreach (new DOMNodeRecursiveIterator($domDoc->getElementsByTagName('*'))as $tag) {
                self::stripAttributes($tag, $allowed_attrs, 2);
            }
        }

        return self::handlePhp($is_php, $domDoc, $allowed_tags);
    }

    public static function getEventsAttributes()
    {
        return array_keys(self::$events_attributes);
    }

    public static function getAttributes()
    {
        return array_keys(self::$attributes);
    }

    public static function getTags()
    {
        return array_keys(self::$tags);
    }
}
}
