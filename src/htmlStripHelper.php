<?php
namespace EZAMA{
abstract class htmlstripHelper
{
    const TAGS=3;
    const ATTRIBUTES=4;
    const TAGS_AND_ATTRIBUTES=1;
    const TAGS_WITH_ATTRIBUTES=2;
    
    protected $is_php=false;
    protected $is_html=false;
    protected $allowedTags=array();
    protected $allowedAttributes=array();
    protected $html='';
    protected $doctype;
    protected $body;
    protected $head;
    protected $html_tag;
    protected static $events_attributes=array(
  'onabort' => 1,
  'onafterprint' => 1,
  'onbeforeprint' => 1,
  'onbeforeunload' => 1,
  'onblur' => 1,
  'oncanplay' => 1,
  'oncanplaythrough' => 1,
  'onchange' => 1,
  'onclick' => 1,
  'oncontextmenu' => 1,
  'oncopy' => 1,
  'oncuechange' => 1,
  'oncut' => 1,
  'ondblclick' => 1,
  'ondrag' => 1,
  'ondragend' => 1,
  'ondragenter' => 1,
  'ondragleave' => 1,
  'ondragover' => 1,
  'ondragstart' => 1,
  'ondrop' => 1,
  'ondurationchange' => 1,
  'onemptied' => 1,
  'onended' => 1,
  'onerror' => 1,
  'onfocus' => 1,
  'onhashchange' => 1,
  'oninput' => 1,
  'oninvalid' => 1,
  'onkeydown' => 1,
  'onkeypress' => 1,
  'onkeyup' => 1,
  'onload' => 1,
  'onloadeddata' => 1,
  'onloadedmetadata' => 1,
  'onloadstart' => 1,
  'onmousedown' => 1,
  'onmousemove' => 1,
  'onmouseout' => 1,
  'onmouseover' => 1,
  'onmouseup' => 1,
  'onmousewheel' => 1,
  'onoffline' => 1,
  'ononline' => 1,
  'onpageshow' => 1,
  'onpaste' => 1,
  'onpause' => 1,
  'onplay' => 1,
  'onplaying' => 1,
  'onprogress' => 1,
  'onratechange' => 1,
  'onreset' => 1,
  'onresize' => 1,
  'onscroll' => 1,
  'onsearch' => 1,
  'onseeked' => 1,
  'onseeking' => 1,
  'onselect' => 1,
  'onstalled' => 1,
  'onsubmit' => 1,
  'onsuspend' => 1,
  'ontimeupdate' => 1,
  'ontoggle' => 1,
  'onunload' => 1,
  'onvolumechange' => 1,
  'onwaiting' => 1,
  'onwheel' => 1
 );
 
