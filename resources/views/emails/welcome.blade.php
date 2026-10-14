<div>
    <h1>Welcome, {{ $user->name }}!</h1>
    <p>Your account has been created. Here are your login details:</p>
    <ul>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>
    <p>Please log in and change your password as soon as possible.</p>
    <p>Thanks,<br>{{ config('app.name') }}</p>
</div>
