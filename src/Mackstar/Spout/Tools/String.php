<?php
/**
 * This file is part of the Mackstar.Spout
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Mackstar\Spout\Tools;

use Mackstar\Spout\Interfaces\StringInterface;

/**
 * Mackstar.Spout
 *
 * @package Mackstar.Spout
 */
class String implements StringInterface
{

    private $string;

    public function __construct($string = null)
    {
        $this->string = $string;
    }

    public function singularize($string = null)
    {
        if (!$string) {
            $string = $this->string;
        }
        $singular = array (
            '/(quiz)zes$/i' => '\\1',
            '/(matr)ices$/i' => '\\1ix',
            '/(vert|ind)ices$/i' => '\\1ex',
            '/^(ox)en/i' => '\\1',
            '/(alias|status)es$/i' => '\\1',
            '/([octop|vir])i$/i' => '\\1us',
            '/(cris|ax|test)es$/i' => '\\1is',
            '/(shoe)s$/i' => '\\1',
            '/(o)es$/i' => '\\1',
            '/(bus)es$/i' => '\\1',
            '/([m|l])ice$/i' => '\\1ouse',
            '/(x|ch|ss|sh)es$/i' => '\\1',
            '/(m)ovies$/i' => '\\1ovie',
            '/(s)eries$/i' => '\\1eries',
            '/([^aeiouy]|qu)ies$/i' => '\\1y',
            '/([lr])ves$/i' => '\\1f',
            '/(tive)s$/i' => '\\1',
            '/(hive)s$/i' => '\\1',
            '/([^f])ves$/i' => '\\1fe',
            '/(^analy)ses$/i' => '\\1sis',
            '/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i' => '\\1\\2sis',
            '/([ti])a$/i' => '\\1um',
            '/(n)ews$/i' => '\\1ews',
            '/s$/i' => ''
        );

        $irregular = array(
            'person' => 'people',
            'man' => 'men',
            'child' => 'children',
            'sex' => 'sexes',
            'move' => 'moves'
        );

        $ignore = array(
            'equipment',
            'information',
            'rice',
            'money',
            'species',
            'series',
            'fish',
            'sheep',
            'press',
            'sms',
        );

        $lowerString = strtolower($string);
        foreach ($ignore as $ignoreString) {
            if (substr($lowerString, (-1 * strlen($ignoreString))) == $ignoreString) {
                return $string;
            }
        }

        foreach ($irregular as $singularString => $pluralString) {
            if (preg_match('/('.$pluralString.')$/i', $string, $arr)) {
                return preg_replace(
                    '/('.$pluralString.')$/i',
                    substr($arr[0], 0, 1).substr($singularString, 1),
                    $string
                );
            }
        }

        foreach ($singular as $rule => $replacement) {
            if (preg_match($rule, $string)) {
                return preg_replace($rule, $replacement, $string);
            }
        }

        return $string;
    }

    public function setString($string)
    {
        $this->string = $string;
    }

    public function getString()
    {
        return $this->string;
    }
}
