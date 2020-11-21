@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-center">
                            <h1>{{__('orders.title')}}</h1>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped">
                            <thead class="thead">
                            <tr>
                                <th>@lang('orders.columns.photo')</th>
                                <th>@lang('orders.columns.name')</th>
                                <th>@lang('orders.columns.date')</th>
                                <th>@lang('orders.columns.paymentAmount')</th>
                                <th>@lang('orders.columns.status')</th>
                                <th>@lang('orders.columns.pay')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        @if($order->photo)
                                            <img src="{{ asset('storage').'/'.$order->product->photo}}" alt=""
                                                 width="100">
                                        @else
                                            <img src="{{asset('img/no-image-icon.png')}}" alt="" width="100">
                                        @endif
                                    </td>
                                    <td>{{$order->product->name}}</td>
                                    <td>{{$order->created_at}}</td>
                                    <td>{{number_format($order->payment_amount, 2)}} {{$order->product->currency->alpha_code}}</td>
                                    <td>
                                        @if($order->status =='CREATED')@lang('status.created')
                                        @elseif($order->status =='REJECTED')@lang('status.rejected')
                                        @elseif($order->status =='PAYED')@lang('status.payed')
                                        @else @lang('states.pending')
                                        @endif
                                        @if($order->country =='co')@lang('countries.CO')
                                        @else @lang('countries.EC')
                                        @endif
                                    </td>
                                    <td>
                                        <div class="form-group row" style="width: max-content;">
                                            <a href="{{url('orders/'.$order->id)}}"
                                               class="btn btn-secondary m-2">@lang('actions.summary.action')</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if(count($orders)==0)
                                <tr>
                                    <td colspan="6">@lang('orders.columns.notFound')</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>

                        <div class="form-group row  justify-content-center">
                            {!!$orders->render()!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
