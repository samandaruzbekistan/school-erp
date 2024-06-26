@extends('admin.header_footer')

@push('css')
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <!-- Add this inside the <head> section of your HTML document -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
            integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
@section('students')
    active
@endsection
@section('section')
    <main class="content p-4">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-3 col-xl-2">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Talabgor haqida</h5>
                        </div>

                        <div class="list-group list-group-flush" role="tablist">
                            <a class="list-group-item list-group-item-action active" data-bs-toggle="list"
                               href="#account" role="tab" aria-selected="true">
                                Talabgor
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#payments"
                               role="tab" aria-selected="false" tabindex="-1">
                                Jarayonlar tarixi
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#sms"
                               role="tab" aria-selected="false" tabindex="-1">
                                Sinfga qabul qilish
                            </a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#sms"
                               role="tab" aria-selected="false" tabindex="-1">
                                Maktabdan ketish
                            </a>
                            <a class="list-group-item list-group-item-action text-danger" data-bs-toggle="list" href="#"
                               role="tab" aria-selected="false" tabindex="-1">
                                Delete account
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-xl-10">
                    <div class="tab-content">
                        <div class="tab-pane fade active show " id="account" role="tabpanel">
                            <div class="row">
                                <div class="card col-md-3 col-xl-4 me-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Talabgor malumotlari</h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <img src="{{ asset('img/users/'.$student->photo) }}" width="130px" alt="">
                                        <h2 class=" text-dark mb-0">{{ $student->name }}</h2>
                                        <div class="text-muted mb-2">O'quvchi</div>

                                    </div>
                                    <hr class="my-0">
                                    <div class="card-body">
                                        <h5 class="h6 card-title">Sinf</h5>
                                        <a href="#" class="badge bg-primary me-1 my-1">@if($student->class_id != null)
                                                {{ $student->class->name }}
                                            @endif</a>
                                    </div>
                                    <hr class="my-0">
                                    <div class="card-body">
                                        <h5 class="h6 card-title">About</h5>
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-1">
                                                <i class="align-middle me-1" data-feather="user"></i>F.I.SH: <a
                                                    href="#">{{ $student->name }}</a>
                                            </li>
                                            <li class="mb-1">
                                                <i class="align-middle me-1" data-feather="calendar"></i>Tug'ilgan sana:
                                                <a href="#">{{ $student->birthday }}</a></li>
                                            <li class="mb-1">
                                                <i class="align-middle me-1" data-feather="file"></i>Guvoxnoma:
                                                <a href="#">{{ $student->passport }}</a></li>
                                            <li class="mb-1">
                                                <i class="align-middle me-1" data-feather="map-pin"></i>Manzil:
                                                <a href="#">{{ $student->region->name }} {{ $student->district->name }} {{ $student->quarter->name }} {{ $student->address }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <hr class="my-0">
                                </div>
                                <div class="card col-md-6 col-xl-5 d-inline-block">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Ota onasi haqida ma'lumot</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-1">
                                                <i class="align-middle me-1" data-feather="user"></i>Otasi: <a
                                                    href="#">{{ $student->father_name }}</a>
                                            </li>
                                            <li class="mb-1">
                                                <i class="align-middle me-1" data-feather="user"></i>Onasi: <a
                                                    href="#">{{ $student->mother_name }}</a>
                                            </li>
                                            <li class="mb-1">
                                                <i class="align-middle me-1" data-feather="file"></i>Ota-ona pasport: <a
                                                    href="#">{{ $student->parents_passport }}</a>
                                            </li>
                                            <li class="mb-1">
                                                <i class="align-middle me-1" data-feather="phone"></i>Otasi telefoni: <a
                                                    href="#">{{ $student->parents_number1 }}</a>
                                            </li>
                                            <li class="mb-1">
                                                <i class="align-middle me-1" data-feather="phone"></i>Onasi telefoni: <a
                                                    href="#">{{ $student->parents_number2 }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="sms" role="tabpanel">
                            <div class="card col-12">
                                <div class="card-header">
                                    <h5 class="card-title mb-0 col"><b class="text-primary">{{ $student->name }}</b> ni
                                        sinfga qabul qilish</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('action') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $student->id }}">
                                        <input type="hidden" name="type_id" value="1">
                                        <div class="row mb-3">
                                            <div class="mb-3 col-sm-4 col-4">
                                                <label for="class_id" class="form-label">Sinfni tanlang</label> <sup
                                                    class="text-danger">*</sup>
                                                <select id="class_id" required="" class="form-select" name="class_id">
                                                    <option disabled="" selected="" hidden>Tanlang</option>
                                                    @foreach($classes as $cl)
                                                        <option value="{{ $cl->id }}">{{ $cl->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label">Buyruq sana <span class="text-danger">*</span></label>
                                                <input name="date" required type="date" class="form-control"
                                                       placeholder="">
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label">Buyruq PDF<span
                                                        class="text-danger">*</span></label>
                                                <input name="document" required type="file" class="form-control"
                                                       placeholder="">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="mb-3 col-sm-4 col-4">
                                                <label for="class_id" class="form-label">Buyruq raqami</label> <sup
                                                    class="text-danger">*</sup>
                                                <input name="document_number" required type="text" class="form-control"
                                                       placeholder="">
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label">Kelgan maktab <span
                                                        class="text-danger">*</span></label>
                                                <input name="school" required type="text" class="form-control"
                                                       placeholder="">
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label">Kelgan maktab manzili <span
                                                        class="text-danger">*</span></label>
                                                <input name="school_address" required type="text" class="form-control"
                                                       placeholder="">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="mb-3 col-sm-4 col-4">
                                                <label for="class_id" class="form-label">Kelgan davlati</label> <sup
                                                    class="text-danger">*</sup>
                                                <input name="country" required type="text" class="form-control"
                                                       placeholder="">
                                            </div>
                                            <div class="col-lg-8">
                                                <label class="form-label">Izox <span
                                                        class="text-danger">*</span></label>
                                                <input name="comment" required type="text" class="form-control"
                                                       placeholder="">
                                            </div>
                                        </div>
                                        <div class=" text-end">
                                            <button type="submit" class="btn btn-success">Xabar yuborish</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="payments" role="tabpanel">
                <div class="card col-12">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <h5 class="card-title mb-0 col">Amallar tarixi</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Jarayon</th>
                                <th>Sinf</th>
                                <th>Buyruq raqami</th>
                                <th>Sana</th>
                                <th>Kelgan maktabi</th>
                                <th>Kelgan maktab manzili</th>
                                <th>Izox</th>
                                <th>Buyruq</th>
                            </tr>
                            </thead>
                            <tbody class="old-data">
                            @foreach($actions as $action)
                                <th class="text-success">{{ $action->actionType->name }}</th>
                                <th>{{ $action->class->name }}</th>
                                <th>{{ $action->document_number }}</th>
                                <th>{{ $action->date }}</th>
                                <th>{{ $action->school }}</th>
                                <th>{{ $action->school_address }}</th>
                                <th>{{ $action->comment }}</th>
                                <th><a href="{{ route('getDownload', ['doc' => $action->document]) }}" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-download align-middle ">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="7 10 12 15 17 10"></polyline>
                                            <line x1="12" y1="15" x2="12" y2="3"></line>
                                        </svg>
                                    </a></th>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-4 d-none">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Faktura</h5>
                    </div>
                    <div class="card-body border m-1" id="printContent">
                        <div class="row ps-5 pe-5">
                            <img src="{{ asset('logo.png') }}" class="img-fluid">
                        </div>
                        <h1 class="text-center "><b>To'landi</b></h1>
                        <div class="row h4 justify-content-between border-bottom">
                            <b class="col mb-0">Sana:</b>
                            <p class="col mb-0 text-end" id="date"></p>
                        </div>
                        <div class="row h4 justify-content-between">
                            <b class="col-3 mb-0">F.I.SH:</b>
                            <p class="col mb-0 text-end" id="name">{{ $student->name }}</p>
                        </div>
                        <div class="row h4 justify-content-between">
                            <b class="col-3 mb-0">Guruh:</b>
                            <p class="col mb-0 text-end" id="subject"></p>
                        </div>
                        <div class="row h4 justify-content-between">
                            <b class="col-3 mb-0">Oy:</b>
                            <p class="col mb-0 text-end" id="month"></p>
                        </div>
                        <div class="row h2 text-center border-bottom border-top">
                            <b class="col mb-0" id="amount"> so'm</b>
                        </div>
                        <div id="qrcode-2" class="text-center d-flex justify-content-center">

                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <button type="button" id="download-button" class="btn btn-info"><i class="align-middle"
                                                                                           data-feather="download"></i>
                            Yuklab olish
                        </button>
                        <button type="button" id="printButton" onClick="printdiv('printContent');"
                                class="btn btn-success"><i class="align-middle" data-feather="printer"></i> Chop etish
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


@section('js')
    <script>


        (function (factory) {
            if (typeof define === 'function' && define.amd) {
                define(['moment'], factory); // AMD
            } else if (typeof exports === 'object') {
                module.exports = factory(require('../moment')); // Node
            } else {
                factory(window.moment); // Browser global
            }
        }(function (moment) {
            return moment.defineLocale('uz', {
                months: 'Yanvar_Fevral_Mart_Aprel_May_Iyun_Iyul_Avgust_Sentabr_Oktabr_Noyabr_Dekabr'.split('_'),
                monthsShort: 'янв_фев_мар_апр_май_июн_июл_авг_сен_окт_ноя_дек'.split('_'),
                weekdays: 'Якшанба_Душанба_Сешанба_Чоршанба_Пайшанба_Жума_Шанба'.split('_'),
                weekdaysShort: 'Якш_Душ_Сеш_Чор_Пай_Жум_Шан'.split('_'),
                weekdaysMin: 'Як_Ду_Се_Чо_Па_Жу_Ша'.split('_'),
                longDateFormat: {
                    LT: 'HH:mm',
                    L: 'DD/MM/YYYY',
                    LL: 'D MMMM YYYY',
                    LLL: 'D MMMM YYYY LT',
                    LLLL: 'D MMMM YYYY, dddd LT'
                },
                calendar: {
                    sameDay: '[Бугун соат] LT [да]',
                    nextDay: '[Эртага] LT [да]',
                    nextWeek: 'dddd [куни соат] LT [да]',
                    lastDay: '[Кеча соат] LT [да]',
                    lastWeek: '[Утган] dddd [куни соат] LT [да]',
                    sameElse: 'L'
                },
                relativeTime: {
                    future: 'Якин %s ичида',
                    past: 'Бир неча %s олдин',
                    s: 'фурсат',
                    m: 'бир дакика',
                    mm: '%d дакика',
                    h: 'бир соат',
                    hh: '%d соат',
                    d: 'бир кун',
                    dd: '%d кун',
                    M: 'бир ой',
                    MM: '%d ой',
                    y: 'бир йил',
                    yy: '%d йил'
                },
                week: {
                    dow: 1, // Monday is the first day of the week.
                    doy: 7  // The week that contains Jan 4th is the first week of the year.
                }
            });
        }));

        @if(session('updated') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'O\'quvchi malumotlari yangilandi',
            duration: 5000,
            dismissible: true,
            position: {
                x: 'center',
                y: 'top'
            },
        });
        @endif

        @if($errors->any())
        const notyf = new Notyf();

        @foreach ($errors->all() as $error)
        notyf.error({
            message: '{{ $error }}',
            duration: 5000,
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
            message: 'Amal bajarildi!',
            duration: 10000,
            dismissible: true,
            position: {
                x: 'right',
                y: 'top'
            },
        });
        @endif

        @if(session('sms_error') == 1)
        const notyf = new Notyf();

        notyf.error({
            message: 'Xatolik. Xabar yuborilmadi',
            duration: 5000,
            dismissible: true,
            position: {
                x: 'center',
                y: 'top'
            },
        });
        @endif

        @if(session('sms_send') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'Xabar yuborildi',
            duration: 5000,
            dismissible: true,
            position: {
                x: 'center',
                y: 'top'
            },
        });
        @endif

        function printdiv(elem) {
            var header_str = '<html><head><title>' + document.title + '</title></head><body>';
            var footer_str = '</body></html>';
            var new_str = document.getElementById(elem).innerHTML;
            var old_str = document.body.innerHTML;
            document.body.innerHTML = header_str + new_str + footer_str;
            window.print();
            document.body.innerHTML = old_str;
            return false;
        }

        //  pdf download
        const button = document.getElementById('download-button');

        function generatePDF() {
            // Choose the element that your content will be rendered to.
            const element = document.getElementById('printContent');
            // Choose the element and save the PDF for your user.
            html2pdf().from(element).save();
        }

        button.addEventListener('click', generatePDF);


        // generate qr code
        var qrcode = new QRCode(document.getElementById("qrcode-2"), {
            text: "https://markaz.ideal-study.uz/receip/13213",
            width: 200,
            height: 200,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });


    </script>
@endsection
