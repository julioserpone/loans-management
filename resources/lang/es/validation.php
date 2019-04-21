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

    'accepted' => 'El :attribute debe ser aceptado.',
    'active_url' => 'El :attribute no es una URL válida.',
    'after' => 'El :attribute debe ser una fecha mayor a :date.',
    'alpha' => 'El :attribute debe contener solo letras.',
    'alpha_dash' => 'El :attribute debe contener letras, numeros, y guiones.',
    'alpha_num' => 'El :attribute debe contener letras y numero.',
    'array' => 'El :attribute debe ser un arreglo.',
    'before' => 'El :attribute debe ser una fecha menor a :date.',
    'between' => [
        'numeric' => 'El :attribute debe ser entre :min y :max.',
        'file' => 'El :attribute debe ser entre :min y :max kilobytes.',
        'string' => 'El :attribute debe ser entre :min y :max characters.',
        'array' => 'El :attribute debe tener entre :min y :max items.',
    ],
    'boolean' => 'El :attribute campo debe ser verdadero o falso.',
    'confirmed' => 'El :attribute confirmación no coincide.',
    'date' => 'El :attribute no es una fecha válida.',
    'date_format' => 'El :attribute no coincide con el formato :format.',
    'different' => 'El :attribute y :oElr deben ser diferentes.',
    'digits' => 'El :attribute debe ser de :digits digitos.',
    'digits_between' => 'El :attribute debe ser entre :min y :max digitos.',
    'email' => 'El :attribute debe ser un correo válido.',
    'exists' => 'El selected :attribute no es válido.',
    'filled' => 'El :attribute campo es obligatorio.',
    'image' => 'El :attribute debe ser una image.',
    'in' => 'El :attribute seleccionado no es válido.',
    'integer' => 'El :attribute debe ser un entero.',
    'ip' => 'El :attribute debe ser una dirección IP válida.',
    'json' => 'El :attribute debe ser un JSON válido.',
    'max' => [
        'numeric' => 'El :attribute no debe ser mayor que :max.',
        'file' => 'El :attribute no debe ser mayor que :max kilobytes.',
        'string' => 'El :attribute no debe ser mayor que :max characters.',
        'array' => 'El :attribute may not have more que :max items.',
    ],
    'mimes' => 'El :attribute debe ser un tipo de archivo válido: :values.',
    'min' => [
        'numeric' => 'El :attribute debe ser al menos :min.',
        'file' => 'El :attribute debe ser al menos :min kilobytes.',
        'string' => 'El :attribute debe ser al menos :min characters.',
        'array' => 'El :attribute debe tener al menos :min items.',
    ],
    'not_in' => 'El :attribute seleccionado no es válido.',
    'numeric' => 'El :attribute debe ser un numero.',
    'regex' => 'El :attribute formato no es válido.',
    'required' => 'El :attribute campo es obligatorio.',
    'required_if' => 'El :attribute campo es obligatorio cuando :oElr es :value.',
    'required_with' => 'El :attribute campo es obligatorio cuando :values es present.',
    'required_with_all' => 'El :attribute campo es obligatorio cuando :values es present.',
    'required_without' => 'El :attribute campo es obligatorio cuando :values es no present.',
    'required_without_all' => 'El :attribute campo es obligatorio cuando nunguno de los valores :values estan presente.',
    'same' => 'El :attribute y :oElr deben ser iguales.',
    'size' => [
        'numeric' => 'El :attribute debe ser :size.',
        'file' => 'El :attribute debe ser :size kilobytes.',
        'string' => 'El :attribute debe ser :size characters.',
        'array' => 'El :attribute debe contener :size items.',
    ],
    'string' => 'El :attribute debe ser una cadena.',
    'timezone' => 'El :attribute debe ser una zona válida.',
    'unique' => 'El :attribute ya esta seleccionado.',
    'url' => 'El :attribute formato no es válido.',

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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
     */

    'attributes' => [],
    'credentials_invalid' => 'Credenciales invalidas',
    'error_default' => 'Hubo un error al precesar la petición. Por favor llamar al administrador del sistema',
    'whoops' => 'Whoops!',
    'inputs_error' => 'Hubo algunos errores con tus valores',
    'not_section_allow' => 'Permiso denegado',
    'exists_identification' => 'El número de identificación ya fue tomado. Intente de nuevo!',
    'user_not_exist' => 'El usuario no existe',
    'bank_not_exist' => 'El banco no existe',
    'city_not_exist' => 'La ciudad no existe',
    'bank_already_exist' => 'El banco ya esta registrado',
    'city_already_exist' => 'La ciudad ya esta registrado',
    'installment_not_exist' => 'La cuota no existe',
    'select_at_least_one_installment' => 'Debe seleccionar al menos una cuota de la lista',
    'request_invalid' => 'La petición no es válido',
    'loan_required_installment' => 'El credito debe tener al menos una cuota asociada',
    'secure_delete_installment'=> 'Esta seguro de borrar esta cuota?',
    'secure_delete_payment'=> 'Esta seguro de borrar este pago?',
    'secure_delete_surcharge'=> 'Esta seguro de borrar este recargo?',
    'holyday_associated' => 'Feria esta asociado a una cuota',
    'first_payment_error' => 'La fecha del primer pago debe ser mayor a la fecha de la ultima cuota pagada',
];
