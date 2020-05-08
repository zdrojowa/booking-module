@extends('DashboardModule::dashboard.index')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header clearfix">
                        <h4 class="card-title float-left">Lista wszystkich Zakładek</h4>
                        <a href="{{route('BookingModule::addTab')}}" class="text-success float-right">
                            <i class="mdi mdi-plus-circle"></i> Dodaj
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascripts')
    @parent

    <script>

        $('.table').zdrojowaTable({

            ajax: {
                url: "{{route('BookingModule::ajax.tabs')}}",
                method: "POST",
                data: {
                    "_token": "{{csrf_token()}}"
                },
            },
            headers: [
                {
                    name: 'L.p',
                    type: 'index',
                },
                {
                    name: 'Nazwa',
                    type: 'text',
                    ajax: 'name',
                    orderable: true,
                },
                {
                    name: 'Kolejnosc',
                    type: 'text',
                    ajax: 'order',
                    orderable: true
                },
                {
                    name: 'Data utworzenia',
                    orderable: true,
                    ajax: 'created_at'
                },
                {
                    name: 'Akcje',
                    ajax: 'key',
                    type: 'actions',
                    buttons: [
                        @permission('BookingModule.edit')
                        {
                            color: 'primary',
                            icon: 'mdi mdi-pencil',
                            class: 'remove',
                            url: "{{route('BookingModule::editTab', ['tab' => '%%id%%'])}}"
                        },
                        @endpermission
                        @permission('BookingModule.delete')
                        {
                            color: 'danger',
                            icon: 'mdi mdi-delete',
                            class: 'ZdrojowaTable--remove-action',
                            url: "{{route('BookingModule::destroyTab', ['tab' => '%%id%%'])}}"
                        },
                        @endpermission
                    ]
                }
            ]
        });
    </script>
@endsection
