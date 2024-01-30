$(document).ready(function() {
    // Fetch countries
    $.ajax({
        url: 'http://api.geonames.org/countryInfoJSON',
        data: {
            username: 'cristovao07'
        },
        dataType: 'jsonp',
        success: function(data) {
            var countrySelect = $('#country');
            $.each(data.geonames, function(key, value) {
                countrySelect.append('<option value="' + value.countryCode + '">' + value.countryName + '</option>');
            });
        }
    });
    $('#country').on('change', function() {
        var countryCode = $(this).val();
        $('#state').empty();
        $.ajax({
            url: 'http://api.geonames.org/searchJSON',
            data: {
                country: countryCode,
                featureCode: 'ADM1',
                username: 'cristovao07'
            },
            dataType: 'jsonp',
            success: function(data) {
                var stateSelect = $('#state');
                $.each(data.geonames, function(key, value) {
                    stateSelect.append('<option value="' + value.adminCode1 + '">' + value.name + '</option>');
                });
            }
        });
    });
    $('#state').on('change', function() {
        var stateCode = $(this).val();
        var countryCode = $('#country').val();
        $('#city').empty();
        $.ajax({
            url: 'http://api.geonames.org/searchJSON',
            data: {
                country: countryCode,
                adminCode1: stateCode,
                featureCode: 'PPL',
                username: 'cristovao07'
            },
            dataType: 'jsonp',
            success: function(data) {
                var citySelect = $('#city');
                $.each(data.geonames, function(key, value) {
                    citySelect.append('<option value="' + value.geonameId + '">' + value.name + '</option>');
                });
            }
        });
    });
});