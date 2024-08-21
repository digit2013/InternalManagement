@extends('layout.main')
@section('title', 'User Management')
@section('content')
@section('Home', 'active')
<section id="contact" class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3> {{ $deptCount }}</h3>

                        <p>Department</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-building nav-icon"></i>
                    </div>
                    <a href="/depts" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>
                            {{ $branchCount }}
                        </h3>

                        <p>Branch</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-warehouse"></i>
                    </div>
                    <a href="/branchs" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $helper->getTopWidget()[0]['userCount'] }}</h3>

                        <p>User Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="/users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>                            {{ $helper->getTopWidget()[0]['productCount'] }}
                        </h3>

                        <p>Products</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="/productlist" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <div class="row">
            <div class="col-md-3">

                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="ion ion-clipboard mr-1"></i>
                            My Tasks
                        </h3>
                        <div class="card-tools">
                            {{-- @if (count($helper->getTaskDetailList()) != 0)
                            <ul class="pagination pagination-sm">
                            @if ($helper->getTaskDetailList()->hasMorePages())
                                <a href="{{ $helper->getTaskDetailList()->nextPageUrl() }}" class="p-1"><small
                                                class="badge badge-info">Next</small></a>
                                            @endif
                                            @if ($helper->getTaskDetailList()->currentPage() > 1)
                                            <a href="{{ $helper->getTaskDetailList()->previousPageUrl() }}" class="p-1"><small
                                                    class="badge badge-info">Prev</small></a>
                                            @endif
                                            </ul>
                                            @endif --}}
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (count($helper->getTaskDetailList()) != 0)
                            <ul class="todo-list" data-widget="todo-list">
                                @foreach ($helper->getTaskDetailList() as $taskd)
                                    <li>
                                        <span class="handle">
                                            <i class="fas fa-ellipsis-v"></i>
                                            <i class="fas fa-ellipsis-v"></i>
                                        </span>
                                        <span class="text">{{ $taskd->name }}-{{ $taskd->description }}</span>
                                        @if ($taskd->status == 1)
                                            <small class="badge badge-info"><i
                                                    class="far fa-clock"></i>{{ $taskd->assign_end_date }}</small>
                                        @elseif($taskd->status == 2)
                                            <small class="badge badge-warning"><i
                                                    class="far fa-clock"></i>{{ $taskd->assign_end_date }}</small>
                                        @elseif($taskd->status == 3)
                                            <small class="badge badge-danger"><i
                                                    class="far fa-clock"></i>{{ $taskd->assign_end_date }}</small>
                                        @elseif($taskd->status == 4)
                                            <small class="badge badge-success"><i
                                                    class="far fa-clock"></i>{{ $taskd->finish_end_date . ' complete' }}</small>
                                        @endif
                                        <div class="tools">
                                            <i class="fas fa-edit" data-toggle="modal"
                                                data-target="#taskDetail-{{ $taskd->id }}"></i>
                                            <i class="fas fa-upload" data-toggle="modal"
                                                data-target="#taskAttach-{{ $taskd->id }}"></i>
                                        </div>
                                    </li>
                                    <div class="modal fade" id="taskDetail-{{ $taskd->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Task Detail</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="itemFrom" role="form" method="POST"
                                                        action="{{ url('/task-detail/' . $taskd->id . '/status') }}">
                                                        @csrf
                                                        <input type="hidden" class="form-control col-md-12"
                                                            id="id" name="id" value="{{ $taskd->id }}">
                                                        <div class="form-group">
                                                            <label for="inputHeading" class="form-label">Assigned
                                                                By</label>
                                                            <input type="text" class="form-control col-md-12"
                                                                value="{{ $helper->getUser($helper->getAssignedBy($taskd->t_id)->created_by)->name }}"
                                                                disabled>

                                                        </div>
                                                        <div class="form-group">
                                                            <label>Effective Date:</label>

                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="far fa-calendar-alt"></i>
                                                                    </span>
                                                                </div>

                                                                <input type="text" class="form-control float-right"
                                                                    value={{ Carbon\Carbon::parse($taskd->assign_start_date)->format('Y/m/d') . ' to ' . Carbon\Carbon::parse($taskd->assign_end_date)->format('Y/m/d') }}
                                                                    disabled>
                                                            </div>
                                                            <!-- /.input group -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputHeading" class="form-label">Task
                                                                Name</label>
                                                            <input type="text" class="form-control col-md-12"
                                                                value="{{ $taskd->name ?? '' }}" disabled>


                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputHeading" class="form-label">Task
                                                                Description </label>
                                                            <input type="text" class="form-control col-md-12"
                                                                value="{{ $taskd->description ?? '' }}" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Select Progress</label>
                                                            <select class="form-control" name="status"
                                                                id="status"
                                                                {{ $taskd->status == 4 ? 'disabled' : '' }}>
                                                                <option value="">-- Select Progress --</option>

                                                                <option {{ $taskd->status == 2 ? 'selected' : '' }}
                                                                    value="2">
                                                                    Pending
                                                                </option>
                                                                <option {{ $taskd->status == 4 ? 'selected' : '' }}
                                                                    value="4">
                                                                    Complete
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="text-center mt-3">
                                                            <button type="submit" class="btn btn-primary">
                                                                @isset($taskd)
                                                                    <i class="fas fa-arrow-circle-up"></i>
                                                                    <span>Update</span>
                                                                @else
                                                                    <i class="fas fa-plus-circle"></i>
                                                                    <span>Create</span>
                                                                @endisset
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="taskAttach-{{ $taskd->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Task Detail</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="itemFrom" role="form" method="POST"
                                                        action="{{ url('task/' . $taskd->id . '/upload') }}"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label>Upload Images (Max:10 files only)</label>
                                                            <input type="file" name="taskAttach[]" multiple
                                                                class="form-control" />
                                                        </div>
                                                        <div class="text-center mt-3">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fas fa-plus-circle"></i>
                                                                Upload </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-6">
                                                    <ul class="list-unstyled">
                                                        @foreach ($helper->getFileList($taskd->id) as $tfile)
                                                            <li>
                                                                <a href="{{ route('download', $tfile->id) }}"
                                                                    class="btn-link text-secondary"><i
                                                                        class="far fa-fw fa-file-word"></i>{{ basename($tfile->file_url) }}</a>
                                                                <a
                                                                    href="{{ url('/task-file/' . $tfile->id . '/delete') }}">Delete</a>
                                                            </li>
                                                    </ul>
                                @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        </ul>
    @else
        There is no tasks!
        @endif
    </div>

    </div>


    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-success">
                <h3 class="card-title">Assigned To(Complete)</h3>
                <div class="card-tools">

                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Members</th>
                            <th>Finish Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($helper->getAssignedByUser(Session::get('user')->id, 4)) != 0)
                            @foreach ($helper->getAssignedByUser(Session::get('user')->id, 4) as $taskd)
                                <tr>
                                    <td>{{ $taskd->name }}</td>
                                    <td>{{ $taskd->assigned_member }}</td>
                                    <td>
                                        {{ $taskd->finish_end_date }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="bg-warning">
                                <td colspan="3">There is no complete tasks!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <hr />
                <div class="row">
                    <div class="col-md-8">

                        {{-- @if (count($helper->getAssignedByUser(Session::get('user')->id, 4)) != 0)
              <ul class="pagination pagination-sm">
                @if ($helper->getAssignedByUser(Session::get('user')->id, 4)->hasMorePages())
                    <a href="{{ $helper->getAssignedByUser( Session::get('user')->id,4)->nextPageUrl() }}" class="p-1"><small
                                    class="badge badge-info">Next</small></a>
                                @endif
                                @if ($helper->getAssignedByUser(Session::get('user')->id, 4)->currentPage() > 1)
                                <a href="{{ $helper->getAssignedByUser( Session::get('user')->id,4)->previousPageUrl() }}" class="p-1"><small
                                        class="badge badge-info">Prev</small></a>
                                @endif
                                </ul>
                                @endif --}}
                    </div>
                    <div class="col-md-4">
                        <small> total {{ $helper->getAssignedByUser(Session::get('user')->id, 4)->total() }} tasks
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-warning">
                <h3 class="card-title">Assigned To(Pending)</h3>
                <div class="card-tools">

                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Members</th>
                            <th>Deadline</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($helper->getAssignedByUser(Session::get('user')->id, 2)) != 0)
                            @foreach ($helper->getAssignedByUser(Session::get('user')->id, 2) as $taskd)
                                <tr>
                                    <td>{{ $taskd->name }}</td>
                                    <td>{{ $taskd->assigned_member }}</td>
                                    <td>
                                        <span class="badge badge-warning">{{ $taskd->assign_end_date }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="bg-warning">
                                <td colspan="3">There is no pending tasks!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <hr />
                <div class="row">
                    <div class="col-md-8">

                        {{-- @if (count($helper->getAssignedByUser(Session::get('user')->id, 2)) != 0)
              <ul class="pagination pagination-sm">
                @if ($helper->getAssignedByUser(Session::get('user')->id, 2)->hasMorePages())
                    <a href="{{ $helper->getAssignedByUser( Session::get('user')->id,2)->nextPageUrl() }}" class="p-1"><small
                                    class="badge badge-info">Next</small></a>
                                @endif
                                @if ($helper->getAssignedByUser(Session::get('user')->id, 2)->currentPage() > 1)
                                <a href="{{ $helper->getAssignedByUser( Session::get('user')->id,2)->previousPageUrl() }}" class="p-1"><small
                                        class="badge badge-info">Prev</small></a>
                                @endif
                                </ul>
                                @endif --}}
                    </div>
                    <div class="col-md-4">
                        <small> total {{ $helper->getAssignedByUser(Session::get('user')->id, 2)->total() }} tasks
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-danger">
                <h3 class="card-title">Assigned To(Overdue)</h3>
                <div class="card-tools">

                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Members</th>
                            <th>Deadline</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($helper->getAssignedByUser(Session::get('user')->id, 3)) != 0)
                            @foreach ($helper->getAssignedByUser(Session::get('user')->id, 3) as $taskd)
                                <tr>
                                    <td>{{ $taskd->name }}</td>
                                    <td>{{ $taskd->assigned_member }}</td>
                                    <td>
                                        <span class="badge badge-danger">{{ $taskd->assign_end_date }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="bg-warning">
                                <td colspan="3">There is no overdue tasks!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <hr />
                <div class="row">
                    <div class="col-md-8">

                        {{-- @if (count($helper->getAssignedByUser(Session::get('user')->id, 3)) != 0)
              <ul class="pagination pagination-sm">
                @if ($helper->getAssignedByUser(Session::get('user')->id, 3)->hasMorePages())
                    <a href="{{ $helper->getAssignedByUser( Session::get('user')->id,3)->nextPageUrl() }}" class="p-1"><small
                                    class="badge badge-info">Next</small></a>
                                @endif
                                @if ($helper->getAssignedByUser(Session::get('user')->id, 3)->currentPage() > 1)
                                <a href="{{ $helper->getAssignedByUser( Session::get('user')->id,3)->previousPageUrl() }}" class="p-1"><small
                                        class="badge badge-info">Prev</small></a>
                                @endif
                                </ul>
                                @endif --}}
                    </div>
                    <div class="col-md-4">
                        <small> total {{ $helper->getAssignedByUser(Session::get('user')->id, 3)->total() }} tasks
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">My Task Chart</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    <figure class="highcharts-figure">
                        <div id="taskChart"></div>
                    </figure>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
      
        <div class="col-md-3">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Product Information</h3>

                </div>
                <style>
                    @media (min-width: 992px) {

                        .modal-lg,
                        .modal-xl {
                            max-width: 850px;
                        }
                    }
                </style>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <?php $img = $helper->getProductImage($product->id);
                                        if(!empty($imgUrl)){
                                            $imgUrl = $img[0]->image_url;
                                        }
                                        else{
                                            $imgUrl = '';
                                        }
                                        ?>
                                        <img src="{{ $imgUrl}}"
                                            alt="{{ $product->name }}" class="img-circle img-size-32 mr-2">
                                        {{ $product->name }}
                                    </td>
                                    <td>
                                        <a class="dropdown-item" role="button" data-toggle="modal"
                                            data-target="#product-{{ $product->id }}">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </td>
                                    <div class="modal fade" id="product-{{ $product->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Product Information</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-6">
                                                            <h3 class="d-inline-block d-sm-none">{{ $product->name }}
                                                            </h3>
                                                            <?php $prod_img = $helper->getProductImage($product->id);
                                                            
                                                            $i = 0; ?>
                                                            @if(!empty($prod_img))
                                                            <div class="col-12">
                                                                <img src="{{ $prod_img[0]->image_url }}"
                                                                    class="product-image" alt="Product Image">
                                                            </div>
                                                            <div class="col-12 product-image-thumbs">
                                                                @foreach ($prod_img as $pimg)
                                                                    @if ($i == 0)
                                                                        <div class="product-image-thumb active"><img
                                                                                src="{{ $pimg->image_url }}"
                                                                                alt="{{ $product->name }}"></div>
                                                                    @else
                                                                        <div class="product-image-thumb "><img
                                                                                src="{{ $pimg->image_url }}"
                                                                                alt="{{ $product->name }}"></div>
                                                                    @endif
                                                                    <?php $i++; ?>
                                                                @endforeach
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <h3 class="my-3">{{ $product->name }}</h3>
                                                            <h4>
                                                                <p class="badge badge-success">{{ $product->cname }}
                                                                </p>
                                                            </h4>

                                                            <hr>
                                                            <hr />

                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <nav class="w-100">
                                                            <div class="nav nav-tabs" id="product-tab"
                                                                role="tablist">
                                                                <a class="nav-item nav-link active"
                                                                    id="product-desc-tab" data-toggle="tab"
                                                                    href="#product-desc" role="tab"
                                                                    aria-controls="product-desc"
                                                                    aria-selected="true">Description</a>
                                                                <a class="nav-item nav-link" id="product-comments-tab"
                                                                    data-toggle="tab" href="#product-comments"
                                                                    role="tab" aria-controls="product-comments"
                                                                    aria-selected="false">Usage</a>
                                                                <a class="nav-item nav-link" id="product-rating-tab"
                                                                    data-toggle="tab" href="#product-rating"
                                                                    role="tab" aria-controls="product-rating"
                                                                    aria-selected="false">Rating</a>
                                                            </div>
                                                        </nav>
                                                        <div class="tab-content p-3" id="nav-tabContent">
                                                            <div class="tab-pane fade show active" id="product-desc"
                                                                role="tabpanel" aria-labelledby="product-desc-tab">
                                                                {!! $product->description !!}</div>
                                                            <div class="tab-pane fade" id="product-comments"
                                                                role="tabpanel"
                                                                aria-labelledby="product-comments-tab">
                                                                {!! $product->description !!}</div>
                                                            <div class="tab-pane fade" id="product-rating"
                                                                role="tabpanel" aria-labelledby="product-rating-tab">
                                                                {!! $product->description !!}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>


                                    </div>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Products on Category</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <style>
                        #cateProductChart,
                        #taskChart {
                            height: 300px;
                        }

                        .highcharts-figure,
                        .highcharts-data-table table {
                            min-width: 310px;
                            max-width: 800px;
                            margin: 1em auto;
                        }

                        .highcharts-data-table table {
                            font-family: Verdana, sans-serif;
                            border-collapse: collapse;
                            border: 1px solid #ebebeb;
                            margin: 10px auto;
                            text-align: center;
                            width: 100%;
                            max-width: 500px;
                        }

                        .highcharts-data-table caption {
                            padding: 1em 0;
                            font-size: 1.2em;
                            color: #555;
                        }

                        .highcharts-data-table th {
                            font-weight: 600;
                            padding: 0.5em;
                        }

                        .highcharts-data-table td,
                        .highcharts-data-table th,
                        .highcharts-data-table caption {
                            padding: 0.5em;
                        }

                        .highcharts-data-table thead tr,
                        .highcharts-data-table tr:nth-child(even) {
                            background: #f8f8f8;
                        }

                        .highcharts-data-table tr:hover {
                            background: #f1f7ff;
                        }
                    </style>
                    <figure class="highcharts-figure">
                        <div id="cateProductChart"></div>
                    </figure>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Last 5 Meeting Minutes</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @if (!empty($minutes))
                            @foreach ($minutes as $minute)
                                <li class="item">
                                    <div class="">
                                        <a class="product-title" role="button" data-toggle="modal"
                                            data-target="#minute-{{ $minute->id }}">Host -
                                            {{ $helper->getUser($minute->host)->name }}
                                            <span class="badge badge-warning float-right">Meeting -
                                                {{ Carbon\Carbon::parse($minute->meeting_date)->format('Y/m/d') }}</span></a>
                                        <span class="product-description">
                                            <?php $i = 0;
                                            $attendees = explode(',', $minute->attendees); ?>
                                            @if (!empty($attendees))
                                                @foreach ($attendees as $a)
                                                    {{ $helper->getUser($a)->name }}
                                                    @if ($i < count($attendees) - 1)
                                                        ,
                                                    @endif
                                                    <?php $i++; ?>
                                                @endforeach
                                            @endif
                                        </span>
                                    </div>
                                    <div class="modal fade" id="minute-{{ $minute->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Meeting Minute -
                                                        {{ Carbon\Carbon::parse($minute->created_at)->format('Y/m/d') }}
                                                    </h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    {!! $minute->description !!}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif


                    </ul>
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-center">
                    <a href="/meeting-minutes" class="uppercase">View All Meeting Minutes</a>
                </div>
                <!-- /.card-footer -->
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-12">
            <style>
                @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@200;300;400;500;600;700&display=swap');

                .highcharts-figure,
                .highcharts-data-table table {
                    min-width: 360px;
                    max-width: 100%;
                    margin: 1em auto;
                }

                .highcharts-data-table table {
                    font-family: Verdana, sans-serif;
                    border-collapse: collapse;
                    border: 1px solid #ebebeb;
                    margin: 10px auto;
                    text-align: center;
                    width: 100%;
                    max-width: 500px;
                }

                .highcharts-data-table caption {
                    padding: 1em 0;
                    font-size: 1.2em;
                    color: #555;
                }

                .highcharts-data-table th {
                    font-weight: 600;
                    padding: 0.5em;
                }

                .highcharts-data-table td,
                .highcharts-data-table th,
                .highcharts-data-table caption {
                    padding: 0.5em;
                }

                .highcharts-data-table thead tr,
                .highcharts-data-table tr:nth-child(even) {
                    background: #f8f8f8;
                }

                .highcharts-data-table tr:hover {
                    background: #f1f7ff;
                }

                #orgChartContainer h4 {
                    text-transform: none;
                    font-size: 12px;
                    font-weight: normal;
                    font-weight: bold;
                }

                #orgChartContainer p {
                    font-size: 11px;
                    line-height: 26px;
                }

                @media screen and (max-width: 600px) {
                    #orgChartContainer h4 {
                        font-size: 11px;
                        line-height: 3vw;
                    }

                    #orgChartContainer p {
                        font-size: 11px;
                        line-height: 3vw;
                    }
                }


                hr {
                    all: initial;
                }

                p.highcharts-description {
                    background-color: #FFF;
                    padding: 0.5em;
                    margin: 0;
                }

                p.highcharts-description code {
                    background-color: #EBEBEB;
                    color: #9E0000;
                }

                @media (prefers-color-scheme: light) {

                    .highcharts-dashboards,
                    .highcharts-dashboards-wrapper {
                        background-color: transparent;
                    }
                }

                .highcharts-light>.highcharts-dashboards-wrapper {
                    background-color: transparent;
                }

                .highcharts-dashboards,
                .highcharts-dashboards-wrapper {
                    overflow-x: auto;
                }
            </style>
            <figure class="highcharts-figure">
                <div id="orgChartContainer"></div>
            </figure>
        </div>
        
    </div>




    </div>
    <script src="{{ url('orgChart/js/highcharts-3d.js') }}"></script>

    <script src="{{ url('orgChart/js/highcharts.js') }}"></script>
    <script src="{{ url('orgChart/js/sankey.js') }}"></script>
    <script src="{{ url('orgChart/js/organization.js') }}"></script>
    <script src="{{ url('orgChart/js/exporting.js') }}"></script>
    <script src="{{ url('orgChart/js/accessibility.js') }}"></script>


    <script src="{{ url('plugins/chart.js/Chart.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var cateProducts = @json($helper->getCategoryPerProducts());
        let cp = [];
        for (let i = 0; i < cateProducts.length; i++) {
            cp[i] = [];
            cp[i][0] = cateProducts[i].name;
            cp[i][1] = cateProducts[i].products;
        }

        Highcharts.chart('taskChart', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                }
            },
            title: {
                text: '',
                align: 'left'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    depth: 35,
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}'
                    }
                }
            }, credits: {
                enabled: false
            },
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: ["viewFullscreen"]
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Tasks',
                data:  [['new tasks',@json($newTaskCount)], ['pending tasks',@json($pendingTaskCount)], ['complete tasks',@json($completeTaskCount)],
                    ['overdue tasks',@json($overdueTaskCount)]
                ]
            }]
        });


        Highcharts.chart('cateProductChart', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45
                }
            },
            title: {
                text: '',
                align: 'left'
            },
            plotOptions: {
                pie: {
                    innerSize: 100,
                    depth: 45
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: ["viewFullscreen"]
                    }
                }
            },
            series: [{
                name: 'Products',
                data: cp
            }]
        });

        Highcharts.chart('orgChartContainer', {
            chart: {
                height: 600,
                inverted: true,
                borderRadius: 10,
            },

            title: {
                text: 'Organization Chart'
            },

            accessibility: {
                point: {
                    descriptionFormat: '{add index 1}. {toNode.name}' +
                        '{#if (ne toNode.name toNode.id)}, {toNode.id}{/if}, ' +
                        'reports to {fromNode.id}'
                }
            },

            series: [{
                type: 'organization',
                name: 'Kanaiya',
                keys: ['from', 'to'],
                data: [

                    ['Board of Director', 'Managing Director'],
                    ['Board of Director', 'Board Audit Committee'],
                    ['Board of Director', 'IT Steering Committee'],
                    ['Managing Director', 'General Manager'],
                    ['Board Audit Committee', 'Internal Audit  Manager'],
                    ['General Manager', 'Head of Finance'],
                    ['General Manager', 'Head of Operations'],
                    ['General Manager', 'Head of Business'],
                    ['IT Steering Committee', 'Head of IT'],
                    ['Head of Finance', 'Senior Finance Manager'],
                    ['Head of Operations', 'Branch Expansion Manager'],
                    ['Head of Operations', 'Human Resource Manager'],
                    ['Head of Operations', 'Sales & Marketing Manager'],
                    ['Head of Operations', 'Admin Manager'],
                    ['Head of Business', 'Business Development Manager'],
                    ['Head of IT', 'IT  Manager'],
                    ['Senior Finance Manager', 'Finance Manager'],
                    ['Finance Manager', 'Finance Controller'],
                    ['Finance Manager', 'Internal Auditor'],
                    ['Finance Controller', 'Senior Accountant'],
                    ['Finance Controller', 'Financial Accountant'],
                    ['Senior Accountant', 'Stock Controller'],
                    ['Senior Accountant', 'Junior Accountant'],
                    ['Senior Accountant', 'Cashier'],
                    ['Branch Expansion Manager', 'Assistant Expansion Manager'],
                    ['Human Resource Manager', 'Training Officer'],
                    ['Human Resource Manager', 'HR Executive'],
                    ['HR Executive', 'HR Officer'],
                    ['HR Officer', 'HR Assistant'],
                    ['Sales & Marketing Manager', 'Assistant Sales & Marketing Manager'],
                    ['Assistant Sales & Marketing Manager', 'Sales & Marketing Supervisor'],
                    ['Sales & Marketing Supervisor', 'Sales Representative'],
                    ['Admin Manager', 'Assistant Admin Manager'],
                    ['Assistant Admin Manager', 'Admin Supervisor'],
                    ['Admin Supervisor', 'Admin Staff'],
                    ['Business Development Manager', 'Business Development Officer'],
                    ['Business Development Manager', 'Business Strategy Officer'],
                    ['Business Development Manager', 'Business Risk Officer'],
                    ['Head of IT', 'Assistant  Manager (IT Operations)'],
                    ['Head of IT', 'Assistant  Manager (Application Support)'],
                    ['Assistant  Manager (IT Operations)', 'Sr Network Engineer'],
                    ['Assistant  Manager (IT Operations)', 'Network Engineer'],
                    ['Assistant  Manager (IT Operations)',
                        'Associated System & Network Support Engineer'
                    ],

                ],
                levels: [{
                    level: 0,
                    color: 'orange',
                    dataLabels: {
                        color: 'white',
                    },
                    height: 35
                }, {
                    level: 1,
                    color: 'silver',
                    dataLabels: {
                        color: 'black'
                    },
                    height: 35
                }, {
                    level: 2,
                    color: '#980104'
                }, {
                    level: 4,
                    color: '#359154'
                }],

                colorByPoint: false,
                color: '#007ad0',
                dataLabels: {
                    color: 'white'
                },
                borderColor: 'white',
                nodeWidth: 'auto'
            }],
            tooltip: {
                outside: true
            },
            credits: {
                enabled: false
            },
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: ["viewFullscreen"]
                    }
                }
            }
        });


        var pieChartCanvas = $('#taskChart').get(0).getContext('2d')
        var data = {
            labels: ['new', 'pending', 'complete', 'overdue'],
            datasets: [{
                data: [@json($newTaskCount), @json($pendingTaskCount), @json($completeTaskCount),
                    @json($overdueTaskCount)
                ],
                backgroundColor: ['#00c0ef', '#f39c12', '#00a65a', '#f56954']
            }]
        };
        var pieData = data;
        var pieOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }
        new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
        })
        var areaChartData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                    label: 'Digital Goods',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [28, 48, 40, 19, 86, 27, 90]
                },
                {
                    label: 'Electronics',
                    backgroundColor: 'rgba(210, 214, 222, 1)',
                    borderColor: 'rgba(210, 214, 222, 1)',
                    pointRadius: false,
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data: [65, 59, 80, 81, 56, 55, 40]
                },
            ]
        }
        var saleData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                    label: 'Face Serum',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [1028, 1448, 3140, 1219, 3386, 2317, 1917]
                },
                {
                    label: 'Shower Gel',
                    backgroundColor: 'rgba(77, 114, 232, 1)',
                    borderColor: 'rgba(77, 114, 114, 1)',
                    pointRadius: false,
                    pointColor: 'rgba(77, 114, 114, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,320,20,1)',
                    data: [8126, 5129, 8101, 2811, 5361, 5225, 3240]
                },
                {
                    label: 'Liquid Foundation',
                    backgroundColor: 'rgba(10, 214, 22, 1)',
                    borderColor: 'rgba(10, 214, 22, 1)',
                    pointRadius: false,
                    pointColor: 'rgba(10, 214, 22, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(210,120,220,1)',
                    data: [1138, 2199, 3380, 5141, 10056, 7515, 6430]
                },
                {
                    label: 'Creampact Powder',
                    backgroundColor: 'rgba(210, 214, 22, 1)',
                    borderColor: 'rgba(210, 214, 22, 1)',
                    pointRadius: false,
                    pointColor: 'rgba(210, 214, 22, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,120,1)',
                    data: [3615, 1359, 2180, 3181, 5156, 4525, 3430]
                },
                {
                    label: 'Facewash',
                    backgroundColor: 'rgba(20, 214, 222, 1)',
                    borderColor: 'rgba(20, 214, 222, 1)',
                    pointRadius: false,
                    pointColor: 'rgba(20, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,120,220,1)',
                    data: [1615, 2519, 3801, 4381, 5516, 6545, 7410]
                },
                {
                    label: 'Lotion',
                    backgroundColor: 'rgba(221, 111, 123, 1)',
                    borderColor: 'rgba(221, 111, 123, 1)',
                    pointRadius: false,
                    pointColor: 'rgba(221, 111, 123, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(120,220,220,1)',
                    data: [1465, 2259, 3810, 1281, 1561, 8229, 1140]
                },

            ]
        }


        var stackedBarChartCanvas = $('#saleChart').get(0).getContext('2d')
        var stackedBarChartData = $.extend(true, {}, saleData)
        stackedBarChartData.datasets[0] = saleData.datasets[0]
        stackedBarChartData.datasets[1] = saleData.datasets[1]
        stackedBarChartData.datasets[2] = saleData.datasets[2]
        stackedBarChartData.datasets[3] = saleData.datasets[3]
        stackedBarChartData.datasets[4] = saleData.datasets[4]
        stackedBarChartData.datasets[5] = saleData.datasets[5]



        var stackedBarChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }

        new Chart(stackedBarChartCanvas, {
            type: 'bar',
            data: stackedBarChartData,
            options: stackedBarChartOptions
        })

        $(document).ready(function() {

            $('.product-image-thumb').on('click', function() {
                var $image_element = $(this).find('img')
                $('.product-image').prop('src', $image_element.attr('src'))
                $('.product-image-thumb.active').removeClass('active')
                $(this).addClass('active')
            })
        })
    </script>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection
