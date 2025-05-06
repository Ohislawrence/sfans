<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">
            <i class="fab fa-youtube"></i>
            Sign in to YouTube
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf
            <div class="mb-3">
              <input type="email" name="email" class="form-control" id="loginEmail" placeholder="Email" :value="old('email')" required>
              <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div class="mb-3">
              <input type="password" name="password" class="form-control" id="loginPassword" placeholder="Password" required>
              <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            
            <div class="login-form-footer">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="rememberLogin">
                <label class="form-check-label" for="rememberLogin">Remember me</label>
              </div>
              <a href="#" class="text-decoration-none">Need help?</a>
            </div>
            
            <button type="submit" class="btn btn-modal-login w-100 mb-3">Sign in</button>
            
            <div class="login-divider">or</div>
            
            <button type="button" class="btn btn-modal-secondary w-100">
              <i class="fab fa-google me-2"></i> Sign in with Google
            </button>
          </form>
        </div>
        <div class="modal-footer">
          <span>Don't have an account?</span>
          <button type="button" class="btn btn-link p-0" style="color: var(--yt-red);">Sign up</button>
        </div>
      </div>
    </div>
  </div>