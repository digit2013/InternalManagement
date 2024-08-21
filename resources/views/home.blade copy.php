@extends('layout.main')
@section('title', 'User Management')
@section('content')
@section('Home', 'active')
<section id="contact" class="contact">
    <div class="container-fluid mt-3" data-aos="fade-in">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-2">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="far fa-building nav-icon"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Departments</span>
                        <span class="info-box-number">
                            {{ $deptCount }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-2">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Users</span>
                        <span class="info-box-number">{{ $helper->getTopWidget()[0]['userCount'] }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-2">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-warehouse"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Warehouse</span>
                        <span class="info-box-number">
                            {{ $branchCount }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-2">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-tag"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Products</span>
                        <span class="info-box-number">
                            {{ $helper->getTopWidget()[0]['productCount'] }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-2">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Sales</span>
                        <span class="info-box-number">76,000</span>
                    </div>
                </div>
            </div>

            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-2">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="far fa-calendar-alt"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Overdue Task</span>
                        <span class="info-box-number">{{ $helper->getTopWidget()[0]['overdueTaskCount'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="ion ion-clipboard mr-1"></i>
                            My Task
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
                                                    id="id" name="id"
                                                    value="{{ $taskd->id }}">
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
            <div class="col-md-6">
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
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="taskChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 466px;"
                            width="466" height="250" class="chartjs-render-monitor"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Products</h3>
                        <div class="card-tools">
                            <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-download"></i>
                            </a>
                            <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-bars"></i>
                            </a>
                        </div>
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
                                    <th>Stock</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stocks as $stock)
                                <tr>
                                    <td>
                                        <img src="{{ $helper->getProductImage($stock->id)[0]->image_url }}"
                                            alt="{{ $stock->name }}" class="img-circle img-size-32 mr-2">
                                        {{ $stock->name }}
                                    </td>
                                    <td>
                                        {{ $stock->sqty }}

                                        @if ($stock->sqty == 0)
                                        <small class="text-success mr-1">
                                            <span class="badge bg-danger">Out of Stock</span>
                                        </small>
                                        @elseif($stock->sqty < 10)
                                            <small class="text-success mr-1">
                                            <span class="badge bg-warning">Back in Stock</span>
                                            </small>
                                            @endif
                                    </td>
                                    <td>
                                        <a class="dropdown-item" role="button" data-toggle="modal"
                                            data-target="#stock-{{ $stock->id }}">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </td>
                                    <div class="modal fade" id="stock-{{ $stock->id }}">
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
                                                            <h3 class="d-inline-block d-sm-none">{{ $stock->name }}
                                                            </h3>
                                                            <?php $prod_img = $helper->getProductImage($stock->id);
                                                            $i = 0; ?>

                                                            <div class="col-12">
                                                                <img src="{{ $prod_img[0]->image_url }}"
                                                                    class="product-image" alt="Product Image">
                                                            </div>
                                                            <div class="col-12 product-image-thumbs">
                                                                @foreach ($prod_img as $pimg)
                                                                @if ($i == 0)
                                                                <div class="product-image-thumb active"><img
                                                                        src="{{ $pimg->image_url }}"
                                                                        alt="{{ $stock->name }}"></div>
                                                                @else
                                                                <div class="product-image-thumb "><img
                                                                        src="{{ $pimg->image_url }}"
                                                                        alt="{{ $stock->name }}"></div>
                                                                @endif
                                                                <?php $i++; ?>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <h3 class="my-3">{{ $stock->name }}</h3>
                                                            <h4>
                                                                <p class="badge badge-success">{{ $stock->cname }}</p>
                                                            </h4>

                                                            <hr>


                                                            <h4 class="mt-3"> <small>Selling Price</small></h4>
                                                            <div class="btn-group btn-group-toggle"
                                                                data-toggle="buttons">
                                                                <div class="row d-flex">
                                                                    @foreach (config('app.selling') as $t => $v)
                                                                    <label class="btn btn-default text-center">
                                                                        <span class="text-xl">
                                                                            <?php $price = $helper->getPrice($v, $stock->sid);
                                                                            if (empty($price)) {
                                                                                $price = 0.0;
                                                                            } ?>
                                                                            ${{ $price[0]->selling_price ?? '0' }}
                                                                        </span>
                                                                        <br>
                                                                        {{ $t }}
                                                                    </label>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <hr />
                                                            <div class=" badge badge-info rounded">
                                                                <h2 class="mb-0">
                                                                    In stock : <small>{{ $stock->sqty }}</small> units
                                                                </h2>
                                                            </div>
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
                                                                {!! $stock->description !!}</div>
                                                            <div class="tab-pane fade" id="product-comments"
                                                                role="tabpanel"
                                                                aria-labelledby="product-comments-tab">
                                                                {!! $stock->description !!}</div>
                                                            <div class="tab-pane fade" id="product-rating"
                                                                role="tabpanel" aria-labelledby="product-rating-tab">
                                                                {!! $stock->description !!}</div>
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
            <div class="col-md-6">
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Sales Based Category</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="saleChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="card-title">Assigned Tasks(Pending)</h3>
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
                        <h3 class="card-title">Assigned Tasks(Overdue)</h3>
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
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="card-title">Assigned Tasks(Complete)</h3>
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
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="info-box mb-3 bg-warning">
                            <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Inventory</span>
                                <span class="info-box-number">5,200</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <div class="info-box mb-3 bg-success">
                            <span class="info-box-icon"><i class="far fa-heart"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Mentions</span>
                                <span class="info-box-number">92,050</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <div class="info-box mb-3 bg-danger">
                            <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Downloads</span>
                                <span class="info-box-number">114,381</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <div class="info-box mb-3 bg-info">
                            <span class="info-box-icon"><i class="far fa-comment"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Direct Messages</span>
                                <span class="info-box-number">163,921</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Top 5 Retailer</h3>

                        <div class="card-tools">
                            <span class="badge badge-danger">Last Month - Top 5 Retailer</span>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <style>
                        .users-list>li {
                            float: left;
                            padding: 10px;
                            text-align: center;
                            width: 20% !important;
                        }
                    </style>
                    <div class="card-body p-0">
                        <ul class="users-list clearfix">
                            <li>
                                <img src="dist/img/user1-128x128.jpg" alt="User Image">
                                <a class="users-list-name" href="#">Alexander Pierce</a>
                                <span class="users-list-date">$77,900</span>
                            </li>
                            <li>
                                <img src="dist/img/user8-128x128.jpg" alt="User Image">
                                <a class="users-list-name" href="#">Norman</a>
                                <span class="users-list-date">$71,010</span>
                            </li>
                            <li>
                                <img src="dist/img/user7-128x128.jpg" alt="User Image">
                                <a class="users-list-name" href="#">Jane</a>
                                <span class="users-list-date">$60,100</span>
                            </li>
                            <li>
                                <img src="dist/img/user6-128x128.jpg" alt="User Image">
                                <a class="users-list-name" href="#">John</a>
                                <span class="users-list-date">$53,000</span>
                            </li>
                            <li>
                                <img src="dist/img/user2-160x160.jpg" alt="User Image">
                                <a class="users-list-name" href="#">Alexander</a>
                                <span class="users-list-date">$39,190</span>
                            </li>
                        </ul>
                        <!-- /.users-list -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <a href="javascript:">View All Retailer Records</a>
                    </div>
                    <!-- /.card-footer -->
                </div>
            </div>
            <div class="col-md-3">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Monthly Project Timeline</h5>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-wrench"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <a href="#" class="dropdown-item">Action</a>
                                    <a href="#" class="dropdown-item">Another action</a>
                                    <a href="#" class="dropdown-item">Something else here</a>
                                    <a class="dropdown-divider"></a>
                                    <a href="#" class="dropdown-item">Separated link</a>
                                </div>
                            </div>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">

                            <!-- /.col -->
                            <div class="col-md-12">
                                <p class="text-center">
                                    <strong>Goal Completion</strong>
                                </p>

                                <div class="progress-group">
                                    Phase 1
                                    <span class="float-right"><b>160</b>/200</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary" style="width: 80%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->

                                <div class="progress-group">
                                    Phase 2
                                    <span class="float-right"><b>310</b>/400</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" style="width: 75%"></div>
                                    </div>
                                </div>

                                <!-- /.progress-group -->
                                <div class="progress-group">
                                    <span class="progress-text">Phase 3</span>
                                    <span class="float-right"><b>480</b>/800</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" style="width: 60%"></div>
                                    </div>
                                </div>

                                <!-- /.progress-group -->
                                <div class="progress-group">
                                    Phase 4
                                    <span class="float-right"><b>250</b>/500</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" style="width: 50%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- ./card-body -->
                    <div class="card-footer">

                    </div>
                    <!-- /.card-footer -->
                </div>
            </div>

        </div>

        <div class="row">
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
    </div>
    </div>
    <div class="modal fade" id="orgChart">
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
                    <script src="orgChart/js/highcharts.js"></script>
                    <script src="orgChart/js/modules/sankey.js"></script>
                    <script src="orgChart/js/modules/organization.js"></script>
                    <script src="orgChart/js/modules/exporting.js"></script>
                    <script src="orgChart/js/modules/accessibility.js"></script>
                    <style>
                        .highcharts-figure,
                        .highcharts-data-table table {
                            min-width: -webkit-fill-available;
                            max-width: -webkit-fill-available;
                            margin: 5px auto !important;
                        }

                        .highcharts-data-table table {
                            font-family: Verdana, sans-serif;
                            border-collapse: collapse;
                            border: 1px solid #ebebeb;
                            margin: 5px auto;
                            text-align: center;
                            width: 100%;
                            max-width: 900px;
                        }

                        .highcharts-data-table caption {
                            padding: 0.5em 0;
                            font-size: 0.5em;
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

                        #orgChartContainer div {
                            min-height: -webkit-fill-available;
                            position: inherit;
                        }

                        #orgChartContainer h4 {
                            text-transform: none;
                            font-size: 12px !important;
                            font-weight: normal;
                            text-wrap: wrap;
                        }

                        #orgChartContainer p {
                            font-size: 10px !important;
                            line-height: 16px;
                        }

                        @media screen and (max-width: 600px) {
                            #orgChartContainer h4 {
                                font-size: 11px !important;
                                line-height: 3vw;
                            }

                            #orgChartContainer p {
                                font-size: 11px !important;
                                line-height: 3vw;
                            }
                        }
                    </style>
                    <figure class="highcharts-figure">
                        <div id="orgChartContainer"></div>
                    </figure>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="orgChat/css/style.css">

    <link rel="stylesheet" href="orgChat/css/treeData.min.css">
    <div class="row">
        <div class="col-md-12">
            <div id="container">
                <div id="tree"></div>
            </div>
        </div>
    </div>
    <script src="{{ url('plugins/chart.js/Chart.min.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="orgChat/js/treeData.js"></script>

    <script>
        var tree = {
            zelda: {
                value: "Zelda Timeline",
                parent: ""
            },
            1: {
                value: "Skyward Sword",
                parent: "zelda"
            },
            2: {
                value: "The Minish Cap",
                parent: "a"
            },
            3: {
                value: "Four Swords",
                parent: "b"
            },
            4: {
                value: "Ocarina of Time",
                parent: "c"
            },
            5: {
                value: "A link to Past",
                parent: "d"
            },
            6: {
                value: "Oracle of Seasons & Oracle of Ages",
                parent: "e"
            },
            7: {
                value: "Link's Awakening",
                parent: "f"
            },
            8: {
                value: "The Legend of Zelda",
                parent: "g"
            },
            9: {
                value: "Adventure of Link",
                parent: "h"
            },
            10: {
                value: "Majora's Mask",
                parent: "d"
            },
            11: {
                value: "Twilight Princess",
                parent: "j"
            },
            12: {
                value: "Four Swords",
                parent: "k"
            },
            13: {
                value: "The Wind Waker",
                parent: "d"
            },
            14: {
                value: "Phanthom Hourglass",
                parent: "m"
            },
            15: {
                value: "Spirit Tracks",
                parent: "n"
            }

        };

        TreeData(tree, "#tree");


        Highcharts.chart('orgChartContainer', {
            chart: {
                height: 600,
                inverted: true
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
                    height: 25
                }, {
                    level: 1,
                    color: 'silver',
                    dataLabels: {
                        color: 'black'
                    },
                    height: 25
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
            exporting: {
                allowHTML: true,
                sourceWidth: 800,
                sourceHeight: 600
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