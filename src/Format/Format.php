<?php
/**
 * Abstract class to manipulate all html data into AjaxTable
 *
 * @author Joubert <eu@redrat.com.br>
 * @copyright Copyright (c) 2016 Vector Internet Business and AjaxTable contributors
 * @license: MIT
 * @see https://github.com/vectornet/ajaxtable/
 * @see http://www.vectornet.com.br
 */

namespace VectorDev\AjaxTable\Format;

abstract class Format
{
    /**
     * Html element id
     *
     * @var string
     */
    protected $html_element_id;

    /**
     * Html element id
     *
     * @var string
     */
    protected $html_element_title;

    /**
     * List of html element class
     *
     * @var array
     */
    protected $html_element_class = [];

    /**
     * List of html element data
     *
     * @var array
     */
    protected $html_element_data = [];

    /**
     * Enable slug for elements
     */
    const SLUG = true;

    /**
     * Slug delimiter
     */
    const SLUG_DELIMITER = '-';

    /**
     * Slug convertion character
     */
    const SLUG_CHARACTER = 'UTF-8';

    /**
     * Default data element for responsive
     */
    const RESPONSIVE_DATA = 'th';

    /**
     * Set html element id
     *
     * @param string $id
     * @return void
     */
    public function setId($id)
    {
        $this->html_element_id = self::slug($id);
    }

    /**
     * Set html element title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->html_element_title = $title;
    }

    /**
     * Add html element class to list
     *
     * @param string|array $class
     * @return void
     */
    public function addClass($class)
    {
        if (is_array($class)) {
            self::slugArray($class);
            $this->html_element_class = array_unique(array_merge($this->html_element_class, $class));
        } elseif (is_string($class)) {
            $this->html_element_class[] = self::slug($class);
            $this->html_element_class = array_unique($this->html_element_class);
        }
    }

    /**
     * Remove html element class from list
     *
     * @param string|array $class
     * @return void
     */
    public function delClass($class)
    {
        if (is_array($class)) {
            $this->html_element_class = array_diff($this->html_element_class, $class);
        } elseif (is_string($class)) {
            $this->html_element_class = array_diff($this->html_element_class, [$class]);
        }
    }

    /**
     * Clear html element class list
     *
     * @return void
     */
    public function clearClass()
    {
        $this->html_element_class = [];
    }

    /**
     * Add html element data to list
     *
     * @param string $data
     * @param string $value
     * @return void
     */
    public function addData($data, $value)
    {
        $this->html_element_data[self::slug($data)] = $value;
    }

    /**
     * Remove html element data from list
     *
     * @param string $data
     * @return void
     */
    public function delData($data)
    {
        if (isset($this->html_element_data[$data])) {
            unset($this->html_element_data[$data]);
        }
    }

    /**
     * Clear html element data list
     *
     * @return void
     */
    public function clearData()
    {
        $this->html_element_data = [];
    }

    /**
     * Genetare and return partial html data
     *
     * @return string
     */
    public function getHtml()
    {
        $html = [];
        if ($this->html_element_id) {
            $html[] = 'id="'.$this->html_element_id.'"';
        }
        if ($this->html_element_class) {
            $html[] = 'class="'.implode(' ', $this->html_element_class).'"';
        }
        if ($this->html_element_title) {
            $html[] = 'title="'.$this->html_element_title.'"';
        }

        if ($this->html_element_data) {
            foreach ($this->html_element_data as $data => $value) {
                $html[] = 'data-'.$data.'="'.$value.'"';
            }
        }

        return implode(' ', $html);
    }

    /**
     * Slugify string for html elements. Original concept by Sean Murphy
     *
     * @param string $string
     * @param array $options
     * @return string
     * @see https://gist.github.com/sgmurphy/3098978
     */
    public static function slug($string, $options = [])
    {
        if (!self::SLUG) {
            return $string;
        }

        $string = mb_convert_encoding((string)$string, self::SLUG_CHARACTER, mb_list_encodings());

        $defaults = [
            'delimiter' => self::SLUG_DELIMITER,
            'limit' => null,
            'lowercase' => true,
            'replacements' => [],
            'transliterate' => true,
        ];

        // Merge options
        $options = array_merge($defaults, $options);

        $char_map = [
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ẽ' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
            'Ï' => 'I', 'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O',
            'Ő' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y',
            'Þ' => 'TH', 'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ẽ' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
            'ï' => 'i', 'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
            'ő' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y',
            'þ' => 'th', 'ÿ' => 'y',

            // Latin symbols
            '©' => '(c)',

            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',

            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',

            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',

            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',

            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z'
        ];

        // Make custom replacements
        $string = preg_replace(array_keys($options['replacements']), $options['replacements'], $string);

        // Transliterate characters to ASCII
        if ($options['transliterate']) {
            $string = str_replace(array_keys($char_map), $char_map, $string);
        }

        // Replace non-alphanumeric characters with our delimiter
        $string = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $string);

        // Remove duplicate delimiters
        $string = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $string);

        // Truncate slug to max. characters
        $string = mb_substr(
            $string,
            0,
            ($options['limit'] ? $options['limit'] : mb_strlen($string, self::SLUG_CHARACTER)),
            self::SLUG_CHARACTER
        );

        // Remove delimiter from ends
        $string = trim($string, $options['delimiter']);

        return $options['lowercase'] ? mb_strtolower($string, self::SLUG_CHARACTER) : $string;
    }

    /**
     * Applies slug on array string.
     *
     * @param array $array
     * @return void
     */
    public static function slugArray(&$array)
    {
        array_walk($array, function (&$value) {
            $value = self::slug($value);
        });
    }
}
