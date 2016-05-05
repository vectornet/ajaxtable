<?php
/**
 * Class with all strings on Brazilian Portuguese
 *
 * @author Joubert <eu@redrat.com.br>
 * @copyright Copyright (c) 2016 Vector Internet Business and AjaxTable contributors
 * @license: MIT
 * @see https://github.com/vectornet/ajaxtable/
 * @see http://www.vectornet.com.br
 */

namespace VectorDev\AjaxTable\Lang;

class PtBr extends Lang
{
    /**
     * Construct with default Brazilian Portuguese strings
     *
     * @return void
     */
    public function __construct()
    {
        $this->totalrows = 'Exibindo %rowfirst a %rowlast de %rowtotal registros';
        $this->pagination = 'Paginação';
        $this->previous = 'Anterior';
        $this->next = 'Próximo';
        $this->first = 'Primeira';
        $this->last = 'Última';
        $this->reload = 'Recarregar';
        $this->setrows = '%row linhas por página';
        $this->norows = 'Nenhum registro encontrado';
        $this->error = 'Um erro ocorreu durante a requisição dos dados, tente novamente';
    }
}
