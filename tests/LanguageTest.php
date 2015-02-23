<?php
namespace minphp\Language;

use \PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \minphp\Language\Language
 */
class LanguageTest extends PHPUnit_Framework_TestCase
{
    protected $lang_path;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->lang_path = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "fixtures" . DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR;
    }

    /**
     * @covers ::_
     * @covers ::getText
     * @covers ::loadLang
     */
    public function testShortGetText()
    {
        Language::setLang("en_us");
        Language::loadLang("language_test", "en_us", $this->lang_path);
        
        $this->assertEquals("The blue car is fast.", Language::_("LanguageTest.b", true, "blue", "fast", "car"));
    }

    /**
     * @covers ::getText
     * @covers ::loadLang
     * @covers ::setOptions
     */
    public function testGetText()
    {
        Language::setLang("en_us");
        Language::loadLang("language_test", "en_uk", $this->lang_path);
        
        $this->assertEquals("The blue car is fast.", Language::getText("LanguageTest.b", true, "blue", "fast", "car"));
        
        $this->assertEquals("I like the color green.", Language::getText("LanguageTest.a", true));
        
        Language::setLang("en_uk");
        $this->assertEquals("The blue car is fast.", Language::getText("LanguageTest.b", true, "blue", "fast", "car"));
        
        Language::setOptions("en_us", true);
        $this->assertEquals("Non-existent", Language::getText("Non-existent", true));
        
        $this->expectOutputString("I like the colour green.");
        Language::getText("LanguageTest.a");
    }

    /**
     * @covers ::loadLang
     */
    public function testLoadLang()
    {
        Language::loadLang("language_test", "en_uk", $this->lang_path);
        Language::loadLang(array("language_test", "language_not_exists"), "en_uk", $this->lang_path);
        
        Language::setLang("en_us");
        $this->assertEquals("I like the color green.", Language::getText("LanguageTest.a", true));
        
        Language::setLang("en_uk");
        $this->assertEquals("I like the colour green.", Language::getText("LanguageTest.a", true));
    }

    /**
     * @covers ::setLang
     */
    public function testSetLang()
    {
        Language::setLang(null);
        $this->assertNull(Language::setLang("en_uk"));
        $this->assertEquals("en_uk", Language::setLang("en_us"));
        
    }
}