    protected static $attributes=array(
  'accept' => 1,
  'accesskey' => 1,
  'action' => 1,
  'alt' => 1,
  'async' => 1,
  'autocomplete' => 1,
  'autofocus' => 1,
  'autoplay' => 1,
  'charset' => 1,
  'checked' => 1,
  'cite' => 1,
  'class' => 1,
  'cols' => 1,
  'colspan' => 1,
  'content' => 1,
  'contenteditable' => 1,
  'controls' => 1,
  'coords' => 1,
  'data' => 1,
  'datetime' => 1,
  'default' => 1,
  'defer' => 1,
  'dir' => 1,
  'dirname' => 1,
  'disabled' => 1,
  'download' => 1,
  'draggable' => 1,
  'dropzone' => 1,
  'enctype' => 1,
  'for' => 1,
  'form' => 1,
  'formaction' => 1,
  'headers' => 1,
  'height' => 1,
  'hidden' => 1,
  'high' => 1,
  'href' => 1,
  'hreflang' => 1,
  'http' => 1,
  'id' => 1,
  'ismap' => 1,
  'kind' => 1,
  'label' => 1,
  'lang' => 1,
  'list' => 1,
  'loop' => 1,
  'low' => 1,
  'max' => 1,
  'maxlength' => 1,
  'media' => 1,
  'method' => 1,
  'min' => 1,
  'multiple' => 1,
  'muted' => 1,
  'name' => 1,
  'novalidate' => 1,
  'onabort' => 1,
  'onafterprint' => 1,
  'onbeforeprint' => 1,
  'onbeforeunload' => 1,
  'onblur' => 1,
  'oncanplay' => 1,
  'oncanplaythrough' => 1,
  'onchange' => 1,
  'onclick' => 1,
  'oncontextmenu' => 1,
  'oncopy' => 1,
  'oncuechange' => 1,
  'oncut' => 1,
  'ondblclick' => 1,
  'ondrag' => 1,
  'ondragend' => 1,
  'ondragenter' => 1,
  'ondragleave' => 1,
  'ondragover' => 1,
  'ondragstart' => 1,
  'ondrop' => 1,
  'ondurationchange' => 1,
  'onemptied' => 1,
  'onended' => 1,
  'onerror' => 1,
  'onfocus' => 1,
  'onhashchange' => 1,
  'oninput' => 1,
  'oninvalid' => 1,
  'onkeydown' => 1,
  'onkeypress' => 1,
  'onkeyup' => 1,
  'onload' => 1,
  'onloadeddata' => 1,
  'onloadedmetadata' => 1,
  'onloadstart' => 1,
  'onmousedown' => 1,
  'onmousemove' => 1,
  'onmouseout' => 1,
  'onmouseover' => 1,
  'onmouseup' => 1,
  'onmousewheel' => 1,
  'onoffline' => 1,
  'ononline' => 1,
  'onpageshow' => 1,
  'onpaste' => 1,
  'onpause' => 1,
  'onplay' => 1,
  'onplaying' => 1,
  'onprogress' => 1,
  'onratechange' => 1,
  'onreset' => 1,
  'onresize' => 1,
  'onscroll' => 1,
  'onsearch' => 1,
  'onseeked' => 1,
  'onseeking' => 1,
  'onselect' => 1,
  'onstalled' => 1,
  'onsubmit' => 1,
  'onsuspend' => 1,
  'ontimeupdate' => 1,
  'ontoggle' => 1,
  'onunload' => 1,
  'onvolumechange' => 1,
  'onwaiting' => 1,
  'onwheel' => 1,
  'open' => 1,
  'optimum' => 1,
  'pattern' => 1,
  'placeholder' => 1,
  'poster' => 1,
  'preload' => 1,
  'readonly' => 1,
  'rel' => 1,
  'required' => 1,
  'reversed' => 1,
  'rows' => 1,
  'rowspan' => 1,
  'sandbox' => 1,
  'scope' => 1,
  'selected' => 1,
  'shape' => 1,
  'size' => 1,
  'sizes' => 1,
  'span' => 1,
  'spellcheck' => 1,
  'src' => 1,
  'srcdoc' => 1,
  'srclang' => 1,
  'source' => 1,
  'start' => 1,
  'step' => 1,
  'style' => 1,
  'tabindex' => 1,
  'target' => 1,
  'title' => 1,
  'translate' => 1,
  'type' => 1,
  'usemap' => 1,
  'value' => 1,
  'width' => 1,
  'wrap' => 1,
);
    protected static $tags=array(
  '<php>'=> 1,
  '<!-- -->' => 1,
  '<doctypetag>' => 1,
  '<a>' => 1,
  '<abbr>' => 1,
  '<acronym>' => 1,
  '<address>' => 1,
  '<applet>' => 1,
  '<embed>' => 1,
  '<object>' => 1,
  '<area>' => 1,
  '<article>' => 1,
  '<aside>' => 1,
  '<audio>' => 1,
  '<b>' => 1,
  '<base>' => 1,
  '<basefont>' => 1,
  '<bdi>' => 1,
  '<bdo>' => 1,
  '<big>' => 1,
  '<blockquote>' => 1,
  '<bodytag>' => 1,
  '<br>' => 1,
  '<button>' => 1,
  '<canvas>' => 1,
  '<caption>' => 1,
  '<center>' => 1,
  '<cite>' => 1,
  '<code>' => 1,
  '<col>' => 1,
  '<colgroup>' => 1,
  '<data>' => 1,
  '<datalist>' => 1,
  '<dd>' => 1,
  '<del>' => 1,
  '<details>' => 1,
  '<dfn>' => 1,
  '<dialog>' => 1,
  '<dir>' => 1,
  '<ul>' => 1,
  '<div>' => 1,
  '<dl>' => 1,
  '<dt>' => 1,
  '<em>' => 1,
  '<fieldset>' => 1,
  '<figcaption>' => 1,
  '<figure>' => 1,
  '<font>' => 1,
  '<footer>' => 1,
  '<form>' => 1,
  '<frame>' => 1,
  '<frameset>' => 1,
  '<h1>' => 1,
  '<h2>' => 1,
  '<h3>' => 1,
  '<h5>' => 1,
  '<h6>' => 1,
  '<hn>' => 1,
  '<head>' => 1,
  '<header>' => 1,
  '<hr>' => 1,
  '<htmltag>' => 1,
  '<i>' => 1,
  '<iframe>' => 1,
  '<img>' => 1,
  '<input>' => 1,
  '<ins>' => 1,
  '<kbd>' => 1,
  '<label>' => 1,
  '<legend>' => 1,
  '<li>' => 1,
  '<link>' => 1,
  '<main>' => 1,
  '<map>' => 1,
  '<mark>' => 1,
  '<meta>' => 1,
  '<meter>' => 1,
  '<nav>' => 1,
  '<noframes>' => 1,
  '<noscript>' => 1,
  '<ol>' => 1,
  '<optgroup>' => 1,
  '<option>' => 1,
  '<output>' => 1,
  '<p>' => 1,
  '<param>' => 1,
  '<picture>' => 1,
  '<pre>' => 1,
  '<progress>' => 1,
  '<q>' => 1,
  '<rp>' => 1,
  '<rt>' => 1,
  '<ruby>' => 1,
  '<s>' => 1,
  '<samp>' => 1,
  '<script>' => 1,
  '<section>' => 1,
  '<select>' => 1,
  '<small>' => 1,
  '<source>' => 1,
  '<span>' => 1,
  '<strike>' => 1,
  '<strong>' => 1,
  '<style>' => 1,
  '<sub>' => 1,
  '<summary>' => 1,
  '<sup>' => 1,
  '<svg>' => 1,
  '<table>' => 1,
  '<tbody>' => 1,
  '<td>' => 1,
  '<template>' => 1,
  '<textarea>' => 1,
  '<tfoot>' => 1,
  '<th>' => 1,
  '<thead>' => 1,
  '<time>' => 1,
  '<title>' => 1,
  '<tr>' => 1,
  '<track>' => 1,
  '<tt>' => 1,
  '<u>' => 1,
  '<var>' => 1,
  '<video>' => 1,
  '<wbr>' => 1,
);

