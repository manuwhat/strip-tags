<?php


$DIR=dirname(__DIR__).DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR;
foreach (array('DOMNodeRecursiveIterator','beforeStrip','prepareStrip','htmlStripHelper','htmlStrip') as $file) {
    require_once($DIR.$file.'.php');
}


use PHPUnit\Framework\TestCase;
use EZAMA\htmlStrip;

class htmlStripTest extends TestCase
{
    public function testGo()
    {
        $x='<script type="text/javascript" async="" src="./Transitioning%20from%20Data%20Developer%20to%20Data%20Scientist%20-%20Statistics%20for%20Data%20Science_files/f.txt">';
        $data='aaaaa<?php echo here ; ?><!doctype><html><head>'.$x.'</head><!-- a comment --> <body><?php echo here ; ?> <h2 onmousedown="alert(\'keke\');">u</h2><p></p><h2>a</h2></body></html>b2b2 ';
        
        $hstrip=new htmlStrip($data, 'replace', array('<h2>',false));
        $this->assertTrue($hstrip->go()===strip_tags($data, '<h2>'));
        
        
        $hstrip=new htmlStrip($data);
        $this->assertTrue($hstrip->go()===strip_tags($data));
        
        $hstrip=new htmlStrip($data, 'replace', array('',true), array('src',true));
        $this->assertFalse((bool)stripos($hstrip->go(htmlStrip::ATTRIBUTES), 'src'));
        
        $hstrip=new htmlStrip($data, 'replace', array('',true), array('src',false));
        $this->assertFalse((bool)stripos($hstrip->go(htmlStrip::ATTRIBUTES), 'type'));
        $this->assertTrue((bool)stripos($hstrip->go(htmlStrip::ATTRIBUTES), 'src'));
    }
}
