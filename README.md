Strip-tags
==========

remove PHP and HTML Tags from a string in a custom and efficient  way

[![Build Status](https://travis-ci.org/manuwhat/strip-tags.svg?branch=master)](https://travis-ci.org/manuwhat/strip-tags)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/manuwhat/strip-tags/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/manuwhat/strip-tags/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/manuwhat/strip-tags/badges/build.png?b=master)](https://scrutinizer-ci.com/g/manuwhat/strip-tags/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/manuwhat/strip-tags/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)


**Requires**: PHP 7.0+
=======



### Why strip-tags package if PHP have the strip_tags function ?
you could use it if you :

1. want to remove tags with some attributes only

2. want to remove some attributes from some tags

3. want to strip only HTML not PHP or only PHP not HTML

4. want to remove completely some tags and  from other tags  partially remove some of
their attributes

5. want to specify tags to remove instead of tags to keep or tags to keep instead of tags to remove.

### How to use it

Require the library by issuing this command:

```bash
composer require manuwhat/strip-tags
```

then you can use it this way:



```php
$data=$data='<!doctype html><html><head>'.$x.$y.'</head><!-- a comment --> <body><?php echo here <br>; ?> <h2 onmousedown="alert(\'keke\');">u</h2><p></p><h2>a</h2></body></html>';
//$data can be a source string or a file
$hstrip=new htmlstrip($data,'remove',array(Htmlstrip::getTags(),true));//strip every thing PHP and HTML TAGS
$hstrip=new htmlstrip($data,'remove',array('<php>,<script>',true));//remove PHP and sript tags
$hstrip=new htmlstrip($data,'replace',array('<php>,<script>',true),array('onemouseover','true'));//remove PHP and sript tags and onemouseover attributes
//tags and attributes can be specified as array instead of string
var_export(htmlspecialchars($hstrip->go()));//execute
//finally you can refine your choices...
var_export(htmlspecialchars($hstrip->go(htmlstrip::TAGS)));//act only on tags
var_export(htmlspecialchars($hstrip->go(htmlstrip::ATTRIBUTES)));//act only on attributes
var_export(htmlspecialchars($hstrip->go(htmlstrip::TAGS_AND_ATTRIBUTES)));//act on tags and  attributes this is the default behavior
var_export(htmlspecialchars($hstrip->go(htmlstrip::TAGS_WITH_ATTRIBUTES)));//act on tags with some attributes 

```

To run unit tests
```bash
composer test
```
