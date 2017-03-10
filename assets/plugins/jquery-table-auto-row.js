var _newAutoRowClassName_ = 'is-new-auto-row';
var _lastAutoRowClassName_ = 'is-last-new-auto-row';
var _tableAutoRowIgnoreClass_ = 'ignore-input';

(function ($) {
    $.fn.tableAutoRow = function (options) {
        var _settings = $.extend({
            showSequence: true,
            tdSequenceNumber: 0,
            beforeNewRow: function (sourceRow) {

            },
            afterNewRow: function (row) {

            },
            beforeAutoRemove: function (row) {

            },
            afterAutoRemove: function (index, table) {

            }
        }, options);

        var _table;
        var _newRow;
        var _newAutoRowClassName = _newAutoRowClassName_;
        var _lastAutoRowClassName = _lastAutoRowClassName_;

        var _orderTdSequence = function () {
            if (_settings.showSequence) {
                _table.find('tbody tr').each(function (index) {
                    if (_settings.tdSequenceNumber === null) {
                        _settings.tdSequenceNumber = 0;
                    }
                    $(this).find('td').eq(_settings.tdSequenceNumber).html(index + 1);
                });
            }
        };

        var _declareClassIsNewAutoRow = function () {
            _table.find('tbody tr:last').addClass(_newAutoRowClassName);
        };

        var _declareLastRow = function () {
            /**_table.find('tbody tr.'+_newAutoRowClassName).removeClass(_lastAutoRowClassName);*/
            _table.find('tbody tr').removeClass(_lastAutoRowClassName);
            _table.find('tbody tr:last').addClass(_lastAutoRowClassName);
        };

        var _checkTdSequenceHasHtmlTag = function () {
            if (_settings.showSequence === true) {
                var innerHtml_ = (_table.find('tbody tr').eq(-1).find('td').eq(_settings.tdSequenceNumber).html());
                var a = document.createElement('div');
                a.innerHTML = innerHtml_;
                for (var c = a.childNodes, i = c.length; i--;) {
                    if (c[i].nodeType === 1)
                        return true;
                }
                return false;
            } else {
                return false;
            }
        };

        /*var _initDatepicker = function () {
            _newRow.find('input[id]').each(function () {
                
                if ($(this).hasClass('hasDatepicker')) {
                    $(this).removeClass('hasDatepicker');
                    $(this).removeAttr('id');
                    $(this).datepicker();
                }
            });
        };*/

        var _removeUnusedRow = function (thisTrNotLast) {
            _table = thisTrNotLast.closest('table');
            var table = thisTrNotLast.closest('table');

            /**table.find('tbody tr.'+_newAutoRowClassName).not('.'+_lastAutoRowClassName).each(function() {*/
            table.find('tbody tr').not('.' + _lastAutoRowClassName).each(function () {
                var inputInTr = $(this).find(':input');
                var allowDelete = true;

                inputInTr.each(function () {
                    if ($(this).prop('tagName') === 'INPUT') {
                        if ($(this).attr('type') === 'hidden') {
                            if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                                if (!!$(this).val()) {
                                    allowDelete = false;
                                }
                            }
                        } else if ($(this).attr('type') === 'text') {
                            if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                                if (!!$(this).val()) {
                                    allowDelete = false;
                                }
                            }
                        } else if ($(this).attr('type') === 'number') {
                            if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                                if (!!$(this).val()) {
                                    allowDelete = false;
                                }
                            }
                        } else if ($(this).attr('type') === 'checkbox') {
                            if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                                if ($(this).is(':checked')) {
                                    allowDelete = false;
                                }
                            }
                        } else if ($(this).attr('type') === 'radio') {
                            if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                                if ($('input[name="' + $(this).attr('name') + '"]:checked').size() > 0) {
                                    allowDelete = false;
                                }
                            }
                        } else if ($(this).attr('type') === 'file') {
                            if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                                if (!!$(this).val()) {
                                    allowDelete = false;
                                }
                            }
                        }
                    } else if ($(this).prop('tagName') === 'SELECT') {
                        if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                            if (!!$(this).val()) {
                                allowDelete = false;
                            }
                        }
                    } else if ($(this).prop('tagName') === 'TEXTAREA') {
                        if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                            if (!!$(this).val()) {
                                allowDelete = false;
                            }
                        }
                    }
                });

                if (allowDelete) {
                    _settings.beforeAutoRemove($(this).get(0));
                    var delIndex = $(this).index();
                    var table = $(this).closest("table").get(0);
                    if ($(this).hasClass(_newAutoRowClassName) || $(this).hasClass(_lastAutoRowClassName)) {
                        if(!$(this).closest('table').hasClass('table-condensed')) {
                            $(this).fadeOut('fast', function () {
                                $(this).remove();
                                _orderTdSequence();
                                _settings.afterAutoRemove(delIndex, table);
                            });    
                        }
                    } else {
                        /** If tr is original. Notthing to do */
                        if(!$(this).closest('table').hasClass('table-condensed')) {
                            $(this).fadeOut('fast', function () {
                                $(this).remove();
                                _orderTdSequence();
                                _settings.afterAutoRemove(delIndex, table);
                            });
                        }
                    }
                }
            });
        };

        var _tableAutoRow = function (thisInput) {
            var __clearAfterClone = function (newRow) {
                newRow.find(':input').each(function (index) {
                    if ($(this).prop('tagName') === 'INPUT') {
                        if ($(this).attr('type') === 'hidden') {
                            if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                                $(this).val('');
                            }
                        } else if ($(this).attr('type') === 'text') {
                            if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                                $(this).val('');
                            }
                        } else if ($(this).attr('type') === 'number') {
                            if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                                $(this).val('');
                            }
                        } else if ($(this).attr('type') === 'checkbox') {
                            $(this).prop('checked', false);
                        } else if ($(this).attr('type') === 'radio') {
                            $(this).removeAttr('checked');
                        } else if ($(this).attr('type') === 'file') {
                            $(this).val('');
                        }
                        
                    } else if ($(this).prop('tagName') === 'SELECT') {
                        $(this).find('option[value=""]').attr("selected", "selected");
                    } else if ($(this).prop('tagName') === 'TEXTAREA') {
                        if (!$(this).hasClass(_tableAutoRowIgnoreClass_)) {
                            $(this).val('');
                        }
                    }
                });
            };

            var thisTr = thisInput.closest('tr');

            _table = thisTr.closest('table');

            if (_checkTdSequenceHasHtmlTag()) {
                alert('If showSequence is true please don\'t create html input or tag in td sequence');
                /**_table.prev().html('If showSequence is true please don\'t create html input or tag in td sequence');*/
                return false;
            }

            /** call back before new row */
            var resultBeforeNewRow = _settings.beforeNewRow(thisTr.get(0));
            if (resultBeforeNewRow !== undefined && resultBeforeNewRow === false) {
                return false;
            }

            _newRow = _table.find('tbody tr').eq(-1).clone();
            _newRow.appendTo(_table.find('tbody'));

            __clearAfterClone(_newRow);

            //_initDatepicker();

            /** order sequence */
            _orderTdSequence();

            _declareClassIsNewAutoRow();
            _declareLastRow();

            /** call back after new row */
            _settings.afterNewRow(_newRow.get(0));
        };

        return $(this).on('change', 'tbody tr:last :input', function () {
            _tableAutoRow($(this));
        }).on('change', 'tbody tr:not(:last)', function () {
            _removeUnusedRow($(this));
        }).on('focusin', 'tbody', function () {
            $(this).find('tr:last').addClass(_lastAutoRowClassName_);
        })
            ;
    };
}(jQuery));

