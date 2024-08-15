@extends('layout.main')
@section('title', 'Head Office List')
@section('content')
@section('selected', 'hos')





<div class="row m-2">

    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Category Portion Remain.....</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if(session()->has('message'))
                <div class="alert alert-success">
                    <div id="infoText">
                    {{ session()->get('message') }}

                    </div>
                </div>
            
                @endif
                <div class="filter-container p-0 row">

                    @foreach ($products as $product)
                        @if (!empty($helper->getProductImage($product->id)->image_url))
                            <div class="filtr-item col-sm-3 border border-info  p-2" data-category="1"
                                data-sort="white sample" align="center" style="border-radius:15px;">

                                <img src="{{ $helper->getProductImage($product->id)->image_url }}"
                                    style="display:inline-block;max-height:100px; max-width:100px; border-radius:15px; border:1px;">
                                <div style="min-height: 70px;text-align:center;border:3px;"
                                    class="text-center text-wrap fs-5">
                                    {{ $product->name }}

                                </div>
                                <div class="text-center font-weight-bolder">
                                    ${{ $product->price }}</p>

                                </div>
                                <form id="itemFrom" role="form" method="POST" action="{{ route('stock.update',$product->id) }}">
                                    @csrf
                                    @isset($product)
                                    @method('PUT')
                                    @endisset
                                    <table>
                                        <tbody>
                                            @foreach(config('app.selling') as $title => $value)
                                            <tr>
                                            <td colspan="2" class="text-left badge badge-info">
                                                {{$title}}
                                            </td>
                                            </tr>
                                            <tr>
                                                <td >
                                                    Selling Price
                                                </td>
                                                <td>
                                                    
                                                    <?php $price = $helper->getPrice($value,$product->s_id); if(empty($price))$price = 0.00; ?>
                                                    <input type="number" class="form-control col-md-12" id="{{$title}}" name="{{$title}}" value="{{ $price[0]->selling_price ?? '0' }}">
                                                </td>
                                            </tr>
                                            @endforeach

                                            {{-- <tr>
                                                <td colspan="2" class="text-left badge badge-info">
                                                    Retail
                                                </td>
                                            </tr>
                                            <tr>
                                                <td >
                                                    Selling Price
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control col-md-12" id="retail_selling_price" name="retail_selling_price" value="{{ $product->s_price ?? '0' }}">
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td colspan="2" class="text-left  badge badge-warning">
                                                    Reseller
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Selling Price
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control col-md-12" id="reseller_selling_price" name="reseller_selling_price" value="{{ $product->s_price ?? '0' }}">
                                                </td>
                                            </tr>
                                            <hr/>
                                            <tr>
                                                <td colspan="2" class="text-left  badge badge-success">
                                                    Wholesales
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Selling Price
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control col-md-12" id="wholesales_selling_price" name="wholesales_selling_price" value="{{ $product->s_price ?? '0' }}">
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <td>
                                                    Quantity
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control col-md-12" id="qty" name="qty" value="{{ $product->s_qty ?? '0' }}">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                   
                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-arrow-circle-up"></i>
                                            <span>Update Prices</span>
                                         
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
  
</script>
@push('scripts')
@endpush
@endsection
