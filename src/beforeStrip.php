<?php
namespace EZAMA{
class BeforeStrip
{
    protected $multi=false;
    protected $is_html=false;
    protected $is_php=false;
    protected $html=array();
    protected $php=array();
    protected $content='';
    protected $doctype;
    protected $body;
    protected $head;
    protected $html_tag;
    public function __construct($html)
    {
        if (!is_string($html)) {
            throw new \InvalidArgumentException(sprintf('Waiting string, %s given', gettype($html)));
        }
        $html=is_file($html) ?file_get_contents($html) : $html;
        $this->setMainTags($html);
        
        $html='<div>'.str_replace(
            array($this->doctype, $this->html_tag, '</html>', $this->head, '</head>', $this->body, '</body>'),
            array('<doctypetag '.substr($this->doctype, 10), '<htmltag '.substr($this->html_tag, 5), '</htmltag>', '<headtag '.substr($this->head, 5), '</headtag>', '<bodytag '.substr($this->body, 5), '</bodytag>'),
            $html
                              ).'</doctypetag></div>';
        $preprocessed=token_get_all($html);
        
        $HTML=array_filter($preprocessed, function($v) {
            return is_array($v)&&$v[0]===T_INLINE_HTML;
        });
        $PHP=array_diff_key($preprocessed, $HTML);
        $this->init($HTML, $PHP, $html);
    }
    
    protected function setMainTags(&$html)
    {
        $doctypeOffset=stripos($html, '<!doctype ');
        $headOffset=stripos($html, '<head');
        $htmlTagOffset=stripos($html, '<html');
        $bodyOffset=stripos($html, '<body');
        if (false!==$doctypeOffset) {
            $endDoctypeOffset=strpos($html, '>', $doctypeOffset);
            $this->doctype=substr($html, $doctypeOffset, $endDoctypeOffset-$doctypeOffset+1);
        }
        if (false!==$headOffset) {
            $endHeadOffset=strpos($html, '>', $headOffset);
            $this->head=substr($html, $headOffset, $endHeadOffset-$headOffset+1);
        }
        if (false!==$bodyOffset) {
            $endBodyOffset=strpos($html, '>', $bodyOffset);
            $this->body=substr($html, $bodyOffset, $endBodyOffset-$bodyOffset+1);
        }
        if (false!==$htmlTagOffset) {
            $endHtmlTagOffset=strpos($html, '>', $htmlTagOffset);
            $this->html_tag=substr($html, $htmlTagOffset, $endHtmlTagOffset-$htmlTagOffset+1);
        }
    }
    protected function init(&$HTML, &$PHP, &$html)
    {
        list($is_h, $is_p)=array((bool)$HTML, (bool)$PHP);
        list($this->is_html, $this->is_php, $this->multi, $this->content, $this->html, $this->php)=array($is_h, $is_p, $is_h&&$is_p, $html, $is_p ? $HTML : array(), $is_p ? $PHP : array());
    }
    
    public function mustLoadMulti()
    {
        return $this->multi;
    }
    
    public function isHtml()
    {
        return $this->is_html;
    }
    public function isPHP()
    {
        return $this->is_php;
    }
    
    public function getPHP()
    {
        return $this->php;
    }
    
    public function getHTML()
    {
        return $this->html;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function getDoctype()
    {
        return $this->doctype;
    }
    public function getHead()
    {
        return $this->head;
    }
    public function getBody()
    {
        return $this->body;
    }
    public function getHtmlTag()
    {
        return $this->html_tag;
    }
}
}
