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
        'female' => 'Female',
        'male' => 'Male',
    ],

    'identification_type' => [
        'cc' => 'CC',
        'ce' => 'CE',
    ],

    'type_status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'delete' => 'Delete',
    ],

    'loans_payment_status' => [
        'pending' => 'Pending',
        'unpaid' => 'Unpaid',
        'paid' => 'Paid',
        'onhold' => 'On Hold',
        'process' => 'On Process',
        'rejected' => 'Rejected'
    ],

    'payments_methods' => [
        'cash' => 'Cash',
        'check' => 'Check',
        'transfer' => 'Transfer',
    ],

    'payments_concepts' => [
        'payment' => 'Payment',
        'surcharge' => 'Surcharge',
        'other' => 'Other'
    ],

    'payments_status' => [
        'active' => 'Active',
        'inactive' => 'Inactive'
    ],

    'installments_status' => [
        'pending' => 'Pending',
        'paid' => 'Paid',
        'rejected' => 'Rejected',
        'process' => 'Process'
    ],

    'payments_type' => [
        'capital' => 'Capital',
        'interest' => 'Interest',
        'installment' => 'Installment'
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
        'linked' => 'Linked',
        'independent' => 'Independent',
        'temporary' => 'Temporary',
    ],

    'affiliation_type' => [
        'contributor' => 'Contributor',
        'beneficiary' => 'Beneficiary',
    ],

    'reference_type' => [
        'family' => 'Family',
        'personal' => 'Personal',
        'cosigner' => 'Cosigner',
    ],

    'document_type' => [
        'cc' => 'CC',
        'services' => 'Services',
        'letter' => 'Letter',
        'others' => 'Others',
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
        'employees_list' => 'Employees List',
        'employees_list_descrip' => 'Management Module',
        'employees_add' => 'Add new employee',
        'employees_edit' => 'Edit a employee',
        'employees_add_descrip_01' => 'Personal fields',
        'employees_add_descrip_02' => 'Account fields',
        'customers_list' => 'Customers List',
        'customers_list_descrip' => 'Management Module',
        'customers_add' => 'Add new customer',
        'customers_edit' => 'Edit a customer',
        'customers_step1_1' => 'Personal information',
        'customers_step1_2' => 'Address and Phone information',
        'customers_step2_1' => 'Employment information',
        'customers_step2_2' => 'More information about employment',
        'customers_step3_1' => 'References',
        'customers_step3_2' => 'More information about References',
        'customers_step4_1' => 'Upload Documents',
        'customers_step4_2' => 'Documents loaded',
        'customers_step5' => 'Complete',
        'loans_list' => 'Loans List',
        'loans_list_descrip' => 'Management Module',
        'request_loan' => 'Request Loan',
        'request_loan_descrip_01' => 'Loan Fields',
        'request_loan_descrip_02' => 'Loan Projection',
        'request_loan_descrip_03' => 'Loan Installments',
        'full_calendar' => 'Full Calendar',
        'full_calendar_des' => 'Dates Controller',
        'calendar_holydays' => 'Holydays',
        'payments_list' => 'Payments List',
        'payments_list_descrip' => 'Management Module',
        'banks_list' => 'Banks List',
        'banks_list_descrip' => 'Management Module',
        'banks_add' => 'Add New Bank',
        'banks_edit' => 'Edit Bank',
        'banks_title_section' => 'Bank informations fields',
        'cities_list' => 'Cities List',
        'cities_list_descrip' => 'Management Module',
        'cities_add' => 'Add New City',
        'cities_edit' => 'Edit City',
        'cities_title_section' => 'City informations fields',
        'payments_freq_list' => 'Payments Frecuences List',
        'payments_freq_list_descrip' => 'Management Module',
        'payments_freq_add' => 'Add new payment frecuence',
        'payments_freq_edit' => 'Edit new payment frecuence',
        'request_payment' => 'Request Payment',
        'payments_add_title' => 'Add a new payment',
        'payments_edit_title' => 'Edit a payment',
        'see_installments' => 'Installments',
        'surcharges_list' => 'Surcharges List',
        'upcoming_payments' => 'Upcoming Payments',
        'upcoming_installments' => 'Upcoming Installments',
        'upcoming_surcharges' => 'Upcoming Surcharges'
    ],

    'side_bar' => [
        'employees' => 'Employees',
        'customers' => 'Customers',
        'loans' => 'Loans',
        'full_calendar' => 'Calendar',
        'holydays' => 'Holydays',
        'payments' => 'Payments',
        'maintenance' => 'Maintenance',
        'settings' => 'Settings',
        'banks' => 'Banks',
        'cities' => 'Cities',
        'payments_frequency' => 'Payments Frequency',
        'surcharges' => 'Surcharges',
    ],

    'relationship' => [
        'grandmother' => 'Grandmother',
        'grandfather' => 'Grandfather',
        'mother' => 'Mother',
        'father' => 'Father',
        'son' => 'Son',
        'daughter' => 'Daughter',
        'grandson' => 'Grandson',
        'granddaughter' => 'Granddaughter',
        'uncle' => 'Uncle',
        'aunt' => 'Aunt',
        'nephew' => 'Nephew',
        'niece' => 'Niece',
        'brother' => 'Brother',
        'sister' => 'Sister',
        'cousin' => 'Cousin',
        'spouse' => 'Spouse',
        'son_in_law' => 'Son in Law',
        'daughter_in_law' => 'Daughter in Law',
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

    'app_title' => 'Loans :: ',
    'success_alert_title' => 'Success',
    'error_alert_title' => 'Oh No!',
    'twitter_label' => 'Twitter',
    'facebook_label' => 'Facebook',
    'search' => 'Search',
    'menu_header' => 'Loans Menu',
    'contentheader_title' => 'Loans Manager Application',
    'add_new' => 'Add new',
    'employee' => 'Employee',
    'customer' => 'Customer',
    'bank' => 'Bank',
    'payment_frequency' => 'Payment Frequency',
    'city' => 'City',
    'loans' => 'Loans',
    'profile' => 'Profile',
    'type_payment' => 'Type Payment',
    'online' => 'Online',
    'type' => 'Type',
    'verified' => 'Verified',
    'status' => 'Status',
    'description' => 'Description',
    'photo' => 'Photo',
    'previous' => 'Previous',
    'submit' => 'Submit',
    'save' => 'Save',
    'submit_continue' => 'Submit and continue',
    'finish' => 'Finish',
    'success_procces' => 'The request was processed successfully!',
    'actions' => 'Actions',
    'copyright' => 'Copyright',
    'created_by' => 'Created by',
    'look_profile' => 'Check me out on',
    'employee_customer' => 'Customer/Employee',
    'select' => '- Select -',
    'updated_at' => 'Updated at',
    'warning' => 'Warning',
    'yes_label' => 'Yes',
    'no_label' => 'No',
    'id' => 'Id',
    'name' => 'Name',
    'days' => 'Days',
    'payment' => 'Payment',
    'look_up' => 'Look Up',
    'click_here' => 'Click Here',
    'sub_total' => 'Sub-Total',
    'bank_name' => 'Bank Name',
    'city_name' => 'City Name',
    'loading' => 'Loading',
    'frequency' => 'Frequency',
    'next_payment' => 'Next Payment',
    'pending_amount' => 'Pending Amount',
    'problem_processing_the_request' => 'There was a problem processing the request, try again!',
    'created_at' => 'Created At',
    'updated_at' => 'Updated At',
    'total' => 'Total',
    'interest' => 'Interest',
    'options' => 'Options',
    'edit_label' => 'Edit',
    'approve_label' => 'Approve',
    'reject_label' => 'Reject',
    'loan_info' => 'Loan :loan Information',
    'see_more' => 'See More',
    'add_surcharge' => 'Add Surcharge',
    'add_payment' => 'Add Payment',
    'member_since' => 'Member since :date',
    'sign_out' => 'Sign out',
    'surcharge' => 'Surcharge',
    'customers' => 'Customers',
    'outstanding' => 'Outstanding',
    'revenue' => 'Revenue',
    'create_by' => 'Create by',
    'user_employee' => 'User/Employee',
    'installment' => 'Installment',
];
