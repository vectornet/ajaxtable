/*
 * AjaxTable for jQuery
 *
 * @author Joubert <eu@redrat.com.br>
 * @copyright Copyright (c) 2016 Vector Internet Business and AjaxTable contributors
 * @license: MIT
 * @requrire: jQuery 1.6 or later
 * http://www.vectornet.com.br
 * https://github.com/vectornet/ajaxtable/
 */

(function($){
     $.fn.extend({
        /**
         * External request for ajaxtable.
         *
         * @param {json} ajaxTableOptions
         * @returns {void}
         */
        ajaxTable: function(options) {
            var request_options = {
                instance_id: '',
                cols: [],
                method: 'POST',
                url: '',
                params: {},
                params_new: {},
                page: 1,
                rows: 10,
                rowsJump: 3,
                rowsJumpResponsive: 1,
                rowsOptions: [5, 10, 20, 50, 100, 500],
                sortOrder: 'ASC',
                paramToSort: null,
                responsive: false,
                refreshCallbackFunctionBefore: null,
                refreshCallbackFunctionAfter: null
            };

            var response_options = {
                json_response: {}
            };

            var format_options = {
                classTable: 'ajaxtable-table',
                classHead: 'ajaxtable-head',
                classBody: 'ajaxtable-body',
                classFoot: 'ajaxtable-foot',
                classLoading: 'ajaxtable-loading',
                classError: 'ajaxtable-error',
                classNoRows: 'ajaxtable-norows',
                classPaginationHead: 'ajaxtable-pagination-head',
                classPaginationFoot: 'ajaxtable-pagination-foot',
                classPaginationContainer: 'ajaxtable-pagination-container',
                classPaginationTotalRows: 'ajaxtable-pagination-totalrows',
                classPaginationPrevious: 'ajaxtable-pagination-previous',
                classPaginationNext: 'ajaxtable-pagination-next',
                classPaginationFirst: 'ajaxtable-pagination-first',
                classPaginationLast: 'ajaxtable-pagination-last',
                classPaginationReload: 'ajaxtable-pagination-reload',
                classPaginationSetRows: 'ajaxtable-pagination-setrows',
                classPaginationJumps: 'ajaxtable-pagination-jumps',
                classPaginationCurrentPage: 'ajaxtable-pagination-currentpage',
                classCols: 'ajaxtable-cols',
                classColSortable: 'ajaxtable-col-sortable',
                classSortAsc: 'ajaxtable-sort-asc',
                classSortDesc: 'ajaxtable-sort-desc',
                classSortArrow: 'ajaxtable-sort-arrow'
            };

            var event_options = {
                eventPagePrevious: 'ajaxtable-event-pageprevious',
                eventPageNext: 'ajaxtable-event-pagenext',
                eventPageFirst: 'ajaxtable-event-pagefirst',
                eventPageLast: 'ajaxtable-event-pagelast',
                eventPageJumps: 'ajaxtable-event-pagejumps',
                eventSetRows: 'ajaxtable-event-pagesetrows',
                eventReload: 'ajaxtable-event-pagereload'
            };

            var text_options = {
                textTotalRows: 'Display %rowfirst to %rowlast of %rowtotal rows',
                textPagination: 'Pagination',
                textPrevious: 'Previous',
                textNext: 'Next',
                textFirst: 'First',
                textLast: 'Last',
                textReload: 'Reload',
                textSetRows: '%row rows per page',
                textNoRows: 'No results found',
                textErrorRetrieveData: 'An error occurred during retrieving data, try again',
                textErrorSetConfig: 'The configuration defined for AjaxTable is invalid, try again',
            };

            this.each(function(){
                if (!(options instanceof Object)) {
                    $(this).data($.extend(
                        request_options,
                        response_options,
                        format_options,
                        text_options,
                        {'cols': [{'error': 'Error'}]},
                        event_options
                    ));

                    $(this).data('instance_id', this.id);

                    $(this).buildTableStructure();
                    $(this).buildTableCols();
                    $(this).buildErrorReport($(this).getOption('textErrorSetConfig'));
                } else {
                    $(this).data($.extend(
                        request_options,
                        response_options,
                        format_options,
                        text_options,
                        options,
                        event_options
                    ));

                    $(this).data('instance_id', this.id);

                    $(this).buildTableStructure();
                    $(this).buildTableCols();
                    $(this).refresh();
                }
            });
        },

        /**
         * Create and build table structure
         *
         * @returns {void}
         */
        buildTableStructure: function() {
            $(this).addClass(this.getOption('classTable'));
            this.append('<thead class="'+this.getOption('classHead')+'"></thead>');
            this.append('<tbody class="'+this.getOption('classBody')+'"></tbody>');
            this.append('<tfoot class="'+this.getOption('classFoot')+'"></tfoot>');

            this.find('thead').append('<tr class="'+this.getOption('classPaginationHead')+'"></tr>');
            this.find('tfoot').append('<tr class="'+this.getOption('classPaginationFoot')+'"></tr>');
        },

        /**
         * Create and build columns
         *
         * @returns {void}
         */
        buildTableCols: function() {
            var html_cols = '';
            var html_colgroups = '';

            var i = 0;
            for (i = 0; i < this.getOption('cols').length; i++) {
                html_cols += '<th';
                if (this.getOption('cols')[i].headerId)
                    html_cols += ' id="'+this.getOption('cols')[i].headerId+'"';

                var class_element = [];
                if (this.getOption('cols')[i].sortable)
                    class_element.push(this.getOption('classColSortable'));
                if (this.getOption('cols')[i].headerClass)
                    class_element.push(this.getOption('cols')[i].headerClass);
                if (class_element.length > 0)
                    html_cols += ' class="'+class_element.join(' ')+'"';
                html_cols += '>';

                if (this.getOption('cols')[i].headerTitle) {
                    if(this.getOption('cols')[i].sortable) {
                        html_cols += '<a href="javascript://" onclick="$(\'#'+this.getOption('instance_id')+'\').ajaxTableSort(\'' + this.getOption('cols')[i].valueToSort + '\', this);">' + this.getOption('cols')[i].headerTitle + '</a>';
                        html_cols += '<span class="'+this.getOption('classSortArrow')+'">';

                        if (this.getOption('sortCol') && this.getOption('sortCol') == this.getOption('cols')[i].valueToSort) {
                            html_cols += this.getOption('sortOrder') === 'ASC' ? '▲' : '▼';
                        }

                        html_cols += '<span>';
                    } else {
                        html_cols += this.getOption('cols')[i].headerTitle;
                    }
                }

                html_cols += '</th>';

                html_colgroups += '<colgroup';
                if (this.getOption('cols')[i].colgroupClass)
                    html_colgroups += ' class="'+this.getOption('cols')[i].colgroupClass+'"';
                if(this.getOption('cols')[i].colgroupid)
                    html_colgroups += ' id="'+this.getOption('cols')[i].colgroupid+'"';
                html_colgroups += ' ></colgroup>';
            }

            this.prepend(html_colgroups);
            this.find('thead').append('<tr class="'+this.getOption('classCols')+'">'+html_cols+'</tr>');
        },

        /**
         * Refresh tabledata
         *
         * @param {type} type
         * @param {type} param
         * @returns {void}
         */
        refresh: function() {
            if (typeof this.getOption('refreshCallbackFunctionBefore') === 'function') {
                this.getOption('refreshCallbackFunctionBefore')();
            } else if (this.getOption('refreshCallbackFunctionBefore')) {
                var func = this.getOption('refreshCallbackFunctionBefore');
                window[func]();
            }

            this.loadAjaxData();
            this.bindEventElements();

            if (typeof this.getOption('refreshCallbackFunctionAfter') === 'function') {
                this.getOption('refreshCallbackFunctionAfter')();
            } else if (this.getOption('refreshCallbackFunctionAfter')) {
                var func = this.getOption('refreshCallbackFunctionAfter');
                window[func]();
            }
        },

        /**
         * Set option on ajaxtable options
         *
         * @param {string} param
         * @param {mixed} value
         * @returns {void}
         */
        setOption: function(param, value) {
            this.data(param, value);
        },

        /**
         * Get ajaxtable option
         *
         * @param {string} param
         * @returns {mixed}
         */
        getOption: function(param) {
            return this.data(param);
        },

        /**
         * Set custom param for request
         *
         * @param {string} param
         * @param {mixed} value
         * @returns {void}
         */
        setRequestParam: function(param, value) {
            this.data('params_new')[param] = value;
            this.setOption('page', 1);
        },

        /**
         * Get custom param for request
         *
         * @param {string} param
         * @returns {mixed}
         */
        getRequestParam: function(param) {
            return this.data('params_new')[param];
        },

        /**
         * Get custom param for request set on config
         *
         * @param {string} param
         * @returns {mixed}
         */
        getDefaultRequestParam: function(param) {
            return this.data('params')[param];
        },

        /**
         * Clear custom param list for request
         *
         * @returns {void}
         */
        clearRequestParams: function() {
            this.setOption('params_new', {});
            this.setOption('page', 1);
        },

        /**
         * Get ajaxtable params for request
         *
         * @returns {object}
         */
        getAjaxTableRequestParams: function() {
            if (this.getOption('responsive')) {
                var cols = [];
                var i = 0;
                for (i = 0; i < this.getOption('cols').length ; i++) {
                    cols.push(this.getOption('cols')[i].headerTitle);
                }
                cols = JSON.stringify(cols);
            } else {
                var cols = this.getOption('cols').length;
            }

            return {
                'ajaxTableOptions[responsive]': this.getOption('responsive'),
                'ajaxTableOptions[cols]': cols,
                'ajaxTableOptions[rows]': this.getOption('rows'),
                'ajaxTableOptions[page]': this.getOption('page'),
                'ajaxTableOptions[sortOrder]': this.getOption('sortOrder'),
                'ajaxTableOptions[sortCol]': (this.getOption('sortCol') == null) ? '' : this.getOption('sortCol')
            };
        },

        /**
         * Get data fron ajax and put on table
         *
         * @returns {void}
         */
        loadAjaxData: function() {
            this.removeClass(this.getOption('classError'));
            this.addClass(this.getOption('classLoading'));

            var params = $.extend( false, this.getAjaxTableRequestParams(), this.getOption('params_new'), this.getOption('params'));
            $.ajax({
                context: this,
                url: this.getOption('url'),
                data: params,
                type: this.getOption('method'),
                instance_id: this.getOption('instance_id'),
                async: false,
                dataType: 'json',
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    this.buildErrorReport(this.getOption('textErrorRetrieveData'));
                },
                success: function(data, textStatus, XMLHttpRequest) {
                    this.setOption('json_response', data);
                    this.clearBody();
                    this.setOption('page', data.page);

                    if (this.getOption('json_response').totalRecords > 10 && this.getOption('rows') > 10)
                        $('#'+this.attr('id')+' .'+this.getOption('classPaginationHead')).html(this.getPagination());
                    else
                        $('#'+this.attr('id')+' .'+this.getOption('classPaginationHead')).html('');
                    $('#'+this.attr('id')+' .'+this.getOption('classPaginationFoot')).html(this.getPagination());

                    if (this.getOption('json_response').totalRecords > 0)
                        this.find('tbody').html(this.getOption('json_response').html);
                    else
                        this.find('tbody').html(this.getNoRows());

                    this.removeClass(this.getOption('classLoading'));
                }
            });
        },

        /**
         * Get data fron ajax and put on table
         *
         * @param {string} reason
         * @returns {void}
         */
        buildErrorReport: function(reason) {
            this.setOption('json_response', {'totalPages': 1, 'page': 1, 'totalRecords': 0, 'html': ''});
            this.clearBody();
            this.setOption('page', 1);

            $('.'+this.getOption('classPaginationFoot')).html(this.getPagination());

            this.find('tbody').html(this.getError(reason));

            this.removeClass(this.getOption('classLoading'));
            this.addClass(this.getOption('classError'));
        },

        /**
         * Get html for no result
         *
         * @returns {string}
         */
        getNoRows: function() {
            return '<tr class="'+this.getOption('classNoRows')+'"><td colspan="'+this.getOption('cols').length +'">'+this.getOption('textNoRows')+'</td></tr>';
        },

        /**
         * Get html for error
         *
         * @param {string} message
         * @returns {string}
         */
        getError: function(message) {
            return '<tr class="'+this.getOption('classError')+'"><td colspan="'+this.getOption('cols').length +'">'+message+'</td></tr>';
        },

        /**
         * Jump for specific page
         *
         * @param {int} page
         * @returns {void}
         */
        jumpToPage: function(page) {
            if(page <= this.getOption('json_response').totalPages) {
                this.setOption('page', page);
                $(this).refresh();
            }
        },

        /**
         * Sort data on table
         *
         * @param {string} valueToSort
         * @param {object} element
         * @returns {void}
         */
        ajaxTableSort: function(valueToSort, element) {
            if(this.getOption('sortCol') === valueToSort)
                this.setOption('sortOrder', ((this.getOption('sortOrder') === 'DESC') ? 'ASC' : 'DESC'));
            else
                this.setOption('sortOrder', 'ASC');
            this.setOption('sortCol', valueToSort);

            $('.'+this.getOption('classSortArrow')).html('');
            $('.'+this.getOption('classSortAsc')).removeClass(this.getOption('classSortAsc'));
            $('.'+this.getOption('classSortDesc')).removeClass(this.getOption('classSortDesc'));

            $(element)
                .parent()
                .addClass(this.getOption(this.getOption('sortOrder') === 'ASC' ? 'classSortAsc' : 'classSortDesc'))
                .find('span')
                .html(this.getOption('sortOrder') === 'ASC' ? '▲' : '▼')
            ;
            $(this).refresh();
        },

        /**
         * Clear body data
         *
         * @returns {void}
         */
        clearBody: function() {
            if (this.find('tbody').length) {
                this.find('tbody').html('');
            }
        },

        /**
         * Get html for pagination
         *
         * @returns {string}
         */
        getPagination: function() {
            var html = '<td colspan="'+this.getOption('cols').length+'">';
            html += '<div class="'+this.getOption('classPaginationContainer')+'"><ul>';

            if (this.getOption('page') >  1) {
                var frist = '<li '+((this.getOption('classPaginationFirst')) ? 'class="'+this.getOption('classPaginationFirst')+'"' : '')+'>';
                frist += '<a href="javascript://" onclick="$(\'#'+this.attr('id')+'\').goToFirst();">'+this.getOption('textFirst')+'</a>';
                frist += '</li>';

                var previous = '<li '+((this.getOption('classPaginationPrevious')) ? 'class="'+this.getOption('classPaginationPrevious')+'"' : '')+'>';
                previous += '<a href="javascript://" onclick="$(\'#'+this.attr('id')+'\').goToPrevious();">'+this.getOption('textPrevious')+'</a>';
                previous += '</li>';

                html += frist + previous;
            }

            var jumps = '';

            var rowsJump = this.getOption('responsive') && screen.width <= 480 ? this.getOption('rowsJumpResponsive') : this.getOption('rowsJump');

            for (var i = -rowsJump; i <= rowsJump; i++) {
                if (parseInt(this.getOption('page')) + i <= this.getOption('json_response').totalPages && parseInt(this.getOption('page')) + i > 0) {
                    if (i == 0)
                        jumps += '<li'+((this.getOption('classPaginationCurrentPage')) ? ' class="'+this.getOption('classPaginationCurrentPage')+'"' : '')+'><a>'+parseInt(this.getOption('page'))+'</a></li>';
                    else
                        jumps += '<li'+((this.getOption('classPaginationJumps')) ? ' class="'+this.getOption('classPaginationJumps')+'"' : '')+'><a href="javascript://" onclick="$(\'#'+ this.attr('id') +'\').jumpToPage('+(parseInt(this.getOption('page')) + i)+');">'+(parseInt(this.getOption('page')) + i)+'</a></li>';
                }
            }

            html += jumps;

            if(this.getOption('page') <  this.getOption('json_response').totalPages) {
                var next = '<li '+((this.getOption('classPaginationNext')) ? 'class="'+this.getOption('classPaginationNext')+'"' : '')+'>';
                next += '<a href="javascript://" onclick="$(\'#'+ this.attr('id') +'\').goToNext();">'+this.getOption('textNext')+'</a>';
                next += '</li>';

                var last = '<li '+((this.getOption('classPaginationLast')) ? 'class="'+this.getOption('classPaginationLast')+'"' : '')+'>';
                last += '<a href="javascript://" onclick="$(\'#'+this.attr('id')+'\').goToLast();">'+this.getOption('textLast')+'</a>';
                last += '</li>';

                html += next + last;
            }

            var reload = '<li '+((this.getOption('classPaginationReload')) ? 'class="'+this.getOption('classPaginationReload')+'"' : '')+'>';
            reload += '<a href="javascript://" onclick="$(\'#'+this.attr('id')+'\').refresh();">'+this.getOption('textReload')+'</a>';
            reload += '</li>';

            html += reload;

            html += '</ul></div>';

            html += '<div class="'+this.getOption('classPaginationSetRows')+'">';
            html += '<select onchange="$(\'#'+this.attr('id')+'\').changeRowsPerPage(this.value);">';
            for (var i = 0; i < this.getOption('rowsOptions').length; i++) {
                html += '<option value="'+this.getOption('rowsOptions')[i]+'"';
                html += (this.getOption('rows') == this.getOption('rowsOptions')[i]) ? ' selected="selected"' : '';
                html += '>';
                html += this.getOption('textSetRows').replace('%row', this.getOption('rowsOptions')[i])+'</option>';
            }
            html += '</select></div>';

            if (this.getOption('json_response').totalRecords > 0) {
                var rows_text = this.getOption('textTotalRows');
                rows_text = rows_text.replace('%rowfirst', (this.getOption('rows') * this.getOption('page') + 1) - this.getOption('rows'));
                if ((this.getOption('page') * this.getOption('rows')) > this.getOption('json_response').totalRecords)
                    rows_text = rows_text.replace('%rowlast', this.getOption('json_response').totalRecords);
                else
                    rows_text = rows_text.replace('%rowlast', this.getOption('page') * this.getOption('rows'));
                rows_text = rows_text.replace('%rowtotal', this.getOption('json_response').totalRecords);
            } else {
                var rows_text = this.getOption('textNoRows');
            }

            html += '<div class="'+this.getOption('classPaginationTotalRows')+'">'+rows_text+'</div>';
            html += '</td>';

            return html;
        },

        /**
         * Change rows per page
         *
         * @param {int} size
         * @returns {void}
         */
        changeRowsPerPage: function(size) {
            //if (this.getOption('rowsOptions').indexOf(size) != -1) {
                this.setOption('rows', size);
                this.refresh();
            //}
        },

        /**
         * Jump page to previous
         *
         * @returns {void}
         */
        goToPrevious: function() {
            this.setOption('page', (this.getOption('page') > 1) ? this.getOption('page') - 1 : 1);
            this.refresh();
        },

        /**
         * Jump page to next
         *
         * @returns {void}
         */
        goToNext: function() {
            this.setOption('page', (this.getOption('page') < this.getOption('json_response').totalPages) ? this.getOption('page') + 1 : this.getOption('json_response').totalPages);
            this.refresh();
        },

        /**
         * Jump page to first
         *
         * @returns {void}
         */
        goToFirst: function() {
            this.setOption('page', 1);
            this.refresh();
        },

        /**
         * Jump page to last
         *
         * @returns {void}
         */
        goToLast: function() {
            this.setOption('page', this.getOption('json_response').totalPages);
            this.refresh();
        },

        /**
         * Bind event elements after ajax load
         *
         * @returns {void}
         */
        bindEventElements: function() {
            // future
        }
    });
})(jQuery);
