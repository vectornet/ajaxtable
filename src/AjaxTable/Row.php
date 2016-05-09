<?php
/**
 * Manipulates all row data from AjaxTable
 *
 * @author Joubert <eu@redrat.com.br>
 * @copyright Copyright (c) 2016 Vector Internet Business and AjaxTable contributors
 * @license: MIT
 * @see https://github.com/vectornet/ajaxtable/
 * @see http://www.vectornet.com.br
 */

namespace VectorDev\AjaxTable;

class Row extends Format\Format
{
    /**
     * List of VectorDev\AjaxTable\Cell
     *
     * @var array
     */
    private $table_cells = [];

    /**
     * Create Row Object with data, this construct
     * support N VectorDev\AjaxTable\Cell on method params
     *
     * @return void
     */
    public function __construct()
    {
        for ($i = 0; $i < func_num_args(); $i++) {
            $this->addCell(func_get_arg($i));
        }
    }

    /**
     * Add VectorDev\AjaxTable\Cell to list
     *
     * @param VectorDev\AjaxTable\Cell $Cell
     * @return void
     */
    public function addCell(Cell $Cell)
    {
        $this->table_cells[] = $Cell;
    }

    /**
     * Get list of VectorDev\AjaxTable\Cell
     *
     * @return array
     */
    public function getCells()
    {
        return $this->table_cells;
    }

    /**
     * Get number of VectorDev\AjaxTable\Cell on list
     *
     * @return int
     */
    public function getNumCells()
    {
        return count($this->table_cells);
    }

    /**
     * Genetare and return html data from this row and cells on list
     *
     * @return string
     */
    public function getHtml()
    {
        $html = [];
        $html[] = '<tr'.(parent::getHtml() ? ' '.parent::getHtml() : '').'>';
        foreach ($this->table_cells as $Cell) {
            $html[] = $Cell->getHtml();
        }
        $html[] = '</tr>';
        return implode('', $html);
    }
}
