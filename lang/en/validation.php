<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'Поле :attribute должно быть принято.',
    'active_url'           => 'Поле :attribute содержит недействительный URL.',
    'after'                => 'Поле :attribute должно быть датой после :date.',
    'after_or_equal'       => 'Поле :attribute должно быть датой после или равной :date.',
    'alpha'                => 'Поле :attribute может содержать только буквы.',
    'alpha_dash'           => 'Поле :attribute может содержать только буквы, цифры, дефисы и подчеркивания.',
    'alpha_num'            => 'Поле :attribute может содержать только буквы и цифры.',
    'array'                => 'Поле :attribute должно быть массивом.',
    'before'               => 'Поле :attribute должно быть датой до :date.',
    'before_or_equal'      => 'Поле :attribute должно быть датой до или равной :date.',
    'between'              => [
        'numeric' => 'Поле :attribute должно быть между :min и :max.',
        'file'    => 'Размер файла в поле :attribute должен быть между :min и :max Кб.',
        'string'  => 'Длина текста в поле :attribute должна быть между :min и :max символов.',
        'array'   => 'Количество элементов в поле :attribute должно быть между :min и :max.',
    ],
    'boolean'              => 'Поле :attribute должно иметь значение логического типа.',
    'confirmed'            => 'Поле :attribute не совпадает с подтверждением.',
    'date'                 => 'Поле :attribute не является датой.',
    'date_format'          => 'Поле :attribute не соответствует формату :format.',
    'different'            => 'Поля :attribute и :other должны различаться.',
    'digits'               => 'Длина цифрового поля :attribute должна быть :digits.',
    'digits_between'       => 'Длина цифрового поля :attribute должна быть между :min и :max.',
    'dimensions'           => 'Изображение в поле :attribute имеет недопустимые размеры.',
    'distinct'             => 'Поле :attribute содержит повторяющееся значение.',
    'email'                => 'Поле :attribute должно быть действительным электронным адресом.',
    'exists'               => 'Выбранное значение для :attribute некорректно.',
    'file'                 => 'Поле :attribute должно быть файлом.',
    'filled'               => 'Поле :attribute обязательно для заполнения.',
    'gt'                   => [
        'numeric' => 'Поле :attribute должно быть больше :value.',
        'file'    => 'Размер файла в поле :attribute должен быть больше :value Кб.',
        'string'  => 'Длина текста в поле :attribute должна быть больше :value символов.',
        'array'   => 'Количество элементов в поле :attribute должно быть больше :value.',
    ],
    'gte'                  => [
        'numeric' => 'Поле :attribute должно быть больше или равно :value.',
        'file'    => 'Размер файла в поле :attribute должен быть больше или равен :value Кб.',
        'string'  => 'Длина текста в поле :attribute должна быть больше или равна :value символов.',
        'array'   => 'Количество элементов в поле :attribute должно быть больше или равно :value.',
    ],
    'image'                => 'Поле :attribute должно быть изображением.',
    'in'                   => 'Выбранное значение для :attribute ошибочно.',
    'in_array'             => 'Поле :attribute не существует в :other.',
    'integer'              => 'Поле :attribute должно быть целым числом.',
    'ip'                   => 'Поле :attribute должно быть действительным IP-адресом.',
    'ipv4'                 => 'Поле :attribute должно быть действительным IPv4-адресом.',

    'ipv6'                 => 'Поле :attribute должно быть действительным IPv6-адресом.',
    'json'                 => 'Поле :attribute должно быть JSON строкой.',
    'lt'                   => [
        'numeric' => 'Поле :attribute должно быть меньше :value.',
        'file'    => 'Размер файла в поле :attribute должен быть меньше :value Кб.',
        'string'  => 'Длина текста в поле :attribute должна быть меньше :value символов.',
        'array'   => 'Количество элементов в поле :attribute должно быть меньше :value.',
    ],
    'lte'                  => [
        'numeric' => 'Поле :attribute должно быть меньше или равно :value.',
        'file'    => 'Размер файла в поле :attribute должен быть меньше или равен :value Кб.',
        'string'  => 'Длина текста в поле :attribute должна быть меньше или равна :value символов.',
        'array'   => 'Количество элементов в поле :attribute должно быть меньше или равно :value.',
    ],
    'max'                  => [
        'numeric' => 'Поле :attribute не может быть более :max.',
        'file'    => 'Размер файла в поле :attribute не может быть больше :max Кб.',
        'string'  => 'Длина текста в поле :attribute не может превышать :max символов.',
        'array'   => 'Количество элементов в поле :attribute не может превышать :max.',
    ],
    'mimes'                => 'Поле :attribute должно быть файлом одного из типов: :values.',
    'mimetypes'            => 'Поле :attribute должно быть файлом одного из типов: :values.',
    'min'                  => [
        'numeric' => 'Поле :attribute должно быть не менее :min.',
        'file'    => 'Размер файла в поле :attribute должен быть не менее :min Кб.',
        'string'  => 'Длина текста в поле :attribute должна быть не менее :min символов.',
        'array'   => 'Количество элементов в поле :attribute должно быть не менее :min.',
    ],
    'not_in'               => 'Выбранное значение для :attribute ошибочно.',
    'not_regex'            => 'Формат поля :attribute недействителен.',
    'numeric'              => 'Поле :attribute должно быть числом.',
    'present'              => 'Поле :attribute должно присутствовать.',
    'regex'                => 'Формат поля :attribute недействителен.',
    'required'             => 'Поле :attribute обязательно для заполнения.',
    'required_if'          => 'Поле :attribute обязательно для заполнения, когда :other равно :value.',
    'required_unless'      => 'Поле :attribute обязательно для заполнения, если :other не равно :values.',
    'required_with'        => 'Поле :attribute обязательно для заполнения, когда :values указано.',
    'required_with_all'    => 'Поле :attribute обязательно для заполнения, когда :values указано.',
    'required_without'     => 'Поле :attribute обязательно для заполнения, когда :values не указано.',
    'required_without_all' => 'Поле :attribute обязательно для заполнения, когда ни одно из :values не указано.',
    'same'                 => 'Значения полей :attribute и :other должны совпадать.',
    'size'                 => [
        'numeric' => 'Поле :attribute должно быть равным :size.',
        'file'    => 'Размер файла в поле :attribute должен быть равен :size Кб.',
        'string'  => 'Длина текста в поле :attribute должна быть равной :size символов.',
        'array'   => 'Количество элементов в поле :attribute должно быть равным :size.',
    ],
    'string'               => 'Поле :attribute должно быть строкой.',
    'timezone'             => 'Поле :attribute должно быть действительным часовым поясом.',
    'unique'               => 'Такое значение поля :attribute уже существует.',
    'uploaded'             => 'Загрузка поля :attribute не удалась.',
    'url'                  => 'Формат поля :attribute недействителен.',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'phone' => [
            'regex' => 'Номер телефона должен быть в формате +7 XXX XXX-XX-XX или 8 XXX XXX-XX-XX.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'Имя',
        'email' => 'Email',
        'phone' => 'Телефон',
        'password' => 'Пароль',
    ],

];
