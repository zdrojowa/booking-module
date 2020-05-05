@extends('DashboardModule::dashboard.index')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('DashboardModule::partials.alerts')

                        <h4 class="card-title">
                            {{ isset($booking) ? 'Edytowanie' : 'Dodawanie nowej' }} zakładki
                        </h4>

                        <form method="POST" action="{{ isset($tab) ? route('BookingModule::updateTab', ['tab' => $tab]) : route('BookingModule::storeTab') }}" enctype="multipart/form-data">
                            @csrf
                            @if (isset($tab))
                                @method('PUT')
                            @endif

                            <div class="d-flex justify-content-center">
                                <div class="form-group @error('name') has-danger @enderror col-6">
                                    <label for="">Nazwa zakladki</label>
                                    <input type="text" class="form-control" name="name" value="{{ isset($tab) ? $tab->name : old('name') }}">
                                    @error('name')
                                        <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group @error('link') has-danger @enderror col-6">
                                    <label for="">Link patern</label>
                                    <input type="text" class="form-control" name="link" value="{{ isset($tab) ? $tab->link : old('link') }}">
                                    @error('link')
                                        <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="logo_file">Plan apartamentu</label>
                                <input
                                    id="logo_file"
                                    type="file"
                                    name="logo_file"
                                    class="dropify"
                                    data-height="100"
                                    data-allowed-file-extensions="svg"
                                    @if(isset($tab) && isset($tab->logo))
                                        data-default-file="{{asset($tab->logo)}}"
                                    @endif
                                    data-max-file-size="1M">

                                @error('logo_file')
                                    <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-start">
                                <div class="form-group @error('order') has-danger @enderror col-3">
                                    <label for="">Kolejność</label>
                                    <input type="number" class="form-control" name="order" value="{{ isset($tab) ? $tab->order : old('order') }}">
                                    @error('order')
                                        <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                    @enderror
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
@section('javascripts')
    @parent
    <script>
        $('.dropify').dropify({})
    </script>
@endsection
