<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send OTP</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <h1>Enter your Phone Number</h1>
    <form action="{{ route('send.otp') }}" method="POST">
        @csrf
        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" id="phone_number" required>
        <button type="button" id="send-otp">Send OTP</button>
    </form>

    @if($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <script>
        $(document).ready(function() {
            $('#send-otp').on('click', function() {
                var phone_number = $('#phone_number').val();
                $.ajax({
                    url: '{{ route('send.otp') }}',
                    method: 'POST',
                    data: {
                        phone_number: phone_number,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = '{{ route('verify.otp') }}';
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
