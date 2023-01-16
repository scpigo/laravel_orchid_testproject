@component($typeForm, get_defined_vars())
    <div>
        <input data-name="{{$name}}" class="form-control" {{ $attributes }} list="adress-{{$name}}">
    </div>

    <datalist data-list="{{$name}}" id="adress-{{$name}}">
    </datalist>
@endcomponent

<script src="{{ asset('jquery.js') }}"></script>
<script>
    var url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address";
    var token = "0a1381c626555b7c3c0c667d8f6462be33116f73";

    $('*[data-name="{{$name}}"]').on('keyup', (event) => {
        var query = $('*[data-name="{{$name}}"]').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        $.ajax({
            type: "POST",
            url: "/ajax/dadata",
            data: ({
                query: query
            }),
            success: function(data){
                $('*[data-list="{{$name}}"]').empty();

                for (var i in data) {
                    $("<option/>").html(data[i]["value"]).appendTo('*[data-list="{{$name}}"]');
                }
            }
        });
    });
</script>
