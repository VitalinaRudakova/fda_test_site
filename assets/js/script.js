function hideAttachedFiles(container, right) {
    let tmpBtnShowMore = document.createElement('div');
    tmpBtnShowMore.innerHTML = `
<a class="messager-attach-file messager-attach-file-show-more" href="javascript:void(0)" onclick="showAttachedFiles(this)">
    <span>Еще #C#</span>
    <svg class="svg-arrow ml-10"><use xlink:href="#triangle-down"></use></svg>
</a>
`;
    tmpBtnShowMore = tmpBtnShowMore.firstElementChild;

    let fileList = container.querySelectorAll('.messager-attach-file');
    console.log(window.matchMedia('(min-width: 730px)').matches);

    if (window.matchMedia('(min-width: 730px)').matches) {
        let topStandard = fileList.item(0).offsetTop;

        if (fileList.item(fileList.length - 1).offsetTop > topStandard) {
            container.prepend(tmpBtnShowMore);
            let f = 0;
            fileList.forEach(function(el, i) {
                if (el.offsetTop > topStandard || f > 0) {
                    el.style.display = 'none';
                    if (f === 0) {
                        tmpBtnShowMore.remove();
                        container.insertBefore(tmpBtnShowMore, el);
                    }
                    f++;
                }
            });
            tmpBtnShowMore.innerHTML = tmpBtnShowMore.innerHTML.replace('#C#', f-1);
        }
    }
    else {
        if (fileList.length > 3) {
            let c = 0;
            for (let i = 2; i < fileList.length; i++) {
                c++;
                fileList.item(i).style.display = 'none';
            }
            tmpBtnShowMore.innerHTML = tmpBtnShowMore.innerHTML.replace('#C#', c);
            container.append(tmpBtnShowMore);
        }
    }
}
function showAttachedFiles(btn) {
    let els = btn.parentElement.children;

    for (let i in els) {
        if (!els.hasOwnProperty(i)) continue;
        let el = els[i];
        el.style.display = '';
        if (el.classList.contains('messager-attach-file-show-more')) {
            el.style.display ='none';
        }
    }
}

document.querySelectorAll('[data-hide-attached-file]').forEach(function(el) {
    return hideAttachedFiles(el);
});

document.querySelectorAll('[data-hide-attached-file]').forEach(function(el) { 
    return hideAttachedFiles(el);
});

function domReady() {
    $(function () {
        $(document).on('show.bs.collapse', '#user-header-controls', function () {
            $('.header').addClass('shadow');
        });
        $(document).on('hidden.bs.collapse', '#user-header-controls', function () {
            $('.header').removeClass('shadow');
        });
    
        $(document).on('click', '.filter-item-title', function () {
            var $filterItem = $(this).closest('.filter-item');
    
            $filterItem.toggleClass('show').siblings().removeClass('show');
        });
    
        $(document).on('click', '#filter-mobile-toggler,#filter-mobile-close', function () {
            var $fm = $('#filter-mobile');
            $fm.toggleClass('show');
            if ($fm.hasClass('show')) {
                $('body').addClass('overflow-hidden');
            } else {
                $('body').removeClass('overflow-hidden');
            }
        });
    
        $('.custom-modal').on('scroll', function () {
            let off = window.matchMedia('(max-width: 929px)').matches;
            sticky(this, 30, off);
        });
    
        
    });
}
domReady();

function togglerEl (el) {
    var textContainer,
        closeText,
        openText,
        rotateContainer,
        $this = $(el),
        $target = $($this.attr('data-toggler'));

    textContainer = $this.find('[data-toggler-text]');
    if (textContainer.length == 0) textContainer = $this;

    rotateContainer = $this.find('[data-toggler-rotate]');
    if (!$this.attr('data-toggler-close-text'))
        $this.attr('data-toggler-close-text', textContainer.html());
    if (!$this.attr('data-toggler-open-text'))
        $this.attr('data-toggler-open-text', textContainer.html());

    closeText = $this.attr('data-toggler-close-text');
    openText = $this.attr('data-toggler-open-text');

    if ($target.hasClass('open')) {
        $target.removeClass('open');
        textContainer.html(closeText);
        rotateContainer.css('transform', '');
    }
    else {
        $target.addClass('open');
        textContainer.html(openText);
        rotateContainer.css('transform', 'rotate(180deg)');
    }
}