var tableAutoRow = (function () {
    var _dataReturn = [];
    var _newAutoRowClassName = _newAutoRowClassName_;
    var _lastAutoRowClassName = _lastAutoRowClassName_;

    _getDataByIdn = function (tr) {
        _dataReturn = [];

        tr.each(function () {
            var dataInTr = {};
            var thisTr = $(this);

            thisTr.find(':input').each(function () {
                var inputInTr = $(this);

                if (inputInTr.prop('tagName') === 'INPUT') {
                    if (inputInTr.attr('type') === 'hidden') {
                        dataInTr[inputInTr.attr('name')] = inputInTr.val();
                    } else if (inputInTr.attr('type') === 'text') {
                        dataInTr[inputInTr.attr('name')] = inputInTr.val();
                    } else if (inputInTr.attr('type') === 'number') {
                        dataInTr[inputInTr.attr('name')] = inputInTr.val();
                    } else if (inputInTr.attr('type') === 'checkbox') {
                        if (inputInTr.is(':checked')) {
                            /** dataInTr[inputInTr.attr('name')] = inputInTr.filter(':checked').val(); **/
                            dataInTr[inputInTr.attr('name')] = true;
                        } else {
                            dataInTr[inputInTr.attr('name')] = false;
                        }
                        dataInTr[inputInTr.attr('name') + 'Value'] = inputInTr.val();
                    } else if (inputInTr.attr('type') === 'radio') {
                        if ($('[name="' + inputInTr.attr('name') + '"]').is(':checked')) {
                            dataInTr[inputInTr.attr('name')] = $('[name="' + inputInTr.attr('name') + '"]:checked').val();
                        } else {
                            dataInTr[inputInTr.attr('name')] = false;
                        }
                    }
                } else if (inputInTr.prop('tagName') === 'SELECT') {
                    dataInTr[inputInTr.attr('name')] = inputInTr.val();
                } else if (inputInTr.prop('tagName') === 'TEXTAREA') {
                    dataInTr[inputInTr.attr('name')] = inputInTr.val();
                }
            });

            _dataReturn.push(dataInTr);
        });
    };

    return {
        getFullJsonStringByTableId: function(tableId, returnInString) {
            returnInString = returnInString || 'string';
            var table_ = $('#' + tableId);
            
            _getDataByIdn(table_.find('tbody tr'));
            
            return (returnInString === 'string'
                ? JSON.stringify(_dataReturn) : _dataReturn);
        },
        getFullJsonByTableId: function(tableId) {
            return tableAutoRow.getFullJsonStringByTableId(tableId, 'json');
        },
        getAllJsonStringByTableId: function (tableId, returnInString) {
            returnInString = returnInString || 'string';
            var table_ = $('#' + tableId);

            _getDataByIdn(table_.find('tbody tr'));

            _dataReturn.splice(-1, 1);

            return (returnInString === 'string'
                ? JSON.stringify(_dataReturn) : _dataReturn);
        },
        getAllJsonByTableId: function (tableId) {
            return tableAutoRow.getAllJsonStringByTableId(tableId, 'json');
        },
        getBaseJsonStringByTableId: function (tableId, returnInString) {
            returnInString = returnInString || 'string';

            var table_ = $('#' + tableId);

            _getDataByIdn(table_.find('tbody tr').not('.' + _newAutoRowClassName));

            return (returnInString === 'string'
                ? JSON.stringify(_dataReturn) : _dataReturn);
        },
        getBaseJsonByTableId: function (tableId) {
            return tableAutoRow.getBaseJsonStringByTableId(tableId, 'json');
        },
        getNewJsonStringByTableId: function (tableId, returnInString) {
            returnInString = returnInString || 'string';

            var table_ = $('#' + tableId);

            _getDataByIdn(table_.find('tbody tr.' + _newAutoRowClassName));

            _dataReturn.splice(-1, 1);

            return (returnInString === 'string'
                ? JSON.stringify(_dataReturn) : _dataReturn);
        },
        getNewJsonByTableId: function (tableId) {
            return tableAutoRow.getNewJsonStringByTableId(tableId, 'json');
        },
        getSpecifyRowJsonStringByTableId: function (tableId, rowSequence, returnInString) {
            returnInString = returnInString || 'string';

            var table_ = $('#' + tableId);

            if (table_.find('tbody tr').eq(rowSequence).length > 0) {
                _getDataByIdn(table_.find('tbody tr').eq(rowSequence));

                return (returnInString === 'string'
                    ? JSON.stringify(_dataReturn) : _dataReturn);
            } else {
                var notFoundReturn = {
                    result: 'error',
                    message: 'Not find index ' + rowSequence + ' of table row'
                };

                return (returnInString === 'string'
                    ? JSON.stringify(notFoundReturn) : notFoundReturn);
            }
        },
        getSpecifyRowJsonByTableId: function (tableId, rowSequence) {
            return tableAutoRow.getSpecifyRowJsonStringByTableId(tableId, rowSequence, 'json');
        }
    };
})();