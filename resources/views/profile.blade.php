@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="luxury-card">
                <div class="luxury-card-header">
                    <h3 class="luxury-title">Update Your Profile</h3>
                    <div class="luxury-divider"></div>
                </div>

                <div class="luxury-card-body">
                    @if(session('success'))
                        <div class="luxury-alert success">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                            </div>
                            <button type="button" class="luxury-close" data-bs-dismiss="alert">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="luxury-form">
                        @csrf
                        @method('PUT')

                        <div class="luxury-form-grid">
                            <div class="luxury-form-group">
                                <label for="name" class="luxury-label">Full Name</label>
                                <div class="luxury-input-wrapper">
                                    <i class="fas fa-user luxury-icon"></i>
                                    <input id="name" type="text" class="luxury-input @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name', Auth::user()->name) }}" required autocomplete="name">
                                </div>
                                @error('name')
                                    <span class="luxury-error">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="luxury-form-group">
                                <label for="email" class="luxury-label">Email Address</label>
                                <div class="luxury-input-wrapper">
                                    <i class="fas fa-envelope luxury-icon"></i>
                                    <input id="email" type="email" class="luxury-input @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email', Auth::user()->email) }}" required autocomplete="email">
                                </div>
                                @error('email')
                                    <span class="luxury-error">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="luxury-form-group">
                            <label for="profile_photo" class="luxury-label">Profile Photo</label>
                            <div class="luxury-upload-area">
                                <div class="luxury-upload-box">
                                    <i class="fas fa-camera luxury-upload-icon"></i>
                                    <div class="luxury-upload-text">Click to upload or drag and drop</div>
                                    <input type="file" class="luxury-file-input @error('profile_photo') is-invalid @enderror" 
                                           id="profile_photo" name="profile_photo" accept="image/*">
                                </div>
                                @if(Auth::user()->profile_photo)
                                    <div class="luxury-current-photo">
                                        <div class="luxury-photo-preview">
                                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" 
                                                 alt="Current Profile Photo" 
                                                 class="luxury-thumbnail">
                                            <div class="luxury-photo-overlay">
                                                <span>Current Photo</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @error('profile_photo')
                                <span class="luxury-error">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </span>
                            @enderror
                            <div class="luxury-hint">Max file size: 2MB (JPEG, PNG, JPG)</div>
                        </div>

                        <div class="luxury-form-group">
                            <button type="submit" class="luxury-btn primary">
                                <i class="fas fa-save me-2"></i>Update Profile
                            </button>
                        </div>
                    </form>

                    <div class="luxury-section-divider">
                        <span>Change Password</span>
                    </div>

                    <form method="POST" action="{{ route('password.update') }}" class="luxury-form">
                        @csrf
                        @method('PUT')

                        <div class="luxury-form-group">
                            <label for="current_password" class="luxury-label">Current Password</label>
                            <div class="luxury-input-wrapper">
                                <i class="fas fa-lock luxury-icon"></i>
                                <input id="current_password" type="password" 
                                       class="luxury-input @error('current_password') is-invalid @enderror" 
                                       name="current_password" required>
                                <span class="luxury-password-toggle" data-target="current_password">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                            @error('current_password')
                                <span class="luxury-error">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="luxury-form-group">
                            <label for="password" class="luxury-label">New Password</label>
                            <div class="luxury-input-wrapper">
                                <i class="fas fa-key luxury-icon"></i>
                                <input id="password" type="password" 
                                       class="luxury-input @error('password') is-invalid @enderror" 
                                       name="password" required>
                                <span class="luxury-password-toggle" data-target="password">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                            @error('password')
                                <span class="luxury-error">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="luxury-form-group">
                            <label for="password_confirmation" class="luxury-label">Confirm New Password</label>
                            <div class="luxury-input-wrapper">
                                <i class="fas fa-key luxury-icon"></i>
                                <input id="password_confirmation" type="password" class="luxury-input" 
                                       name="password_confirmation" required>
                                <span class="luxury-password-toggle" data-target="password_confirmation">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div class="luxury-form-group">
                            <button type="submit" class="luxury-btn primary">
                                <i class="fas fa-key me-2"></i>Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Pink Color Palette */
    :root {
        --luxury-primary: #ff69b4; /* Hot pink */
        --luxury-secondary: #db7093; /* Pale violet red */
        --luxury-dark: #1a1a1a; /* Dark background */
        --luxury-light: #fff0f5; /* Lavender blush */
        --luxury-accent: #ffb6c1; /* Light pink */
        --luxury-error: #e74c3c; /* Soft red */
        --luxury-success: #2ecc71; /* Soft green */
        --luxury-border: rgba(255, 105, 180, 0.3); /* Pink with transparency */
    }

    /* Luxury Card Styles */
    .luxury-card {
        background-color: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid var(--luxury-border);
    }

    .luxury-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }

    .luxury-card-header {
        background: linear-gradient(135deg, var(--luxury-primary), var(--luxury-secondary));
        padding: 2rem;
        text-align: center;
        position: relative;
    }

    .luxury-title {
        color: white;
        font-weight: 300;
        font-size: 1.8rem;
        letter-spacing: 1px;
        margin: 0;
    }

    .luxury-divider {
        height: 2px;
        width: 80px;
        background-color: white;
        margin: 1rem auto;
        opacity: 0.5;
    }

    .luxury-card-body {
        padding: 2.5rem;
    }

    /* Alert Styles */
    .luxury-alert {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }

    .luxury-alert.success {
        background-color: rgba(46, 204, 113, 0.1);
        border-left: 4px solid var(--luxury-success);
        color: var(--luxury-success);
    }

    .luxury-close {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        font-size: 1rem;
        opacity: 0.7;
        transition: opacity 0.3s;
    }

    .luxury-close:hover {
        opacity: 1;
    }

    /* Form Styles */
    .luxury-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .luxury-form-group {
        margin-bottom: 1.5rem;
    }

    .luxury-label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--luxury-secondary);
        font-weight: 500;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }

    .luxury-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .luxury-icon {
        position: absolute;
        left: 1rem;
        color: var(--luxury-secondary);
        font-size: 1rem;
    }

    .luxury-input {
        width: 100%;
        padding: 0.8rem 1rem 0.8rem 2.5rem;
        border: 1px solid var(--luxury-border);
        border-radius: 8px;
        background-color: white;
        color: #333;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
    }

    .luxury-input:focus {
        border-color: var(--luxury-primary);
        box-shadow: 0 0 0 3px rgba(255, 105, 180, 0.2);
        outline: none;
    }

    .luxury-password-toggle {
        position: absolute;
        right: 1rem;
        cursor: pointer;
        color: var(--luxury-secondary);
        transition: color 0.3s;
    }

    .luxury-password-toggle:hover {
        color: var(--luxury-primary);
    }

    .luxury-error {
        display: block;
        margin-top: 0.5rem;
        color: var(--luxury-error);
        font-size: 0.85rem;
    }

    .luxury-hint {
        font-size: 0.8rem;
        color: #999;
        margin-top: 0.5rem;
    }

    /* Button Styles */
    .luxury-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.8rem 2rem;
        border-radius: 8px;
        font-weight: 500;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        width: 100%;
    }

    .luxury-btn.primary {
        background-color: var(--luxury-primary);
        color: white;
        box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3);
    }

    .luxury-btn.primary:hover {
        background-color: #e6499e;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 105, 180, 0.4);
    }

    /* Upload Area */
    .luxury-upload-area {
        display: flex;
        gap: 1.5rem;
        align-items: center;
    }

    .luxury-upload-box {
        position: relative;
        width: 180px;
        height: 180px;
        border: 2px dashed var(--luxury-border);
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: rgba(255, 105, 180, 0.05);
    }

    .luxury-upload-box:hover {
        border-color: var(--luxury-primary);
        background-color: rgba(255, 105, 180, 0.1);
    }

    .luxury-upload-icon {
        font-size: 2rem;
        color: var(--luxury-secondary);
        margin-bottom: 0.5rem;
    }

    .luxury-upload-text {
        font-size: 0.85rem;
        color: var(--luxury-secondary);
        padding: 0 1rem;
    }

    .luxury-file-input {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    /* Current Photo Preview */
    .luxury-current-photo {
        position: relative;
    }

    .luxury-thumbnail {
        width: 180px;
        height: 180px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--luxury-border);
    }

    .luxury-photo-preview {
        position: relative;
    }

    .luxury-photo-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        padding: 0.5rem;
        text-align: center;
        font-size: 0.8rem;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    /* Section Divider */
    .luxury-section-divider {
        display: flex;
        align-items: center;
        margin: 2rem 0;
        color: var(--luxury-secondary);
    }

    .luxury-section-divider::before,
    .luxury-section-divider::after {
        content: "";
        flex: 1;
        border-bottom: 1px solid var(--luxury-border);
    }

    .luxury-section-divider span {
        padding: 0 1rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .luxury-form-grid {
            grid-template-columns: 1fr;
        }
        
        .luxury-upload-area {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .luxury-card-body {
            padding: 1.5rem;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    document.querySelectorAll('.luxury-password-toggle').forEach(function(element) {
        element.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Preview uploaded image
    const fileInput = document.getElementById('profile_photo');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const previewArea = document.querySelector('.luxury-upload-box');
                    if (previewArea) {
                        previewArea.innerHTML = `
                            <img src="${event.target.result}" class="luxury-thumbnail" alt="Preview">
                            <div class="luxury-photo-overlay">New Photo</div>
                        `;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endsection