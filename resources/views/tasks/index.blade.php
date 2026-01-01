@extends('layout.main')
@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <style>
        body { background-color: #f0f2f5; font-size: 13px; color: #4e5154; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; }

        /* Summary Cards */
        .card-summary { border: 1px solid #e4e9f0; border-radius: 4px; padding: 10px; background: #fff; height: 100%; }
        .summary-count { font-weight: bold; font-size: 16px; margin-right: 5px; }
        .summary-label { color: #6a6c6f; }
        .summary-subtext { color: #83888d; font-size: 11px; display: block; }

        /* Table Styling */
        .table-tasks thead th { background-color: #f9fafb; border-bottom: 1px solid #ebf1f2; color: #333; font-weight: 600; border-top: none; }
        .table-tasks td { vertical-align: middle; padding: 12px 8px; border-top: 1px solid #f0f0f0; }

        /* Status Dropdown Button */
        .status-dropdown-btn {
            padding: 4px 10px; border-radius: 4px; font-size: 11px; background: #fff;
            border: 1px solid #b8d3ff; color: #2d62d3; cursor: pointer;
            text-decoration: none !important; display: inline-flex; align-items: center;
        }
        .status-dropdown-btn:after { content: '\f078'; font-family: 'Font Awesome 5 Free'; font-weight: 900; margin-left: 8px; font-size: 8px; }

        /* Priority Links */
        .priority-dropdown-link { color: #00aeff; text-decoration: none !important; font-size: 13px; }
        .priority-dropdown-link:after { content: '\f078'; font-family: 'Font Awesome 5 Free'; font-weight: 900; margin-left: 5px; font-size: 9px; display: inline-block; }

        /* Dropdown Menu Styling */
        .dropdown-menu { border-radius: 8px; border: 1px solid #ddd; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 5px 0; }
        .dropdown-item { font-size: 13px; padding: 8px 20px; color: #333; }
        .dropdown-item:hover { background-color: #f8f9fa; }

        .avatar { width: 24px; height: 24px; border-radius: 50%; border: 1px solid #ddd; background: #eee; }

        /* Modal Customizations */
        .modal-content { border-radius: 8px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,.1); }
        .modal-header { border-bottom: 1px solid #f0f0f0; padding: 15px 20px; }
        .modal-title { font-size: 16px; font-weight: 700; color: #4e5154; }
        .form-control { border: 1px solid #d1d9e1; border-radius: 4px; font-size: 13px; color: #4e5154; }
        .input-group-text { background-color: #fff; border-color: #d1d9e1; color: #83888d; }

        /* Pagination Styling */
        .page-item.active .page-link { background-color: #333; border-color: #333; }
        .page-link { color: #333; }
    </style>
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
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
                <h3>{{trans('file.welcome')}} <span>{{Auth::user()->name}}</span> </h3>
            </div>
          </div>
        </div>
      </div>


      <!-- Counts Section -->
      <section class="dashboard-counts">
        <div class="container-fluid">






            <div class="container-fluid py-4">
                <div class="row mb-4">
                    <div class="col"><h4 class="mb-0 font-weight-bold" style="color:#4e5154;">Tasks <small class="text-primary ml-2" style="font-size: 12px; cursor: pointer; font-weight: 400;">Tasks Overview →</small></h4></div>
                </div>

                <div class="row mb-4 no-gutters">
                    <div class="col px-1"><div class="card-summary"><span class="summary-count">13</span> <span class="summary-label">Not Started</span><span class="summary-subtext">My Tasks: 8</span></div></div>
                    <div class="col px-1"><div class="card-summary"><span class="summary-count text-primary">11</span> <span class="summary-label text-primary">In Progress</span><span class="summary-subtext">My Tasks: 4</span></div></div>
                    <div class="col px-1"><div class="card-summary"><span class="summary-count">7</span> <span class="summary-label">Testing</span><span class="summary-subtext">My Tasks: 2</span></div></div>
                    <div class="col px-1"><div class="card-summary"><span class="summary-count">13</span> <span class="summary-label">Awaiting Feedback</span><span class="summary-subtext">My Tasks: 5</span></div></div>
                    <div class="col px-1"><div class="card-summary"><span class="summary-count">19</span> <span class="summary-label">Complete</span><span class="summary-subtext">My Tasks: 11</span></div></div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <button class="btn btn-dark btn-sm px-3" data-toggle="modal" data-target="#addTaskModal"><i class="fas fa-plus mr-1"></i> New Task</button>
                            </div>
                            <div class="d-flex">
                                <div class="input-group input-group-sm mr-2" style="width: 200px;">
                                    <div class="input-group-prepend"><span class="input-group-text border-right-0"><i class="fas fa-search"></i></span></div>
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
                                <tbody>



                                    @foreach($tasks as $task)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="#" class="task-name text-dark font-weight-bold d-block">{{ $task->title }}</a>
                                                <small class="text-muted">{{ $task->short_title }}</small>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <div class="status-dropdown-btn" data-toggle="dropdown">In Progress</div>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Mark as Not Started</a>
                                                        <a class="dropdown-item" href="#">Mark as Testing</a>
                                                        <a class="dropdown-item" href="#">Mark as Awaiting Feedback</a>
                                                        <a class="dropdown-item" href="#">Mark as Complete</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>2025-12-30</td>
                                            <td>2025-12-30</td>
                                            <td><img src="https://i.pravatar.cc/150?u=1" class="avatar"></td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" class="priority-dropdown-link" data-toggle="dropdown">Medium</a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Low</a><a class="dropdown-item" href="#">High</a><a class="dropdown-item" href="#">Urgent</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach



                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3 px-3">
                            <div id="tableInfo" class="text-muted small"></div>
                            <nav><ul class="pagination pagination-sm mb-0" id="paginationControls"></ul></nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bold" style="font-size: 16px; color: #4e5154;">Add New Task</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="taskForm">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="publicTask">
                                            <label class="custom-control-label" for="publicTask">Public</label>
                                        </div>
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="billableTask" checked>
                                            <label class="custom-control-label" for="billableTask">Billable</label>
                                        </div>
                                    </div>
                                    <a href="#" class="text-primary small font-weight-bold">Attach Files</a>
                                </div>

                                <hr class="mt-0">

                                <div class="form-group">
                                    <label class="font-weight-bold small"><span class="text-danger">*</span> Subject</label>
                                    <input type="text" class="form-control form-control-sm border-primary" style="border-width: 1.5px;">
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold small text-muted">Hourly Rate</label>
                                    <input type="number" class="form-control form-control-sm" value="0">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold small"><span class="text-danger">*</span> Start Date</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control" value="2025-12-30">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold small text-muted">Due Date</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control" placeholder="">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-end">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold small text-muted">Priority</label>
                                            <select class="form-control form-control-sm">
                                                <option>Medium</option>
                                                <option>Low</option>
                                                <option>High</option>
                                                <option>Urgent</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold small text-muted">Repeat every</label>
                                            <select class="form-control form-control-sm text-muted">
                                                <option>Nothing selected</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold small text-muted">Related To</label>
                                            <select class="form-control form-control-sm text-muted">
                                                <option>Nothing selected</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold small text-muted">Assignees</label>
                                            <select class="form-control form-control-sm">
                                                <option>Eldon McCullough</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold small text-muted">Followers</label>
                                            <select class="form-control form-control-sm text-muted">
                                                <option>Nothing selected</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold small text-muted"><i class="fas fa-tag mr-1"></i> Tags</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Tag" style="border-top:none; border-left:none; border-right:none; border-radius:0;">
                                </div>

                                <hr>

                                <div class="form-group">
                                    <label class="font-weight-bold small text-muted">Task Description</label>
                                    <textarea class="form-control" rows="4" placeholder="Add Description"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-dark btn-sm px-3">Save</button>
                        </div>
                    </div>
                </div>
            </div>








        </div>

      </section>


@endsection

@push('scripts')
<script type="text/javascript">



$(document).ready(function() {
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
            $li.click(function(e) {
                e.preventDefault();
                currentPage = i;
                showPage(currentPage, rowsToPaginate);
                $(this).addClass('active').siblings().removeClass('active');
            });
            $controls.append($li);
        }
        showPage(1, rowsToPaginate);
    }

    $('#taskSearch').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        const filteredRows = $rows.filter(function() {
            return $(this).text().toLowerCase().indexOf(value) > -1;
        });
        $rows.hide();
        initPagination(filteredRows);
    });

    initPagination($rows);

    function get_tasks_data_info() {}







});




</script>
@endpush

