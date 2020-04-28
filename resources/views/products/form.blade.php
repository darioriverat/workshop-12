<div>

    <div>
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('tables.name') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{$product->name ?? ''}}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="description"
                class="col-md-4 col-form-label text-md-right">{{ __('tables.description') }}</label>

            <div class="col-md-6">
                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                    name="description" value="{{$product->description ?? ''}}" required autocomplete="description"
                    autofocus>

                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('tables.price') }}</label>

            <div class="col-md-6">
                <input id="price" type="float" class="form-control @error('price') is-invalid @enderror" name="price"
                    value="{{$product->price ?? ''}}" required autocomplete="price" autofocus>

                @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="currency" class="col-md-4 col-form-label text-md-right">{{ __('tables.currency') }}</label>

            <div class="col-md-6">
                <select value="" name="currency" id="currency"
                    class="form-control @error('currency') is-invalid @enderror" required autocomplete="currency"
                    autofocus>
                    <option value="">-- @lang('actions.options.combobox.default') --</option>
                    <option {{$product->currency ?? '' =='COP' ? ' selected ':''}} value="COP">{{__('currencys.cop')}}
                    </option>
                    <option {{$product->currency ?? ''=='USD' ? ' selected ':''}} value="USD">{{__('currencys.usd')}}
                    </option>
                </select>
                @error('currency')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="category" class="col-md-4 col-form-label text-md-right">{{ __('tables.category') }}</label>
            <div class="col-md-6">
                <select value="{{$product->category ?? ''}}" name="category_id" id="category"
                    class="form-control @error('category_id') is-invalid @enderror" required autocomplete="category_id"
                    autofocus>
                    <option value="">-- @lang('actions.options.combobox.default') --</option>
                    @foreach ($categories as $category)
                    <option {{ $product->category_id ?? ''== $category->id ? ' selected ':''}}
                        value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="photo" class="col-md-4 col-form-label text-md-right">{{ __('tables.photo') }}</label>

            <div class="col-md-6">
                @if(isset($product->photo))
                <img src="{{ asset('storage').'/'.$product->photo}}" alt="" width="100">
                @endif

                <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo"
                    accept="image/png, image/jpeg" value="{{$product->photo ?? ''}}" autocomplete="photo" autofocus>

                @error('photo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{$type=='create'? __('actions.create.action'): __('actions.edit.action')}}
                </button>
            </div>
        </div>
    </div>

</div>