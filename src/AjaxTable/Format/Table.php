<?php
/**
 * Abstract class responsible to manipulate basic data
 * for AjaxTable work as configuration on view or a response on controller.
 *
 * @author Joubert <eu@redrat.com.br>
 * @copyright Copyright (c) 2016 Vector Internet Business and AjaxTable contributors
 * @license: MIT
 * @see https://github.com/vectornet/ajaxtable/
 * @see http://www.vectornet.com.br
 */

namespace VectorDev\AjaxTable\Format;

abstract class Table
{
    /**
     * Request method
     *
     * @var string
     */
    protected $request_method = self::REQUEST_METHOD_DEFAULT;

    /**
     * Rows per page
     *
     * @var int
     */
    protected $rows = 10;

    /**
     * Page
     *
     * @var int
     */
    protected $page = 1;

    /**
     * Sort column
     *
     * @var string
     */
    protected $sort_col;

    /**
     * Sort column order
     *
     * @var string
     */
    protected $sort_order = self::SORT_ASC;

    /**
     * Request method $_POST
     */
    const REQUEST_METHOD_POST = 'POST';

    /**
     * Request method $_GET
     */
    const REQUEST_METHOD_GET = 'GET';

    /**
     * Request method default
     */
    const REQUEST_METHOD_DEFAULT = self::REQUEST_METHOD_POST;

    /**
     * Sort asc
     */
    const SORT_ASC = 'ASC';

    /**
     * Sort desc
     */
    const SORT_DESC = 'DESC';

    /**
     * Set request method
     *
     * @param string $request_method
     * @return void
     */
    public function setRequestMethod($request_method)
    {
        if (!in_array($request_method, self::getRequestMethodsAvaliable())) {
            throw new Exception('Invalid request method');
        }
        $this->request_method = $request_method;
    }

    /**
     * Set request method as GET
     *
     * @return void
     */
    public function setRequestMethodGet()
    {
        $this->setRequestMethod(self::REQUEST_METHOD_GET);
    }

    /**
     * Set request method as POST
     *
     * @return void
     */
    public function setRequestMethodPost()
    {
        $this->setRequestMethod(self::REQUEST_METHOD_POST);
    }

    /**
     * Get request method
     *
     * @return string
     */
    public function getRequestMethod()
    {
        return $this->request_method;
    }

    /**
     * Get avaliable request methods
     *
     * @return array
     */
    public static function getRequestMethodsAvaliable()
    {
        return [self::REQUEST_METHOD_GET, self::REQUEST_METHOD_POST];
    }

    /**
     * Get sort options
     *
     * @return array
     */
    public static function getSortOptions()
    {
        return [self::SORT_ASC, self::SORT_DESC];
    }

    /**
     * Set sort
     *
     * @param string $sort_col
     * @param string $sort_order
     * @return void
     */
    public function setSort($sort_col, $sort_order)
    {
        if (!in_array($sort_order, self::getSortOptions())) {
            throw new Exception('Unkown sort option');
        }
        $this->sort_col = $sort_col;
        $this->sort_order = $sort_order;
    }

    /**
     * Get sort column
     *
     * @return string
     */
    public function getSortCol()
    {
        return $this->sort_col;
    }

    /**
     * Get sort column
     *
     * @return string
     */
    public function getSortOrder()
    {
        return $this->sort_order;
    }

    /**
     * Set page
     *
     * @param int $page
     * @return void
     */
    public function setPage($page = null)
    {
        if (!filter_var($page, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
            throw new Exception('Invalid page');
        }
        $this->page = (int) $page;
    }

    /**
     * Get page
     *
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set rows per page
     *
     * @param int $rows
     * @return void
     */
    public function setRows($rows)
    {

    }

    /**
     * Get rows per page
     *
     * @return int
     */
    public function getRows()
    {
        return $this->rows;
    }
}
