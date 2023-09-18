<?php
// This file is part of PowerEduc - http://powereduc.org/
//
// PowerEduc is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// PowerEduc is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with PowerEduc.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Unit test for the filter_urltolink
 *
 * @package    filter_urltolink
 * @category   phpunit
 * @copyright  2010 David Mudrak <david@powereduc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace filter_urltolink;

use filter_urltolink;

defined('POWEREDUC_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/filter/urltolink/filter.php'); // Include the code to test


class filter_test extends \basic_testcase {

    function get_convert_urls_into_links_test_cases() {
        // Create a 4095 and 4096 long URLs.
        $superlong4095 = str_pad('http://www.superlong4095.com?this=something', 4095, 'a');
        $superlong4096 = str_pad('http://www.superlong4096.com?this=something', 4096, 'a');

        $texts = array (
            //just a url
            'http://powereduc.org - URL' => '<a href="http://powereduc.org" class="_blanktarget">http://powereduc.org</a> - URL',
            'www.powereduc.org - URL' => '<a href="http://www.powereduc.org" class="_blanktarget">www.powereduc.org</a> - URL',
            //url with params
            'URL: http://powereduc.org/s/i=1&j=2' => 'URL: <a href="http://powereduc.org/s/i=1&j=2" class="_blanktarget">http://powereduc.org/s/i=1&j=2</a>',
            //url with escaped params
            'URL: www.powereduc.org/s/i=1&amp;j=2' => 'URL: <a href="http://www.powereduc.org/s/i=1&amp;j=2" class="_blanktarget">www.powereduc.org/s/i=1&amp;j=2</a>',
            //https url with params
            'URL: https://powereduc.org/s/i=1&j=2' => 'URL: <a href="https://powereduc.org/s/i=1&j=2" class="_blanktarget">https://powereduc.org/s/i=1&j=2</a>',
            //url with port and params
            'URL: http://powereduc.org:8080/s/i=1' => 'URL: <a href="http://powereduc.org:8080/s/i=1" class="_blanktarget">http://powereduc.org:8080/s/i=1</a>',
            // URL with complex fragment.
            'Most voted issues: https://tracker.powereduc.org/browse/MDL#selectedTab=com.atlassian.jira.plugin.system.project%3Apopularissues-panel' => 'Most voted issues: <a href="https://tracker.powereduc.org/browse/MDL#selectedTab=com.atlassian.jira.plugin.system.project%3Apopularissues-panel" class="_blanktarget">https://tracker.powereduc.org/browse/MDL#selectedTab=com.atlassian.jira.plugin.system.project%3Apopularissues-panel</a>',
            // Domain with more parts
            'URL: www.bbc.co.uk.' => 'URL: <a href="http://www.bbc.co.uk" class="_blanktarget">www.bbc.co.uk</a>.',
            // URL in brackets.
            '(http://powereduc.org) - URL' => '(<a href="http://powereduc.org" class="_blanktarget">http://powereduc.org</a>) - URL',
            '(www.powereduc.org) - URL' => '(<a href="http://www.powereduc.org" class="_blanktarget">www.powereduc.org</a>) - URL',
            // URL in brackets with a path.
            '(http://example.com/index.html) - URL' => '(<a href="http://example.com/index.html" class="_blanktarget">http://example.com/index.html</a>) - URL',
            '(www.example.com/index.html) - URL' => '(<a href="http://www.example.com/index.html" class="_blanktarget">www.example.com/index.html</a>) - URL',
            // URL in brackets with anchor.
            '(http://powereduc.org/main#anchor) - URL' => '(<a href="http://powereduc.org/main#anchor" class="_blanktarget">http://powereduc.org/main#anchor</a>) - URL',
            '(www.powereduc.org/main#anchor) - URL' => '(<a href="http://www.powereduc.org/main#anchor" class="_blanktarget">www.powereduc.org/main#anchor</a>) - URL',
            // URL in square brackets.
            '[http://powereduc.org] - URL' => '[<a href="http://powereduc.org" class="_blanktarget">http://powereduc.org</a>] - URL',
            '[www.powereduc.org] - URL' => '[<a href="http://www.powereduc.org" class="_blanktarget">www.powereduc.org</a>] - URL',
            // URL in square brackets with a path.
            '[http://example.com/index.html] - URL' => '[<a href="http://example.com/index.html" class="_blanktarget">http://example.com/index.html</a>] - URL',
            '[www.example.com/index.html] - URL' => '[<a href="http://www.example.com/index.html" class="_blanktarget">www.example.com/index.html</a>] - URL',
            // URL in square brackets with anchor.
            '[http://powereduc.org/main#anchor] - URL' => '[<a href="http://powereduc.org/main#anchor" class="_blanktarget">http://powereduc.org/main#anchor</a>] - URL',
            '[www.powereduc.org/main#anchor] - URL' => '[<a href="http://www.powereduc.org/main#anchor" class="_blanktarget">www.powereduc.org/main#anchor</a>] - URL',
            //brackets within the url
            'URL: http://cc.org/url_(withpar)_go/?i=2' => 'URL: <a href="http://cc.org/url_(withpar)_go/?i=2" class="_blanktarget">http://cc.org/url_(withpar)_go/?i=2</a>',
            'URL: www.cc.org/url_(withpar)_go/?i=2' => 'URL: <a href="http://www.cc.org/url_(withpar)_go/?i=2" class="_blanktarget">www.cc.org/url_(withpar)_go/?i=2</a>',
            'URL: http://cc.org/url_(with)_(par)_go/?i=2' => 'URL: <a href="http://cc.org/url_(with)_(par)_go/?i=2" class="_blanktarget">http://cc.org/url_(with)_(par)_go/?i=2</a>',
            'URL: www.cc.org/url_(with)_(par)_go/?i=2' => 'URL: <a href="http://www.cc.org/url_(with)_(par)_go/?i=2" class="_blanktarget">www.cc.org/url_(with)_(par)_go/?i=2</a>',
            // URL legitimately ending in a bracket. Commented out as part of MDL-22390. See next tests for work-arounds.
            // 'http://en.wikipedia.org/wiki/Slash_(punctuation)'=>'<a href="http://en.wikipedia.org/wiki/Slash_(punctuation)" class="_blanktarget">http://en.wikipedia.org/wiki/Slash_(punctuation)</a>',
            'http://en.wikipedia.org/wiki/%28#Parentheses_.28_.29 - URL' => '<a href="http://en.wikipedia.org/wiki/%28#Parentheses_.28_.29" class="_blanktarget">http://en.wikipedia.org/wiki/%28#Parentheses_.28_.29</a> - URL',
            'http://en.wikipedia.org/wiki/(#Parentheses_.28_.29 - URL' => '<a href="http://en.wikipedia.org/wiki/(#Parentheses_.28_.29" class="_blanktarget">http://en.wikipedia.org/wiki/(#Parentheses_.28_.29</a> - URL',
            //escaped brackets in url
            'http://en.wikipedia.org/wiki/Slash_%28punctuation%29'=>'<a href="http://en.wikipedia.org/wiki/Slash_%28punctuation%29" class="_blanktarget">http://en.wikipedia.org/wiki/Slash_%28punctuation%29</a>',
            //anchor tag
            'URL: <a href="http://powereduc.org">http://powereduc.org</a>' => 'URL: <a href="http://powereduc.org">http://powereduc.org</a>',
            'URL: <a href="http://powereduc.org">www.powereduc.org</a>' => 'URL: <a href="http://powereduc.org">www.powereduc.org</a>',
            'URL: <a href="http://powereduc.org"> http://powereduc.org</a>' => 'URL: <a href="http://powereduc.org"> http://powereduc.org</a>',
            'URL: <a href="http://powereduc.org"> www.powereduc.org</a>' => 'URL: <a href="http://powereduc.org"> www.powereduc.org</a>',
            //escaped anchor tag. Commented out as part of MDL-21183
            //htmlspecialchars('escaped anchor tag <a href="http://powereduc.org">www.powereduc.org</a>') => 'escaped anchor tag &lt;a href="http://powereduc.org"&gt; www.powereduc.org&lt;/a&gt;',
            //trailing fullstop
            'URL: http://powereduc.org/s/i=1&j=2.' => 'URL: <a href="http://powereduc.org/s/i=1&j=2" class="_blanktarget">http://powereduc.org/s/i=1&j=2</a>.',
            'URL: www.powereduc.org/s/i=1&amp;j=2.' => 'URL: <a href="http://www.powereduc.org/s/i=1&amp;j=2" class="_blanktarget">www.powereduc.org/s/i=1&amp;j=2</a>.',
            //trailing unmatched bracket
            'URL: http://powereduc.org)<br />' => 'URL: <a href="http://powereduc.org" class="_blanktarget">http://powereduc.org</a>)<br />',
            //partially escaped html
            'URL: <p>text www.powereduc.org&lt;/p> text' => 'URL: <p>text <a href="http://www.powereduc.org" class="_blanktarget">www.powereduc.org</a>&lt;/p> text',
            //decimal url parameter
            'URL: www.powereduc.org?u=1.23' => 'URL: <a href="http://www.powereduc.org?u=1.23" class="_blanktarget">www.powereduc.org?u=1.23</a>',
            //escaped space in url
            'URL: www.powereduc.org?u=test+param&' => 'URL: <a href="http://www.powereduc.org?u=test+param&" class="_blanktarget">www.powereduc.org?u=test+param&</a>',
            //multiple urls
            'URL: http://powereduc.org www.powereduc.org'
            => 'URL: <a href="http://powereduc.org" class="_blanktarget">http://powereduc.org</a> <a href="http://www.powereduc.org" class="_blanktarget">www.powereduc.org</a>',
            //containing anchor tags including a class parameter and a url to convert
            'URL: <a href="http://powereduc.org">http://powereduc.org</a> www.powereduc.org <a class="customclass" href="http://powereduc.org">http://powereduc.org</a>'
            => 'URL: <a href="http://powereduc.org">http://powereduc.org</a> <a href="http://www.powereduc.org" class="_blanktarget">www.powereduc.org</a> <a class="customclass" href="http://powereduc.org">http://powereduc.org</a>',
            //subdomain
            'http://subdomain.powereduc.org - URL' => '<a href="http://subdomain.powereduc.org" class="_blanktarget">http://subdomain.powereduc.org</a> - URL',
            //multiple subdomains
            'http://subdomain.subdomain.powereduc.org - URL' => '<a href="http://subdomain.subdomain.powereduc.org" class="_blanktarget">http://subdomain.subdomain.powereduc.org</a> - URL',
            //looks almost like a link but isnt
            'This contains http, http:// and www but no actual links.'=>'This contains http, http:// and www but no actual links.',
            //no link at all
            'This is a story about powereduc.coming to a cinema near you.'=>'This is a story about powereduc.coming to a cinema near you.',
            //URLs containing utf 8 characters
            'http://Iñtërnâtiônàlizætiøn.com?ô=nëø'=>'<a href="http://Iñtërnâtiônàlizætiøn.com?ô=nëø" class="_blanktarget">http://Iñtërnâtiônàlizætiøn.com?ô=nëø</a>',
            'www.Iñtërnâtiônàlizætiøn.com?ô=nëø'=>'<a href="http://www.Iñtërnâtiônàlizætiøn.com?ô=nëø" class="_blanktarget">www.Iñtërnâtiônàlizætiøn.com?ô=nëø</a>',
            //text containing utf 8 characters outside of a url
            'Iñtërnâtiônàlizætiøn is important to http://powereduc.org'=>'Iñtërnâtiônàlizætiøn is important to <a href="http://powereduc.org" class="_blanktarget">http://powereduc.org</a>',
            //too hard to identify without additional regexs
            'powereduc.org' => 'powereduc.org',
            //some text with no link between related html tags
            '<b>no link here</b>' => '<b>no link here</b>',
            //some text with a link between related html tags
            '<b>a link here www.powereduc.org</b>' => '<b>a link here <a href="http://www.powereduc.org" class="_blanktarget">www.powereduc.org</a></b>',
            //some text containing a link within unrelated tags
            '<br />This is some text. www.powereduc.com then some more text<br />' => '<br />This is some text. <a href="http://www.powereduc.com" class="_blanktarget">www.powereduc.com</a> then some more text<br />',
            //check we aren't modifying img tags
            'image<img src="http://powereduc.org/logo/logo-240x60.gif" />' => 'image<img src="http://powereduc.org/logo/logo-240x60.gif" />',
            'image<img src="www.powereduc.org/logo/logo-240x60.gif" />'    => 'image<img src="www.powereduc.org/logo/logo-240x60.gif" />',
            'image<img src="http://www.example.com/logo.gif" />'        => 'image<img src="http://www.example.com/logo.gif" />',
            //and another url within one tag
            '<td background="http://powereduc.org">&nbsp;</td>' => '<td background="http://powereduc.org">&nbsp;</td>',
            '<td background="www.powereduc.org">&nbsp;</td>' => '<td background="www.powereduc.org">&nbsp;</td>',
            '<form name="input" action="http://powereduc.org/submit.asp" method="get">'=>'<form name="input" action="http://powereduc.org/submit.asp" method="get">',
            '<input type="submit" value="Go to http://powereduc.org">' => '<input type="submit" value="Go to http://powereduc.org">',
            '<td background="https://www.powereduc.org">&nbsp;</td>' => '<td background="https://www.powereduc.org">&nbsp;</td>',
            // CSS URLs.
            '<table style="background-image: url(\'http://powereduc.org/pic.jpg\');">' => '<table style="background-image: url(\'http://powereduc.org/pic.jpg\');">',
            '<table style="background-image: url(http://powereduc.org/pic.jpg);">' => '<table style="background-image: url(http://powereduc.org/pic.jpg);">',
            '<table style="background-image: url("http://powereduc.org/pic.jpg");">' => '<table style="background-image: url("http://powereduc.org/pic.jpg");">',
            '<table style="background-image: url( http://powereduc.org/pic.jpg );">' => '<table style="background-image: url( http://powereduc.org/pic.jpg );">',
            //partially escaped img tag
            'partially escaped img tag &lt;img src="http://powereduc.org/logo/logo-240x60.gif" />' => 'partially escaped img tag &lt;img src="http://powereduc.org/logo/logo-240x60.gif" />',
            //fully escaped img tag. Commented out as part of MDL-21183
            //htmlspecialchars('fully escaped img tag <img src="http://powereduc.org/logo/logo-240x60.gif" />') => 'fully escaped img tag &lt;img src="http://powereduc.org/logo/logo-240x60.gif" /&gt;',
            //Double http with www
            'One more link like http://www.powereduc.org to test' => 'One more link like <a href="http://www.powereduc.org" class="_blanktarget">http://www.powereduc.org</a> to test',
            //Encoded URLs in the path
            'URL: http://127.0.0.1/one%28parenthesis%29/path?param=value' => 'URL: <a href="http://127.0.0.1/one%28parenthesis%29/path?param=value" class="_blanktarget">http://127.0.0.1/one%28parenthesis%29/path?param=value</a>',
            'URL: www.localhost.com/one%28parenthesis%29/path?param=value' => 'URL: <a href="http://www.localhost.com/one%28parenthesis%29/path?param=value" class="_blanktarget">www.localhost.com/one%28parenthesis%29/path?param=value</a>',
            //Encoded URLs in the query
            'URL: http://127.0.0.1/path/to?param=value_with%28parenthesis%29&param2=1' => 'URL: <a href="http://127.0.0.1/path/to?param=value_with%28parenthesis%29&param2=1" class="_blanktarget">http://127.0.0.1/path/to?param=value_with%28parenthesis%29&param2=1</a>',
            'URL: www.localhost.com/path/to?param=value_with%28parenthesis%29&param2=1' => 'URL: <a href="http://www.localhost.com/path/to?param=value_with%28parenthesis%29&param2=1" class="_blanktarget">www.localhost.com/path/to?param=value_with%28parenthesis%29&param2=1</a>',
            // Test URL less than 4096 characters in size is converted to link.
            'URL: ' . $superlong4095 => 'URL: <a href="' . $superlong4095 . '" class="_blanktarget">' . $superlong4095 . '</a>',
            // Test URL equal to or greater than 4096 characters in size is not converted to link.
            'URL: ' . $superlong4096 => 'URL: ' . $superlong4096,
            // Testing URL within a span tag.
            'URL: <span style="kasd"> my link to http://google.com </span>' => 'URL: <span style="kasd"> my link to <a href="http://google.com" class="_blanktarget">http://google.com</a> </span>',
            // Nested tags test.
            '<b><i>www.google.com</i></b>' => '<b><i><a href="http://www.google.com" class="_blanktarget">www.google.com</a></i></b>',
            '<input type="submit" value="Go to http://powereduc.org">' => '<input type="submit" value="Go to http://powereduc.org">',
            // Test realistic content.
            '<p><span style="color: rgb(37, 37, 37); font-family: sans-serif; line-height: 22.3999996185303px;">Lorem ipsum amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut http://google.com aliquip ex ea <a href="http://google.com">commodo consequat</a>. Duis aute irure in reprehenderit in excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia https://docs.google.com/document/d/BrokenLinkPleaseAyacDHc_Ov8aoskoSVQsfmLHP_jYAkRMk/edit?usp=sharing https://docs.google.com/document/d/BrokenLinkPleaseAyacDHc_Ov8aoskoSVQsfmLHP_jYAkRMk/edit?usp=sharing mollit anim id est laborum.</span><br></p>'
            =>
            '<p><span style="color: rgb(37, 37, 37); font-family: sans-serif; line-height: 22.3999996185303px;">Lorem ipsum amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut <a href="http://google.com" class="_blanktarget">http://google.com</a> aliquip ex ea <a href="http://google.com">commodo consequat</a>. Duis aute irure in reprehenderit in excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia <a href="https://docs.google.com/document/d/BrokenLinkPleaseAyacDHc_Ov8aoskoSVQsfmLHP_jYAkRMk/edit?usp=sharing" class="_blanktarget">https://docs.google.com/document/d/BrokenLinkPleaseAyacDHc_Ov8aoskoSVQsfmLHP_jYAkRMk/edit?usp=sharing</a> <a href="https://docs.google.com/document/d/BrokenLinkPleaseAyacDHc_Ov8aoskoSVQsfmLHP_jYAkRMk/edit?usp=sharing" class="_blanktarget">https://docs.google.com/document/d/BrokenLinkPleaseAyacDHc_Ov8aoskoSVQsfmLHP_jYAkRMk/edit?usp=sharing</a> mollit anim id est laborum.</span><br></p>',
            // Test some broken html.
            '5 < 10 www.google.com <a href="hi.com">im a link</a>' => '5 < 10 <a href="http://www.google.com" class="_blanktarget">www.google.com</a> <a href="hi.com">im a link</a>',
            'h3 (www.styles.com/h3) < h1 (www.styles.com/h1)' => 'h3 (<a href="http://www.styles.com/h3" class="_blanktarget">www.styles.com/h3</a>) < h1 (<a href="http://www.styles.com/h1" class="_blanktarget">www.styles.com/h1</a>)',
            '<p>text www.powereduc.org&lt;/p> text' => '<p>text <a href="http://www.powereduc.org" class="_blanktarget">www.powereduc.org</a>&lt;/p> text',
            // Some more urls.
            '<link rel="search" type="application/opensearchdescription+xml" href="/osd.jsp" title="Peer review - PowerEduc Tracker"/>' => '<link rel="search" type="application/opensearchdescription+xml" href="/osd.jsp" title="Peer review - PowerEduc Tracker"/>',
            '<a href="https://docs.powereduc.org/dev/Main_Page"></a><span>www.google.com</span><span class="placeholder"></span>' => '<a href="https://docs.powereduc.org/dev/Main_Page"></a><span><a href="http://www.google.com" class="_blanktarget">www.google.com</a></span><span class="placeholder"></span>',
            'http://nolandforzombies.com <a href="zombiesFTW.com">Zombies FTW</a> http://aliens.org' => '<a href="http://nolandforzombies.com" class="_blanktarget">http://nolandforzombies.com</a> <a href="zombiesFTW.com">Zombies FTW</a> <a href="http://aliens.org" class="_blanktarget">http://aliens.org</a>',
            // Test 'nolink' class.
            'URL: <span class="nolink">http://powereduc.org</span>' => 'URL: <span class="nolink">http://powereduc.org</span>',
            '<span class="nolink">URL: http://powereduc.org</span>' => '<span class="nolink">URL: http://powereduc.org</span>',
            //URLs in Javascript. Commented out as part of MDL-21183
            //'var url="http://powereduc.org";'=>'var url="http://powereduc.org";',
            //'var url = "http://powereduc.org";'=>'var url = "http://powereduc.org";',
            //'var url="www.powereduc.org";'=>'var url="www.powereduc.org";',
            //'var url = "www.powereduc.org";'=>'var url = "www.powereduc.org";',
            //doctype. do we care about this failing?
            //'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN http://www.w3.org/TR/html4/strict.dtd">'=>'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN http://www.w3.org/TR/html4/strict.dtd">'
        );

        $data = array();
        foreach ($texts as $text => $correctresult) {
            $data[] = array($text, $correctresult);
        }
        return $data;
    }

    /**
     * @dataProvider get_convert_urls_into_links_test_cases
     */
    function test_convert_urls_into_links($text, $correctresult) {
        $testablefilter = new testable_filter_urltolink();
        $testablefilter->convert_urls_into_links($text);
        $this->assertEquals($correctresult, $text);
    }

}


/**
 * Test subclass that makes all the protected methods we want to test public.
 */
class testable_filter_urltolink extends filter_urltolink {
    public function __construct() {
    }
    public function convert_urls_into_links(&$text) {
        parent::convert_urls_into_links($text);
    }
}
