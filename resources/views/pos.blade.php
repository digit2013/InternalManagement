@extends('layout.main')
@section('title', 'Head Office List')
@section('content')
@section('selected', 'hos')



<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>


<div class="row m-2">

    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Category Portion Remain.....</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

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
                                <div>
                                    <a href="{{ url('add-to-cart/' . $product->id) }}"
                                        class="btn btn-warning btn-block text-center "
                                        style="color: #fff;font-weight:bolder;" role="button">Add to cart</a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

            </div>

            {{-- <div class="position-relative p-1"
                style="min-height: 200px;text-align:center;border:3px;">
                <img src="{{ $helper->getProductImage($product->id)->image_url }}"
                    style="display:inline-block;max-height:100px; max-width:100px; border-radius:15px; border:1px;">

                <div class="mx-auto my-0 flex w-auto flex-col-reverse"
                    style="font-weight:bold; font-size:smaller;">

                    {{ $product->name }}
                </div>
                <div class="mx-auto my-0 flex w-auto flex-col-reverse"
                style="font-weight:bold; font-size:smaller;">
                    <p class="font-semibold"
                style="font-weight:bold; font-size:medium;margin-bottom:0px!important;">
                ${{ $product->price }}</p>
            </div>

            </div>
           
            <div class="mx-auto my-0 flex w-auto flex-col-reverse"
            style="font-weight:bold; font-size:smaller;">
            <a href="{{ url('add-to-cart/' . $product->id) }}"
                class="btn btn-warning btn-block text-center "
                style="color: #fff;font-weight:bolder;" role="button">Add to cart</a>
                                                    </div>
                                                     --}}
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-primary">

            <div class="card-body">

                <table id="cart" class="table table-bordered table-hover table-condensed mt-3">
                    <thead>
                        <tr>
                            <th style="width:50%">Product</th>
                            <th style="width:8%">Quantity</th>
                            <th style="width:22%" class="text-center">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $total = 0; ?>                                    
                       

                        @if (session('cart'))
                            @foreach (session('cart') as $id => $details)
                                <?php $total += $details['price'] * $details['quantity']; ?>

                                <tr>
                                    <td data-th="Product">
                                        <div class="row">
                                            <div class="col-sm-4 hidden-xs"><img
                                                    src="{{ $helper->getProductImage($id)->image_url }}" width="50"
                                                    height="" class="img-responsive" style="border-radius:15px;" />

                                            </div>

                                            <div class="col-sm-8">
                                                <p class="nomargin">{{ $details['name'] }}</p>
                                                <a class="btn btn-danger remove-from-cart" data-id="{{ $id }}"
                                                    title="Delete">Remove</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-th="Quantity">
                                        <input type="number"  value="{{ $details['quantity'] }}" data-id="{{$id}}"
                                            class="form-control quantity"  />
                                        <div class="row">
                                            <div class="col-sm-6 text-right mt-1">

                                                <a href="{{ url('minus-to-cart/' . $id) }}" class=" btn-warning "
                                                    role="button"> <i class="fa fa-minus"> </i></a>

                                            </div>
                                            <div class="col-sm-6 text-right mt-1">

                                                <a href="{{ url('add-to-cart/' . $id) }}" class=" btn-warning "
                                                    role="button"> <i class="fa fa-plus"> </i></a>

                                            </div>
                                        </div>
                                    </td>
                                    <td data-th="Subtotal" class="text-center">
                                        ${{ $details['price'] * $details['quantity'] }}</td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                    <tfoot>
                        
                        @if (!empty($details))
                            <tr class="visible-xs">
                                <td class="text-right" colspan="2"><strong>Total</strong></td>
                                <td class="text-center"> ${{ $total }}</td>
                            </tr>
                        @else
                            <tr>
                                <td class="text-center" colspan="3">Your Cart is Empty.....</td>
                            <tr>
                        @endif
                          <tr class="visible-xs">
                            <td class="text-right" colspan="2"><strong>Discount</strong></td>
                            <td class="text-center">
                                <?php $discounts=$helper->getDiscounts();?>
                                @if((isset($discounts))&&(!empty($discounts)))
                                <select class="form-control" name="discounts" id="discounts" style="font-size: smaller;">
                                    <option value="">- Discount -</option>
                                    @foreach ($discounts as $data)
                                    <option  value="{{$data->amount}}" >
                                        {{$data->name}}( {{($data->type == 1 ? "$":"")}}{{$data->amount}} {{($data->type == 2 ? "%":"")}}) 
                                    </option>
                                   @endforeach
                                </select>
                                @endif
                                </div>
                            </td>
                        </tr>
                        @if (!empty($details))
                        <tr class="visible-xs">
                            <td class="text-right" colspan="2"><strong>Grand Total</strong></td>
                            <td class="text-center"> <p id="gt">${{ $total }}</p></td>
                        </tr>
                        @else
                            <tr>
                                <td class="text-center" colspan="3">-</td>
                            <tr>
                        @endif
                    </tfoot>

                </table>
            </div>
        </div>

    </div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $("input[type='number']").on("change", function() {
        $.ajax({
            url: "custom-to-cart/" +$(this).data("id")+"/"+this.value,
            type: "GET",
            success: function(result) {
                if(result){
                    location.reload();
                }
            }
        });

    });
    $(document).ready(function () {
        var gtotal = 0;
        $('#discounts').on('change', function () {
            // if(this.data('id')==1){
            //     gtotal = JSON.parse("{{ json_encode($total) }}") - this.value;
            // }
            // else if(this.data('id')==2){
            //     gtotal = JSON.parse("{{ json_encode($total) }}") - ((JSON.parse("{{ json_encode($total) }}")*this.value)/100);
            // }
            // else{
            //     gtotal = JSON.parse("{{ json_encode($total) }}");
            // }
            if($("#discounts option:selected").text().includes("$")){
                gtotal = JSON.parse("{{ json_encode($total) }}") - this.value;
            }
            else if($("#discounts option:selected").text().includes("%")){
                gtotal = JSON.parse("{{ json_encode($total) }}") - ((JSON.parse("{{ json_encode($total) }}")*this.value)/100);
            }else{
                gtotal = JSON.parse("{{ json_encode($total) }}");
            }
            $('#gt').html("$"+gtotal);
        });



        });
    $(".remove-from-cart").click(function(e) {
        e.preventDefault();

        var ele = $(this);

        if (confirm("Are you sure want to remove product from the cart.")) {
            $.ajax({
                url: '{{ url("remove-from-cart") }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.attr("data-id")
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        }
    });
</script>
@push('scripts')
@endpush
@endsection
