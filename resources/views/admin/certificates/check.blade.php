@extends('admin.layouts.main')
@section('content')

<div class="cold-12">
    <form action="{{route('check-certificate')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="code">Уникальный код</label>
            <input name="code" type="text" class="form-control" id="code" aria-describedby="code" placeholder="Введите код">
        </div>
        <button type="submit" class="btn btn-primary mb-2">Проверить сертификат</button>
    </form>
</div>
@endsection
