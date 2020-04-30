@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-left">
                        <div class="col-sm-8">
                            <h1>@lang('products.title')</h1>
                        </div>
                        <div class="col-sm-4">
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
                                <th>@lang('products.columns.description')</th>
                                <th>@lang('products.columns.price')</th>
                                <th>@lang('products.columns.actions')</th>
                            </tr>
                        </thead>
                        <tbody>

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
                                        <a href="{{url('products/'.$product->id.'/edit')}}"
                                            class="btn btn-secondary m-2">@lang('actions.edit.action')</a>

                                        <form method="post" action="{{url('products/'.$product->id)}}">

                                            {{csrf_field()}}
                                            {{method_field('DELETE')}}
                                            <button class="btn btn-primary m-2" type="submit"
                                                onclick="return confirm( '{{$product->name}}');">@lang('actions.delete.action')</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @if(count($products)==0)
                            <tr>
                                <td colspan="6">@lang('products.columns.notFound')</td>
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
