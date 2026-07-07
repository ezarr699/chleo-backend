<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa Validasi
    |--------------------------------------------------------------------------
    |
    | Baris berikut berisi pesan error default yang dipakai kelas Validator.
    | Beberapa rule punya beberapa versi seperti rule ukuran (size). Silakan
    | sesuaikan pesan-pesan ini sesuai kebutuhan aplikasi.
    |
    */

    'accepted' => ':attribute harus disetujui.',
    'accepted_if' => ':attribute harus disetujui apabila :other bernilai :value.',
    'active_url' => ':attribute bukan URL yang valid.',
    'after' => ':attribute harus tanggal setelah :date.',
    'after_or_equal' => ':attribute harus tanggal setelah atau sama dengan :date.',
    'alpha' => ':attribute hanya boleh berisi huruf.',
    'alpha_dash' => ':attribute hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num' => ':attribute hanya boleh berisi huruf dan angka.',
    'any_of' => ':attribute tidak valid.',
    'array' => ':attribute harus berupa larik (array).',
    'ascii' => ':attribute hanya boleh berisi karakter alfanumerik dan simbol satu byte.',
    'before' => ':attribute harus tanggal sebelum :date.',
    'before_or_equal' => ':attribute harus tanggal sebelum atau sama dengan :date.',
    'between' => [
        'array' => ':attribute harus memiliki antara :min dan :max item.',
        'file' => ':attribute harus berukuran antara :min dan :max kilobyte.',
        'numeric' => ':attribute harus bernilai antara :min dan :max.',
        'string' => ':attribute harus memiliki antara :min dan :max karakter.',
    ],
    'boolean' => ':attribute harus bernilai true atau false.',
    'can' => ':attribute berisi nilai yang tidak sah.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'contains' => ':attribute tidak memiliki nilai yang diperlukan.',
    'current_password' => 'Password salah.',
    'date' => ':attribute bukan tanggal yang valid.',
    'date_equals' => ':attribute harus tanggal yang sama dengan :date.',
    'date_format' => ':attribute tidak cocok dengan format :format.',
    'decimal' => ':attribute harus memiliki :decimal angka desimal.',
    'declined' => ':attribute harus ditolak.',
    'declined_if' => ':attribute harus ditolak apabila :other bernilai :value.',
    'different' => ':attribute dan :other harus berbeda.',
    'digits' => ':attribute harus :digits digit.',
    'digits_between' => ':attribute harus antara :min dan :max digit.',
    'dimensions' => ':attribute memiliki dimensi gambar yang tidak sah.',
    'distinct' => ':attribute memiliki nilai yang duplikat.',
    'doesnt_contain' => ':attribute tidak boleh mengandung salah satu dari berikut: :values.',
    'doesnt_end_with' => ':attribute tidak boleh diakhiri dengan salah satu dari berikut: :values.',
    'doesnt_start_with' => ':attribute tidak boleh diawali dengan salah satu dari berikut: :values.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'encoding' => ':attribute harus menggunakan enkoding :encoding.',
    'ends_with' => ':attribute harus diakhiri dengan salah satu dari berikut: :values.',
    'enum' => ':attribute yang dipilih tidak sah.',
    'exists' => ':attribute yang dipilih tidak sah.',
    'extensions' => ':attribute harus memiliki salah satu ekstensi berikut: :values.',
    'file' => ':attribute harus berupa file.',
    'filled' => ':attribute harus memiliki nilai.',
    'gt' => [
        'array' => ':attribute harus memiliki lebih dari :value item.',
        'file' => ':attribute harus lebih besar dari :value kilobyte.',
        'numeric' => ':attribute harus lebih besar dari :value.',
        'string' => ':attribute harus lebih besar dari :value karakter.',
    ],
    'gte' => [
        'array' => ':attribute harus memiliki :value item atau lebih.',
        'file' => ':attribute harus lebih besar atau sama dengan :value kilobyte.',
        'numeric' => ':attribute harus lebih besar atau sama dengan :value.',
        'string' => ':attribute harus lebih besar atau sama dengan :value karakter.',
    ],
    'hex_color' => ':attribute harus berupa warna heksadesimal yang valid.',
    'image' => ':attribute harus berupa gambar.',
    'in' => ':attribute yang dipilih tidak sah.',
    'in_array' => ':attribute tidak ada di dalam :other.',
    'in_array_keys' => ':attribute harus memiliki setidaknya salah satu kunci berikut: :values.',
    'integer' => ':attribute harus berupa bilangan bulat.',
    'ip' => ':attribute harus berupa alamat IP yang valid.',
    'ipv4' => ':attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => ':attribute harus berupa alamat IPv6 yang valid.',
    'json' => ':attribute harus berupa JSON string yang valid.',
    'list' => ':attribute harus berupa daftar (list).',
    'lowercase' => ':attribute harus huruf kecil.',
    'lt' => [
        'array' => ':attribute harus memiliki kurang dari :value item.',
        'file' => ':attribute harus kurang dari :value kilobyte.',
        'numeric' => ':attribute harus kurang dari :value.',
        'string' => ':attribute harus kurang dari :value karakter.',
    ],
    'lte' => [
        'array' => ':attribute tidak boleh memiliki lebih dari :value item.',
        'file' => ':attribute harus kurang dari atau sama dengan :value kilobyte.',
        'numeric' => ':attribute harus kurang dari atau sama dengan :value.',
        'string' => ':attribute harus kurang dari atau sama dengan :value karakter.',
    ],
    'mac_address' => ':attribute harus berupa alamat MAC yang valid.',
    'max' => [
        'array' => ':attribute tidak boleh memiliki lebih dari :max item.',
        'file' => ':attribute tidak boleh lebih besar dari :max kilobyte.',
        'numeric' => ':attribute tidak boleh lebih besar dari :max.',
        'string' => ':attribute tidak boleh lebih besar dari :max karakter.',
    ],
    'max_digits' => ':attribute tidak boleh memiliki lebih dari :max digit.',
    'mimes' => ':attribute harus berupa file bertipe: :values.',
    'mimetypes' => ':attribute harus berupa file bertipe: :values.',
    'min' => [
        'array' => ':attribute harus memiliki setidaknya :min item.',
        'file' => ':attribute harus berukuran setidaknya :min kilobyte.',
        'numeric' => ':attribute harus bernilai setidaknya :min.',
        'string' => ':attribute harus memiliki setidaknya :min karakter.',
    ],
    'min_digits' => ':attribute harus memiliki setidaknya :min digit.',
    'missing' => ':attribute harus tidak ada.',
    'missing_if' => ':attribute harus tidak ada apabila :other bernilai :value.',
    'missing_unless' => ':attribute harus tidak ada kecuali :other bernilai :value.',
    'missing_with' => ':attribute harus tidak ada apabila :values ada.',
    'missing_with_all' => ':attribute harus tidak ada apabila :values ada.',
    'multiple_of' => ':attribute harus merupakan kelipatan dari :value.',
    'not_in' => ':attribute yang dipilih tidak sah.',
    'not_regex' => 'Format :attribute tidak sah.',
    'numeric' => ':attribute harus berupa angka.',
    'password' => [
        'letters' => ':attribute harus memiliki setidaknya satu huruf.',
        'mixed' => ':attribute harus memiliki setidaknya satu huruf besar dan satu huruf kecil.',
        'numbers' => ':attribute harus memiliki setidaknya satu angka.',
        'symbols' => ':attribute harus memiliki setidaknya satu simbol.',
        'uncompromised' => ':attribute yang diberikan pernah muncul dalam kebocoran data. Silakan pilih :attribute lain.',
    ],
    'present' => ':attribute harus ada.',
    'present_if' => ':attribute harus ada apabila :other bernilai :value.',
    'present_unless' => ':attribute harus ada kecuali :other bernilai :value.',
    'present_with' => ':attribute harus ada apabila :values ada.',
    'present_with_all' => ':attribute harus ada apabila :values ada.',
    'prohibited' => ':attribute dilarang diisi.',
    'prohibited_if' => ':attribute dilarang diisi apabila :other bernilai :value.',
    'prohibited_if_accepted' => ':attribute dilarang diisi apabila :other disetujui.',
    'prohibited_if_declined' => ':attribute dilarang diisi apabila :other ditolak.',
    'prohibited_unless' => ':attribute dilarang diisi kecuali :other ada di dalam :values.',
    'prohibits' => ':attribute melarang :other untuk diisi.',
    'regex' => 'Format :attribute tidak sah.',
    'required' => ':attribute wajib diisi.',
    'required_array_keys' => ':attribute harus memiliki entri untuk: :values.',
    'required_if' => ':attribute wajib diisi apabila :other bernilai :value.',
    'required_if_accepted' => ':attribute wajib diisi apabila :other disetujui.',
    'required_if_declined' => ':attribute wajib diisi apabila :other ditolak.',
    'required_unless' => ':attribute wajib diisi kecuali :other ada di dalam :values.',
    'required_with' => ':attribute wajib diisi apabila :values ada.',
    'required_with_all' => ':attribute wajib diisi apabila :values ada.',
    'required_without' => ':attribute wajib diisi apabila :values tidak ada.',
    'required_without_all' => ':attribute wajib diisi apabila tidak ada satupun dari :values yang ada.',
    'same' => ':attribute dan :other harus sama.',
    'size' => [
        'array' => ':attribute harus berisi :size item.',
        'file' => ':attribute harus berukuran :size kilobyte.',
        'numeric' => ':attribute harus bernilai :size.',
        'string' => ':attribute harus berisi :size karakter.',
    ],
    'starts_with' => ':attribute harus diawali dengan salah satu dari berikut: :values.',
    'string' => ':attribute harus berupa teks.',
    'timezone' => ':attribute harus berupa zona waktu yang valid.',
    'unique' => ':attribute sudah digunakan.',
    'uploaded' => ':attribute gagal diunggah.',
    'uppercase' => ':attribute harus huruf besar.',
    'url' => ':attribute harus berupa URL yang valid.',
    'ulid' => ':attribute harus berupa ULID yang valid.',
    'uuid' => ':attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa Validasi Kustom
    |--------------------------------------------------------------------------
    |
    | Di sini bisa ditentukan pesan validasi kustom untuk atribut memakai
    | konvensi "atribut.rule" untuk menamai baris. Ini mempercepat penentuan
    | baris bahasa kustom untuk rule tertentu pada atribut tertentu.
    |
    */

    'custom' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Atribut Bahasa Validasi Kustom
    |--------------------------------------------------------------------------
    |
    | Baris berikut dipakai untuk mengganti placeholder atribut dengan
    | sesuatu yang lebih mudah dibaca seperti "Alamat Email" daripada
    | "email". Ini membantu membuat pesan lebih deskriptif.
    |
    */

    // Dikapitalisasi di huruf pertama karena :attribute pada seluruh pesan di
    // atas selalu ada di awal kalimat (mis. ":attribute wajib diisi.") — supaya
    // hasilnya "Nama wajib diisi." bukan "nama wajib diisi.", konsisten dengan
    // gaya kalimat Indonesia lain di aplikasi (mis. "Data tidak ditemukan.").
    'attributes' => [
        'name' => 'Nama',
        'email' => 'Email',
        'password' => 'Password',
        'admin' => 'Admin',
        'admin.name' => 'Nama admin',
        'admin.email' => 'Email admin',
        'admin.password' => 'Password admin',
        'slug' => 'Slug',
        'domain' => 'Domain',
        'suspended' => 'Status suspend',
        'aktif' => 'Status aktif',
        'user_id' => 'User',
        'profesi_id' => 'Profesi',
        'poliklinik_id' => 'Poliklinik',
        'no_sip' => 'Nomor SIP',
        'no_str' => 'Nomor STR',
        'str_berlaku_sampai' => 'Tanggal berlaku STR',
        'nik' => 'NIK',
        'nama' => 'Nama',
        'tanggal_lahir' => 'Tanggal lahir',
        'jenis_kelamin_id' => 'Jenis kelamin',
        'golongan_darah_id' => 'Golongan darah',
        'penjamin_id' => 'Penjamin',
        'asuransi_id' => 'Asuransi',
        'asuransi' => 'Asuransi',
        'asuransi.*.asuransi_id' => 'Asuransi',
        'asuransi.*.nomor_polis' => 'Nomor polis',
        'asuransi.*.masa_berlaku' => 'Masa berlaku',
        'tempat_lahir' => 'Tempat lahir',
        'nomor_telepon' => 'Nomor telepon',
        'alamat' => 'Alamat',
        'foto' => 'Foto',
        'provinsi_code' => 'Provinsi',
        'kabupaten_code' => 'Kabupaten',
        'kecamatan_code' => 'Kecamatan',
        'kelurahan_code' => 'Kelurahan',
        'bpjs_nomor' => 'Nomor BPJS',
        'bpjs_jenis_peserta' => 'Jenis peserta BPJS',
        'bpjs_kelas' => 'Kelas BPJS',
        'bpjs_nama_fasyankes' => 'Nama fasyankes BPJS',
        'bpjs_kode_fasyankes' => 'Kode fasyankes BPJS',
        'bpjs_masa_berlaku' => 'Masa berlaku BPJS',
    ],

];