function sticky(parent, marginTop, off) {
    marginTop = marginTop || 30;
    off = off === true;
    if (off) {
        $(parent).find('[data-sticky-item]').removeClass('sticking').css({
            'position': '',
            'top': ''
        });
    } else {
        $(parent).find('[data-sticky-container]').each(function (i, container) {
            let containerRect = container.getBoundingClientRect();
            $(container).find('[data-sticky-item]').each(function (j, item) {
                if (containerRect.top < -containerRect.height) {
                    let offsetTop = Math.abs(containerRect.top) + marginTop;
                    $(item).addClass('sticking').css({
                        'position': 'relative',
                        'top': offsetTop,
                    });
                }
                else {
                    $(item).removeClass('sticking').css({
                        // 'position': '',
                        'top': 0,
                    });
                }
            });
        });
    }
}

$(function() {
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#date-range-picker-start').text(start.format('DD.MM.YYYY'));
        $('#date-range-picker-end').text(end.format('DD.MM.YYYY'));
    }

    $('#date-range-picker').daterangepicker({
        startDate: start,
        endDate: end,
        alwaysShowCalendars: true,
        showCustomRangeLabel: false,
        showDropdowns: true,
        opens: "right",
        drops: "auto",
        locale: {
            firstDay: 1,
            format: 'DD.MM.YYYY',
            applyLabel: 'Применить',
            cancelLabel: 'Отменить',
            fromLabel: 'От',
            toLabel: 'До',
            daysOfWeek: [
                "Вс",
                "Пн",
                "Вт",
                "Ср",
                "Чт",
                "Пт",
                "Сб"
            ],
            monthNames: [
                "Январь",
                "Февраль",
                "Март",
                "Апрель",
                "Май",
                "Июнь",
                "Июль",
                "Август",
                "Сентябрь",
                "Октябрь",
                "Ноябрь",
                "Декабрь"
            ],
        },
        ranges: {
            'Сегодня': [moment(), moment()],
            'Вчера': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Предыдущие 7 дней': [moment().subtract(6, 'days'), moment()],
            'Предыдущие 30 дней': [moment().subtract(29, 'days'), moment()],
            'Этот месяц': [moment().startOf('month'), moment().endOf('month')],
            'Предыдущий месяц': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb)

    $('#date-range-picker').on('hide.daterangepicker', function () { $(this).removeClass('show') })
    $('#date-range-picker').on('show.daterangepicker', function () {
        $(this).addClass('show');
        console.log(this);
    });

    cb(start, end);
});

function ToggleStructureItem(el) {
    let $parent = $(el).closest('.structure-item');
    $parent.toggleClass('open');
    if (!$parent.hasClass('open')) {
        $parent.find('.structure-item').removeClass('open');
    }
}

function OpenConfigurationUnits() {
    $('#configuration-popup').css('display', '');
}

function LoadActive(el) {
    if ($(el).data('loaded') !== true) {
        var template = document.getElementById('active-item').innerHTML;
        var $container = $('#active-container');

        $.ajax({
            url: ГлобальныйКонтекст.Коннектор1С.ПутьКБазе1С + '/v-can.site/assets?option=asset',
            dataType: 'json',
            success: function (json) {
                var html = Mustache.render(template, json);
                $container.animate({opacity: 0}, 250, function () {
                    $container.html(html);
                    $container.animate({opacity: 1}, 250);
                    $(el).data('loaded', true);
                });
            }
        });
    }
}

function LoadConfigurationGroups() {
    var template = document.getElementById('structure').innerHTML;
    $.ajax(ГлобальныйКонтекст.Коннектор1С.ПутьКБазе1С + '/v-can.site/assets?option=type', {
        dataType: 'json',
        success: function (json) {
            var html = Mustache.render(template, json);
            $('#groups-container').html(html)
        }
    });
}

function LoadConfigurationUnits(el, uid) {
    if ($(el).data('loaded') !== true) {
        var template = document.getElementById('structure-item').innerHTML;
        var $container = $(el).closest('.structure-item').find('>.structure-body');

        $.ajax(ГлобальныйКонтекст.Коннектор1С.ПутьКБазе1С + '/v-can.site/assets?option=configuration%20unit&uid='+uid, {
            dataType: 'json',
            success: function (json) {
                var html = Mustache.render(template, json);
                $container.animate({opacity: 0}, 250, function () {
                    $container.html(html);
                    $container.animate({opacity: 1}, 250);
                    $(el).data('loaded', true);
                });
            }
        });
    }
}

function SelectConfigurationUnit(el) {
    var $el = $(el),
    ref = $el.attr('ref'),
    name = $el.data('name'),
    code = $el.data('uid');

    var $input = $('#НовоеОбращениеАктив'),
    $inputCode = $('#configuration-unit-code');

    $input.attr('ref', ref);
    $input.val(name);
    $inputCode.val(code);

    $('#configuration-popup').css('display','none');
}

// Уведомляемые
function LoadNotifyUser() {
    $.ajax({
        url: ГлобальныйКонтекст.Коннектор1С.ПутьКБазе1С + '/v-can.site/execute',
        method: 'POST',
        data: {
            siteID: 'v-can.site_itil',
            exec: 'КэнСайтСервер.ФормаСписка(ПараметрыЗапроса)',
            targetelem_querytext: 'ЛичныйКабинетИнициатораСайт.СписокПользователейТекстЗапроса(ПараметрыЗапроса)',
            targetelem_formdataname: 'Уведомляемый',
            targetelem_maintable: 'СправочникСсылка.Пользователи',
            targetelem_listformcols: 'Ссылка'
        },
        success: function (data) {

            var div = document.createElement('div');
            div.innerHTML = data;

            var items = [];

            $(div).find('tr').each(function () {
                var $tr = $(this),
                ref = $tr.attr('ref'),
                name = $tr.attr('presentation');

                items.push({
                    name: name,
                    ref: ref
                });
            });

            var $container = $('#notify-user-popup');
            var html = Mustache.render(document.getElementById('notify-user-items-popup').innerHTML, {items: items});
            $container.html(html).css('display', '');
        }
    });
}
function RenderNotifyUsers() {
    var $container = $('#container-user-notify'),
    template = document.getElementById('notify-users').innerHTML;

    var html = Mustache.render(template, ГлобальныйКонтекст.Формы.Уведомляемые);
    $container.html(html);
}
function SelectNotifyUser(el) {
    var ref = $(el).attr('ref'),
    name = $(el).text().trim();

    var notifyUserExist = ГлобальныйКонтекст.Формы.Уведомляемые.Строки.find(function(e) { return e.Уведомляемый.Ссылка == ref; });
    if (!notifyUserExist)
        ГлобальныйКонтекст.Формы.Уведомляемые.Строки.push({Уведомляемый:{Представление: name, Ссылка: ref}});
    RenderNotifyUsers();
    $('#notify-user-popup').css('display', 'none');
}
function DeleteNotifyUser(elButton) {
    var $el = $(elButton).closest('.user-notify'),
    ref = $el.attr('ref');

    ГлобальныйКонтекст.Формы.Уведомляемые.Строки = ГлобальныйКонтекст.Формы.Уведомляемые.Строки.filter(function(e) { return e.Уведомляемый.Ссылка!=ref; });
    RenderNotifyUsers();
}
$(function () {
    $(document).on('click', function (e) {
        $('#configuration-popup,#notify-user-popup').css('display','none');
    });
});

// Фильтры
function GetFilterList(el) {
    var $el = $(el);
    var $container = $el.parent();
    if ($container.hasClass('show')) {
        $container.removeClass('show');
    } else {
        var fbody = $el.closest('.filter-body')
        fbody.find('.filter-item-body').remove();
        fbody.find('.filter-item').removeClass('show');

        var formdataname = $el.attr('formdataname'),
        maintable = $el.attr('maintable'),
        listformcols = $el.attr('listformcols'),
        querytext = $el.attr('querytext');

        var data = {
            siteID: 'v-can.site_itil',
            targetelem_formdataname: formdataname,
            targetelem_maintable: maintable,
            targetelem_listformcols: listformcols,
            targetelem_querytext: querytext,
			findtext: 'texttest',
            exec: 'КэнСайтСервер.ФормаСписка(ПараметрыЗапроса)',
            ТекущаяСтраницаСписка: ГлобальныйКонтекст.ДополнительныеПараметрыЗапросов.ТекущаяСтраницаСписка || 1
        };

        $.ajax({
            url: ГлобальныйКонтекст.Коннектор1С.ПутьКБазе1С + '/v-can.site/execute',
            data: data,
            method: 'POST',
            contentType: 'multipart/form-data',
            success: function (htmlstr) {
                var div = document.createElement('div');
                div.innerHTML = htmlstr;

                var items = [];
                $(div).find('tr.RefItem').each(function (i, trItem) {
                    items.push({
                        ref: $(trItem).attr('ref'),
                        presentation: $(trItem).attr('presentation'),
                        groupname: $(trItem).find('td').eq(1).text()
                    });
                });

                var template = document.getElementById('filterItemBody').innerHTML;

                $container.find('.filter-item-body').remove();

                var html = Mustache.render(template, {items: items});
                $container.append(html);
                $container.addClass('show');
            }
        });
    }
}
function SelectFilter(el) {
    var $el = $(el);
    var $parent = $el.closest('.filter-item');
    var $container = $parent.find('.filter-item-title');

    var ref = $el.attr('ref');
    $container.attr('ref', ref);

    var pres = $el.attr('presentation');
    $container.attr('presentation', pres);

    УстановитьОтборСпискаОбращений();
    $parent.removeClass('show');
}

// 
function GetServices(uid, fn) {
    var link = ГлобальныйКонтекст.Коннектор1С.ПутьКБазе1С + '/v-can.site/services?option=service';
    if (uid) link += '&uid='+uid;
    $.ajax({
        url: link,
        dataType: 'json',
        success: fn
    });
}
function RenderServices(el) {
    var template = document.getElementById('services').innerHTML;

    if (el !== undefined) {
        var uid = $(el).data('uid');
        var $container = $(el).closest('.structure-item').find('.structure-body');
        $.ajax({
            url: ГлобальныйКонтекст.Коннектор1С.ПутьКБазе1С + '/v-can.site/services?option=service&uid=' + uid,
            dataType: 'json',
            success: function (json) {
                var html = Mustache.render(template, json);
                $container.animate({opacity: 0}, 250, function () {
                    $container.html(html);
                    $container.animate({opacity: 1}, 250);
                    $(el).data('loaded', true);
                });
            }
        });
    } else {
        var $container = $('#service-popup');
        $.ajax({
            url: ГлобальныйКонтекст.Коннектор1С.ПутьКБазе1С + '/v-can.site/services?option=service',
            dataType: 'json',
            success: function (json) {
                var html = Mustache.render(template, json);
                $container.animate({opacity: 0}, 250, function () {
                    $container.html(html);
                    $container.animate({opacity: 1}, 250);
                });
            }
        });
        $container.show();
    }
}
var searchTmr;
function RenderSearchServices(el) {
    clearTimeout(searchTmr);
    var searchStr = $(el).val();
    var $container = $('#service-popup');
    if (searchStr.length >= 3) {
        var template = document.getElementById('services').innerHTML;
        searchTmr = setTimeout(function () {

            $.ajax({
                url: ГлобальныйКонтекст.Коннектор1С.ПутьКБазе1С + '/v-can.site/services?option=search&search_text=' + searchStr,
                dataType: 'json',
                success: function (json) {
                    var html = Mustache.render(template, json);
                    $container.html(html);
                }
            })

        }, 1000);
    }
}
function CloseServicePopup() {
    $('#service-popup').css('display', 'none');
}


/*



vcan_sessionid: null
t: 0.7158947838606882
siteID: v-can.site_itil
ТекущаяСтраницаСписка: 1
targetelem_class: filter-item-title
targetelem_onclick: ФормаВыбораЭтапа(this)
targetelem_id: filterStep
targetelem_formdataname: Этап
targetelem_maintable: СправочникСсылка.itilprofЭтапыМаршрутов
targetelem_listformcols: Ссылка:Этап, Владелец:Маршрут
targetelem_querytext: ЛичныйКабинетИнициатораСайт.ЭтапыМаршрутов_ТекстЗапроса(ПараметрыЗапроса, Запрос, ИсточникДанных)
targetelem_ref: 
exec: КэнСайтСервер.ФормаСписка(ПараметрыЗапроса)



siteID: v-can.site_itil
targetelem_formdataname: Этап
targetelem_maintable: СправочникСсылка.itilprofЭтапыМаршрутов
targetelem_listformcols: Ссылка:Этап, Владелец:Маршрут
targetelem_querytext: ЛичныйКабинетИнициатораСайт.ЭтапыМаршрутов_ТекстЗапроса(ПараметрыЗапроса, Запрос, ИсточникДанных)
exec: КэнСайтСервер.ФормаСписка(ПараметрыЗапроса)





vcan_sessionid: null
t: 0.34376469589450864
siteID: v-can.site_itil
ТекущаяСтраницаСписка: 1
formTemplate: customquery
formName: ЛичныйКабинетИнициатораСайт.СписокОбращений(ПараметрыЗапроса)
Отбор: {"status":3,"step":"{"#",2695c249-269e-4364-a1df-7752e15599a7,2216:abc11add341b75d311eaab005880dce8}"}
exec: КэнСайтСервер.ФормаСписка(ПараметрыЗапроса)


vcan_sessionid: null
t: 0.36913691389674774
siteID: v-can.site_itil
ТекущаяСтраницаСписка: 1
formTemplate: customquery
formName: ЛичныйКабинетИнициатораСайт.СписокОбращений(ПараметрыЗапроса)
Отбор: {"status":3,"step":"{"#",2695c249-269e-4364-a1df-7752e15599a7,2216:abc11add341b75d311eaab005880dce8}","initiator":"{"#",604931cd-d4a8-48d0-bc59-2ac90e044abb,47:9e806cf0495891ea11dfc46885429882}"}
exec: КэнСайтСервер.ФормаСписка(ПараметрыЗапроса)
*/