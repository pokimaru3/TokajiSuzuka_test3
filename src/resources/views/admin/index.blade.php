@extends('layouts.admin_app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
@endsection


@section('content')
<div class="admin-managers-wrapper">
    <h2 class="admin-managers-title">店舗代表者一覧</h2>
    <table class="admin-managers-table">
        <thead>
            <tr class="admin-managers__header">
                <th class="table__name">名前</th>
                <th class="table__email">メールアドレス</th>
                <th class="table__created_at">作成日</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($managers as $manager)
                <tr>
                    <td>{{ $manager->name }}</td>
                    <td>{{ $manager->email }}</td>
                    <td>{{ $manager->created_at->format('Y年m月d日') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
