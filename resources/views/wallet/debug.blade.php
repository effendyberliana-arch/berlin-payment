<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Debug: Enkripsi & Dekripsi') }}
        </h2>
    </x-slot>
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('wallet.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition">
                    ← Kembali
                </a>
            </div>
 
            <!-- Info -->
            <div
                class="mb-6 bg-yellow-50 dark:bg-yellow-900/50 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4">
                <h3 class="font-semibold text-yellow-900 dark:text-yellow-100 mb-2">⚠️ Debug Mode</h3>
                <p class="text-sm text-yellow-800 dark:text-yellow-200">
                    Halaman ini menampilkan data terenkripsi dan terdekripsi untuk tujuan demonstrasi.
                    Dalam produksi, data terenkripsi tidak boleh ditampilkan ke user.
                </p>
            </div>
 
            @if ($wallet && $debugInfo)
                <!-- Encryption Algorithm Info -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            🔐 Informasi Enkripsi
                        </h3>
                        <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                            <p><strong>Algoritma:</strong> AES-256-CBC</p>
                            <p><strong>Framework:</strong> Laravel Crypt (Illuminate\Support\Facades\Crypt)</p>
                            <p><strong>APP_KEY:</strong> Digunakan sebagai encryption key</p>
                            <p><strong>Encrypted At:</strong> {{ $debugInfo['encrypted_at'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
 
                <!-- Virtual Account Debug -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Virtual Account Number
                        </h3>
 
                        <div class="space-y-4">
                            <!-- Decrypted -->
                            <div>
                                <label class="block text-sm font-medium text-green-700 dark:text-green-400 mb-2">
                                    ✓ Data Terdekripsi (Plaintext)
                                </label>
                                <div
                                    class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg p-4">
                                    <p class="font-mono text-sm break-all text-gray-900 dark:text-gray-100">
                                        {{ $debugInfo['decrypted']['virtual_account'] }}
                                    </p>
                                </div>
                                <p class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                                    Ini adalah data asli yang dapat dibaca. Data ini didekripsi secara otomatis saat
                                    diakses melalui model.
                                </p>
                            </div>
 
                            <!-- Encrypted -->
                            <div>
                                <label class="block text-sm font-medium text-red-700 dark:text-red-400 mb-2">
                                    🔒 Data Terenkripsi (Ciphertext)
                                </label>
                                <div
                                    class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg p-4">
                                    <p class="font-mono text-xs break-all text-gray-900 dark:text-gray-100">
                                        {{ $debugInfo['encrypted']['virtual_account'] }}
                                    </p>
                                </div>
                                <p class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                                    Ini adalah data yang tersimpan di database. Data ini tidak dapat dibaca tanpa kunci
                                    dekripsi yang tepat.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
 
                <!-- Balance Debug -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Balance (Saldo)
                        </h3>
 
                        <div class="space-y-4">
                            <!-- Decrypted -->
                            <div>
                                <label class="block text-sm font-medium text-green-700 dark:text-green-400 mb-2">
                                    ✓ Data Terdekripsi (Plaintext)
                                </label>
                                <div
                                    class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg p-4">
                                    <p class="font-mono text-sm break-all text-gray-900 dark:text-gray-100">
                                        {{ $debugInfo['decrypted']['balance'] }}
                                    </p>
                                    <p class="mt-2 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        Rp {{ number_format($debugInfo['decrypted']['balance'], 2, ',', '.') }}
                                    </p>
                                </div>
                                <p class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                                    Ini adalah nilai saldo yang dapat dibaca dan digunakan untuk kalkulasi.
                                </p>
                            </div>
 
                            <!-- Encrypted -->
                            <div>
                                <label class="block text-sm font-medium text-red-700 dark:text-red-400 mb-2">
                                    🔒 Data Terenkripsi (Ciphertext)
                                </label>
                                <div
                                    class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg p-4">
                                    <p class="font-mono text-xs break-all text-gray-900 dark:text-gray-100">
                                        {{ $debugInfo['encrypted']['balance'] }}
                                    </p>
                                </div>
                                <p class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                                    Ini adalah nilai saldo yang terenkripsi di database. Tanpa kunci yang tepat, data
                                    ini tidak dapat didekripsi.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
 
                <!-- How It Works -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            💡 Cara Kerja Enkripsi/Dekripsi
                        </h3>
 
                        <div class="space-y-4 text-sm text-gray-700 dark:text-gray-300">
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Saat Data Disimpan
                                    (Enkripsi):</h4>
                                <ol class="list-decimal list-inside space-y-1 ml-2">
                                    <li>User memasukkan data (plaintext)</li>
                                    <li>Laravel Mutator <code
                                            class="bg-gray-100 dark:bg-gray-700 px-1 rounded">setVirtualAccountAttribute()</code>
                                        dipanggil</li>
                                    <li>Data dienkripsi menggunakan <code
                                            class="bg-gray-100 dark:bg-gray-700 px-1 rounded">Crypt::encryptString()</code>
                                    </li>
                                    <li>Data terenkripsi (ciphertext) disimpan ke database</li>
                                </ol>
                            </div>
 
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Saat Data Dibaca
                                    (Dekripsi):</h4>
                                <ol class="list-decimal list-inside space-y-1 ml-2">
                                    <li>Data terenkripsi diambil dari database</li>
                                    <li>Laravel Accessor <code
                                            class="bg-gray-100 dark:bg-gray-700 px-1 rounded">getVirtualAccountAttribute()</code>
                                        dipanggil</li>
                                    <li>Data didekripsi menggunakan <code
                                            class="bg-gray-100 dark:bg-gray-700 px-1 rounded">Crypt::decryptString()</code>
                                    </li>
                                    <li>Data asli (plaintext) dikembalikan ke aplikasi</li>
                                </ol>
                            </div>
 
                            <div
                                class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-4 mt-4">
                                <p class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Keamanan:</p>
                                <ul class="list-disc list-inside space-y-1 ml-2">
                                    <li>Menggunakan APP_KEY dari .env sebagai kunci enkripsi</li>
                                    <li>Setiap enkripsi menghasilkan ciphertext yang berbeda (non-deterministic)</li>
                                    <li>Hanya aplikasi dengan APP_KEY yang sama yang dapat mendekripsi</li>
                                    <li>Database administrator tidak dapat membaca data terenkripsi</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- No Wallet -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            Anda belum memiliki wallet.
                        </p>
                        <a href="{{ route('wallet.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition">
                            Buat Wallet
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>