@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1>@lang('categories.title')</h1>
                        </div>
                        <div class="col-sm-4 pt-2 text-right" style="vertical-align: middle;">
                            <a class="btn btn-primary"
                               href="{{route('categories.create')}}"> @lang('actions.create.action') {{trans_choice('categories.name',2)}}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="thead">
                        <tr>
                            <th>@lang('categories.columns.name')</th>
                            <th>@lang('categories.columns.description')</th>
                            <th>@lang('categories.columns.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{$category->name}}</td>
                                <td>{{$category->description}}</td>
                                <td style="vertical-align: middle;">
                                    <div class="form-group row" style="width: max-content;">
                                        <div>
                                            <a href="{{route('categories.edit',$category->id)}}"
                                               class="btn btn-secondary m-1">@lang('actions.edit.action')</a>
                                        </div>
                                        <div>
                                            <form method="post"
                                                  action="{{ route('categories.destroy', $category->id)}}">
                                                {{csrf_field()}}
                                                {{method_field('DELETE')}}
                                                <button class="btn btn-primary m-1" type="submit"
                                                        onclick="return confirm('{{$category->name}}');">@lang('actions.delete.action')</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if(count($categories)==0)
                            <tr>
                                <td colspan="6">@lang('categories.columns.notFound')</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <div class="form-group row  justify-content-center">
                        {!!$categories->render()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
