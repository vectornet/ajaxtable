<?php
/**
 * Get data from request and build response to ajaxtable on view
 *
 * @author Joubert <eu@redrat.com.br>
 * @copyright Copyright (c) 2016 Vector Internet Business and AjaxTable contributors
 * @license: MIT
 * @see https://github.com/vectornet/ajaxtable/
 * @see http://www.vectornet.com.br
 */

namespace VectorDev\AjaxTable;

class Response extends Format\Table
{
    /**
     * Total of rows
     *
     * @var int
     */
    private $rows_total;

    /**
     * Ajaxtable params send by request
     *
     * @var array
     */
    private $ajaxtable_params = [];

    /**
     * Another params send by request
     *
     * @var array
     */
    private $custom_params = [];

    /**
     * Numer of cols send by request
     *
     * @var int
     */
    private $table_cols;

    /**
     * List of VectorDev\AjaxTable\Row
     *
     * @var array
     */
    private $table_rows = [];

    /**
     * Json header to send on response
     */
    const HEADER_JSON = 'Content-Type: application/json; charset=utf-8';

    /**
     * Index of ajaxtable params send by request
     */
    const REQUEST_ARRAY = 'ajaxTableOptions';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->detectRequestMethod();
        $this->populateParams();
    }

    /**
     * Validate and add VectorDev\AjaxTable\Row to list
     *
     * @param VectorDev\AjaxTable\Row $Row
     * @return void
     */
    public function addRow(Row $Row)
    {
        if ($this->getNumRows() >= $this->rows) {
            exit('Number of rows expect number allowed');
        }

        if ($Row->getNumCells() != $this->getNumCols()) {
            exit('Number of GridCell on Row expect number allowed');
        }

        $this->table_rows[] = $Row;
    }

    /**
     * Get number of VectorDev\AjaxTable\Row on list
     *
     * @return int
     */
    public function getNumRows()
    {
        return count($this->table_rows);
    }

    /**
     * Get number of Cols on view
     *
     * @return int
     */
    public function getNumCols()
    {
        return $this->table_cols;
    }

    /**
     * Detect request method used by request
     *
     * @return void
     */
    private function detectRequestMethod()
    {
        $this->setRequestMethod($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Define header to response
     *
     * @return void
     */
    private function loadHeaderResponse()
    {
        header(self::HEADER_JSON);
    }

    /**
     * Set rows per page used by request
     *
     * @param int $rows
     */
    public function setRows($rows)
    {
        if (!(filter_var($rows, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) !== false)) {
            exit('Invalid rows');
        }
        $this->rows = $rows;
    }

    /**
     * Set total of rows for response
     *
     * @param int $rows_total
     */
    public function setRowsTotal($rows_total)
    {
        if (!(filter_var($rows_total, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) !== false)) {
            exit('Invalid rows total');
        }
        $this->rows_total = $rows_total;
    }

    /**
     * Get total of rows
     *
     * @param int $rows_total
     */
    public function getRowsTotal()
    {
        return $this->rows_total;
    }

    /**
     * Get ajaxgrid params send by request
     *
     * @return array
     */
    public function getAjaxgridParams()
    {
        if ($this->ajaxtable_params) {
            return $this->ajaxtable_params;
        }

        switch ($this->request_method) {
            case parent::REQUEST_METHOD_POST:
                $params = $_POST[self::REQUEST_ARRAY];
                break;
            case parent::REQUEST_METHOD_GET:
                $params = $_GET[self::REQUEST_ARRAY];
                break;
            default:
                exit('Unknow request method');
                break;
        }
        return $params;
    }

    /**
     * Get other params send by request
     *
     * @return array
     */
    public function getCustomParams()
    {
        if ($this->custom_params) {
            return $this->custom_params;
        }

        switch ($this->request_method) {
            case parent::REQUEST_METHOD_POST:
                $params = $_POST;
                break;
            case parent::REQUEST_METHOD_GET:
                $params = $_GET;
                break;
            default:
                exit('Unknow request method');
                break;
        }
        unset($params[self::REQUEST_ARRAY]);
        return $params;
    }

    /**
     * Alias of getCustomParams method
     *
     * @return array
     */
    public function getRequestParams()
    {
        return $this->getCustomParams();
    }

    /**
     * Get ajaxgrid and other params send by request
     * and populate on object
     *
     * @return void
     */
    private function populateParams()
    {
        if (!$this->ajaxtable_params) {
            $this->ajaxtable_params = $this->getAjaxgridParams();
        }

        if (!$this->custom_params) {
            $this->custom_params = $this->getCustomParams();
        }

        $this->table_cols = (int) $this->ajaxtable_params['cols'];
        $this->page = (int) $this->ajaxtable_params['page'];
        $this->rows = (int) $this->ajaxtable_params['rows'];
        $this->setSort($this->ajaxtable_params['sortCol'], $this->ajaxtable_params['sortOrder']);
    }

    /**
     * Get limit data for use on sql
     *
     * @return array
     */
    public function getLimitForSql()
    {
        return [
            $this->rows * $this->page - $this->rows,
            $this->rows
        ];
    }

    /**
     * Get sort data for use on sql
     *
     * @return array
     */
    public function getOrderByForSql()
    {
        return $this->sort_col && $this->sort_order ? ['`'.$this->sort_col.'`', $this->sort_order] : null;
    }

    /**
     * Get total of pages based on rows per line and total rows
     *
     * @return array
     */
    public function getTotalPages()
    {
        return $this->rows_total > 0 ? ceil($this->rows_total / $this->rows) : 1;
    }

    /**
     * Verify if is first page of rows
     *
     * @return bool
     */
    public function isFirstPage()
    {
        return $this->rows_total == 1;
    }

    /**
     * Verify if is last page of rows
     *
     * @return bool
     */
    public function isLastPage()
    {
        return $this->rows_total == $this->getTotalPages();
    }

    /**
     * Get array data
     *
     * @return array
     */
    public function getArray()
    {
        $array = [];

        $array['totalPages'] = $this->getTotalPages();
        $array['page'] = min($this->page, $this->getTotalPages());
        $array['totalRecords'] = $this->rows_total;
        $array['html'] = $this->getHtmlBody();

        return $array;
    }

    /**
     * Get json data
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
     * Return json data to view
     *
     * @param bool $humanize
     * @return void
     */
    private function returnJson($humanize = false)
    {
        $this->loadHeaderResponse();
        exit($this->getJson($humanize));
    }

    /**
     * Return data to view
     *
     * @param bool $humanize
     * @return void
     */
    public function returnRequest()
    {
        $this->returnJson();
    }

    /**
     * Get html from VectorDev\AjaxTable\Row on list
     *
     * @return string
     */
    private function getHtmlBody()
    {
        $html = [];
        foreach ($this->table_rows as $Row) {
            $html[] = $Row->getHtml();
        }
        return implode('', $html);
    }
}
