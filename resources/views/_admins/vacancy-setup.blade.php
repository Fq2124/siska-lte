@extends('layouts.mst')
@section('title', 'Vacancy List &ndash; '.env("APP_NAME").' Admins | SISKA &mdash; Sistem Informasi Karier')
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 id="panel_title">Vacancy
                            <small>List</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link" data-toggle="tooltip" title="Minimize" data-placement="left">
                                    <i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="btn_vacancy" data-toggle="tooltip" title="Create"
                                   data-placement="right"><i class="fa fa-plus"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div id="content1" class="x_content">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Vacancy</th>
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $no = 1; @endphp
                            @foreach($vacancies as $vacancy)
                                @php
                                    $agency = $vacancy->getAgency;
                                    $city = $vacancy->getCity->name;
                                    $salary = $vacancy->getSalary;
                                    $jobfunc = $vacancy->getJobFunction;
                                    $joblevel = $vacancy->GetJoblevel;
                                    $industry = $vacancy->getIndustry;
                                    $degrees = $vacancy->getDegree;
                                    $majors = $vacancy->getMajor;
                                @endphp
                                <tr>
                                    <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                    <td style="vertical-align: middle">
                                        <table>
                                            <tr>
                                                <td>
                                                    <a href="{{route('agency.profile',['id' => $vacancy->agency_id])}}"
                                                       target="_blank"
                                                       style="float: left;margin-right: .5em;margin-bottom: 0">
                                                        <img class="img-responsive" width="64" src="{{$agency->ava == ""
                                                        || $agency->ava == "agency.png" ? asset('images/agency.png') :
                                                        asset('storage/admins/ava/'.$agency->ava)}}">
                                                    </a>
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <a href="{{route('detail.vacancy',['id' =>
                                                                $vacancy->id])}}" target="_blank">
                                                                    <strong>{{$vacancy->judul}}</strong></a> &ndash;
                                                                <i class="fa fa-calendar"></i>&nbsp;{{\Carbon\Carbon::parse
                                                                ($vacancy->created_at)->format('j F Y')}} |
                                                                <i class="fa fa-clock"></i>&nbsp;{{$vacancy->updated_at
                                                                ->diffForHumans()}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><a href="{{route('agency.profile',['id' =>
                                                            $vacancy->agency_id])}}"
                                                                   target="_blank">{{$agency->company}}</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{substr($city, 0, 2)=="Ko" ? substr($city,5) :
                                                            substr($city,10)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span data-toggle="tooltip" data-placement="bottom"
                                                                      title="Recruitment Date" class="label label-info">
                                                                    <strong><i class="fa fa-users"></i>&ensp;
                                                                        {{$vacancy->recruitmentDate_start != "" &&
                                                                        $vacancy->recruitmentDate_end != "" ?
                                                                        \Carbon\Carbon::parse
                                                                        ($vacancy->recruitmentDate_start)
                                                                        ->format('j F Y').' - '.\Carbon\Carbon::parse
                                                                        ($vacancy->recruitmentDate_end)
                                                                        ->format('j F Y') : 'Unknown'}}
                                                                    </strong>
                                                                </span>&nbsp;|
                                                                <span data-toggle="tooltip" data-placement="bottom"
                                                                      title="Job Interview Date"
                                                                      class="label label-primary">
                                                                    <strong><i class="fa fa-user-tie"></i>&ensp;
                                                                        {{$vacancy->interview_date != "" ?
                                                                        \Carbon\Carbon::parse($vacancy->interview_date)
                                                                        ->format('l, j F Y') : 'Unknown'}}
                                                                    </strong>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <hr style="margin: .5em auto">
                                        <strong>Requirements</strong><br>{!! $vacancy->syarat !!}
                                        <hr style="margin: .5em auto">
                                        <strong>Responsibilities</strong><br>{!! $vacancy->tanggungjawab !!}
                                    </td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td><i class="fa fa-warehouse"></i>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>{{$jobfunc->name}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-industry"></i>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>{{$industry->name}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-level-up-alt"></i>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>{{$joblevel->name}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-money-bill-wave"></i>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>IDR {{$salary->name}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-graduation-cap"></i>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>{{$degrees->name}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-user-graduate"></i>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>{{$majors->name}}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-briefcase"></i>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>
                                                    At least {{$vacancy->pengalaman > 1 ?
                                                    $vacancy->pengalaman.' years' : $vacancy->pengalaman.' year'}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-paper-plane"></i></td>
                                                <td>&nbsp;</td>
                                                <td><strong>{{\App\Models\Applications::where('vacancy_id',$vacancy->id)
                                                ->where('isApply',true)->count()}}</strong> applicants
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="vertical-align: middle" align="center">
                                        <a class="btn btn-warning btn-sm" style="font-size: 16px" data-toggle="tooltip"
                                           title="Edit" onclick="editVacancy('{{$vacancy->id}}')">
                                            <i class="fa fa-edit"></i></a>
                                        <hr style="margin: 5px auto">
                                        <a href="{{route('delete.vacancies',['id'=>encrypt($vacancy->id)])}}"
                                           class="btn btn-danger btn-sm delete-data" style="font-size: 16px"
                                           data-toggle="tooltip"
                                           title="Delete" data-placement="bottom"><i class="fa fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="content2" class="x_content" style="display: none;">
                        <form method="post" action="{{route('create.vacancies')}}" id="form-vacancy">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" id="method">
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label for="agency_id">Agency <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user-tie"></i></span>
                                        <select id="agency_id" class="form-control selectpicker" name="agency_id"
                                                data-live-search="true" title="-- Select Agency --" required>
                                            @foreach(\App\Models\Agencies::all() as $agency)
                                                <option value="{{$agency->id}}">{{$agency->company}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-8">
                                    <label for="judul">Vacancy <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                        <input type="text" id="judul" class="form-control" maxlength="200" name="judul"
                                               placeholder="Vacancy name" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label for="pengalaman">Work Experience <span class="required">*</span></label>
                                    <div class="input-group" style="text-transform: none">
                                        <span class="input-group-addon">At least</span>
                                        <input class="form-control" type="text"
                                               onkeypress="return numberOnly(event, false)"
                                               maxlength="3" placeholder="0" id="pengalaman" name="pengalaman" required>
                                        <span class="input-group-addon">year(s)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label for="jobfunction_id">Job Function <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-warehouse"></i></span>
                                        <select id="jobfunction_id" class="form-control selectpicker"
                                                name="jobfunction_id"
                                                data-live-search="true" title="-- Select Job Function --" required>
                                            @foreach(\App\Models\JobFunction::all() as $function)
                                                <option value="{{$function->id}}">{{$function->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="industry_id">Industry <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-industry"></i></span>
                                        <select id="industry_id" class="form-control selectpicker" name="industry_id"
                                                data-live-search="true" title="-- Select Industry --" required>
                                            @foreach(\App\Models\Industries::all() as $industry)
                                                <option value="{{$industry->id}}">{{$industry->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label for="joblevel_id">Job Level <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-level-up-alt"></i></span>
                                        <select id="joblevel_id" class="form-control selectpicker" name="joblevel_id"
                                                data-live-search="true" title="-- Select Job Level --" required>
                                            @foreach(\App\Models\JobLevel::all() as $level)
                                                <option value="{{$level->id}}">{{$level->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="jobtype_id">Job Type <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user-clock"></i></span>
                                        <select id="jobtype_id" class="form-control selectpicker" name="jobtype_id"
                                                data-live-search="true" title="-- Select Job Type --" required>
                                            @foreach(\App\Models\JobType::all() as $type)
                                                <option value="{{$type->id}}">{{$type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label for="city_id">Location <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-map-marked"></i></span>
                                        <select class="form-control selectpicker" title="-- Select City --" id="city_id"
                                                data-live-search="true" name="city_id" required>
                                            @foreach(\App\Models\Provinces::all() as $province)
                                                <optgroup label="{{$province->name}}">
                                                    @foreach($province->getCity as $city)
                                                        <option value="{{$city->id}}">{{substr($city->name, 0, 2)=="Ko" ?
                                                    substr($city->name,4) : substr($city->name,9)}}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="salary_id">Salary <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><strong>Rp</strong></span>
                                        <select id="salary_id" class="form-control selectpicker" name="salary_id"
                                                data-live-search="true" title="-- Select Salary --" required>
                                            @foreach(\App\Models\Salaries::all() as $salary)
                                                <option value="{{$salary->id}}">{{$salary->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label for="degree_id">Education Degree <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-graduation-cap"></i></span>
                                        <select id="degree_id" class="form-control selectpicker" name="degree_id"
                                                data-live-search="true" title="-- Select Degree --" required>
                                            @foreach(\App\Models\Degrees::all() as $degree)
                                                <option value="{{$degree->id}}">{{$degree->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="major_id">Education Major <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user-graduate"></i></span>
                                        <select id="major_id" class="form-control selectpicker" name="major_id"
                                                data-live-search="true" title="-- Select Major --" required>
                                            @foreach(\App\Models\Majors::all() as $major)
                                                <option value="{{$major->id}}">{{$major->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label for="syarat">Requirements <span class="required">*</span></label>
                                    <textarea id="syarat" class="use-tinymce" name="syarat"></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <label for="tanggungjawab">Responsibilities <span class="required">*</span></label>
                                    <textarea id="tanggungjawab" class="use-tinymce" name="tanggungjawab"></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <button id="btn_submit" type="submit" class="btn btn-block btn-primary">Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        $(".btn_vacancy").on("click", function () {
            $("#content1").toggle(300);
            $("#content2").toggle(300);
            $(".btn_vacancy i").toggleClass('fa-plus fa-th-list');

            $(".btn_vacancy[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Create" ? "View" : "Create";
            }).tooltip('show');

            $("#panel_title").html(function (i, v) {
                return v === "Vacancy Setup<small>Form</small>" ? "Vacancy<small>List</small>" : "Vacancy Setup<small>Form</small>";
            });

            $('#agency_id').val('default').selectpicker("refresh");
            $('#judul').val('');
            $('#pengalaman').val('');
            $('#jobfunction_id').val('default').selectpicker("refresh");
            $('#industry_id').val('default').selectpicker("refresh");
            $('#joblevel_id').val('default').selectpicker("refresh");
            $('#jobtype_id').val('default').selectpicker("refresh");
            $('#city_id').val('default').selectpicker("refresh");
            $('#salary_id').val('default').selectpicker("refresh");
            $('#degree_id').val('default').selectpicker("refresh");
            $('#major_id').val('default').selectpicker("refresh");
            tinyMCE.get('syarat').setContent('');
            tinyMCE.get('tanggungjawab').setContent('');

            $("#method").val('');
            $("#form-vacancy").attr('action', '{{route('create.vacancies')}}');
            $("#btn_submit").html("<strong>SUBMIT</strong>");
        });

        function editVacancy(id) {
            $("#content1").toggle(300);
            $("#content2").toggle(300);
            $(".btn_agency i").toggleClass('fa-plus fa-th-list');

            $(".btn_agency[data-toggle=tooltip]").attr('data-original-title', function (i, v) {
                return v === "Create" ? "View" : "Create";
            }).tooltip('show');

            $("#panel_title").html(function (i, v) {
                return v === "Vacancy Edit<small>Form</small>" ? "Vacancy<small>List</small>" : "Vacancy Edit<small>Form</small>";
            });

            $.get("{{route('edit.vacancies',['id' => ''])}}/" + id, function (data) {
                $('#agency_id').val(data.agency_id).selectpicker("refresh");
                $('#judul').val(data.judul);
                $('#pengalaman').val(data.pengalaman);
                $('#jobfunction_id').val(data.jobfunction_id).selectpicker("refresh");
                $('#industry_id').val(data.industry_id).selectpicker("refresh");
                $('#joblevel_id').val(data.joblevel_id).selectpicker("refresh");
                $('#jobtype_id').val(data.jobtype_id).selectpicker("refresh");
                $('#city_id').val(data.city_id).selectpicker("refresh");
                $('#salary_id').val(data.salary_id).selectpicker("refresh");
                $('#degree_id').val(data.degree_id).selectpicker("refresh");
                $('#major_id').val(data.major_id).selectpicker("refresh");
                tinyMCE.get('syarat').setContent(data.syarat);
                tinyMCE.get('tanggungjawab').setContent(data.tanggungjawab);
            });

            $("#method").val('PUT');
            $("#form-vacancy").attr('action', '{{url('admin/vacancies')}}/' + id + '/update');
            $("#btn_submit").html("<strong>SAVE CHANGES</strong>");
        }

        $("#form-vacancy").on("submit", function (e) {
            e.preventDefault();
            if (tinyMCE.get('syarat').getContent() == "") {
                swal({
                    title: 'ATTENTION!',
                    text: 'Requirements field can\'t be null!',
                    type: 'warning',
                    timer: '3500'
                });

            } else if (tinyMCE.get('tanggungjawab').getContent() == "") {
                swal({
                    title: 'ATTENTION!',
                    text: 'Responsibilities field can\'t be null!',
                    type: 'warning',
                    timer: '3500'
                });

            } else {
                $('#form-vacancy')[0].submit();
            }
        })
    </script>
@endpush