<div>

    <div>
        <div class="form-group row">
            <div class="card">
                @if($product->photo)
                    <img class="card-img-top" style="width: 35%; align-self: center;" src="{{ asset('storage').'/'.$product->photo}}" alt="" width="100">
                @else
                    <img class="card-img-top" style="width: 35%; align-self: center;" src="{{asset('img/no-image-icon.png')}}" alt="" width="100">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{$product->name}}</h5>
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="card-text"><b>@lang('orders.columns.category')</b> : {{$product->category->name}}
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="card-text"><b>@lang('orders.columns.description')</b> : {{$product->description}}
                            </p>
                        </div>
                        <div class="col-sm-12">
                            <p class="card-text"><b>@lang('orders.columns.price')</b> :
                                {{number_format($product->price, 2).' ' .$product->currency}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <input id="product_id" hidden type="number" step="1"
                   class="form-control @error('product_id') is-invalid @enderror" name="product_id"
                   placeholder="Cantidad"
                   value="{{$product->id ?? ''}}" autocomplete="product_id" autofocus>
            <label for="country"
                   class="col-md-2 col-form-label text-md-right">{{ __('orders.columns.paymentCountry') }}</label>
            <div class="col-md-4">
                <select value="" name="country" id="country" class="form-control @error('country') is-invalid @enderror"
                        required autocomplete="country" autofocus>
                    <option value="">-- @lang('actions.options.combobox.default') --</option>
                    <option {{$product->country ?? '' =='co' ? ' selected ':''}} value="co"> @lang('countries.CO')
                    </option>
                    <option {{$product->country ?? ''=='ec' ? ' selected ':''}} value="ec"> @lang('countries.EC')
                    </option>
                </select>
                @error('country')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="col-md-6">
                <input id="quantity" type="number" step="1" class="form-control @error('quantity') is-invalid @enderror"
                       name="quantity" placeholder="{{__('orders.columns.quantity')}}" value="1" required
                       autocomplete="quantity" autofocus>
                @error('quantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-0 justify-content-center">
            <a class="btn btn-secondary"
               href="{{route('orders.index')}}">{{__('actions.options.button.return')}}</a>

            <button type="submit" class="mx-5 btn btn-primary">
                {{ __('orders.action')}}
            </button>
        </div>

    </div>
</div>
