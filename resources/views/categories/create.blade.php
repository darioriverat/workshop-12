@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> @lang('actions.create.action') {{trans_choice('categories.name',2)}}</div>
                <div class="card-body">
                    <form action="{{route('categories.store')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        @include('categories.form', ['type'=>'create'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
