@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">

            <div class="card" style="width: -webkit-fill-available;">
                <div class="card-header">
                    <div class="row justify-content-left">
                        <div class="col-sm-8">
                            <h1>@lang('products.title')</h1>
                        </div>
                        <div class="col-sm-4 pt-2 text-right" style="vertical-align: middle;">
                            <a class="btn btn-primary"
                               href="{{route('products.create')}}">@lang('actions.create.action')
                                {{trans_choice('products.name',2)}}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="thead">
                        <tr>
                            <th>@lang('products.columns.photo')</th>
                            <th>@lang('products.columns.name')</th>
                            <th>@lang('products.columns.category')</th>
                            <th>@lang('products.columns.description')</th>
                            <th>@lang('products.columns.price')</th>
                            <th>@lang('products.columns.created_by')</th>
                        </tr>
                        </thead>
                        <tbody>


                        <tr>
                            <td>
                                @if($product->photo)
                                    <img src="{{ asset('storage').'/'.$product->photo}}" alt="" width="100">
                                @else
                                    <img src="{{asset('img/no-image-icon.png')}}" alt="" width="100">
                                @endif

                            </td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->category_name}}</td>
                            <td>{{$product->description}}</td>
                            <td>{{number_format($product->price, 2)}} {{$product->currency_code}}</td>

                            <td>
                                {{ $product->created_by }}
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
