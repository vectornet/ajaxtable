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
    private $table = 'ajaxtable';

    /**
     * Head section class
     *
     * @var string
     */
    private $head = 'ajaxtable-head';

    /**
     * Body section class
     *
     * @var string
     */
    private $body = 'ajaxtable-body';

    /**
     * Foot section class
     *
     * @var string
     */
    private $foot = 'ajaxtable-foot';

    /**
     * Loading class
     *
     * @var string
     */
    private $loading = 'ajaxtable-loading';

    /**
     * Error class
     *
     * @var string
     */
    private $error = 'ajaxtable-error';

    /**
     * No result class
     *
     * @var string
     */
    private $norows = 'ajaxtable-norows';

    /**
     * Pagination on head class
     *
     * @var string
     */
    private $paginationhead = 'ajaxtable-pagination-head';

    /**
     * Pagination on foot class
     *
     * @var string
     */
    private $paginationfoot = 'ajaxtable-pagination-foot';

    /**
     * Pagination container class
     *
     * @var string
     */
    private $paginationcontainer = 'ajaxtable-pagination-container';

    /**
     * Pagination total rows class
     *
     * @var string
     */
    private $paginationtotalrows = 'ajaxtable-pagination-totalrows';

    /**
     * Pagination previous button class
     *
     * @var string
     */
    private $paginationprevious = 'ajaxtable-pagination-previous';

    /**
     * Pagination next button class
     *
     * @var string
     */
    private $paginationnext = 'ajaxtable-pagination-next';

    /**
     * Pagination first button class
     *
     * @var string
     */
    private $paginationfirst = 'ajaxtable-pagination-first';

    /**
     * Pagination last button class
     *
     * @var string
     */
    private $paginationlast = 'ajaxtable-pagination-last';

    /**
     * Pagination reload button class
     *
     * @var string
     */
    private $paginationreload = 'ajaxtable-pagination-reload';

    /**
     * Pagination rows per page select class
     *
     * @var string
     */
    private $paginationsetrows = 'ajaxtable-pagination-setrows';

    /**
     * Pagination jumps button class
     *
     * @var string
     */
    private $paginationjumps = 'ajaxtable-pagination-jumps';

    /**
     * Pagination current page button class
     *
     * @var string
     */
    private $paginationcurrentpage = 'ajaxtable-pagination-currentpage';

    /**
     * Table cols class
     *
     * @var string
     */
    private $cols = 'ajaxtable-cols';

    /**
     * Table sort asc class
     *
     * @var string
     */
    private $sortasc = 'ajaxtable-sort-asc';

    /**
     * Table sort desc class
     *
     * @var string
     */
    private $sortdesc = 'ajaxtable-sort-desc';

    /**
     * Table sort arrow class
     *
     * @var string
     */
    private $sortarrow = 'ajaxtable-sort-arrow';

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
            $this->$name = \VectorDev\TableFormat::slug($value);
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

        $array['classTable'] = $this->table;
        $array['classHead'] = $this->head;
        $array['classBody'] = $this->body;
        $array['classFoot'] = $this->foot;
        $array['classLoading'] = $this->loading;
        $array['classError'] = $this->error;
        $array['classNoRows'] = $this->norows;
        $array['classPaginationHead'] = $this->paginationhead;
        $array['classPaginationFoot'] = $this->paginationfoot;
        $array['classPaginationContainer'] = $this->paginationcontainer;
        $array['classPaginationTotalRows'] = $this->paginationtotalrows;
        $array['classPaginationPrevious'] = $this->paginationprevious;
        $array['classPaginationNext'] = $this->paginationnext;
        $array['classPaginationFirst'] = $this->paginationfirst;
        $array['classPaginationLast'] = $this->paginationlast;
        $array['classPaginationReload'] = $this->paginationreload;
        $array['classPaginationSetRows'] = $this->paginationsetrows;
        $array['classPaginationJumps'] = $this->paginationjumps;
        $array['classPaginationCurrentPage'] = $this->paginationcurrentpage;
        $array['classCols'] = $this->cols;
        $array['classSortAsc'] = $this->sortasc;
        $array['classSortDesc'] = $this->sortdesc;
        $array['classSortArrow'] = $this->sortarrow;

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
