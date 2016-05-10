<?php
/**
 * Manipulates all cell data from AjaxTable
 *
 * @author Joubert <eu@redrat.com.br>
 * @copyright Copyright (c) 2016 Vector Internet Business and AjaxTable contributors
 * @license: MIT
 * @see https://github.com/vectornet/ajaxtable/
 * @see http://www.vectornet.com.br
 */

namespace VectorDev\AjaxTable;

class Cell extends Format\Format
{
    /**
     * Text or html on cell
     *
     * @var string
     */
    private $text;

    /**
     * Create Cell Object with data
     *
     * @param string $text
     * @param string|array $class
     * @param string $id
     * @param string $title
     * @return void
     */
    public function __construct($text, $class = null, $id = null, $title = null)
    {
        $this->text = $text;
        $this->setTitle($title);
        $this->setId($id);
        $this->addClass($class);
    }

    /**
     * Genetare and return html data from this cell
     *
     * @param string $responsive_data
     * @return string
     */
    public function getHtml($responsive_data = null)
    {
        if (!is_null($responsive_data)) {
            $this->addData(parent::RESPONSIVE_DATA, $responsive_data ? $responsive_data : 'Data');
        }
        return '<td'.(parent::getHtml() ? ' '.parent::getHtml() : '').'>'.$this->text.'</td>';
    }
}
