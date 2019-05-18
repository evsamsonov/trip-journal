const $ = require('jquery');

const startDatePrefix = 'trip_start_date';
const startDateDay = $(`#${startDatePrefix}_day`);
const startDateMonth = $(`#${startDatePrefix}_month`);
const startDateYear = $(`#${startDatePrefix}_year`);

const region = $('#trip_region');
const endDate = $('#trip_end_date');

// Событие на изменение
[startDateDay, startDateMonth, startDateYear, region].forEach(function (elem) {
    elem.on('change', function () {
        updateEndDate();
    });
});

/**
 * Обновляет дату окончания поездки
 */
function updateEndDate() {
    $.get('/trips/end-date', {
        start_date: `${startDateYear.val()}-${startDateMonth.val()}-${startDateDay.val()}`,
        region_id: region.val()
    }, function (response) {
        if ('error' in response) {
            alert('Ошибка при подсчете даты прибытия: ' + response.message);
            return false;
        }

        endDate.text(response.end_date);
    });
}

updateEndDate();