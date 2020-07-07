$( document ).ready(function() {
    // Ваш ключ
    var key = 'api ключ';
    $('#form').submit(function (e) {
        e.preventDefault();
        var adress = $(this).find($('#inputAdress')).val();
        $.ajax({
            url: "https://geocode-maps.yandex.ru/1.x/?apikey=" + key +"&format=json&geocode=" + adress,
            success: function (response) {
                // Адрес
                var adress = response.response.GeoObjectCollection.featureMember[0].GeoObject.metaDataProperty.GeocoderMetaData.text;
                $('#adress').html(
                    'Адрес: ' + adress
                );
                // Координаты
                var point = response.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos;
                $('#point').html(
                    'Координаты: ' + point
                );
                // Метро
                $.ajax({
                    url: "https://geocode-maps.yandex.ru/1.x/?apikey=" + key +"&format=json&kind=metro&geocode=" + point,
                    success: function (resp) {
                        var metro = resp.response.GeoObjectCollection.featureMember[0].GeoObject.metaDataProperty.GeocoderMetaData.text;
                        $('#metro').html(
                            'Ближайшее метро: ' + metro
                        );
                    }
                });
            }
        })
    });
});