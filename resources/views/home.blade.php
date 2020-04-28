@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('home.title')</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="thead">
                            <tr>
                                <th>@lang('tables.photo')</th>
                                <th>@lang('tables.name')</th>
                                <th>@lang('tables.description')</th>
                                <th>@lang('tables.price')</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($products)>0)
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    @if($product->photo)
                                    <img src="{{ asset('storage').'/'.$product->photo}}" alt="" width="100">
                                    @else
                                    <img src="{{asset('img/no-image-icon.png')}}" alt="" width="100">
                                    @endif
                                </td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->description}}</td>
                                <td>{{number_format($product->price, 2)}} {{$product->currency}}</td>
                                <td>
                                    <div class="form-group row">
                                        <a class="btn btn-primary m-2"
                                            href="{{url('/orders/create/'.$product->id)}}">@lang('home.action')</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6">@lang('tables.notFound')</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="form-group row  justify-content-center">
                        {!!$products->render()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection