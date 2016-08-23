<?php
/**
 * Abstract class to manipulate language data for ajaxtable.js on view
 *
 * @author Joubert <eu@redrat.com.br>
 * @copyright Copyright (c) 2016 Vector Internet Business and AjaxTable contributors
 * @license: MIT
 * @see https://github.com/vectornet/ajaxtable/
 * @see http://www.vectornet.com.br
 */

namespace VectorDev\AjaxTable\Lang;

abstract class Lang
{
    /**
     * Language on result information
     *
     * @var string
     */
    protected $totalrows = 'Display %rowfirst to %rowlast of %rowtotal rows';

    /**
     * Language on pagination area
     *
     * @var string
     */
    protected $pagination = 'Pagination';

    /**
     * Language on previous button
     *
     * @var string
     */
    protected $previous = 'Previous';

    /**
     * Language on next button
     *
     * @var string
     */
    protected $next = 'Next';

    /**
     * Language on first button
     *
     * @var string
     */
    protected $first = 'First';

    /**
     * Language on last button
     *
     * @var string
     */
    protected $last = 'Last';

    /**
     * Language on reload button
     *
     * @var string
     */
    protected $reload = 'Reload';

    /**
     * Language on rows per page select
     *
     * @var string
     */
    protected $setrows = '%row rows';

    /**
     * Language on text about empty response
     *
     * @var string
     */
    protected $norows = 'No results found';

    /**
     * Language on text about response error on retrieving data
     *
     * @var string
     */
    protected $error_retrieve_data = 'An error occurred during retrieving data, try again';

    /**
     * Language on text about response error on set configurations to AjaxTable
     *
     * @var string
     */
    protected $error_set_config = 'The configuration defined for AjaxTable is invalid, try again';

    /**
     * Set custom language translation on the fly
     *
     * @param string $name
     * @param string $value
     * @return void
     */
    public function __set($name, $value)
    {
        if (isset($this->$name)) {
            $this->$name = strip_tags($value);
        }
    }

    /**
     * Get language translation string
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

        $array['textTotalRows'] = $this->totalrows;
        $array['textPagination'] =  $this->pagination;
        $array['textPrevious'] =  $this->previous;
        $array['textNext'] =  $this->next;
        $array['textFirst'] =  $this->first;
        $array['textLast'] =  $this->last;
        $array['textReload'] =  $this->reload;
        $array['textSetRows'] =  $this->setrows;
        $array['textNoRows'] =  $this->norows;
        $array['textErrorRetrieveData'] =  $this->error_retrieve_data;
        $array['textErrorSetConfig'] =  $this->error_set_config;

        return $array;
    }

    /**
     * Get language json data to be user on ajaxtable.js configuration
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
     * Enable to use arrows instead words on pagination
     *
     * @return void
     */
    public function useArrows()
    {
        $this->first = '&lt;&lt;';
        $this->previous = '&lt;';
        $this->next = '&gt;';
        $this->last = '&gt;&gt;';
    }

    /**
     * Alias of method setArrows
     *
     * @return void
     * @see self::useArrows()
     */
    public function enableArrows()
    {
        $this->setArrows();
    }
}
