@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('actions.edit.action')
                    @lang('categories.singular')</div>
                <div class="card-body">
                    <form action="{{route('categories.update', $category['id'])}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        {{method_field('PATCH')}}
                        @include('categories.form', ['type'=>'editar'])

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