	protected function loadHTML($html)
    {   
        if (!strlen($html)) {
            throw new \InvalidArgumentException("Empty string given");
        }
        $xml = new \DOMDocument();
		//Suppress warnings: proper error handling is beyond scope of example
        libxml_use_internal_errors(true);
        
        $true=$xml->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        if ($true) {
            $this->html=$xml;
        }
    }
    
    protected function handleTags($notAllowedTags, $callback, $callback1)
    {
        if (!is_array($notAllowedTags)) {
            return false;
        }
        if (count($notAllowedTags)!==2) {
            return false;
        }
        $notAllowedTags=array_values($notAllowedTags);
        $keep=(bool)$notAllowedTags[1];
        $notAllowedTags=$notAllowedTags[0];
        if (is_string($notAllowedTags)) {
            $notAllowedTags=explode(',', $notAllowedTags);
        }
        if (is_array($notAllowedTags)) {
            $notAllowedTags=array_filter(array_map($callback, $notAllowedTags), $callback1);
            $this->allowedTags=!$keep ?array_fill_keys($notAllowedTags, 1) : array_diff_key(self::$tags, array_flip($notAllowedTags));
        } else {
            return false;
        }
        return true;
    }

    protected function handleAttributes($notAllowedAttributes, $callback, $callback2)
    {
        if (!is_array($notAllowedAttributes)) {
            return false;
        }
        if (count($notAllowedAttributes)!==2) {
            return false;
        }
        $keep=(bool)$notAllowedAttributes[1];
        $notAllowedAttributes=$notAllowedAttributes[0];
        if (is_string($notAllowedAttributes)) {
            $notAllowedAttributes=explode(',', $notAllowedAttributes);
        }
        if (is_array($notAllowedAttributes)) {
            $notAllowedAttributes=array_filter(array_map($callback, $notAllowedAttributes), $callback2);
            $this->allowedAttributes=!$keep ?array_fill_keys($notAllowedAttributes, 1) : array_diff_key(self::$attributes, array_flip($notAllowedAttributes));
        } else {
            return false;
        }
        return true;
    }
    
