@extends('layout.main')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


<style>
    body {
        background-color: #f0f2f5;
        font-size: 13px;
        color: #4e5154;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    /* Summary Cards */
    .card-summary {
        border: 1px solid #e4e9f0;
        border-radius: 4px;
        padding: 10px;
        background: #fff;
        height: 100%;
    }

    .summary-count {
        font-weight: bold;
        font-size: 16px;
        margin-right: 5px;
    }

    .summary-label {
        color: #6a6c6f;
    }

    .summary-subtext {
        color: #83888d;
        font-size: 11px;
        display: block;
    }

    /* Table Styling */
    .table-tasks thead th {
        background-color: #f9fafb;
        border-bottom: 1px solid #ebf1f2;
        color: #333;
        font-weight: 600;
        border-top: none;
    }

    .table-tasks td {
        vertical-align: middle;
        padding: 12px 8px;
        border-top: 1px solid #f0f0f0;
    }

    /* Status Dropdown Button */
    .status-dropdown-btn {
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 11px;
        background: #fff;
        border: 1px solid #b8d3ff;
        color: #2d62d3;
        cursor: pointer;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
    }

    .status-dropdown-btn:after {
        content: '\f078';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        margin-left: 8px;
        font-size: 8px;
    }

    /* Priority Links */
    .priority-dropdown-link {
        color: #00aeff;
        text-decoration: none !important;
        font-size: 13px;
    }

    .priority-dropdown-link:after {
        content: '\f078';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        margin-left: 5px;
        font-size: 9px;
        display: inline-block;
    }

    /* Dropdown Menu Styling */
    .dropdown-menu {
        border-radius: 8px;
        border: 1px solid #ddd;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 5px 0;
    }

    .dropdown-item {
        font-size: 13px;
        padding: 8px 20px;
        color: #333;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 1px solid #ddd;
        background: #eee;
    }

    /* Modal Customizations */
    .modal-content {
        border-radius: 8px;
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, .1);
    }

    .modal-header {
        border-bottom: 1px solid #f0f0f0;
        padding: 15px 20px;
    }

    .modal-title {
        font-size: 16px;
        font-weight: 700;
        color: #4e5154;
    }

    .form-control {
        border: 1px solid #d1d9e1;
        border-radius: 4px;
        font-size: 13px;
        color: #4e5154;
    }

    .input-group-text {
        background-color: #fff;
        border-color: #d1d9e1;
        color: #83888d;
    }

    /* Pagination Styling */
    .page-item.active .page-link {
        background-color: #333;
        border-color: #333;
    }

    .page-link {
        color: #333;
    }

    .is-invalid {
        border: 1px solid red;
    }
    .editModalWrap { border-radius: 16px; overflow: hidden; }
    .editModalHeader{
        background: linear-gradient(135deg, #111827, #0f766e);
        color: #fff;
    }
    .editModalTitle{ font-weight: 800; font-size: 18px; letter-spacing: .2px; }
    .editModalSub{ font-size: 12px; opacity: .85; margin-top: 2px; }

    .editLeftPanel{
        background: #0b1220;
        color: #e5e7eb;
        min-height: 100%;
    }
    .editRightPanel{
        background: #ffffff;
    }

    .miniCard{
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 14px;
        padding: 14px;
    }
    .miniLabel{ font-size: 11px; opacity: .75; margin-bottom: 4px; }
    .miniValue{ font-size: 14px; font-weight: 700; color: #fff; }
    .miniHint{
        margin-top: 14px;
        font-size: 12px;
        opacity: .8;
        line-height: 1.5;
    }

    .niceInput{
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: .55rem .75rem;
    }
    .niceInput:focus{
        border-color: #0f766e;
        box-shadow: 0 0 0 .15rem rgba(15,118,110,.15);
    }
    .niceTextarea{
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        padding: .75rem;
    }
    .formRow2{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    .formRow3{
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 12px;
    }
    @media (max-width: 992px){
        .formRow2, .formRow3 { grid-template-columns: 1fr; }
    }
    .editModalFooter{
        background: #f9fafb;
    }

</style>
@if(session()->has('not_permitted'))
<div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
        aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
@if(session()->has('message'))
<div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
        aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
@endif
@php
if($general_setting->theme == 'default.css'){
$color = '#733686';
$color_rgba = 'rgba(115, 54, 134, 0.8)';
}
elseif($general_setting->theme == 'green.css'){
$color = '#2ecc71';
$color_rgba = 'rgba(46, 204, 113, 0.8)';
}
elseif($general_setting->theme == 'blue.css'){
$color = '#3498db';
$color_rgba = 'rgba(52, 152, 219, 0.8)';
}
elseif($general_setting->theme == 'dark.css'){
$color = '#34495e';
$color_rgba = 'rgba(52, 73, 94, 0.8)';
}
@endphp
<div class="row">
    <div class="container-fluid">
        <div class="col-md-12 ">
            <div class="brand-text float-left mt-4">
                <h3>{{trans('file.welcome')}} <span>{{Auth::user()->role_id}}</span> </h3>
            </div>
        </div>
    </div>
</div>


<!-- Counts Section -->
<section class="dashboard-counts">
    <div class="container-fluid">


        <div class="container-fluid py-4">
            <div class="row mb-4">
                <div class="col">
                    <h4 class="mb-0 font-weight-bold" style="color:#4e5154;">
                        Tasks
                        <small class="text-primary ml-2" style="font-size: 12px; cursor: pointer; font-weight: 400;">
                            Tasks Overview →
                        </small>
                    </h4>
                </div>
            </div>

            <div class="row mb-4 no-gutters">
                <div class="col px-1">
                    <div class="card-summary card_1 p-4 ">
                        <span class="summary-count card_11 ">0</span>
                        <span class="summary-label">In Progress</span>
                        <!-- <span class="summary-subtext">My Tasks: 8</span> -->
                    </div>
                </div>
                <div class="col px-1">
                    <div class="card-summary card_2 p-4  ">
                        <span class="summary-count text-primary card_21">0</span>
                        <span class="summary-label text-primary">Not Started</span>
                        <!-- <span class="summary-subtext">My Tasks: 4</span> -->
                    </div>
                </div>
                <div class="col px-1">
                    <div class="card-summary card_3 p-4  ">
                        <span class="summary-count card_31">0</span>
                        <span class="summary-label">Testing</span>
                        <!-- <span class="summary-subtext">My Tasks: 2</span> -->
                    </div>
                </div>
                <div class="col px-1">
                    <div class="card-summary card_4 p-4  ">
                        <span class="summary-count card_41">0</span>
                        <span class="summary-label">Awaiting Feedback</span>
                        <!-- <span class="summary-subtext">My Tasks: 5</span> -->
                    </div>
                </div>
                <div class="col px-1">
                    <div class="card-summary card_5 p-4  ">
                        <span class="summary-count card_51">0</span>
                        <span class="summary-label">Complete</span>
                        <!-- <span class="summary-subtext">My Tasks: 11</span> -->
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between mb-3">
                        @if(Auth::user()->role_id == 1)
                            <div>
                                <button class="btn btn-dark btn-sm px-3" data-toggle="modal" data-target="#addTaskModal">
                                    <i class="fas fa-plus mr-1"></i>
                                    New Task
                                </button>
                            </div>
                        @endif
                        <div class="d-flex">
                            <div class="input-group input-group-sm mr-2" style="width: 200px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-right-0">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" id="taskSearch" class="form-control border-left-0" placeholder="Search by name or ID...">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-tasks" id="taskTable">
                            <thead>
                                <tr>
                                    <th width="40">#</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Start Date</th>
                                    <th>Due Date</th>
                                    <th>Assigned to</th>
                                    <th>Priority</th>
                                </tr>
                            </thead>
                            <tbody class="data_assigning"></tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3 px-3">
                        <div id="tableInfo" class="text-muted small"></div>
                        <nav>
                            <ul class="pagination pagination-sm mb-0" id="paginationControls"></ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>


            <!-- View and Edit Task -->
            <div class="modal fade" id="view_and_edit_task" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                    <div class="modal-content border-0 editModalWrap">
                        <div class="modal-header border-0 px-4 py-3 editModalHeader">
                            <div>
                                <div class="editModalTitle" id="view_and_edit_taskTitle" ></div>
                                <div class="editModalSub" id="view_and_edit_taskDesc" ></div>
                            </div>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body p-0 modalBodyEditTaskData "></div>

                        @if(Auth::user()->role_id == 1)
                            <div class="modal-footer border-0 px-4 py-3 editModalFooter">
                                <button type="button" class="btn btn-light btn-sm px-4" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-dark btn-sm px-4 update_task_btn">Update Task</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- View and Edit Task -->




        <!-- Add New Task Modal -->
        <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" style="font-size: 16px; color: #4e5154;">
                            Add New Task
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="taskForm">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <!-- <div>
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="publicTask">
                                            <label class="custom-control-label" for="publicTask">Public</label>
                                        </div>
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="billableTask" checked>
                                            <label class="custom-control-label" for="billableTask">Billable</label>
                                        </div>
                                    </div>
                                    <a href="#" class="text-primary small font-weight-bold">Attach Files</a> -->
                            </div>

                            <hr class="mt-0">

                            <div class="form-group">
                                <label class="font-weight-bold small">
                                    <span class="text-danger">*</span>
                                    Subject
                                </label>
                                <input type="text" class="form-control form-control-sm border-primary tasks_title " style="border-width: 1.5px;">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold small">
                                            <span class="text-danger">*</span>
                                            Short Details
                                        </label>
                                        <input type="text" class="form-control form-control-sm border-primary short_details " style="border-width: 1.5px;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold small">
                                            <span class="text-danger">*</span>
                                            Note
                                        </label>
                                        <input type="text" class="form-control form-control-sm border-primary tasks_notes " style="border-width: 1.5px;">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold small">
                                            <span class="text-danger">*</span>
                                            Start Date
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control date start_datess" value="{{date('d-m-Y')}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold small text-muted">Due Date</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control date end_datess"
                                                value="{{date('d-m-Y')}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i
                                                        class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold small text-muted">Assignees To</label>
                                        <select class="form-control form-control-sm user_selected_idd ">
                                            <option value="">Select User</option>
                                            @foreach ($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold small text-muted ">Priority</label>
                                        <select class="form-control form-control-sm priority_selecteds">
                                            <option value="">Select Priority</option>
                                            <option value="1">Low</option>
                                            <option value="2">Medium</option>
                                            <option value="3">High</option>
                                            <option value="4">Urgent</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold small text-muted  ">Status</label>
                                        <select class="form-control form-control-sm selected_status_opt">
                                            <option value="" class="dropdown-item">Select Status</option>
                                            <option value="1" class="dropdown-item">In Progress</option>
                                            <option value="2" class="dropdown-item">Mark as Not Started</option>
                                            <option value="3" class="dropdown-item">Mark as Testing</option>
                                            <option value="4" class="dropdown-item">Mark as Awaiting Feedback</option>
                                            <option value="5" class="dropdown-item">Mark as Complete</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold small text-muted"><i class="fas fa-tag mr-1"></i>
                                            Tags</label>
                                        <input type="text" class="form-control form-control-sm tag_type_here "
                                            placeholder="Tag"
                                            style="border-top:none; border-left:none; border-right:none; border-radius:0;">
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">
                                <label class="font-weight-bold small text-muted">Task Description</label>
                                <textarea class="form-control task_description_typings " rows="4"
                                    placeholder="Add Description"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                            data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-dark btn-sm px-3 entry_new_task_btn ">Save</button>
                    </div>
                </div>
            </div>
        </div>




    </div>

</section>
@endsection


@push('scripts')
@if(Auth::user()->role_id == 1)
    <script type="text/javascript">



        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            get_tasks_data_info();

            function get_tasks_data_info() {
                $.ajax({
                    type: "get",
                    url: "task-get_data",
                    data: "",
                    dataType: "json",
                    success: function (resp) {
                        let res = resp.tasks;

                        let statusCount = {
                            1: 0,
                            2: 0,
                            3: 0,
                            4: 0,
                            5: 0
                        };

                        let data_html = '';
                        for (let n = 0; n < res.length; n++) {
                            statusCount[res[n].status]++;
                            data_html += `<tr>
                                            <td>${n + 1}</td>
                                            <td>
                                                <div class="task-name text-dark font-weight-bold d-block task_view_btn " task_id="${res[n].id}" style="cursor: pointer;" >${res[n].title}</div>
                                                <small class="text-muted">${res[n].short_title || ''},</small>
                                                <small class="text-muted">=> ${res[n].note || ''}</small>

                                                <div class="row-options">
                                                    <a style="cursor: pointer; " task_id="${res[n].id}" class="text-success task_view_btn">View </a>
                                                    <a style="cursor: pointer; margin-left: 10px;" task_id="${res[n].id}" class="text-danger _delete_task task-delete">Delete </a>
                                                </div>
                                            </td>
                                            <td>
                                                <select class="status-dropdown-btn change_status_options " tasks_idd="${res[n].id}" data-toggle="dropdown" >
                                                    <option value="1" ${res[n].status == 1 ? 'selected' : ''} class="dropdown-item">In Progress</option>
                                                    <option value="2" ${res[n].status == 2 ? 'selected' : ''} class="dropdown-item">Mark as Not Started</option>
                                                    <option value="3" ${res[n].status == 3 ? 'selected' : ''} class="dropdown-item">Mark as Testing</option>
                                                    <option value="4" ${res[n].status == 4 ? 'selected' : ''} class="dropdown-item">Mark as Awaiting Feedback</option>
                                                    <option value="5" ${res[n].status == 5 ? 'selected' : ''} class="dropdown-item">Mark as Complete</option>
                                                </select>
                                            </td>
                                            <td>${res[n].start_date}</td>
                                            <td>${res[n].due_date}</td>
                                            <td>${res[n].user.name}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <select class="priority-dropdown-link task_priority_changeable " task_id_au="${res[n].id}" data-toggle="dropdown">
                                                        <option  value="1" ${res[n].priority == 1 ? 'selected' : ''}  class="dropdown-item" >Low</option>
                                                        <option  value="2" ${res[n].priority == 2 ? 'selected' : ''}  class="dropdown-item" >Medium</option>
                                                        <option  value="3" ${res[n].priority == 3 ? 'selected' : ''}  class="dropdown-item" >High</option>
                                                        <option  value="4" ${res[n].priority == 4 ? 'selected' : ''}  class="dropdown-item" >Urgent</option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr> `
                        }
                        $('.data_assigning').html(data_html);
                        $(".card_11").text(statusCount[1]);
                        $(".card_21").text(statusCount[2]);
                        $(".card_31").text(statusCount[3]);
                        $(".card_41").text(statusCount[4]);
                        $(".card_51").text(statusCount[5]);

                        const rowsPerPage = 5;
                        let currentPage = 1;
                        const $tableBody = $('.table-tasks tbody');
                        const $rows = $tableBody.find('tr');

                        function showPage(page, rowsToDisplay) {
                            const start = (page - 1) * rowsPerPage;
                            const end = start + rowsPerPage;
                            rowsToDisplay.hide();
                            const visibleRows = rowsToDisplay.slice(start, end);
                            visibleRows.show();

                            const total = rowsToDisplay.length;
                            const currentEnd = end > total ? total : end;
                            $('#tableInfo').text(total > 0 ? `Showing ${start + 1} to ${currentEnd} of ${total} entries` : "No entries found");
                        }

                        function initPagination(rowsToPaginate) {
                            const pageCount = Math.ceil(rowsToPaginate.length / rowsPerPage);
                            const $controls = $('#paginationControls');
                            $controls.empty();
                            for (let i = 1; i <= pageCount; i++) {
                                const $li = $(`<li class="page-item ${i === 1 ? 'active' : ''}"><a class="page-link" href="#">${i}</a></li>`);
                                $li.click(function (e) {
                                    e.preventDefault();
                                    currentPage = i;
                                    showPage(currentPage, rowsToPaginate);
                                    $(this).addClass('active').siblings().removeClass('active');
                                });
                                $controls.append($li);
                            }
                            showPage(1, rowsToPaginate);
                        }

                        $('#taskSearch').on('keyup', function () {
                            const value = $(this).val().toLowerCase();
                            const filteredRows = $rows.filter(function () {
                                return $(this).text().toLowerCase().indexOf(value) > -1;
                            });
                            $rows.hide();
                            initPagination(filteredRows);
                        });

                        initPagination($rows);

                    }
                });
            }

            $(document).on('click', '.entry_new_task_btn', function (e) {
                e.preventDefault();

                if (!checkTaskFields()) {
                    return;
                }
                let payload = {
                    title:          $('.tasks_title').val(),
                    start_date:     $('.start_datess').val(),
                    short:          $('.short_details').val(),
                    note:           $('.tasks_notes').val(),
                    end_date:       $('.end_datess').val(),
                    user_id:        $('.user_selected_idd option:selected').val(),
                    priority:       $('.priority_selecteds option:selected').val(),
                    status:         $('.selected_status_opt option:selected').val(),
                    tag:            $('.tag_type_here').val(),
                    description:    $('.task_description_typings').val(),
                };

                $.ajax({
                    type: "POST",
                    url: "/tasks/store",
                    data: payload,
                    dataType: "json",
                    success: function (res) {
                        console.log(res);
                        $('#addTaskModal').modal('hide');
                        alert(res.message ?? 'Task saved!');
                        get_tasks_data_info();
                    },
                    error: function (xhr) {
                        console.log("Status:", xhr.status);
                        console.log("Response:", xhr.responseText);

                        // Laravel validation error হলে
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            alert(Object.values(errors).flat().join("\n"));
                        }
                    }
                });
            });

            function checkTaskFields() {
                let fields = [
                    'tasks_title',
                    'start_datess',
                    'end_datess',
                    'user_selected_idd option:selected',
                    'priority_selecteds option:selected',
                    'selected_status_opt option:selected',
                    'tag_type_here',
                    'task_description_typings',
                    'short_details',
                    'tasks_notes'
                ];

                let isValid = true;

                fields.forEach(function (cls) {
                    let value = $('.' + cls).val();

                    if (!value || value.trim() === '') {
                        isValid = false;
                        $('.' + cls).addClass('is-invalid');
                    } else {
                        $('.' + cls).removeClass('is-invalid');
                    }
                });
                if (!isValid) $('.is-invalid:first').focus();
                return isValid;
            }

            function resetTaskFields() {

                let allFields = [
                    'tasks_title',
                    'start_datess',
                    'end_datess',
                    'user_selected_idd',
                    'priority_selecteds',
                    'selected_status_opt',
                    'tag_type_here',
                    'task_description_typings'
                ];

                allFields.forEach(cls => {
                    let el = $('.' + cls);

                    if (el.is('select')) {
                        el.val('').trigger('change');
                    } else {
                        el.val('');
                    }

                    el.removeClass('is-invalid');
                });
            }

            $(document).on('change', '.change_status_options', function () {
                let task_id = $(this).attr('tasks_idd');
                let this_status_val = $(this).find('option:selected').val();

                $.ajax({
                    type: "post",
                    url: "/tasks/update",
                    data: {
                        task_id: task_id,
                        type: 'status',
                        value: this_status_val
                    },
                    success: function (rs) {
                        alert(rs.message ?? 'Task Update!');
                        get_tasks_data_info();
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            alert(Object.values(errors).flat().join("\n"));
                        }
                    }
                });
            });

            $(document).on('change', '.task_priority_changeable', function () {
                let task_id = $(this).attr('task_id_au');
                let this_status_val = $(this).find('option:selected').val();

                $.ajax({
                    type: "post",
                    url: "/tasks/update",
                    data: {
                        task_id: task_id,
                        type: 'priority',
                        value: this_status_val
                    },
                    success: function (rs) {
                        alert(rs.message ?? 'Task Update!');
                        get_tasks_data_info();
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            alert(Object.values(errors).flat().join("\n"));
                        }
                    }
                });
            });

            $(document).on('click', '._delete_task', function () {
                let task_id = $(this).attr('task_id');
                if (confirm('Are You sure to Delete? ')) {
                    $.ajax({
                        type: "post",
                        url: "/tasks/delete",
                        data: {
                            id: task_id
                        },
                        success: function (rs) {
                            alert(rs.message ?? 'Task Deleted!');
                            get_tasks_data_info();
                        },
                        error: function (xhr) {
                            if (xhr.status === 404) {
                                let errors = xhr.responseJSON.errors;
                                alert(Object.values(errors).flat().join("\n"));
                            }
                        }
                    });
                }
            });

            $(document).on('click', '.task_view_btn', function () {
                let task_id = $(this).attr('task_id');

                $.ajax({
                    type: "post",
                    url: "/tasks/find_single",
                    data: {
                        id: task_id
                    },
                    beforeSend: function () {
                        $("#loader").css('display', 'block');
                    },
                    dataType: "json",
                    success: function (rss) {

                        let priorityText = ({
                            1: 'Low',
                            2: 'Medium',
                            3: 'High',
                            4: 'Urgent'
                        }[rss.task.priority]) || '';

                        const statusConfig = {
                            1: { text: 'In Progress', color: 'primary' },
                            2: { text: 'Not Started', color: 'secondary' },
                            3: { text: 'Testing', color: 'info' },
                            4: { text: 'Awaiting Feedback', color: 'warning' },
                            5: { text: 'Completed', color: 'success' }
                        };
                        let status = statusConfig[rss.task.status];
                        let html = status ? `<span class="badge badge-${status.color}">${status.text}</span>` : '';


                        $("#loader").css('display', 'none');
                        $('#view_and_edit_taskTitle').text(rss.task.title);
                        $('#view_and_edit_taskDesc').text(rss.task.short_title);
                        // $('.view_task_modal').html(``);
                        $('#view_and_edit_task').modal('show');

                        $('.modalBodyEditTaskData').html(`
                            <div id="editTaskForm">
                                <input type="hidden" class="edit_task_id" value="${rss.task.id || ''}">
                                <div class="row no-gutters">
                                    <div class="col-lg-4 editLeftPanel p-4">
                                        <div class="miniCard mb-3">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <div class="miniLabel">Priority</div>
                                                    <div class="miniValue edit_preview_priority">${priorityText || 'Edit modal'}</div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="miniLabel">Status</div>
                                                    <div class="miniValue edit_preview_status"><span class="badge badge-${status.color || 'secondary'}">${status.text || 'Edit modal'}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="miniCard mb-3">
                                            <div class="miniLabel">Timeline</div>
                                                <div class="miniValue">
                                                    <span class="edit_preview_start">—</span> → <span class="edit_preview_end">${rss.task.due_date || '--'}</span>
                                                </div>
                                            </div>
                                            <div class="miniHint">
                                                Tip: ডানে কিছু পরিবর্তন করলে বাম পাশে Summary auto-update করতে পারবে।
                                            </div>
                                        </div>

                                        <div class="col-lg-8 editRightPanel p-4">
                                            <div class="formRow2">
                                                <div class="form-group mb-3">
                                                    <label class="small font-weight-bold">Subject</label>
                                                    <input type="text" class="form-control form-control-sm niceInput edit_tasks_title" value="${rss.task.title || ''}" placeholder="Task subject">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="small font-weight-bold">Tags</label>
                                                    <input type="text" class="form-control form-control-sm niceInput edit_tags" placeholder="e.g. bug, ui, urgent" value="${rss.task.tag || ''}">
                                                </div>
                                            </div>
                                            <div class="formRow2">
                                                <div class="form-group mb-3">
                                                    <label class="small font-weight-bold">Short Details</label>
                                                    <input type="text" class="form-control form-control-sm niceInput edit_short_details" placeholder="Short summary" value="${rss.task.short_title || ''}">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="small font-weight-bold">Note</label>
                                                    <input type="text" class="form-control form-control-sm niceInput edit_tasks_notes" placeholder="Internal note" value="${rss.task.note || ''}">
                                                </div>
                                            </div>
                                            <div class="formRow3">
                                                <div class="form-group mb-3">
                                                    <label class="small font-weight-bold">Start Date</label>
                                                    <input type="text" class="form-control form-control-sm niceInput date edit_start_date" placeholder="dd-mm-yyyy" value="${rss.task.start_date || ''}">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="small font-weight-bold">Due Date</label>
                                                    <input type="text" class="form-control form-control-sm niceInput date edit_end_date" placeholder="dd-mm-yyyy" value="${rss.task.due_date || ''}">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="small font-weight-bold">Assign To</label>
                                                    <select class="form-control form-control-sm niceInput edit_user_id">
                                                        <option value="">Select User</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{$user->id}}" ${rss.task.user_id == '{{$user->id}}' ? 'selected' : ''} >{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="formRow2">
                                                <div class="form-group mb-3">
                                                    <label class="small font-weight-bold">Priority</label>
                                                    <select class="form-control form-control-sm niceInput edit_priority">
                                                        <option value="1" ${rss.task.priority == 1 ? 'selected' : ''}>Low</option>
                                                        <option value="2" ${rss.task.priority == 2 ? 'selected' : ''}>Medium</option>
                                                        <option value="3" ${rss.task.priority == 3 ? 'selected' : ''}>High</option>
                                                        <option value="4" ${rss.task.priority == 4 ? 'selected' : ''}>Urgent</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="small font-weight-bold">Status</label>
                                                    <select class="form-control form-control-sm niceInput edit_status">
                                                        <option value="1" ${rss.task.status == 1 ? 'selected' : ''} >In Progress</option>
                                                        <option value="2" ${rss.task.status == 2 ? 'selected' : ''} >Not Started</option>
                                                        <option value="3" ${rss.task.status == 3 ? 'selected' : ''} >Testing</option>
                                                        <option value="4" ${rss.task.status == 4 ? 'selected' : ''} >Awaiting Feedback</option>
                                                        <option value="5" ${rss.task.status == 5 ? 'selected' : ''} >Completed</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0">
                                                <label class="small font-weight-bold">Description</label>
                                                <textarea class="form-control niceTextarea edit_description" rows="5" placeholder="Write full task description...">${rss.task.task_desc || ''}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);

                        // VERY IMPORTANT
                        $('.date').datepicker({
                            format: 'dd-mm-yyyy',
                            autoclose: true
                        });
                    },
                    error: function (xhr) {
                        if (xhr.status === 404) {
                            let errors = xhr.responseJSON.errors;
                            alert(Object.values(errors).flat().join("\n"));
                        }
                    }
                });
            });


            $(document).on('click', '.update_task_btn', function (e) {
                e.preventDefault();

                const data = {
                    id:             $('.edit_task_id').val(),
                    title:          $('.edit_tasks_title').val(),
                    tag:            $('.edit_tags').val(),
                    short_title:    $('.edit_short_details').val(),
                    note:           $('.edit_tasks_notes').val(),
                    start_date:     $('.edit_start_date').val(),
                    due_date:       $('.edit_end_date').val(),
                    user_id:        $('.edit_user_id').val(),
                    priority:       $('.edit_priority').val(),
                    status:         $('.edit_status').val(),
                    task_desc:      $('.edit_description').val(),
                };

                $.ajax({
                    url: '/tasks/updateAll',
                    type: 'POST', // বা 'PUT'
                    data: data,
                    success: function (res) {
                        // success UI
                        $('#view_and_edit_task').modal('hide');

                        // quick toast/alert
                        alert(res.message || 'Task updated successfully!');
                        get_tasks_data_info();
                    },
                    error: function (xhr) {
                        // Laravel validation errors
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let msg = Object.values(errors).flat().join('\n');
                            alert(msg);
                        } else {
                            alert('Something went wrong!');
                        }
                    }
                });
            });




        });




    </script>
@else
    <script type="text/javascript">



        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            get_tasks_data_info();

            function get_tasks_data_info() {
                $.ajax({
                    type: "get",
                    url: "task-get_data",
                    data: "",
                    dataType: "json",
                    success: function (resp) {
                        let res = resp.tasks;

                        let statusCount = {
                            1: 0,
                            2: 0,
                            3: 0,
                            4: 0,
                            5: 0
                        };

                        let data_html = '';
                        for (let n = 0; n < res.length; n++) {
                            statusCount[res[n].status]++;
                            data_html += `<tr>
                                            <td>${n + 1}</td>
                                            <td>
                                                <div class="task-name text-dark font-weight-bold d-block task_view_btn " task_id="${res[n].id}" style="cursor: pointer;" >${res[n].title}</div>
                                                <small class="text-muted">${res[n].short_title || ''},</small>
                                                <small class="text-muted">=> ${res[n].note || ''}</small>

                                                <div class="row-options">
                                                    <a style="cursor: pointer; " task_id="${res[n].id}" class="text-success task_view_btn">View </a>
                                                </div>
                                            </td>
                                            <td>
                                                <select class="status-dropdown-btn change_status_options " tasks_idd="${res[n].id}" data-toggle="dropdown" >
                                                    <option value="1" ${res[n].status == 1 ? 'selected' : ''} class="dropdown-item">In Progress</option>
                                                    <option value="2" ${res[n].status == 2 ? 'selected' : ''} class="dropdown-item">Mark as Not Started</option>
                                                    <option value="3" ${res[n].status == 3 ? 'selected' : ''} class="dropdown-item">Mark as Testing</option>
                                                    <option value="4" ${res[n].status == 4 ? 'selected' : ''} class="dropdown-item">Mark as Awaiting Feedback</option>
                                                    <option value="5" ${res[n].status == 5 ? 'selected' : ''} class="dropdown-item">Mark as Complete</option>
                                                </select>
                                            </td>
                                            <td>${res[n].start_date}</td>
                                            <td>${res[n].due_date}</td>
                                            <td>${res[n].user.name}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <select class="priority-dropdown-link task_priority_changeable " disabled task_id_au="${res[n].id}" data-toggle="dropdown">
                                                        <option  value="1" ${res[n].priority == 1 ? 'selected' : ''}  class="dropdown-item" >Low</option>
                                                        <option  value="2" ${res[n].priority == 2 ? 'selected' : ''}  class="dropdown-item" >Medium</option>
                                                        <option  value="3" ${res[n].priority == 3 ? 'selected' : ''}  class="dropdown-item" >High</option>
                                                        <option  value="4" ${res[n].priority == 4 ? 'selected' : ''}  class="dropdown-item" >Urgent</option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr> `
                        }
                        $('.data_assigning').html(data_html);
                        $(".card_11").text(statusCount[1]);
                        $(".card_21").text(statusCount[2]);
                        $(".card_31").text(statusCount[3]);
                        $(".card_41").text(statusCount[4]);
                        $(".card_51").text(statusCount[5]);

                        const rowsPerPage = 5;
                        let currentPage = 1;
                        const $tableBody = $('.table-tasks tbody');
                        const $rows = $tableBody.find('tr');

                        function showPage(page, rowsToDisplay) {
                            const start = (page - 1) * rowsPerPage;
                            const end = start + rowsPerPage;
                            rowsToDisplay.hide();
                            const visibleRows = rowsToDisplay.slice(start, end);
                            visibleRows.show();

                            const total = rowsToDisplay.length;
                            const currentEnd = end > total ? total : end;
                            $('#tableInfo').text(total > 0 ? `Showing ${start + 1} to ${currentEnd} of ${total} entries` : "No entries found");
                        }

                        function initPagination(rowsToPaginate) {
                            const pageCount = Math.ceil(rowsToPaginate.length / rowsPerPage);
                            const $controls = $('#paginationControls');
                            $controls.empty();
                            for (let i = 1; i <= pageCount; i++) {
                                const $li = $(`<li class="page-item ${i === 1 ? 'active' : ''}"><a class="page-link" href="#">${i}</a></li>`);
                                $li.click(function (e) {
                                    e.preventDefault();
                                    currentPage = i;
                                    showPage(currentPage, rowsToPaginate);
                                    $(this).addClass('active').siblings().removeClass('active');
                                });
                                $controls.append($li);
                            }
                            showPage(1, rowsToPaginate);
                        }

                        $('#taskSearch').on('keyup', function () {
                            const value = $(this).val().toLowerCase();
                            const filteredRows = $rows.filter(function () {
                                return $(this).text().toLowerCase().indexOf(value) > -1;
                            });
                            $rows.hide();
                            initPagination(filteredRows);
                        });

                        initPagination($rows);

                    }
                });
            }

            $(document).on('click', '.entry_new_task_btn', function (e) {
                e.preventDefault();

                if (!checkTaskFields()) {
                    return;
                }
                let payload = {
                    title:          $('.tasks_title').val(),
                    start_date:     $('.start_datess').val(),
                    short:          $('.short_details').val(),
                    note:           $('.tasks_notes').val(),
                    end_date:       $('.end_datess').val(),
                    user_id:        $('.user_selected_idd option:selected').val(),
                    priority:       $('.priority_selecteds option:selected').val(),
                    status:         $('.selected_status_opt option:selected').val(),
                    tag:            $('.tag_type_here').val(),
                    description:    $('.task_description_typings').val(),
                };

                $.ajax({
                    type: "POST",
                    url: "/tasks/store",
                    data: payload,
                    dataType: "json",
                    success: function (res) {
                        console.log(res);
                        $('#addTaskModal').modal('hide');
                        alert(res.message ?? 'Task saved!');
                        get_tasks_data_info();
                    },
                    error: function (xhr) {
                        console.log("Status:", xhr.status);
                        console.log("Response:", xhr.responseText);

                        // Laravel validation error হলে
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            alert(Object.values(errors).flat().join("\n"));
                        }
                    }
                });
            });

            function checkTaskFields() {
                let fields = [
                    'tasks_title',
                    'start_datess',
                    'end_datess',
                    'user_selected_idd option:selected',
                    'priority_selecteds option:selected',
                    'selected_status_opt option:selected',
                    'tag_type_here',
                    'task_description_typings',
                    'short_details',
                    'tasks_notes'
                ];

                let isValid = true;

                fields.forEach(function (cls) {
                    let value = $('.' + cls).val();

                    if (!value || value.trim() === '') {
                        isValid = false;
                        $('.' + cls).addClass('is-invalid');
                    } else {
                        $('.' + cls).removeClass('is-invalid');
                    }
                });
                if (!isValid) $('.is-invalid:first').focus();
                return isValid;
            }

            function resetTaskFields() {

                let allFields = [
                    'tasks_title',
                    'start_datess',
                    'end_datess',
                    'user_selected_idd',
                    'priority_selecteds',
                    'selected_status_opt',
                    'tag_type_here',
                    'task_description_typings'
                ];

                allFields.forEach(cls => {
                    let el = $('.' + cls);

                    if (el.is('select')) {
                        el.val('').trigger('change');
                    } else {
                        el.val('');
                    }

                    el.removeClass('is-invalid');
                });
            }

            $(document).on('change', '.change_status_options', function () {
                let task_id = $(this).attr('tasks_idd');
                let this_status_val = $(this).find('option:selected').val();

                $.ajax({
                    type: "post",
                    url: "/tasks/update",
                    data: {
                        task_id: task_id,
                        type: 'status',
                        value: this_status_val
                    },
                    success: function (rs) {
                        alert(rs.message ?? 'Task Update!');
                        get_tasks_data_info();
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            alert(Object.values(errors).flat().join("\n"));
                        }
                    }
                });
            });

            $(document).on('change', '.task_priority_changeable', function () {
                let task_id = $(this).attr('task_id_au');
                let this_status_val = $(this).find('option:selected').val();

                $.ajax({
                    type: "post",
                    url: "/tasks/update",
                    data: {
                        task_id: task_id,
                        type: 'priority',
                        value: this_status_val
                    },
                    success: function (rs) {
                        alert(rs.message ?? 'Task Update!');
                        get_tasks_data_info();
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            alert(Object.values(errors).flat().join("\n"));
                        }
                    }
                });
            });

            $(document).on('click', '._delete_task', function () {
                let task_id = $(this).attr('task_id');
                if (confirm('Are You sure to Delete? ')) {
                    $.ajax({
                        type: "post",
                        url: "/tasks/delete",
                        data: {
                            id: task_id
                        },
                        success: function (rs) {
                            alert(rs.message ?? 'Task Deleted!');
                            get_tasks_data_info();
                        },
                        error: function (xhr) {
                            if (xhr.status === 404) {
                                let errors = xhr.responseJSON.errors;
                                alert(Object.values(errors).flat().join("\n"));
                            }
                        }
                    });
                }
            });

            $(document).on('click', '.task_view_btn', function () {
                let task_id = $(this).attr('task_id');

                $.ajax({
                    type: "post",
                    url: "/tasks/find_single",
                    data: {
                        id: task_id
                    },
                    beforeSend: function () {
                        $("#loader").css('display', 'block');
                    },
                    dataType: "json",
                    success: function (rss) {

                        let priorityText = ({
                            1: 'Low',
                            2: 'Medium',
                            3: 'High',
                            4: 'Urgent'
                        }[rss.task.priority]) || '';

                        const statusConfig = {
                            1: { text: 'In Progress', color: 'primary' },
                            2: { text: 'Not Started', color: 'secondary' },
                            3: { text: 'Testing', color: 'info' },
                            4: { text: 'Awaiting Feedback', color: 'warning' },
                            5: { text: 'Completed', color: 'success' }
                        };
                        let status = statusConfig[rss.task.status];
                        let html = status ? `<span class="badge badge-${status.color}">${status.text}</span>` : '';


                        $("#loader").css('display', 'none');
                        $('#view_and_edit_taskTitle').text(rss.task.title);
                        $('#view_and_edit_taskDesc').text(rss.task.short_title);
                        // $('.view_task_modal').html(``);
                        $('#view_and_edit_task').modal('show');

                        $('.modalBodyEditTaskData').html(`
                            <div id="editTaskForm">
                                <input type="hidden" class="edit_task_id" value="${rss.task.id || ''}">
                                <div class="row no-gutters">
                                    <div class="col-lg-4 editLeftPanel p-4">
                                        <div class="miniCard mb-3">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <div class="miniLabel">Priority</div>
                                                    <div class="miniValue edit_preview_priority">${priorityText || 'Edit modal'}</div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="miniLabel">Status</div>
                                                    <div class="miniValue edit_preview_status"><span class="badge badge-${status.color || 'secondary'}">${status.text || 'Edit modal'}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="miniCard mb-3">
                                            <div class="miniLabel">Timeline</div>
                                                <div class="miniValue">
                                                    <span class="edit_preview_start">—</span> → <span class="edit_preview_end">${rss.task.due_date || '--'}</span>
                                                </div>
                                            </div>
                                            <div class="miniHint">
                                                Tip: ডানে কিছু পরিবর্তন করলে বাম পাশে Summary auto-update করতে পারবে।
                                            </div>
                                        </div>

                                        <div class="col-lg-8 editRightPanel p-4">
                                            <div class="formRow2">
                                                <div class="form-group mb-3">
                                                    <label class="small font-weight-bold">Subject</label>
                                                    <input type="text" class="form-control form-control-sm niceInput edit_tasks_title" value="${rss.task.title || ''}" placeholder="Task subject">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="small font-weight-bold">Tags</label>
                                                    <input type="text" class="form-control form-control-sm niceInput edit_tags" placeholder="e.g. bug, ui, urgent" value="${rss.task.tag || ''}">
                                                </div>
                                            </div>
                                            <div class="formRow2">
                                                <div class="form-group mb-3">
                                                    <label class="small font-weight-bold">Short Details</label>
                                                    <input type="text" class="form-control form-control-sm niceInput edit_short_details" placeholder="Short summary" value="${rss.task.short_title || ''}">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="small font-weight-bold">Note</label>
                                                    <input type="text" class="form-control form-control-sm niceInput edit_tasks_notes" placeholder="Internal note" value="${rss.task.note || ''}">
                                                </div>
                                            </div>
                                            <div class="formRow3">
                                                <div class="form-group mb-3">
                                                    <label class="small font-weight-bold">Start Date</label>
                                                    <input type="text" class="form-control form-control-sm niceInput date edit_start_date" placeholder="dd-mm-yyyy" value="${rss.task.start_date || ''}">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="small font-weight-bold">Due Date</label>
                                                    <input type="text" class="form-control form-control-sm niceInput date edit_end_date" placeholder="dd-mm-yyyy" value="${rss.task.due_date || ''}">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="small font-weight-bold">Assign To</label>
                                                    <select class="form-control form-control-sm niceInput edit_user_id">
                                                        <option value="">Select User</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{$user->id}}" ${rss.task.user_id == '{{$user->id}}' ? 'selected' : ''} >{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="formRow2">
                                                <div class="form-group mb-3">
                                                    <label class="small font-weight-bold">Priority</label>
                                                    <select class="form-control form-control-sm niceInput edit_priority">
                                                        <option value="1" ${rss.task.priority == 1 ? 'selected' : ''}>Low</option>
                                                        <option value="2" ${rss.task.priority == 2 ? 'selected' : ''}>Medium</option>
                                                        <option value="3" ${rss.task.priority == 3 ? 'selected' : ''}>High</option>
                                                        <option value="4" ${rss.task.priority == 4 ? 'selected' : ''}>Urgent</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="small font-weight-bold">Status</label>
                                                    <select class="form-control form-control-sm niceInput edit_status">
                                                        <option value="1" ${rss.task.status == 1 ? 'selected' : ''} >In Progress</option>
                                                        <option value="2" ${rss.task.status == 2 ? 'selected' : ''} >Not Started</option>
                                                        <option value="3" ${rss.task.status == 3 ? 'selected' : ''} >Testing</option>
                                                        <option value="4" ${rss.task.status == 4 ? 'selected' : ''} >Awaiting Feedback</option>
                                                        <option value="5" ${rss.task.status == 5 ? 'selected' : ''} >Completed</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0">
                                                <label class="small font-weight-bold">Description</label>
                                                <textarea class="form-control niceTextarea edit_description" rows="5" placeholder="Write full task description...">${rss.task.task_desc || ''}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);

                        // VERY IMPORTANT
                        $('.date').datepicker({
                            format: 'dd-mm-yyyy',
                            autoclose: true
                        });
                    },
                    error: function (xhr) {
                        if (xhr.status === 404) {
                            let errors = xhr.responseJSON.errors;
                            alert(Object.values(errors).flat().join("\n"));
                        }
                    }
                });
            });


            $(document).on('click', '.update_task_btn', function (e) {
                e.preventDefault();

                const data = {
                    id:             $('.edit_task_id').val(),
                    title:          $('.edit_tasks_title').val(),
                    tag:            $('.edit_tags').val(),
                    short_title:    $('.edit_short_details').val(),
                    note:           $('.edit_tasks_notes').val(),
                    start_date:     $('.edit_start_date').val(),
                    due_date:       $('.edit_end_date').val(),
                    user_id:        $('.edit_user_id').val(),
                    priority:       $('.edit_priority').val(),
                    status:         $('.edit_status').val(),
                    task_desc:      $('.edit_description').val(),
                };

                $.ajax({
                    url: '/tasks/updateAll',
                    type: 'POST', // বা 'PUT'
                    data: data,
                    success: function (res) {
                        // success UI
                        $('#view_and_edit_task').modal('hide');

                        // quick toast/alert
                        alert(res.message || 'Task updated successfully!');
                        get_tasks_data_info();
                    },
                    error: function (xhr) {
                        // Laravel validation errors
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let msg = Object.values(errors).flat().join('\n');
                            alert(msg);
                        } else {
                            alert('Something went wrong!');
                        }
                    }
                });
            });




        });




    </script>
@endif
@endpush
