@extends('emails.template')
@section('content')
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; text-align:left">
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td align="left">
            {{ trans('email.forgot_pass.msg_01') }}
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td align="left">
            {{ trans('email.forgot_pass.msg_02') }}&nbsp;
            <a href="mailto:{{ $main_company['support_email'] }}">{{ $main_company['support_email'] }}</a>&nbsp;
            {{ trans('email.forgot_pass.msg_03') }}
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td align="left">
            <strong>{{ trans('email.access_infotmation') }}</strong>
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td align="left">
            {{ trans('auth.log_in') }}:&nbsp;{{ $data['email'] }}
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td align="left">
            {{ trans('auth.password') }}:&nbsp;{{ $data['password'] }}
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td align="left">
           <strong>{{ trans('email.forgot_pass.msg_04') }}</strong>
        </td>
    </tr>
</table>
@endsection