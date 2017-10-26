(function() {

    $(document).on('input', '[data-page-name=find_bus_times] [name=bus_number]', function(e) {
        var bus_number = $(this).val();
        $.getJSON('index.php?a=get_bus_points', function(points) {
            var points_el = $('[name=filter_by_point_id]');
            points_el.find('option').remove();
            $.each(points, function(i, p) {
                points_el.append('<option value="' + p.id + '">' + p.description + '</option>')
            })
        })
    })

})()