@extends('layouts.app')

@section('content')
    <div class="mt-8 mx-auto px-4 max-w-6xl">
        <div class="bg-white p-6 rounded-xl shadow-md">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Текстовая часть -->
                <div class="w-full md:w-2/5 space-y-8">
                    <h3 class="text-3xl font-bold text-gray-800">Наш магазин</h3>

                    <div class="space-y-6">
                        <div>
                            <h4 class="font-semibold text-xl mb-3 text-gray-700">Адрес</h4>
                            <p class="text-gray-600 text-lg">г. Томск, ул. Гоголя, д. 55</p>
                            <p class="text-gray-500 mt-2">Вход со стороны парковки</p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-xl mb-3 text-gray-700">Контакты</h4>
                            <p class="text-gray-600 text-lg">Телефон: +7 (961) 888-32-08</p>
                            <p class="text-gray-600 text-lg">Email: sneakstride@mail.com</p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-xl mb-3 text-gray-700">Часы работы</h4>
                            <p class="text-gray-600 text-lg">Пн-Пт: 10:00 - 20:00</p>
                            <p class="text-gray-600 text-lg">Сб-Вс: 11:00 - 18:00</p>
                        </div>
                    </div>
                </div>

                <!-- Карта -->
                <div class="w-full md:flex-[2] min-h-[400px] md:min-h-[500px] -mx-2">
                    <div class="h-full w-full rounded-lg overflow-hidden">
                        <script type="text/javascript" charset="utf-8" async
                                src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Aa6cf256020e9625748920189c3d0824e11d2a303195ad8d8156200c2b0a6eb7d&amp;width=100%&amp;height=100%&amp;lang=ru_RU&amp;scroll=true">
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
