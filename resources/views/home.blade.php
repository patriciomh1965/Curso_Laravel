@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Llama</div>


                   <div class="card-body alert-dark">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <img src="{{ URL::asset('sb/logo03.png')}}"  />

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
