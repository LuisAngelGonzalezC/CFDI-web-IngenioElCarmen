@component('mail::message')
# Verificación de correo electrónico

Hola {{ $user->name }}.
<br>
Gracias por registrar tu correo electrónico para recibir tus CFDIs al instante, da clic en el botón para terminar el proceso de verificación. 
<br><br>
¡Saludos!
<br><br>
Departamento de informática.
<br>

@component('mail::button', ['url' => route('email.validation',['confirmation_code' => $user->confirmation_code, 'email' => $user->email])])
Verificar
@endcomponent

En caso de no funcionar el botón, copiar el enlace en el navegador web de su preferencia.
<br>
<a href="{{ route('email.validation',['confirmation_code' => $user->confirmation_code, 'email' => $user->email]) }}">{{ route('email.validation',['confirmation_code' => $user->confirmation_code, 'email' => $user->email]) }}</a>
@endcomponent
