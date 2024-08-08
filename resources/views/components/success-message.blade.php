@if (session('success'))
    <div class="border-success dark:border-success text-green-500 p-4 mb-5 rounded-sm bg-green-200 dark:bg-green-200">
        {{ session('success') }}
    </div>
@endif
