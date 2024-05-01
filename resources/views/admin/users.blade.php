@extends('admin.header_footer')

@push('css')
    <style>
        .pagination{height:36px;margin:0;padding: 0;}
        .pager,.pagination ul{margin-left:0;*zoom:1}
        .pagination ul{padding:0;display:inline-block;*display:inline;margin-bottom:0;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 2px rgba(0,0,0,.05);-moz-box-shadow:0 1px 2px rgba(0,0,0,.05);box-shadow:0 1px 2px rgba(0,0,0,.05)}
        .pagination li{display:inline}
        .pagination a{float:left;padding:0 12px;line-height:30px;text-decoration:none;border:1px solid #ddd;border-left-width:0}
        .pagination .active a,.pagination a:hover{background-color:#f5f5f5;color:#94999E}
        .pagination .active a{color:#94999E;cursor:default}
        .pagination .disabled a,.pagination .disabled a:hover,.pagination .disabled span{color:#94999E;background-color:transparent;cursor:default}
        .pagination li:first-child a,.pagination li:first-child span{border-left-width:1px;-webkit-border-radius:3px 0 0 3px;-moz-border-radius:3px 0 0 3px;border-radius:3px 0 0 3px}
        .pagination li:last-child a{-webkit-border-radius:0 3px 3px 0;-moz-border-radius:0 3px 3px 0;border-radius:0 3px 3px 0}
        .pagination-centered{text-align:center}
        .pagination-right{text-align:right}
        .pager{margin-bottom:18px;text-align:center}
        .pager:after,.pager:before{display:table;content:""}
        .pager li{display:inline}
        .pager a{display:inline-block;padding:5px 12px;background-color:#fff;border:1px solid #ddd;-webkit-border-radius:15px;-moz-border-radius:15px;border-radius:15px}
        .pager a:hover{text-decoration:none;background-color:#f5f5f5}
        .pager .next a{float:right}
        .pager .previous a{float:left}
        .pager .disabled a,.pager .disabled a:hover{color:#999;background-color:#fff;cursor:default}
        .pagination .prev.disabled span{float:left;padding:0 12px;line-height:30px;text-decoration:none;border:1px solid #ddd;border-left-width:0}
        .pagination .next.disabled span{float:left;padding:0 12px;line-height:30px;text-decoration:none;border:1px solid #ddd;border-left-width:0}
        .pagination li.active, .pagination li.disabled {
            float:left;padding:0 12px;line-height:30px;text-decoration:none;border:1px solid #ddd;border-left-width:0
        }
        .pagination li.active {
            background: #364E63;
            color: #fff;
        }
        .pagination li:first-child {
            border-left-width: 1px;
        }
    </style>
@endpush

@section('students')
    active
@endsection
@section('section')

    <main class="content teachers">
        <div class="container-fluid p-0">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0"><span class="text-danger">{{ $current_class->name }}</span> sinf o'quvchilari</h5>
                    </div>
                    <table class="table table-striped table-hover table-responsive">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>F.I.Sh</th>
                            <th class="d-none d-sm-table-cell">Telefon</th>
                            <th>Sinf</th>
                        </tr>
                        </thead>
                        <tbody id="tbody">
                        @foreach($users as $id => $student)
                            <tr>
                                <td>
                                    {{ $id+1 }}
                                </td>
                                <td><a href="{{ route('user', ['id' => $student->id]) }}">{{ $student->name }}</a></td>
                                <td class="d-none d-sm-table-cell">{{ $student->phone }}</td>
                                <td class="d-none d-sm-table-cell">{{ $student->class->name }}</td>
                                {{--                                <td style="cursor: pointer"><a href="{{ route('cashier.add_to_subject') }}/{{ $student->id }}" class="btn btn-success add-student"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus align-middle"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg></a></td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection


@section('js')
    <script>
        $(document).on('change', '#region', function() {
            let selectedId = $(this).val();
            let firstOption = $('#district option:first');

            $("#district").empty();
            $('#district').append('<option value="" disabled selected hidden>Tanlash...</option>');
            $.ajax({
                url: '{{ route('cashier.district.regionID') }}/' + selectedId,
                method: 'GET',
                success: function(data) {
                    $("#district").empty();
                    $('#district').append('<option value="" disabled selected hidden>Tanlash...</option>');
                    $.each(data, function(key, value){
                        $('#district').append('<option value="' + value.id+ '">' + value.name + '</option>');
                    });
                }
            });
        });

        $(document).on('change', '#district', function() {
            let selectedId = $(this).val();
            let firstOption = $('#quarter option:first');

            $("#quarter").empty();
            $('#quarter').append('<option value="" disabled selected hidden>Tanlash...</option>');
            $.ajax({
                url: '{{ route('cashier.quarter.districtID') }}/' + selectedId,
                method: 'GET',
                success: function(data) {
                    $("#quarter").empty();
                    $('#quarter').append('<option value="" disabled selected hidden>Tanlash...</option>');
                    $.each(data, function(key, value){
                        $('#quarter').append('<option value="' + value.id+ '">' + value.name + '</option>');
                    });
                }
            });
        });


        $(document).on('click', '.new-student', function () {
            $('.add-student').show();
            $('.teachers').hide();
        });

        function formatPaymentAmount(input) {
            // Remove existing non-numeric characters
            const numericValue = input.value.replace(/\D/g, '');

            // Add thousand separators
            const formattedValue = numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');

            // Update the input field with the formatted value
            input.value = formattedValue;
        }

        @if($errors->any())
        const notyf = new Notyf();

        @foreach ($errors->all() as $error)
        notyf.error({
            message: '{{ $error }}',
            duration: 10000,
            dismissible: true,
            position: {
                x: 'center',
                y: 'top'
            },
        });
        @endforeach

        @endif


        @if(session('success') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'Yangi o\'quvchi qo\'shildi!',
            duration: 5000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif

        @if(session('username_error') == 1)
        const notyf = new Notyf();

        notyf.error({
            message: 'Xatolik! Bunday ism mavjud',
            duration: 5000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif

        $(".add").on("click", function() {
            $('.forma').show();
            $('.teachers').hide();
        });

        $(".cancel").on("click", function() {
            event.stopPropagation();
            $('.forma').hide();
            $('.teachers').show();
        });

        $(".cancel1").on("click", function() {
            event.stopPropagation();
            $('.add-student').hide();
            $('.teachers').show();
        });


        $(document).ready(function() {
            $('#is_uzbekistan').change(function() {
                if(this.checked) {
                    $('#quarter').hide();
                    $('#mahalla-input').show();
                }
                else{
                    $('#quarter').show();
                    $('#mahalla-input').hide();
                }
            });
        });
    </script>
@endsection
