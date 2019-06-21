<?php
namespace EZAMA{
class prepareStrip
{
    protected $state ;
    protected $preprocessed;
    public function __construct(beforeStrip $prepocessed)
    {
        if ($prepocessed->mustLoadMulti()) {
            $this->state='multi';
        } else {
            $this->state='single';
        }
        $this->prepocessed=$prepocessed;
    }
    
    public function getPrepared()
    {
        if ($this->state==='single') {
            return $this->prepocessed->getContent();
        }
        $prepared=
            array_map(function ($v) {
                return is_array($v)&&($v[0]===T_OPEN_TAG||$v[0]===T_CLOSE_TAG)?($v[0]===T_OPEN_TAG?'<php>':'</php>'):(is_array($v)?$v[1]:$v);
            }, $this->prepocessed->getPHP())+
            array_map(function ($v) {
                return is_array($v)?$v[1]:$v;
            }, $this->prepocessed->getHTML())
        ;
        ksort($prepared);
        return join('', $prepared);
    }
}
}