    protected static function handlePhp($is_php, $domDoc, &$allowed_tags)
    {
        $result=$domDoc->saveHTML();
        self::handleMainHtmlTags($result, $allowed_tags);
        return substr(($is_php&&isset($allowed_tags['<php>']))?
        str_replace(array('<php>','</php>'), array('<?php ','?>'), $result):
        $result, stripos($result, '<div>')+5, -7);
    }
  
    protected static function handleMainHtmlTags(&$result, &$allowed_tags)
    {
        $result=str_replace(
            array('<doctypetag', '</doctypetag>', '<headtag', '</headtag', '<htmltag', '</htmltag', '<bodytag', '</bodytag'),
            array('<!doctype', '', '<head', '</head', '<html', '</html', '<body', '</body'),
            $result
                        );
        if (!isset($allowed_tags['<doctypetag>'])) {
            $doctypeOffset=stripos($result, '<!doctype');
            $result=str_replace(substr($result, $doctypeOffset, strpos($result, '>', $doctypeOffset)+1-$doctypeOffset), '', $result);
        }
    }
    protected static function handleComments($domDoc, &$allowed_tags)
    {
        if (!isset($allowed_tags['<!-- -->'])) {
            $xpath=new \DOMXPath($domDoc);
            $DomComments=$xpath->query("//comment()");
            foreach ($DomComments as $DomComment) {
                $DomComment->parentNode->removeChild($DomComment);
            }
        }
    }
    protected static function stripAttributes($tag, &$allowed_attrs, $type=1)
    {
        if ($tag instanceof \DOMElement) {
            if ($type===2) {
                self:: stripAttributesTypeTwo($tag, $allowed_attrs);
            } else {
                self::stripAttributesTypeOne($tag, $allowed_attrs);
            }
        }
    }
    
    protected static function stripAttributesTypeOne($tag, &$allowed_attrs)
    {
        foreach (Iterator_to_array($tag->attributes) as $attr) {
            if (!isset($allowed_attrs[$attr->nodeName])) {
                $tag->removeAttribute($attr->nodeName);
            }
        }
    }
    
    protected static function stripAttributesTypeTwo($tag, &$allowed_attrs)
    {
        foreach (Iterator_to_array($tag->attributes) as $attr) {
            if (!isset($allowed_attrs[$attr->nodeName])) {
                if ($tag->parentNode) {
                    $tag->parentNode->removeChild($tag);
                }
            }
        }
    }
}

}
