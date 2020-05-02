<div>

    <div>
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">@lang('categories.columns.name')</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{$category->name ?? ''}}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="description" class="col-md-4 col-form-label text-md-right">@lang('categories.columns.description')</label>

            <div class="col-md-6">
                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                    name="description" value="{{$category->description ?? ''}}" required autocomplete="description"
                    autofocus>

                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>



        </div>
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <a class="btn btn-secondary"
                   href="{{route('categories.index')}}">{{__('actions.options.button.return')}}</a>
                <button type="submit" class="btn btn-primary">
                    {{$type=='create'? __('actions.create.action'): __('actions.edit.action')}}
                </button>
            </div>
        </div>
    </div>
</div>
