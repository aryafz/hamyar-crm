@extends('layouts.app')

@section('content')
    <!-- اینجا نباید id="app" دوباره باشه اگر توی app.js بهش وصل شدیم -->
    <!-- اما چون پروژه تو اینجوریه که app.js به id="app" وصل میشه: -->

    <div id="app">
        <h1>تست ویو: @{{ 2 + 2 }}</h1>
        <dashboard></dashboard>

        <div class="mt-10 grid grid-cols-1 gap-10">
            <div class="bg-white p-5 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4 border-b pb-2">ثبت مشتری جدید</h2>
                <customer-form></customer-form>
            </div>

            <div class="bg-white p-5 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4 border-b pb-2">لیست مشتریان</h2>
                <customer-list></customer-list>
            </div>
        </div>
    </div>
@endsection
