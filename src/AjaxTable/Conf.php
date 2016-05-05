<?php
/**
 * Manipulate configurations data to build json to configure ajaxtable.js on view
 *
 * @author Joubert <eu@redrat.com.br>
 * @copyright Copyright (c) 2016 Vector Internet Business and AjaxTable contributors
 * @license: MIT
 * @see https://github.com/vectornet/ajaxtable/
 * @see http://www.vectornet.com.br
 */

namespace VectorDev\AjaxTable;

class Conf extends Format\Table
{
    /**
     * Request url
     *
     * @var string
     */
    private $request_url;

    /**
     * Custom language for config
     *
     * @var VectorDev\AjaxTable\Lang\Lang
     */
    private $Lang;

    /**
     * Custom classes for config
     *
     * @var VectorDev\AjaxTable\Format\Classes
     */
    private $Classes;

    /**
     * List of VectorDev\AjaxTable\Col
     *
     * @var array
     */
    private $table_cols = [];

    /**
     * List of custom params to send with request
     *
     * @var array
     */
    private $params = [];

    /**
     * List of rows per page user can change on view
     *
     * @var array
     */
    private $rows_per_page = [5, 10, 20, 50, 100, 500];

    /**
     * Object construct
     *
     * @param string $request_url
     * @return void
     */
    public function __construct($request_url)
    {
        $this->setRequestUrl($request_url);
    }

    /**
     * Set request url
     *
     * @param string $request_url
     * @return void
     */
    public function setRequestUrl($request_url)
    {
        $this->request_url = $request_url;
    }

    /**
     * Get request url
     *
     * @return string
     */
    public function getRequestUrl($request_url)
    {
        return $this->request_url;
    }

    /**
     * Set list of rows per page user can be change on view
     *
     * @param array $rows_per_page
     * @return void
     */
    public function setRowsPerPage(array $rows_per_page)
    {
        if ($rows_per_page) {
            $this->rows_per_page = array_unique($rows_per_page);
            sort($this->rows_per_page);
        }
    }

    /**
     * Get list of rows per page user can be change on view
     *
     * @return array
     */
    public function getRowsPerPage()
    {
        return $this->rows_per_page;
    }

    /**
     * Set number of rows per page on ajaxtable
     *
     * @param int $rows
     */
    public function setRows($rows)
    {
        if (in_array($rows, $this->rows_per_page)) {
            $this->rows = (int) $rows;
        }
    }

    /**
     * Add custom param to list
     *
     * @param string $data
     * @param string $value
     * @return void
     */
    public function addParam($data, $value)
    {
        $this->params[$data] = $value;
    }

    /**
     * Add custom param from list
     *
     * @param string $data
     * @return void
     */
    public function delParam($data)
    {
        if (isset($this->params[$data])) {
            unset($this->params[$data]);
        }
    }

    /**
     * Clear custom param list
     *
     * @return void
     */
    public function clearParams()
    {
        $this->params = [];
    }

    /**
     * Set sort column to asc
     *
     * @param string $sort_col
     * @return void
     */
    public function setSortAsc($sort_col)
    {
        $this->setSort($sort_col, parent::SORT_ASC);
    }

    /**
     * Set sort column to desc
     *
     * @param string $sort_col
     * @return void
     */
    public function setSortDesc($sort_col)
    {
        $this->setSort($sort_col, parent::SORT_DESC);
    }

    /**
     * Add VectorDev\AjaxTable\Col to list
     *
     * @param VectorDev\AjaxTable\Col $Col
     * @return void
     */
    public function addCol(Col $Col)
    {
        $this->table_cols[$Col->getName()] = $Col;
    }

    /**
     * Get VectorDev\AjaxTable\Col array data on list
     *
     * @return array
     */
    public function getArrayCol()
    {
        $array = [];
        foreach ($this->table_cols as $Col) {
            $array[] = $Col->getArray();
        }
        return $array;
    }

    /**
     * get json config data from all VectorDev\AjaxTable\Col array data on list
     *
     * @param bool $humanize
     * @return string
     */
    public function getJsonCol($humanize = false)
    {
        if ($humanize) {
            $json = json_encode($this->getArrayCol(), JSON_PRETTY_PRINT);
        } else {
            $json = json_encode($this->getArrayCol());
        }
        return $json;
    }

    /**
     * Get array data
     *
     * @return array
     */
    public function getArray()
    {
        $array = [];

        // request conf
        if (!is_null($this->request_url)) {
            $array['url'] = $this->request_url;
        }
        if (!is_null($this->request_method)) {
            $array['method'] = $this->request_method;
        }
        if ($this->params) {
            $array['params'] = $this->params;
        }
        $array['cols'] = $this->getArrayCol();

        // pagination conf
        if (!is_null($this->page)) {
            $array['page'] = $this->page;
        }
        if (!is_null($this->rows)) {
            $array['rows'] = $this->rows;
        } else {
            $array['rows'] = $this->rows_per_page[0];
        }
        if (!is_null($this->rows_per_page)) {
            $array['rowsOptions'] = $this->rows_per_page;
        }

        // sort conf
        if (!is_null($this->sort_col)) {
            $array['sortCol'] = $this->sort_col;
        }
        if (!is_null($this->sort_order)) {
            $array['sortOrder'] = $this->sort_order;
        }

        // lang conf
        if ($this->Lang) {
            $array = array_merge($array, $this->Lang->getArray());
        }

        // classes conf
        if ($this->Classes) {
            $array = array_merge($array, $this->Classes->getArray());
        }

        return $array;
    }

    /**
     * Get gerenal json data to be user on ajaxtable.js configuration
     *
     * @param bool $humanize
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

    /**
     * Set AjaxTable language
     *
     * @param \VectorDev\AjaxTable\Lang\Lang $Lang
     * @return void
     */
    public function setLang(Lang\Lang $Lang)
    {
        $this->Lang = $Lang;
    }

    /**
     * Get AjaxTable language
     *
     * @return \VectorDev\AjaxTable\Lang\Lang
     */
    public function getLang()
    {
        return $this->Lang;
    }

    /**
     * Set AjaxTable classes
     *
     * @param \VectorDev\AjaxTable\Format\Classes $Classes
     */
    public function setClasses(Format\Classes $Classes)
    {
        $this->Classes = $Classes;
    }

    /**
     * Get AjaxTable classes
     *
     * @return \VectorDev\AjaxTable\Format\Classes
     */
    public function getClasses()
    {
        return $this->Classes;
    }
}
