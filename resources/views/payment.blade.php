<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        {{-- src="https://app.midtrans.com/snap/snap.js" --}}
        {{-- data-client-key="SB-Mid-client-LuRh4t6hempU6vad" --}}
        data-client-key="SB-Mid-client-zcC2S_n3IG42W4D5"
        {{-- data-client-key="Mid-client-XZCR9t5ePdhcGaNC" --}}
        ></script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Studio Poonya</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/logopo.png" rel="icon">
    <link href="assets/img/logopo.png" rel="logo">

    {{-- font awesome --}}
    <script src="https://kit.fontawesome.com/f573b69a51.js" crossorigin="anonymous"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mada:wght@700&display=swap" rel="stylesheet">
    {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet"> --}}


    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.1.1/css/fontawesome.min.css"
        integrity="sha384-zIaWifL2YFF1qaDiAo0JFgsmasocJ/rqu7LKYH8CoBEXqGbb9eO+Xi3s6fQhgFWM" crossorigin="anonymous">
    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>


    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">

        <div class="container" data-aos="zoom-out" data-aos-delay="100">
          <div class="row">
            <div class="col-xl-6">
              <h1>EVERYONE</h1>
              <h2>HAD FUN</h2>
              <button class="btn-get-started scrollto" id="pay-button">Start Photo</button>&nbsp;&nbsp;&nbsp;
              <button class="btn-get-started2 scrollto">Booking Photo</button>
            </div>

            <div class="mt-3">
                <form action="{{ route('redeemCode') }}">
                    <i class="fas fa-tags" style="color: white; size:20px" ></i>
                    <input type="text" placeholder="Do you have a coupon?" name="codeInput">
                    <button type="submit" class="btn-get-started" id="redeemCode">Reedem</button>
                </form>
            </div>
          </div>
        </div>

      </section>

    {{-- <section id="hero" class="d-flex align-items-center">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 pt-2 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
                    <div>
                        <h1>Show Your</h1><br>
                    </div>
                    <h2>Best Expresion</h2>
                    <br>
                    <button onclick="myFunction()">Click me</button>

                    <div class="mt-3">
                        <button class="btn-get-started scrollto" id="pay-button">Start Photo</button>
                        <button class="btn-get-quote">Booking Photo</button>
                    </div>
                    <div class="mt-3">
                        <form action="{{ route('redeemCode') }}">
                            <i class="fas fa-tags"></i>
                            <input type="text" placeholder="Do you have a coupon?" name="codeInput">
                            <button type="submit" class="btn-get-redeem" id="redeemCode">Reedem</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img">
                    <img src="assets/img/MGroup.png" class="img-fluid mb-3" alt="">
                </div>
            </div>
        </div>
    </section> --}}



    {{-- <form action="" id="submit_form" method="POST">
        @csrf
        <input type="hidden" name="json" id="json_callback">

    </form> --}}

    <script type="text/javascript">
        $(function() {
            $("#pay-button").click(function() {
                // $.ajax('{{config("app.url")}}api/init-camera', {
                //     method:'post',
                // })
                // $.ajax('http://localhost:1500/api/start?mode=print&password=I9okCyP7dih2QEQs', {
                //     success: function(data, status, xhr) {
                //         console.log(data);
                //     }
                // })
                $.ajax('{{config("app.url")}}generatePayment', {
                    //  dataType: 'json', // type of response data
                    timeout: 2000, // timeout milliseconds
                    success: function(data, status, xhr) { // success callback function
                        console.log(data)
                        window.snap.pay(data, {
                            onSuccess: function(result) {
                                /* You may add your own implementation here */
                                $.ajax('{{config("app.url")}}api/init-camera', {
                                    method:'post',
                                })
                            },
                            onPending: function(result) {
                                /* You may add your own implementation here */
                                console.log(result);
                                send_response_to_form(result);
                            },
                            onError: function(result) {
                                /* You may add your own implementation here */
                                console.log(result);
                                send_response_to_form(result);
                            },
                            onClose: function() {
                                /* You may add your own implementation here */
                                // alert('you closed the popup without finishing the payment');
                                // send_response_to_form(result);
                            }
                        })
                        //  $('p').append(data.firstName + ' ' + data.middleName + ' ' + data.lastName);
                    },
                    error: function(jqXhr, textStatus, errorMessage) { // error callback
                        console.log(errorMessage)
                    }
                });
            });
            // For example trigger on button clicked, or any time you need

            // payButton.addEventListener('click', function () {

            //   // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            //   window.snap.pay('', {
            //     onSuccess: function(result){
            //       /* You may add your own implementation here */
            //       console.log(result);
            //       send_response_to_form(result);
            //     },
            //     onPending: function(result){
            //       /* You may add your own implementation here */
            //       console.log(result);
            //       send_response_to_form(result);
            //     },
            //     onError: function(result){
            //       /* You may add your own implementation here */
            //      console.log(result);
            //       send_response_to_form(result);
            //     },
            //     onClose: function(){
            //       /* You may add your own implementation here */
            //       alert('you closed the popup without finishing the payment');
            //       send_response_to_form(result);
            //     }
            //   })
            // });

            function send_response_to_form(result) {
                document.getElementById('json_callback').value = JSON.stringify(result);
                console.log(result)
                $('#submit_form').submit();
            }
        });
    </script>

    {{-- <script>
        function myFunction() {
            // document.getElementById("demo").innerHTML = "Hello World";
            var oShell = new ActiveXObject("Shell.Application");
            var commandtoRun = "C:\\Windows\\notepad.exe";
            oShell.ShellExecute(commandtoRun, "", "", "open", "1");
        }
    </script> --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(function() {
            // Swal.fire({ //displays a pop up with sweetalert
            //     icon: 'success',
            //     title: "hello",
            //     showConfirmButton: false,
            //     timer: 1000
            // });
            @if (Session::has('success'))
                Swal.fire({ //displays a pop up with sweetalert
                    icon: 'success',
                    title: "{{ Session::get('success') }}",
                    showConfirmButton: false,
                    timer: 1000
                });
            @endif

            @if (Session::has('error'))
                Swal.fire({ //displays a pop up with sweetalert
                    icon: 'error',
                    title: "{{ Session::get('error') }}",
                    showConfirmButton: false,
                    timer: 1000
                });
            @endif
        });
    </script>

</body>

</html>
