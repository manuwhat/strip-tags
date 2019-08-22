<?php

namespace EZAMA{
class prepareStrip
{
    protected $state;
    protected $preprocessed;

    public function __construct(beforeStrip $prepocessed)
    {
        if ($prepocessed->mustLoadMulti()) {
            $this->state = 'multi';
        } else {
            $this->state = 'single';
        }
        $this->prepocessed = $prepocessed;
    }

    public function getPrepared()
    {
        if ($this->state === 'single') {
            return $this->prepocessed->getContent();
        }
        $prepared = $this->preparePhp() + $this->prepareHtml();
        ksort($prepared);

        return join('', $prepared);
    }

    public function prepareHtml()
    {
        return  array_map(function ($v) {
            return is_array($v) ? $v[1] : $v;
        }, $this->prepocessed->getHTML());
    }

    public function preparePhp()
    {
        return array_map(function ($v) {
            return is_array($v) && ($v[0] === T_OPEN_TAG || $v[0] === T_CLOSE_TAG) ? ($v[0] === T_OPEN_TAG ? '<php>' : '</php>') : (is_array($v) ? $v[1] : $v);
        }, $this->prepocessed->getPHP());
    }
}
}
