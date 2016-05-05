<?php
/**
 * Manipulates all col data for configurate ajaxtable.js
 *
 * @author Joubert <eu@redrat.com.br>
 * @copyright Copyright (c) 2016 Vector Internet Business and AjaxTable contributors
 * @license: MIT
 * @see https://github.com/vectornet/ajaxtable/
 * @see http://www.vectornet.com.br
 */

namespace VectorDev\AjaxTable;

class Col extends Format\Format
{
    /**
     * Column name
     *
     * @var string
     */
    public $name;

    /**
     * Name of column to sort if is enabled
     *
     * @var string
     */
    public $order;

    /**
     * Element id of colgroup
     *
     * @var string
     */
    private $html_colgroup_id;

    /**
     * List of element class of colgroup
     *
     * @var array
     */
    private $html_colgroup_class = [];

    /**
     * Create new Col with required data
     *
     * @param string $name
     * @param string $text
     * @return void
     */
    public function __construct($name, $text)
    {
        $this->setName($name);
        $this->setTitle($text);
    }

    /**
     * Set Column name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = parent::slug($name);
    }

    /**
     * Get Column name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Column name for sort
     *
     * @param string $name
     * @return void
     */
    public function setOrder($name)
    {
        $this->order = $name;
    }

    /**
     * Set colgroup element id
     *
     * @param string $id
     * @return void
     */
    public function setColgroupId($id)
    {
        $this->html_colgroup_id = parent::slug($id);
    }

    /**
     * Add colgroup element class to list
     *
     * @param string|array $class
     * @return void
     */
    public function addColgroupClass($class)
    {
        if (is_array($class)) {
            self::slugArray($class);
            $this->html_colgroup_class = array_unique(array_merge($this->html_colgroup_class, $class));
        } elseif (is_string($class)) {
            $this->html_colgroup_class[] = self::slug($class);
            $this->html_colgroup_class = array_unique($this->html_colgroup_class);
        }
    }

    /**
     * Delete colgroup element class from list
     *
     * @param string|array $class
     * @return void
     */
    public function delColgroupClass($class)
    {
        if (is_array($class)) {
            $this->html_colgroup_class = array_diff($this->html_colgroup_class, $class);
        } elseif (is_string($class)) {
            $this->html_colgroup_class = array_diff($this->html_colgroup_class, [$class]);
        }
    }

    /**
     * Clear colgroup element class list
     *
     * @return void
     */
    public function clearColgroupClass()
    {
        $this->html_colgroup_class = [];
    }

    /**
     * Get array data
     *
     * @return array
     */
    public function getArray()
    {
        $array = [];
        $array['jsonName'] = $this->name;
        $array['headerTitle'] = $this->html_element_title;

        if ($this->html_element_id) {
            $array['headerId'] = $this->html_element_id;
        }
        if ($this->html_element_class) {
            $array['headerClass'] = implode(' ', $this->html_element_class);
        }

        if ($this->html_colgroup_id) {
            $array['colgroupId'] = $this->html_colgroup_id;
        }
        if ($this->html_colgroup_class) {
            $array['colgroupClass'] = implode(' ', $this->html_colgroup_class);
        }
        if ($this->order) {
            $array['valueToSort'] = $this->order;
            $array['sortable'] = true;
        } else {
            $array['sortable'] = false;
        }
        return $array;
    }

    /**
     * Get json data to be used on ajaxtable.js configuration
     *
     * @return string
     */
    public function getJson($humanize = false)
    {
        if ($humanize) {
            $json = json_encode($this->getArray(), JSON_PRETTY_PRINT);
        } else {
            $json = json_encode($this->getArray());
        }
        return $json;
    }
}
