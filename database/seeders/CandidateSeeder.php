<?php

namespace Database\Seeders;

use App\Models\Candidate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    public function run()
    {
        $candidates = [
            [
                'name' => 'Budi Santoso',
                'photo' => 'https://ui-avatars.com/api/?name=Budi+Santoso&size=400&background=5FA782&color=fff',
                'visi' => 'Membangun perumahan yang aman, nyaman, dan harmonis dengan mengedepankan transparansi, gotong royong, dan kesejahteraan bersama.',
                'misi' => '1. Meningkatkan keamanan lingkungan dengan sistem keamanan 24 jam
2. Memperbaiki infrastruktur jalan dan fasilitas umum
3. Mengelola keuangan dengan transparan dan akuntabel
4. Mengadakan kegiatan sosial untuk mempererat tali silaturahmi
5. Menyediakan fasilitas olahraga dan taman bermain yang memadai',
                'bio' => 'Pengusaha sukses dengan pengalaman 15 tahun di bidang properti. Aktif dalam kegiatan sosial dan peduli terhadap lingkungan.',
                'vote_count' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Siti Rahma Wati',
                'photo' => 'https://ui-avatars.com/api/?name=Siti+Rahma+Wati&size=400&background=667eea&color=fff',
                'visi' => 'Menciptakan lingkungan perumahan yang bersih, hijau, dan ramah keluarga dengan fokus pada pendidikan dan kesehatan warga.',
                'misi' => '1. Program bank sampah dan pengelolaan limbah yang ramah lingkungan
2. Menyediakan ruang terbuka hijau dan taman di setiap blok
3. Mengadakan kelas gratis untuk anak-anak (bimbel, keterampilan)
4. Program kesehatan rutin dan posyandu lansia
5. Mengoptimalkan teknologi untuk pelayanan warga',
                'bio' => 'Ibu rumah tangga aktif yang berpengalaman sebagai koordinator PKK selama 8 tahun. Lulusan S1 Kesehatan Masyarakat.',
                'vote_count' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Ahmad Hidayat',
                'photo' => 'https://ui-avatars.com/api/?name=Ahmad+Hidayat&size=400&background=764ba2&color=fff',
                'visi' => 'Mewujudkan tata kelola perumahan yang modern, digital, dan partisipatif untuk kesejahteraan seluruh warga.',
                'misi' => '1. Digitalisasi administrasi perumahan dengan aplikasi mobile
2. Meningkatkan partisipasi warga dalam pengambilan keputusan
3. Mengembangkan usaha bersama untuk meningkatkan ekonomi warga
4. Menyediakan wifi gratis di area publik perumahan
5. Membentuk tim tanggap bencana dan keamanan lingkungan',
                'bio' => 'Profesional IT dengan pengalaman 12 tahun. Aktif di berbagai organisasi kemasyarakatan dan peduli terhadap kemajuan teknologi.',
                'vote_count' => 0,
                'is_active' => true,
            ],
        ];

        foreach ($candidates as $candidate) {
            Candidate::create($candidate);
        }
    }
}
