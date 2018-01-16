<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"  style="height:100%">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style type="text/css">
        button[type=button]{
            cursor: pointer;
        }
    </style>
</head>
<body style="height:100%">
    <div class="container" style="height:100%" id="app">
        @yield('content')
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/numeral.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            $('body').on('blur', '.numeric', function () {
                var $this = $(this),
                    value = $this.val(),
                    newValue = numeral(value).format('00');

                $this.val(newValue)
            });

            $('body').on('focus', '.numeric', function () {
                var $this = $(this),
                    value = $this.val(),
                    newValue = numeral().unformat(value);

                $this.val(newValue);
                $this.select();
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('tr[data-role=form] button[data-method]').click(function () {
                var $this = $(this),
                    tr = $this.closest('tr'),
                    originalContent = $this.html(),
                    method = $this.data('method'),
                    url = $this.data('url'),
                    payload = {
                        _method: method,
                    };


                tr.find('.field').each(function () {
                    payload[$(this).data('name')] = $(this).val();
                })

                console.log('attempting xhr to %s with method %s', url, method);
                $this.html('<i class="fa fa-spin fa-spinner"></i>').attr('disabled', 'disabled');

                $.ajax({
                    method: 'POST',
                    url: url,
                    data: payload
                }).done(function (res) {
                    window.location.reload();
                }).fail(function () {
                    window.alert('A intern')
                }).always(function () {
                    $this.removeAttr('disabled').html(originalContent);
                })

            })

            function toggleHidden() {
                $('.edit-button, .save-button, .cancel-button, tr[data-role=form], tr[data-role=display]').toggleClass('d-none');
            }
            $('.edit-button, .cancel-button').click(toggleHidden);

            $('form.ajax').submit(function (e) {

                e.preventDefault();

                var $this = $(this),
                submitBtn = $this.find('[type=submit]'),
                formData = new FormData($this[0]);

                $this.find('.has-error .help-block').remove();
                $this.find('.has-error').removeClass('has-error')

                submitBtn.attr('disabled', 'disabled').html('<i class="fa fa-spin fa-spinner"></i> Saving...')

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        if(res.hasOwnProperty('next_url')){
                            window.location.href = res.next_url;
                        }else if($this.data('next-url')){
                            window.location.href = $this.data('next-url');
                        }else{
                            window.location.href = window.location;
                        }
                    },
                    error: function (err) {
                        if(err.status == 422){
                            var errors = err.responseJSON['errors'];
                            for(var field in errors){
                                var fieldName = field;
                                if(field.indexOf('.') !== -1){
                                var parts = field.split('.'),
                                name = parts.splice(0, 1),
                                newField = name+'['+parts.join('][')+']';
                                fieldName = newField;
                            }
                            console.log(fieldName)
                            var input = $("[name=\""+fieldName+"\"]");
                            input.closest('.form-group').addClass('has-error').append('<span class="help-block">'+errors[field][0]+'</span>');
                        }
                        }else{
                            window.alert('Internal server error!');
                        }
                    },
                    complete: function () {
                        submitBtn.removeAttr('disabled').text('Save');
                    }
                })
            })

            $('.delete-button').click(function () {
                if(!confirm('Are you sure? This action cannot be undone.')) return;

                var $this = $(this);

                $this.attr('disabled', 'disabled').html('<i class="fa fa-spin fa-spinner"></i>')
                console.log($this.data('id'))

                $.ajax({
                    url: $('#entries').data('delete-url').replace('idx', $this.data('id')),
                    method: 'DELETE',
                    success: function () {
                        window.location.href = window.location;
                    },
                    error: function() {
                        window.alert('Internal server error!');
                    },
                    complete: function (argument) {
                        $this.html('<i class="fa fa-trash"></i>')
                    }
                })
            })

            $('.actual-weight').blur(function () {
                var $this = $(this),
                    value = parseFloat($this.val() || 0),
                    optimal = parseFloat($this.data('optimal-weight') || 0),
                    result = value - optimal;
                $this.closest('td').siblings('.result:first').html(function () {
                    var className = result < 0 ? 'text-danger' : 'text-success';
                    return '<strong class="text-right d-block '+className+'">'+result+'</span>';
                });
            }).trigger('blur');
        })
    </script>
    @stack('js')
</body>
</html>
