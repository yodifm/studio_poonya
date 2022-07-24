<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{url('assets/style.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
  </head>
  <body>
    <form action="/payment" method="GET" >
      <h1>Data diri</h1>
      <div class="formcontainer">
      <hr/>
      <div class="container">
        <label for="uname"><strong>Nama</strong></label>
        <input type="text" placeholder="Enter Nama" name="uname" required>
        <label for="uname"><strong>Email</strong></label>
        <input type="text" placeholder="Enter Email" name="email" required>
        <label for="uname"><strong>Number</strong></label>
        <input type="text" placeholder="Enter number" name="number" required>
       
      </div>
      <button type="submit">Lanjut</button>
    </form>
    @if(session('alert-success'))
    <script>alert("{{session('alert-success')}}")</script>
    @elseif(session('alert-failed'))
    <script>alert("{{session('alert-failed')}}")</script>
    @endif
  </body>
</html>