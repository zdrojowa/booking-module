@extends('DashboardModule::dashboard.index')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('DashboardModule::partials.alerts')

                        <h4 class="card-title">
                            {{ isset($booking) ? 'Edytowanie' : 'Dodawanie nowego' }} Bookingu
                        </h4>

                        <form method="POST" action="{{ isset($booking) ? route('BookingModule::update', ['booking' => $booking]) : route('BookingModule::store') }}" enctype="multipart/form-data">
                            @csrf
                            @if (isset($booking))
                                @method('PUT')
                            @endif

                            <div class="form-group @error('name') has-danger @enderror col-5">
                                <label for="">Nazwa</label>
                                <input type="text" class="form-control" name="name" value="{{ isset($booking) ? $booking->name : old('name') }}">
                                @error('name')
                                    <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group @error('code') has-danger @enderror col-3">
                                <label for="">Kod</label>
                                <input type="text" class="form-control" name="code" value="{{ isset($booking) ? $booking->code : old('code') }}">
                                @error('code')
                                    <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group @error('order') has-danger @enderror col-3">
                                <label for="">Kolejność</label>
                                <input type="number" class="form-control" name="order" value="{{ isset($booking) ? $booking->order : old('order') }}">
                                @error('order')
                                    <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group @error('custom_link') has-danger @enderror col-12">
                                <label for="">Custom link pattern</label>
                                <input type="text" class="form-control" name="custom_link" value="{{ isset($booking) ? $booking->custom_link : old('custom_link') }}">
                                @error('custom_link')
                                <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-3">
                                <label for="">Zakładka</label>
                                <select name="tab_id" id="tab" class="form-control">
                                    @php
                                        $tabId = isset($booking) ? $booking->tab_id : false;
                                    @endphp
                                    @foreach($tabs as $tab)
                                        <option value="{{ $tab->id }}" @if($tabId === $tab->id) selected @endif>
                                            {{ $tab->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-3">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        @php
                                            $checked = isset($booking) ? $booking->is_default : false;
                                        @endphp
                                        <input type="checkbox" class="form-check-input" name="is_default" @if($checked) checked @endif>
                                        Domyślnie wybrany <i class="input-helper"></i>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="float-right mt-2 btn btn-primary mr-2">Zapisz</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
