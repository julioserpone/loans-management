<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Globals Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the paginator library to build
    | the simple pagination links. You are free to change them to anything
    | you want to customize your views to better match your application.
    |
     */

    'gender' => [
        'female' => 'Femenino',
        'male' => 'Masculino',
    ],

    'identification_type' => [
        'cc' => 'CC',
        'ce' => 'CE',
    ],

    'type_status' => [
        'active' => 'Activo',
        'inactive' => 'Inactivo',
        'delete' => 'Eliminado',
    ],

    'loans_payment_status' => [
        'pending' => 'Pendiente',
        'unpaid' => 'Sin Pago',
        'paid' => 'Pagado',
        'onhold' => 'Sobregirado',
        'process' => 'En Proceso',
        'rejected' => 'Rechazado'
    ],

    'payments_methods' => [
        'cash' => 'Efectivo',
        'check' => 'Cheque',
        'transfer' => 'Transferencia',
    ],

    'payments_concepts' => [
        'payment' => 'Pago',
        'surcharge' => 'Recargo',
        'other' => 'Otro'
    ],

    'payments_status' => [
        'active' => 'Activo',
        'inactive' => 'Inactivo'
    ],

    'installments_status' => [
        'pending' => 'Pendiente',
        'paid' => 'Pagado',
        'rejected' => 'Rechazado',
        'process' => 'Procesado'
    ],

    'payments_type' => [
        'capital' => 'Capital',
        'interest' => 'Intereses',
        'installment' => 'Cuota'
    ],

    'loans_payment_status_class' => [
        'pending' => 'label label-primary',
        'unpaid' => 'label label-warning',
        'rejected' => 'label label-danger',
        'paid' => 'label label-success',
        'onhold' => 'label label-info',
        'process' => 'label label-warning'
    ],

    'status_class' => [
        'inactive' => 'label label-danger',
        'active' => 'label label-success',
        'delete' => 'label label-danger',
    ],

    'roles' => [
        'admin' => 'Admin',
        'customer' => 'Customer',
        'adviser' => 'Adviser',
        'supervisor' => 'Supervisor'
    ],

    'verification' => [
        'yes' => 'yes',
        'no' => 'no',
    ],

    'contract_type' => [
        'linked' => 'Vinculado',
        'independent' => 'Independiente',
        'temporary' => 'Temporal',
    ],

    'affiliation_type' => [
        'contributor' => 'Contribuyente',
        'beneficiary' => 'Beneficiario',
    ],

    'reference_type' => [
        'family' => 'Familiar',
        'personal' => 'Personal',
        'cosigner' => 'Consignador',
    ],

    'document_type' => [
        'cc' => 'CC',
        'services' => 'Servicios',
        'letter' => 'Letras',
        'others' => 'Otros',
    ],

    'card_type' => [
        'visa' => 'Visa Card',
        'mastercard' => 'Mastercard',
        'amex' => 'Amex Card',
    ],

    'section_title' => [
        'home' => 'Home',
        'dashboard' => 'Dashboard',
        'profile' => 'Profile',
        'employees_list' => 'Lista de Empleados',
        'employees_list_descrip' => 'Módulo de Gestión',
        'employees_add' => 'Agregar nuevo empleado',
        'employees_edit' => 'Editar un empleado',
        'employees_add_descrip_01' => 'Datos Personales',
        'employees_add_descrip_02' => 'Datos Financieros',
        'customers_list' => 'Listado de Clientes',
        'customers_list_descrip' => 'Módulo de Gestión',
        'customers_add' => 'Agregar nuevo cliente',
        'customers_edit' => 'Editar un cliente',
        'customers_step1_1' => 'Información Personal',
        'customers_step1_2' => 'Información de Dirección y Teléfonos',
        'customers_step2_1' => 'Información de Empleo',
        'customers_step2_2' => 'Más Información acerca de Empleo',
        'customers_step3_1' => 'Referencias',
        'customers_step3_2' => 'Más Información acerca de Referencias',
        'customers_step4_1' => 'Carga de documentos',
        'customers_step4_2' => 'Documentos cargados',
        'customers_step5' => 'Completado',
        'loans_list' => 'Listado de Prestamos',
        'loans_list_descrip' => 'Módulo de Gestión',
        'request_loan' => 'Solicitud de Prestamos',
        'request_loan_descrip_01' => 'Campos del Prestamo',
        'request_loan_descrip_02' => 'Proyección del Prestamo',
        'request_loan_descrip_03' => 'Cuotas del Prestamo',
        'full_calendar' => 'Full Calendar',
        'full_calendar_des' => 'Dates Controller',
        'calendar_holydays' => 'Festivos',
        'payments_list' => 'Listado de Pagos',
        'payments_list_descrip' => 'Módulo de Gestión',
        'banks_list' => 'Listado de Bancos',
        'banks_list_descrip' => 'Módulo de Gestión',
        'banks_add' => 'Agregar nuevo banco',
        'banks_edit' => 'Editar un banco',
        'banks_title_section' => 'Campos de Información del Banco',
        'cities_list' => 'Listado de Ciudades',
        'cities_list_descrip' => 'Módulo de Gestión',
        'cities_add' => 'Agregar nueva ciudad',
        'cities_edit' => 'Editar una ciudad',
        'cities_title_section' => 'Campos de Información de la Ciudad',
        'payments_freq_list' => 'Listado de Pagos Frecuentes',
        'payments_freq_list_descrip' => 'Módulo de Gestión',
        'payments_freq_add' => 'Agregar un pago frecuente',
        'payments_freq_edit' => 'Editar un pago precuente',
        'request_payment' => 'Solicitud de Pago',
        'payments_add_title' => 'Agregar un pago',
        'payments_edit_title' => 'Editar un pago',
        'see_installments' => 'Cuotas',
        'surcharges_list' => 'Listado de Recargos',
        'upcoming_payments' => 'Proximos Pagos',
        'upcoming_installments' => 'Proximas cuotas',
        'upcoming_surcharges' => 'Proximos Recargos'
    ],

    'side_bar' => [
        'employees' => 'Empleados',
        'customers' => 'Clientes',
        'loans' => 'Prestamos',
        'full_calendar' => 'Calendario',
        'holydays' => 'Festivos',
        'payments' => 'Pagos',
        'maintenance' => 'Mantenimiento',
        'settings' => 'Configuración',
        'banks' => 'Bancos',
        'cities' => 'Ciudades',
        'payments_frequency' => 'Frecuencias de Pago',
        'surcharges' => 'Recargos',
    ],

    'relationship' => [
        'grandmother' => 'Abuela',
        'grandfather' => 'Abuela',
        'mother' => 'Madre',
        'father' => 'Padre',
        'son' => 'Hijo',
        'daughter' => 'Hija',
        'grandson' => 'Nieto',
        'granddaughter' => 'Nieta',
        'uncle' => 'Tio',
        'aunt' => 'Tia',
        'nephew' => 'Sobrino',
        'niece' => 'Sobrina',
        'brother' => 'Hermano',
        'sister' => 'Hermana',
        'cousin' => 'Primo(a)',
        'spouse' => 'Esposo(a)',
        'son_in_law' => 'Yerno',
        'daughter_in_law' => 'Yerna',
    ],

    'eps' => [
        'saludcoop' => 'SALUDCOOP',
        'sura' => 'SURA',
        'nuevaeps' => 'NUEVAEPS',
        'salud_total' => 'SALUD TOTAL',
        'sanitas' => 'SANITAS',
        'coomeva' => 'COOMEVA',
        'cafe_salud' => 'CAFESALUD',
    ],

    'pension' => [
        'prroteccion' => 'PRROTECCION',
        'colpensiones' => 'COLPENSIONES',
        'porvenir' => 'PORVENIR',
    ],

    'inputmask' => [
        'date' => 'dd-mm-yyyy',
        'phone_mask' => '999-999-99-99',
        'phone_home_mask' => '999-99-99',
        'phone_placeholder' => '___-___-__-__',
        'phone_home_placeholder' => '___-__-__',
        'amount' => '$ 999.999.999,99',
        'interest_rate' => '% 99,99',
        'penalty_rate' => '% 9',
        'two_digits' => '99',
    ],

    'paymentfrequency' => [
        'daily' => '1',
        'weekly' => '7',
        'ten' => '10',
        'fourteen' => '14',
        'biweekly' => '15',
        'monthly' => '30',
    ],

    'app_title' => 'Prestamos :: ',
    'success_alert_title' => 'Success',
    'error_alert_title' => 'Oh No!',
    'twitter_label' => 'Twitter',
    'facebook_label' => 'Facebook',
    'search' => 'Buscar',
    'menu_header' => 'Menu Prestamos',
    'contentheader_title' => 'Sistema de Gestión de Prestamos',
    'add_new' => 'Agregar nuevo',
    'employee' => 'Empleado',
    'customer' => 'Cliente',
    'bank' => 'Banco',
    'payment_frequency' => 'Frecuencia de Pago',
    'city' => 'Ciudad',
    'loans' => 'Prestamo',
    'profile' => 'Profile',
    'type_payment' => 'Tipo de Pago',
    'online' => 'Online',
    'type' => 'Tipo',
    'verified' => 'Verificado',
    'status' => 'Estatus',
    'description' => 'Descripción',
    'photo' => 'Foto',
    'previous' => 'Anterior',
    'submit' => 'Enviar',
    'save' => 'Guargar',
    'submit_continue' => 'Enviar y continuar',
    'finish' => 'Finalizar',
    'success_procces' => 'La solicitud fue procesada satisfactoriamente!',
    'actions' => 'Acciones',
    'copyright' => 'Copyright',
    'created_by' => 'Created by',
    'look_profile' => 'Check me out on',
    'employee_customer' => 'Cliente/Empleado',
    'select' => '- Seleccionar -',
    'warning' => 'Advertencia',
    'yes_label' => 'Si',
    'no_label' => 'No',
    'id' => 'Id',
    'name' => 'Nombre',
    'days' => 'Días',
    'payment' => 'Pago',
    'look_up' => 'Buscar',
    'click_here' => 'Click Aqui',
    'sub_total' => 'Sub-Total',
    'bank_name' => 'Nombre del Banco',
    'city_name' => 'Nombre de Ciudad',
    'loading' => 'Cargando',
    'frequency' => 'Frecuencia',
    'next_payment' => 'Siguiente pago',
    'pending_amount' => 'Monto Pendiente',
    'problem_processing_the_request' => 'Hubo un problema al procesar la solicitud, inténtelo de nuevo!',
    'created_at' => 'Creado en',
    'updated_at' => 'Actualizado en',
    'total' => 'Total',
    'interest' => 'Intereses',
    'options' => 'Opciones',
    'edit_label' => 'Editar',
    'approve_label' => 'Aprobar',
    'reject_label' => 'Rechazar',
    'loan_info' => 'Prestamo :loan Información',
    'see_more' => 'Ver más',
    'add_surcharge' => 'Agregar Recargo',
    'add_payment' => 'Agregar Pago',
    'member_since' => 'Miembro desde :date',
    'sign_out' => 'Desconectar',
    'surcharge' => 'Recargo',
    'customers' => 'Clientes',
    'outstanding' => 'Pendiente por Pagar',
    'revenue' => 'Ingresos',
    'create_by' => 'Creado por',
    'user_employee' => 'Usuario/Empleado',
    'installment' => 'Cuota',
];
