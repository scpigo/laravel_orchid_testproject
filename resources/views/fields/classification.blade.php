@component($typeForm, get_defined_vars())
    <div>
        <input type="email" data-name="{{$name}}" class="form-control" {{ $attributes }} list="classification-{{$name}}" multiple="multiple">
    </div>

    <datalist data-list="{{$name}}" id="classification-{{$name}}">
    </datalist>
@endcomponent

<script src="{{ asset('jquery.js') }}"></script>
<script>
    $('*[data-name="{{$name}}"]').focusin ( function() { $(this).attr("type","email"); });
    $('*[data-name="{{$name}}"]').focusout( function() { $(this).attr("type","textbox"); });
    $(':submit').click( function() { $('*[data-name="{{$name}}"]').attr("type","textbox"); });

    $('*[data-name="{{$name}}"]').on('keyup', (event) => {
        var query = $('*[data-name="{{$name}}"]').val().split(',').slice(-1);
        query = $.trim(query);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        $.ajax({
            type: "POST",
            url: "/ajax/classification",
            data: ({
                query: query
            }),
            success: function(data)
            {
                $('*[data-list="{{$name}}"]').empty();

                for (var i in data) {
                    $("<option/>").html(data[i]).appendTo('*[data-list="{{$name}}"]');
                }
            }
        });
    });
</script>
