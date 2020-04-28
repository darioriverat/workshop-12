@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-center">
                        <div class="col-sm-8">
                            <h1>@lang('orders.singular')</h1>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="thead">
                            <tr>
                                <th>@lang('tables.photo')</th>
                                <th>@lang('tables.country')</th>
                                <th>@lang('tables.paymentAmount')</th>
                                <th>@lang('tables.state')</th>
                                <th>@lang('tables.pay')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>
                                    @if($order->photo)
                                    <img src="{{ asset('storage').'/'.$order->photo}}" alt="" width="100">
                                    @else
                                    <img src="{{asset('img/no-image-icon.png')}}" alt="" width="100">
                                    @endif

                                </td>
                                <td> @if($order->country =='co')@lang('countries.CO')
                                    @else @lang('countries.EC')
                                    @endif</td>
                                <td>{{number_format($order->paymentAmount, 2)}} {{$order->currency}}</td>
                                <td>
                                    @if($order->status =='CREATED')@lang('states.created')
                                    @elseif($order->status =='REJECTED')@lang('states.rejected')
                                    @elseif($order->status =='PAYED')@lang('states.payed')
                                    @else @lang('states.pending')
                                    @endif
                                </td>
                                <td>
                                    <div class="form-group row">

                                        <a href="{{url('orders/'.$order->id)}}"
                                            class="btn btn-secondary m-2">@lang('actions.summary.action')</a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @if(count($orders)==0)
                            <tr>
                                <td colspan="6">@lang('tables.notFound')</td>
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