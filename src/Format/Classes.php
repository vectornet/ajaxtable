<?php
/**
 * Manipulate classes data to build json to configure ajaxtable.js on view
 * This is advanced area, use with caution.
 *
 * @author Joubert <eu@redrat.com.br>
 * @copyright Copyright (c) 2016 Vector Internet Business and AjaxTable contributors
 * @license: MIT
 * @see https://github.com/vectornet/ajaxtable/
 * @see http://www.vectornet.com.br
 */
namespace VectorDev\AjaxTable\Format;

class Classes
{
    /**
     * Base table class
     *
     * @var string
     */
    private $table = 'table';

    /**
     * Head section class
     *
     * @var string
     */
    private $head = 'head';

    /**
     * Body section class
     *
     * @var string
     */
    private $body = 'body';

    /**
     * Foot section class
     *
     * @var string
     */
    private $foot = 'foot';

    /**
     * Loading class
     *
     * @var string
     */
    private $loading = 'loading';

    /**
     * Error class
     *
     * @var string
     */
    private $error = 'error';

    /**
     * No result class
     *
     * @var string
     */
    private $norows = 'norows';

    /**
     * Pagination on head class
     *
     * @var string
     */
    private $paginationhead = 'pagination-head';

    /**
     * Pagination on foot class
     *
     * @var string
     */
    private $paginationfoot = 'pagination-foot';

    /**
     * Pagination container class
     *
     * @var string
     */
    private $paginationcontainer = 'pagination-container';

    /**
     * Pagination total rows class
     *
     * @var string
     */
    private $paginationtotalrows = 'pagination-totalrows';

    /**
     * Pagination previous button class
     *
     * @var string
     */
    private $paginationprevious = 'pagination-previous';

    /**
     * Pagination next button class
     *
     * @var string
     */
    private $paginationnext = 'pagination-next';

    /**
     * Pagination first button class
     *
     * @var string
     */
    private $paginationfirst = 'pagination-first';

    /**
     * Pagination last button class
     *
     * @var string
     */
    private $paginationlast = 'pagination-last';

    /**
     * Pagination reload button class
     *
     * @var string
     */
    private $paginationreload = 'pagination-reload';

    /**
     * Pagination rows per page select class
     *
     * @var string
     */
    private $paginationsetrows = 'pagination-setrows';

    /**
     * Pagination jumps button class
     *
     * @var string
     */
    private $paginationjumps = 'pagination-jumps';

    /**
     * Pagination current page button class
     *
     * @var string
     */
    private $paginationcurrentpage = 'pagination-currentpage';

    /**
     * Table cols class
     *
     * @var string
     */
    private $cols = 'cols';

    /**
     * Table col sortable class
     *
     * @var string
     */
    private $colsortable = 'col-sortable';

    /**
     * Table sort asc class
     *
     * @var string
     */
    private $sortasc = 'sort-asc';

    /**
     * Table sort desc class
     *
     * @var string
     */
    private $sortdesc = 'sort-desc';

    /**
     * Table sort arrow class
     *
     * @var string
     */
    private $sortarrow = 'sort-arrow';

    /**
     * Css prefix
     *
     * @var string
     */
    private $prefix = self::PREFIX;

    /**
     * Ajaxtable default prefix
     */
    const PREFIX = 'ajaxtable';

    /**
     * Set class on object
     *
     * @param string $name
     * @param string $value
     * @return void
     */
    public function __set($name, $value)
    {
        if (isset($this->$name)) {
            $this->$name = Format::slug($value);
        }
    }

    /**
     * Set class data
     *
     * @param string $name
     * @return string
     */
    public function __get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        }
    }

    /**
     * Get array data
     *
     * @return array
     */
    public function getArray()
    {
        $array = [];

        $array['classTable'] = ($this->prefix ? $this->prefix.'-' : '').$this->table;
        $array['classHead'] = ($this->prefix ? $this->prefix.'-' : '').$this->head;
        $array['classBody'] = ($this->prefix ? $this->prefix.'-' : '').$this->body;
        $array['classFoot'] = ($this->prefix ? $this->prefix.'-' : '').$this->foot;
        $array['classLoading'] = ($this->prefix ? $this->prefix.'-' : '').$this->loading;
        $array['classError'] = ($this->prefix ? $this->prefix.'-' : '').$this->error;
        $array['classNoRows'] = ($this->prefix ? $this->prefix.'-' : '').$this->norows;
        $array['classPaginationHead'] = ($this->prefix ? $this->prefix.'-' : '').$this->paginationhead;
        $array['classPaginationFoot'] = ($this->prefix ? $this->prefix.'-' : '').$this->paginationfoot;
        $array['classPaginationContainer'] = ($this->prefix ? $this->prefix.'-' : '').$this->paginationcontainer;
        $array['classPaginationTotalRows'] = ($this->prefix ? $this->prefix.'-' : '').$this->paginationtotalrows;
        $array['classPaginationPrevious'] = ($this->prefix ? $this->prefix.'-' : '').$this->paginationprevious;
        $array['classPaginationNext'] = ($this->prefix ? $this->prefix.'-' : '').$this->paginationnext;
        $array['classPaginationFirst'] = ($this->prefix ? $this->prefix.'-' : '').$this->paginationfirst;
        $array['classPaginationLast'] = ($this->prefix ? $this->prefix.'-' : '').$this->paginationlast;
        $array['classPaginationReload'] = ($this->prefix ? $this->prefix.'-' : '').$this->paginationreload;
        $array['classPaginationSetRows'] = ($this->prefix ? $this->prefix.'-' : '').$this->paginationsetrows;
        $array['classPaginationJumps'] = ($this->prefix ? $this->prefix.'-' : '').$this->paginationjumps;
        $array['classPaginationCurrentPage'] = ($this->prefix ? $this->prefix.'-' : '').$this->paginationcurrentpage;
        $array['classCols'] = ($this->prefix ? $this->prefix.'-' : '').$this->cols;
        $array['classColSortable'] = ($this->prefix ? $this->prefix.'-' : '').$this->colsortable;
        $array['classSortAsc'] = ($this->prefix ? $this->prefix.'-' : '').$this->sortasc;
        $array['classSortDesc'] = ($this->prefix ? $this->prefix.'-' : '').$this->sortdesc;
        $array['classSortArrow'] = ($this->prefix ? $this->prefix.'-' : '').$this->sortarrow;

        return $array;
    }

    /**
     * Get classes json data to be user on ajaxtable.js configuration
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
}
