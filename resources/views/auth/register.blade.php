<form action="{{ route('process_register') }}" method="post">
 @csrf
    Name
    <input type="name" name="name">
    <br>
    Email
    <input type="email" name="email">
    <br>
    Password
    <input type="password" name="password">
    <br>
    <button>
        Register
    </button>
</form>
