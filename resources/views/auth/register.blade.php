<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{asset('img/ProjectIcon.png')}}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->	
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet"> <!-- External Css-->
    <script type="text/javascript" src="/js/script.js"></script> <!-- External JS -->

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Google captcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
	
	<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
  }

  section {
    position: relative;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
  }

  section .container {
    position: relative;
    width: 1000px;
    height: 1500px;
    background: #fff;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    overflow: hidden;
  }

  section .container .user {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
  }

  section .container .user .imgBx {
    position: relative;
    width: 50%;
    height: 100%;
    background: #ff0;
    transition: 0.5s;
  }

  section .container .user .imgBx img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  section .container .user .formBx {
    position: relative;
    width: 50%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px;
    transition: 0.5s;
  }

  section .container .user .formBx form h2 {
    font-size: 18px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    text-align: center;
    width: 100%;
    margin-bottom: 10px;
    color: #555;
  }

  section .container .user .formBx form input {
    position: relative;
    width: 100%;
    padding: 10px;
    background: #f5f5f5;
    color: #333;
    border: none;
    outline: none;
    box-shadow: none;
    margin: 8px 0;
    font-size: 14px;
    letter-spacing: 1px;
    font-weight: 300;
  }

  section .container .user .formBx form input[type='submit'] {
    max-width: 130px;
    background: #677eff;
    color: #fff;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 1px;
    transition: 0.5s;
  }


  section .container .user .formBx form .signup a {
    font-weight: 600;
    text-decoration: none;
    color: #677eff;
  }


  section .container .signinBx .formBx {
    left: 0%;
  }

  section .container.active .signinBx .formBx {
    left: 100%;
  }

  section .container .signinBx .imgBx {
    left: 0%;
  }

  section .container.active .signinBx .imgBx {
    left: -100%;
  }

  @media (max-width: 991px) {
    section .container {
      max-width: 400px;
    }

    section .container .imgBx {
      display: none;
    }

    section .container .user .formBx {
      width: 100%;
      }
  }

  
</style>

</head>
<body>


<section>
    <div class="container shadow-lg">

    <div class="user signinBx">
        <div class="formBx">
          <form method="POST" action="{{ route('register') }}">
          @csrf
			<a href="/"><img src="img/logo.png" class="auto ms-5"></a>
			<br>		  
            <h2>Create an account</h2>

            <div>
                <input type="text" name="firstName" class="form-control @error('firstName') is-invalid @enderror" value="{{ old('firstName') }}" placeholder="First Name" required autocomplete="firstName">
                @error('firstName')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror                
            </div>

            <div>
                <input type="text" name="lastName" class="form-control @error('lastName') is-invalid @enderror" value="{{ old('lastName') }}" placeholder="Last Name" required autocomplete="lastName">
                @error('lastName')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror                
            </div>
            
            <div>
                <input type="text" name="middleName" class="form-control @error('middleName') is-invalid @enderror" value="{{ old('middleName') }}" placeholder="Middle Name">
                @error('middleName')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror                
            </div>

            <div>
                Day of Birth
                <input type="date" name="birthDate" class="form-control @error('birthDate') is-invalid @enderror" required autocomplete="birthDate">
                @error('birthDate')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror                
            </div>

            <div>
                Gender
                <select name="gender" id="gender" type="text" class="text-center form-control @error('gender') is-invalid @enderror" required autocomplete="select gender">
                    <option value="none" selected disabled hidden>-------- Select Gender ---------</option>                             
                    <option value="Male" >Male</option>
                    <option value="Female">Female</option>
                </select>
                @error('gender')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror               
            </div>

            <br>
            
            Phone Number
            <div class="d-flex justify-content-start">
              <div class="bd-highlight mt-3 me-2">
                +63
              </div>	
              <div class="bd-highlight w-100">
                <input type="text" name="contactNo" class="form-control @error('contactNo') is-invalid @enderror"  value="{{ old('contactNo') }}" placeholder="Contact No: +63 or 09" required autocomplete="contactNo">
                @error('contactNo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>								
            </div>	
            
            <div>
                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" placeholder="City" required autocomplete="city">
                @error('city')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror                
            </div>

            
            <div>
                <input type="text" name="barangay" class="form-control @error('barangay') is-invalid @enderror" value="{{ old('barangay') }}" placeholder="Barangay" required autocomplete="barangay">
                @error('barangay')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror                
            </div>

            <div>
                <input type="text" name="streetNumber" class="form-control @error('streetNumber') is-invalid @enderror" value="{{ old('streetNumber') }}" placeholder="Street" required autocomplete="streetNumber">
                @error('streetNumber')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror                
            </div>

            <div>
                <input type="text" name="zipCode" class="form-control @error('zipCode') is-invalid @enderror" value="{{ old('zipCode') }}" placeholder="Zip Code" required autocomplete="zipCode">
                @error('zipCode')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror                
            </div>


            <div>
                Type of User
                <select name="userType" id="userType" type="text" class="text-center form-control @error('userType') is-invalid @enderror" required autocomplete="select type of user">
                  <option value="none" selected disabled hidden>-------- Select Type of User ---------</option>                           
                    <option value="ClinicAdmin" >Clinic Admin</option>
                    <option value="ClinicEmployee">Clinic Employee</option>
                    <option value="Patient">Patient</option>
                </select>
                @error('userType')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror               
            </div>  

            <div>
                <input id="email" type="email" class="form-control @error('email')   is-invalid @enderror" name="email" placeholder="Email Address">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror               
            </div>  


            <div>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror             
            </div> 

            <div>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">        
            </div>    

            <br>
                  
            <div class="d-flex justify-content-center">
              <div class="w-50">
                <input type="checkbox" name="consent" value="1" required> 

              </div>
              <div>
                <p>I give my consent for processing my confidential data and agrees to the 
                  <a class="text-decoration-none pink" data-bs-toggle="modal" data-bs-target="#terms">Terms and Conditions</a>
                  @include('inc.terms')
                </p>
              </div>              
            </div>

            <br>

			  <p class="signup">
              Already have an account ?
              <a href="{{ route('login') }}" style="color: #34BE82;">Log in</a>
            </p>
		
            <button type="submit" class="btn btn-outline" style="background-color: #34BE82; float:right; color: white; width:25%">
                Signup
            </button>
			<br><br><br>

          </form>
        </div>
        <div class="imgBx"><img src="img/login2.jpg"></div>
      </div>    
    </div>

  </section>



</body>
</html>
