@extends('layouts.authlayout')
@section('title',  'Refund Policy' )
@section('type',  'website' )
@section('url',  Request::url() )
@section('image',  asset("images/tracklia-page.jpg") )
@section('description',  'This policy is effective as of 11th November 2024' )
@section('imagealt',  'Refund Policy image' )


@section('header')
@endsection




@section('footer')
<script>
    // Password strength indicator
    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('passwordStrengthBar');
    const lengthHint = document.getElementById('lengthHint');
    const numberHint = document.getElementById('numberHint');
    const specialHint = document.getElementById('specialHint');

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        
        // Check password length
        if (password.length >= 8) {
            strength += 1;
            lengthHint.classList.add('valid');
            lengthHint.innerHTML = '<i class="fas fa-check"></i> At least 8 characters';
        } else {
            lengthHint.classList.remove('valid');
            lengthHint.innerHTML = '<i class="fas fa-circle"></i> At least 8 characters';
        }
        
        // Check for numbers
        if (/\d/.test(password)) {
            strength += 1;
            numberHint.classList.add('valid');
            numberHint.innerHTML = '<i class="fas fa-check"></i> Contains a number';
        } else {
            numberHint.classList.remove('valid');
            numberHint.innerHTML = '<i class="fas fa-circle"></i> Contains a number';
        }
        
        // Check for special characters
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
            strength += 1;
            specialHint.classList.add('valid');
            specialHint.innerHTML = '<i class="fas fa-check"></i> Contains a special character';
        } else {
            specialHint.classList.remove('valid');
            specialHint.innerHTML = '<i class="fas fa-circle"></i> Contains a special character';
        }
        
        // Update strength bar
        const width = (strength / 3) * 100;
        strengthBar.style.width = width + '%';
        
        // Change color based on strength
        if (strength === 1) {
            strengthBar.style.backgroundColor = '#ff0000';
        } else if (strength === 2) {
            strengthBar.style.backgroundColor = '#ffa500';
        } else if (strength === 3) {
            strengthBar.style.backgroundColor = '#4CAF50';
        } else {
            strengthBar.style.backgroundColor = '#ff0000';
        }
    });
</script>
@endsection

@section('slot')
<div class="auth-container">
    <div class="auth-header">
        <div class="auth-logo">
            <i class="fa-solid fa-venus-mars"></i>
        </div>
        <h1 class="auth-title">Sign in</h1>
        <p class="auth-subtitle">to continue to SluttyFan</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="row">
            <div class="mb-3">
                <input name="name" type="text" class="form-control" id="name" placeholder="Full name" required>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
        </div>
        
        <div class="mb-3">
            <input type="email" class="form-control" id="email" placeholder="Email" name="email" :value="old('email')" required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        
        <div class="mb-3">
            <input type="password" class="form-control" id="password" placeholder="Password" name="password"
            required autocomplete="new-password" >
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <div class="password-strength mt-2">
                <div class="password-strength-bar" id="passwordStrengthBar"></div>
            </div>
            <div class="password-hints mt-2">
                <div class="password-hint" id="lengthHint">
                    <i class="fas fa-circle"></i> At least 8 characters
                </div>
                <div class="password-hint" id="numberHint">
                    <i class="fas fa-circle"></i> Contains a number
                </div>
                <div class="password-hint" id="specialHint">
                    <i class="fas fa-circle"></i> Contains a special character
                </div>
            </div>
        </div>
        
        <div class="mb-3">
            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm password" name="password_confirmation" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="terms" required>
            <label class="form-check-label" for="terms">
                I agree to the <a href="#" class="auth-link">Terms of Service</a> and <a href="#" class="auth-link">Privacy Policy</a>
            </label>
        </div>
        
        <button type="submit" class="btn btn-register mb-3">Create account</button>
        
        <div class="divider">or</div>
        
        <button type="button" class="btn btn-google mb-3">
            <i class="fab fa-google"></i> Sign up with Google
        </button>
    </form>

    <div class="auth-footer">
        <p>Already have an account? <a href="{{ route('login') }}" class="auth-link">Sign in</a></p>
    </div>
</div>
@endsection
