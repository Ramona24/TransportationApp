var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};


(function() {

    var updateFilterPointsElement = function(bus_number) {
        //$('#filter-points').fadeIn();
        //$('#filter-points').find('label,select').hide();
        $('#filter-points-loader').show();

        $.getJSON('index.php?a=get_bus_points', {"bus_number": bus_number}, function(points) {
            
            var points_el = $('[name=filter_by_point_id]');
            points_el.find('option').remove();
            var current_point_filter_id = getUrlParameter('filter_by_point_id');
            points_el.append('<option value="all">Show All</option>')
            $.each(points, function(i, p) {
                points_el.append('<option value="' + p.id + '" ' + (current_point_filter_id == (p.id + "") ? 'SELECTED' : '') + '>' + p.description + '</option>')
            })

            setTimeout(function() {
                $('#filter-points-loader').fadeOut();
                //$('#filter-points').find('label,select').fadeIn();
            }, 1000)
        })
    }

    if(getUrlParameter('bus_number')) {
        updateFilterPointsElement(getUrlParameter('bus_number'));
    }

    $(document).on('input', '[data-page-name=find_bus_times] [name=bus_number]', function(e) {
        
        var bus_number = $(this).val();
        updateFilterPointsElement(bus_number);
    })

})()