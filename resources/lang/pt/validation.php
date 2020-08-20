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

    'accepted' => 'O campo :attribute deve ser aceitado.',
    'active_url' => 'O campo :attribute não é uma URL válida.',
    'after' => 'O campo :attribute deve ser uma data depois de :date.',
    'after_or_equal' => 'O campo :attribute deve ser uma data depois ou igual a :date.',
    'alpha' => 'O campo :attribute deve apenas conter letras.',
    'alpha_dash' => 'O campo :attribute deve apenas conter letras, numeros, traços e sublinhados.',
    'alpha_num' => 'O campo :attribute deve apenas conter letras e numeros',
    'array' => 'O campo :attribute deve ser um array.',
    'before' => 'O campo :attribute deve ser uma data antes de :date.',
    'before_or_equal' => 'O campo :attribute deve ter uma data anterior ou igual a :date.',
    'between' => [
        'numeric' => 'O campo :attribute deve ser entre :min e :max.',
        'file' => 'O campo :attribute deve ser entre :min e :max kilobytes.',
        'string' => 'O campo :attribute deve ser entre :min e :max caracteres.',
        'array' => 'O campo :attribute mudeve ser entre :min e :max items.',
    ],
    'boolean' => 'O campo :attribute deve ter um valor verdadeiro ou falso.',
    'confirmed' => 'No campo :attribute a confirmação não combina.',
    'date' => 'O campo :attribute não é uma data válida.',
    'date_equals' => 'O campo :attribute deve ser uma data igual a :date.',
    'date_format' => 'O campo :attribute nao combina com o formato :format.',
    'different' => 'O campo :attribute e :other devem ser diferentes.',
    'digits' => 'O campo :attribute deve ter :digits digitos.',
    'digits_between' => 'O campo :attribute deve ser entre :min e :max digitos.',
    'dimensions' => 'O campo :attribute não tem as dimensões válidas de uma imagem',
    'distinct' => 'O(a) campo :attribute tem valor duplicado.',
    'email' => 'O campo :attribute deve ser um email valido.',
    'ends_with' => 'O campo :attribute deve terminar com um dos following: :values',
    'exists' => 'O campo :attribute  selecionado é invalido.',
    'file' => 'O campo :attribute deve ser um arquivo.',
    'filled' => 'O campo :attribute deve ser preenchido.',
    'gt' => [
        'numeric' => 'O campo :attribute deve ser maior que :value.',
        'file' => 'O campo :attribute deve ser maior que :value kilobytes.',
        'string' => 'O campo :attribute deve ser maior que :value caracteres.',
        'array' => 'O campo :attribute deve ser maior que :value items.',
    ],
    'gte' => [
        'numeric' => 'O campo :attribute deve ser maior ou igual a :value.',
        'file' => 'O campo :attribute deve ser maior ou igual a :value kilobytes.',
        'string' => 'O campo :attribute deve ser maior ou igual a :value characters.',
        'array' => 'O campo :attribute deve ter :value items ou mais.',
    ],
    'image' => 'O campo :attribute deve ser uma imagem.',
    'in' => 'O campo :attribute selecionado é invalido.',
    'in_array' => 'O campo :attribute não existe em :other.',
    'integer' => 'O campo :attribute deve ser um inteiro.',
    'ip' => 'O campo :attribute deve ser um endereço de IP válido.',
    'ipv4' => 'O campo :attribute deve ser um endereço de IPv4 válido.',
    'ipv6' => 'O campo :attribute deve ser um endereço de IPv6 válido.',
    'json' => 'O campo :attribute deve ser uma string JSON válida.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'O campo :attribute nao pode ser maior do que :max.',
        'file' => 'O campo :attribute não pode ser maior do que :max kilobytes.',
        'string' => 'O campo :attribute não pode ser maior do que :max caracteres.',
        'array' => 'O campo :attributenão pode ser maior do que :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'O campo :attribute deve ser pelo menos :min.',
        'file' => 'O campo :attribute deve ser pelo menos :min kilobytes.',
        'string' => 'O campo :attribute deve ter pelo menos :min caracteres.',
        'array' => 'O campo :attribute deve ter pelo menos :min items.',
    ],
    'not_in' => 'O campo :attribute selecionado é invalido.',
    'not_regex' => 'O formato do campo :attribute é invalido.',
    'numeric' => 'O campo :attribute deve ser um numero.',
    'password' => 'A senha esta incorreta.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'O formato do campo :attribute é invalido.',
    'required' => 'O campo :attribute é obrigatório.',
    'required_if' => 'O campo :attribute é obrigatório quando :other é :value.',
    'required_unless' => 'O campo :attribute é obrigatório a não ser que :other é :values.',
    'required_with' => 'O campo :attribute é obrigatório quando tem :values.',
    'required_with_all' => 'O campo :attribute é obrigatório quando tem :values.',
    'required_without' => 'O campo :attribute é obrigatório quando não tem :values.',
    'required_without_all' => 'O campo :attribute é obrigatório quando não tem :values.',
    'same' => 'O campo :attribute e :other devem ser os mesmos.',
    'size' => [
        'numeric' => 'O campo :attribute deve ter :size.',
        'file' => 'O campo :attribute deve ter :size kilobytes.',
        'string' => 'O campo :attribute deve ter :size caracteres.',
        'array' => 'O campo :attribute deve conter :size items.',
    ],
    'starts_with' => 'O campo :attribute deve começar com um dos following: :values',
    'string' => 'O campo :attribute deve ser uma palavra.',
    'timezone' => 'O campo :attribute deve ser uma zona valida.',
    'unique' => 'Este(a) :attribute já existe.',
    'uploaded' => ':attribute falhou no upload.',
    'url' => 'O campo :attribute esta com formato invalido.',
    'uuid' => 'O campo :attribute deve ter um UUID valido.',

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
        'attribute-name' => [
            'rule-name' => 'custom-message',
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

        
    ],

];
