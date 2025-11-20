<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate; // Menggunakan atribut validasi PHP 8

#[Layout('components.layouts.app')]
class Login extends Component
{
    // Menggunakan atribut Validate langsung di properti (gaya Livewire 3 modern)
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Method untuk memproses login
     */
    public function login()
    {
        // 1. Validasi input berdasarkan atribut #[Validate] di atas
        $this->validate();

        // 2. Coba login menggunakan Auth facade
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            
            // 3. Regenerasi ID sesi untuk keamanan (mencegah session fixation)
            session()->regenerate();

            // 4. Redirect ke halaman utama ('/')
            // navigate: true membuat transisi lebih cepat (SPA mode)
            return $this->redirect('/', navigate: true);
        }

        // 5. Jika login gagal
        // Kirim error ke field email
        $this->addError('email', 'Email atau password yang Anda masukkan salah.');
        
        // Kosongkan password agar pengguna mengetik ulang
        $this->reset('password');
    }

    // Tidak perlu method render() jika menggunakan atribut #[Layout] dan nama file view sesuai konvensi
}