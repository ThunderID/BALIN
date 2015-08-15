$('.input-number').on('change  paste', function () {
    var val = parseInt($(this).val());
    var min = parseInt($(this).attr('min'));
    var max = parseInt($(this).attr('max'));

    var test = isNaN(val);

    if(test == false)
    {
        if (val > max)
        {
            $(this).val(max);
        }
        else if (val < min)
        {
            $(this).val(min);
        }
    }
    else
    {
        $(this).val(min);
    }
});