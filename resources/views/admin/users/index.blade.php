@extends('admin.layouts.main')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form class="row" action="" method="POST">
                    @csrf
                    <ul class="list-group">
                        <li class="list-group-item row">
                            div.col-md-6*2
                        </li>
                    </ul>
                    <button type="submit" class="btn btn-primary mb-2">Сохранить изменения</button>
                </form>
            </div>
        </div>
    </div>
@endsection
