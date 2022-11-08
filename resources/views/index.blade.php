@extends('layouts.main')
@section('content')
    <Suspense>
        <template #default>
            <Index></Index>
        </template>
        <template #fallback>
            <div></div>
        </template>
    </Suspense>
@endsection
