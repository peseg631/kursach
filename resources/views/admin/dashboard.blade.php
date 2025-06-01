@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto my-8 px-10 py-8 bg-white shadow-md rounded-xl font-sans text-gray-800">
        <h1 class="text-2xl font-bold mb-8 text-gray-800">Панель администратора</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('admin.products.index') }}"
               class="p-6 bg-white border border-gray-200 rounded-lg shadow hover:shadow-md transition-all text-center hover:bg-gray-50 group">
                <div class="flex justify-center mb-3">
                    <svg width="40" height="40" viewBox="0 0 20 20" class="text-gray-700 group-hover:text-[rgb(54,91,106)] transition-colors">
                        <path d="M15.578 2.432L13.578 1.382C11.822 0.461 10.944 0 10 0C9.056 0 8.178 0.46 6.422 1.382L6.101 1.551L15.024 6.65L19.04 4.64C18.394 3.908 17.352 3.361 15.578 2.43M19.748 5.964L15.75 7.964V11C15.75 11.1989 15.671 11.3897 15.5303 11.5303C15.3897 11.671 15.1989 11.75 15 11.75C14.8011 11.75 14.6103 11.671 14.4697 11.5303C14.329 11.3897 14.25 11.1989 14.25 11V8.714L10.75 10.464V19.904C11.468 19.725 12.285 19.297 13.578 18.618L15.578 17.568C17.729 16.439 18.805 15.875 19.403 14.86C20 13.846 20 12.583 20 10.06V9.943C20 8.05 20 6.866 19.748 5.964ZM9.25 19.904V10.464L0.252 5.964C8.9407e-08 6.866 0 8.05 0 9.941V10.058C0 12.583 -1.19209e-07 13.846 0.597 14.86C1.195 15.875 2.271 16.44 4.422 17.569L6.422 18.618C7.715 19.297 8.532 19.725 9.25 19.904ZM0.96 4.641L10 9.161L13.411 7.456L4.525 2.378L4.422 2.432C2.649 3.362 1.606 3.909 0.96 4.642" fill="currentColor"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 group-hover:text-[rgb(54,91,106)] transition-colors">Просмотр товаров</h3>
            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="p-6 bg-white border border-gray-200 rounded-lg shadow hover:shadow-md transition-all text-center hover:bg-gray-50 group">
                <div class="flex justify-center mb-3">
                    <svg width="40" height="40" viewBox="0 0 20 16" class="text-gray-700 group-hover:text-[rgb(54,91,106)] transition-colors">
                        <path d="M3.75 3.69231H20V16H0V0H8.75L11.25 2.46154H2.5V13.5385H3.75V3.69231Z" fill="currentColor"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 group-hover:text-[rgb(54,91,106)] transition-colors">Просмотр категорий</h3>
            </a>
        </div>
    </div>
@endsection
