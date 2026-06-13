<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

/**
 * Seeds ALL content of the public "Tentang" page in 3 locales (id, en, ar).
 * Every visible text on the page is editable via Admin → Pengaturan → Tentang
 * and is stored here as the default. Keys are grouped with the "tentang." prefix.
 */
class TentangSeeder extends Seeder
{
    public function run(): void
    {
        // key => [id, en, ar]
        $data = [

            // ─────────── HERO ───────────
            'hero_badge' => [
                'Mengenal Akar Sehat',
                'Get to Know Akar Sehat',
                'تعرّف على أكار سيهات',
            ],
            'hero_title' => [
                'Kesehatan yang Dimulai dari Akar Permasalahannya',
                'Health That Begins From the Root of the Problem',
                'صحة تبدأ من جذر المشكلة',
            ],
            'hero_desc' => [
                'Kami bukan sekadar platform suplemen herbal. Akar Sehat adalah gerakan untuk mengembalikan masyarakat pada pemahaman bahwa tubuh memiliki kecerdasan alaminya sendiri — dan tugas kita adalah mendukungnya, bukan melawannya.',
                'We are not just an herbal supplement platform. Akar Sehat is a movement to bring people back to the understanding that the body has its own natural intelligence — and our job is to support it, not fight it.',
                'نحن لسنا مجرد منصة لمكملات الأعشاب. أكار سيهات حركة لإعادة الناس إلى فهم أن للجسد ذكاءه الطبيعي الخاص — ومهمتنا هي دعمه لا محاربته.',
            ],
            'hero_stat1_val'   => ['500+', '500+', '500+'],
            'hero_stat1_label' => ['Pengguna yang terbantu', 'Users helped', 'مستخدم تمت مساعدته'],
            'hero_stat2_val'   => ['15+', '15+', '15+'],
            'hero_stat2_label' => ['Tahun pengalaman terapi herbal', 'Years of herbal therapy experience', 'سنوات من خبرة العلاج بالأعشاب'],
            'hero_stat3_val'   => ['8', '8', '8'],
            'hero_stat3_label' => ['Produk herbal pilihan', 'Selected herbal products', 'منتجات عشبية مختارة'],
            'hero_stat4_val'   => ['0', '0', '0'],
            'hero_stat4_label' => ['Biaya konsultasi awal', 'Initial consultation fee', 'رسوم الاستشارة الأولية'],

            // ─────────── SIAPA KAMI ───────────
            'intro_label' => ['Siapa Kami', 'Who We Are', 'من نحن'],
            'intro_title' => [
                'Platform Kesehatan Holistik yang Berpihak pada Alam',
                'A Holistic Health Platform That Sides With Nature',
                'منصة صحية شاملة تنحاز إلى الطبيعة',
            ],
            'intro_p1' => [
                'Akar Sehat lahir dari keyakinan sederhana: bahwa sebagian besar keluhan kesehatan modern bukan sekadar masalah organ yang rusak, melainkan sinyal dari ketidakseimbangan yang lebih dalam — dalam pola makan, gaya hidup, pikiran, dan hubungan kita dengan alam.',
                'Akar Sehat was born from a simple belief: that most modern health complaints are not merely a matter of damaged organs, but signals of a deeper imbalance — in our diet, lifestyle, mind, and relationship with nature.',
                'وُلدت أكار سيهات من قناعة بسيطة: أن معظم الشكاوى الصحية الحديثة ليست مجرد مشكلة في أعضاء تالفة، بل إشارات إلى خلل أعمق — في نظامنا الغذائي وأسلوب حياتنا وعقولنا وعلاقتنا بالطبيعة.',
            ],
            'intro_p2' => [
                'Kami mengintegrasikan kearifan pengobatan herbal Nusantara yang telah teruji selama berabad-abad dengan pemahaman fisiologi modern, untuk membantu setiap pengguna menemukan akar masalah di balik gejala yang mereka rasakan — bukan sekadar meredam gejalanya.',
                'We integrate the centuries-tested wisdom of Indonesian herbal medicine with a modern understanding of physiology, to help every user find the root of the problem behind the symptoms they feel — not merely suppress those symptoms.',
                'ندمج حكمة الطب العشبي الإندونيسي المُختبرة عبر القرون مع فهم حديث لعلم وظائف الأعضاء، لمساعدة كل مستخدم على إيجاد جذر المشكلة خلف الأعراض التي يشعر بها — وليس مجرد تخفيف تلك الأعراض.',
            ],
            'intro_p3' => [
                'Didampingi langsung oleh Kang Bahri, setiap pengguna mendapatkan pendekatan yang personal, bukan protokol generik. Karena setiap tubuh berbeda, setiap solusi pun harus berbeda.',
                'Guided directly by Kang Bahri, every user receives a personal approach, not a generic protocol. Because every body is different, every solution must be different too.',
                'بتوجيه مباشر من كانغ باهري، يحصل كل مستخدم على نهج شخصي وليس بروتوكولاً عاماً. لأن كل جسد مختلف، يجب أن يكون كل حل مختلفاً أيضاً.',
            ],
            'value1_title' => ['Pendekatan Akar, Bukan Gejala', 'Root Approach, Not Symptoms', 'نهج الجذور لا الأعراض'],
            'value1_desc'  => [
                'Kami tidak berhenti di permukaan. Setiap sesi konsultasi bertujuan menemukan penyebab utama di balik keluhan, bukan sekadar menghilangkan rasa sakitnya.',
                'We don\'t stop at the surface. Every consultation session aims to find the main cause behind the complaint, not merely remove the pain.',
                'لا نتوقف عند السطح. تهدف كل جلسة استشارة إلى إيجاد السبب الرئيسي خلف الشكوى، وليس مجرد إزالة الألم.',
            ],
            'value2_title' => ['Personal & Manusiawi', 'Personal & Humane', 'شخصي وإنساني'],
            'value2_desc'  => [
                'Tidak ada protokol satu ukuran untuk semua. Kami memperlakukan setiap pengguna sebagai individu unik dengan konteks kehidupan yang berbeda-beda.',
                'There is no one-size-fits-all protocol. We treat every user as a unique individual with a different life context.',
                'لا يوجد بروتوكول واحد يناسب الجميع. نتعامل مع كل مستخدم كفرد فريد له سياق حياتي مختلف.',
            ],
            'value3_title' => ['Transparansi & Kepercayaan', 'Transparency & Trust', 'الشفافية والثقة'],
            'value3_desc'  => [
                'Kami berbagi pengetahuan secara terbuka melalui edukasi. Anda berhak memahami mengapa sebuah pendekatan direkomendasikan untuk kondisi Anda.',
                'We share knowledge openly through education. You have the right to understand why an approach is recommended for your condition.',
                'نشارك المعرفة بصراحة من خلال التثقيف. لديك الحق في فهم سبب التوصية بنهج معين لحالتك.',
            ],
            'value4_title' => ['Berbasis Bukti & Pengalaman', 'Evidence & Experience Based', 'قائم على الأدلة والخبرة'],
            'value4_desc'  => [
                'Rekomendasi kami didukung oleh pengalaman lapangan bertahun-tahun serta pemahaman mekanisme herbal yang terus diperbarui.',
                'Our recommendations are backed by years of field experience and a continually updated understanding of herbal mechanisms.',
                'توصياتنا مدعومة بسنوات من الخبرة الميدانية وفهم متجدد باستمرار لآليات الأعشاب.',
            ],

            // ─────────── VISI & MISI ───────────
            'vm_title' => ['Visi & Misi', 'Vision & Mission', 'الرؤية والرسالة'],
            'vm_desc'  => [
                'Landasan yang memandu setiap langkah kami dalam melayani dan mendidik masyarakat tentang kesehatan holistik.',
                'The foundation that guides our every step in serving and educating the public about holistic health.',
                'الأساس الذي يوجه كل خطوة لنا في خدمة وتثقيف المجتمع حول الصحة الشاملة.',
            ],
            'visi_label' => ['Visi', 'Vision', 'الرؤية'],
            'visi' => [
                'Menjadi platform edukasi dan pendampingan kesehatan herbal terpercaya yang mengembalikan masyarakat Indonesia pada kearifan alami untuk hidup sehat, seimbang, dan berdaya dari dalam.',
                'To become a trusted herbal health education and mentoring platform that returns the Indonesian people to natural wisdom for living healthily, in balance, and empowered from within.',
                'أن نصبح منصة موثوقة للتثقيف الصحي العشبي والإرشاد تعيد الشعب الإندونيسي إلى الحكمة الطبيعية للعيش بصحة وتوازن وقوة من الداخل.',
            ],
            'misi_label'   => ['Misi', 'Mission', 'الرسالة'],
            'misi_heading' => ['Langkah Nyata yang Kami Lakukan', 'The Real Steps We Take', 'الخطوات الحقيقية التي نتخذها'],
            'misi' => [
                "Memberikan edukasi kesehatan holistik yang akurat, mudah dipahami, dan dapat langsung dipraktikkan oleh masyarakat luas.\nMembantu setiap individu menemukan akar masalah kesehatannya melalui pendampingan personal yang empatik dan terstruktur.\nMenyediakan produk herbal berkualitas tinggi yang bahan bakunya dapat ditelusuri, formulasinya terbukti, dan dampaknya nyata.\nMembangun komunitas yang saling mendukung dalam perjalanan menuju kesehatan optimal berbasis alam dan gaya hidup seimbang.",
                "Provide accurate, easy-to-understand holistic health education that can be directly practiced by the wider community.\nHelp every individual find the root of their health problem through empathetic and structured personal mentoring.\nProvide high-quality herbal products whose raw materials are traceable, whose formulations are proven, and whose impact is real.\nBuild a mutually supportive community on the journey toward optimal health based on nature and a balanced lifestyle.",
                "تقديم تثقيف صحي شامل دقيق وسهل الفهم يمكن للمجتمع الأوسع ممارسته مباشرة.\nمساعدة كل فرد على إيجاد جذر مشكلته الصحية من خلال إرشاد شخصي متعاطف ومنظم.\nتوفير منتجات عشبية عالية الجودة يمكن تتبع موادها الخام، وصيغها مثبتة، وتأثيرها حقيقي.\nبناء مجتمع متعاضد في رحلة نحو الصحة المثلى القائمة على الطبيعة وأسلوب حياة متوازن.",
            ],

            // ─────────── PROFIL KANG BAHRI ───────────
            'profil_section_label' => ['Tentang Pendiri', 'About the Founder', 'عن المؤسس'],
            'profil_section_title' => ['Mengenal Kang Bahri', 'Meet Kang Bahri', 'تعرّف على كانغ باهري'],
            'profil_inner_label'   => ['Profil Lengkap', 'Full Profile', 'الملف الكامل'],
            'profil_nama'  => ['Bahri, S.Kes.', 'Bahri, S.Kes.', 'باهري، S.Kes.'],
            'profil_gelar' => [
                'Terapis Herbal · Konsultan Kesehatan Holistik · Pendiri Akar Sehat',
                'Herbal Therapist · Holistic Health Consultant · Founder of Akar Sehat',
                'معالج بالأعشاب · استشاري صحة شاملة · مؤسس أكار سيهات',
            ],
            'profil_bio' => [
                "Kang Bahri adalah seorang terapis herbal dan konsultan kesehatan holistik yang telah mengabdikan lebih dari satu setengah dekade hidupnya untuk mempelajari, mempraktikkan, dan menyebarluaskan pengetahuan tentang pengobatan herbal Nusantara dan pendekatan kesehatan integratif.\n\nLahir dan besar di lingkungan yang akrab dengan tanaman obat, Kang Bahri mewarisi kecintaan pada herbal dari sang nenek yang dikenal sebagai dukun beranak di desanya. Keingintahuan masa kecil ini kemudian tumbuh menjadi dedikasi seumur hidup.\n\nKang Bahri menempuh pendidikan formal di bidang kesehatan sambil terus belajar dari berbagai guru dan maestro pengobatan tradisional di Jawa, Sumatera, hingga Kalimantan.\n\nHari ini, Kang Bahri melayani konsultasi kesehatan secara personal dan mendirikan Akar Sehat sebagai platform untuk menjangkau lebih banyak masyarakat.",
                "Kang Bahri is a herbal therapist and holistic health consultant who has dedicated more than a decade and a half of his life to studying, practicing, and disseminating knowledge of Indonesian herbal medicine and integrative health approaches.\n\nBorn and raised in an environment familiar with medicinal plants, Kang Bahri inherited his love of herbs from his grandmother, known as a traditional midwife in her village. This childhood curiosity later grew into a lifelong dedication.\n\nKang Bahri pursued formal education in health while continuing to learn from various teachers and masters of traditional medicine across Java, Sumatra, and Kalimantan.\n\nToday, Kang Bahri provides personal health consultations and founded Akar Sehat as a platform to reach a wider community.",
                "كانغ باهري معالج بالأعشاب واستشاري صحة شاملة كرّس أكثر من عقد ونصف من حياته لدراسة وممارسة ونشر معرفة الطب العشبي الإندونيسي ونُهج الصحة التكاملية.\n\nوُلد ونشأ كانغ باهري في بيئة مألوفة بالنباتات الطبية، وورث حب الأعشاب عن جدته التي عُرفت كقابلة تقليدية في قريتها. وقد نما فضول الطفولة هذا لاحقاً ليصبح تفانياً مدى الحياة.\n\nتابع كانغ باهري تعليمه الرسمي في مجال الصحة مع استمراره في التعلم من مختلف المعلمين وأساتذة الطب التقليدي عبر جاوة وسومطرة وكاليمانتان.\n\nاليوم، يقدّم كانغ باهري استشارات صحية شخصية وأسس أكار سيهات كمنصة للوصول إلى مجتمع أوسع.",
            ],
            'cert1' => ['Terapis Herbal Bersertifikat', 'Certified Herbal Therapist', 'معالج بالأعشاب معتمد'],
            'cert2' => ['Konsultan Kesehatan Holistik', 'Holistic Health Consultant', 'استشاري صحة شاملة'],
            'cert3' => ['Praktisi Jamu Nusantara', 'Nusantara Jamu Practitioner', 'ممارس جامو نوسانتارا'],
            'profil_stat1_val'   => ['15+', '15+', '15+'],
            'profil_stat1_label' => ['Tahun pengalaman sebagai terapis', 'Years of experience as a therapist', 'سنوات من الخبرة كمعالج'],
            'profil_stat2_val'   => ['500+', '500+', '500+'],
            'profil_stat2_label' => ['Klien yang ditangani secara personal', 'Clients handled personally', 'عملاء تمت خدمتهم شخصياً'],
            'profil_stat3_val'   => ['200+', '200+', '200+'],
            'profil_stat3_label' => ['Jenis tanaman herbal yang dikuasai', 'Herbal plant types mastered', 'أنواع النباتات العشبية المتقَنة'],
            'keahlian_title' => ['Area Keahlian', 'Areas of Expertise', 'مجالات الخبرة'],
            'keahlian_tags' => [
                "Detoksifikasi Tubuh\nKesehatan Pencernaan\nManajemen Imunitas\nHerbal Anti-Inflamasi\nPengelolaan Stres Kronis\nNutrisi Fungsional\nFitomedicine Modern\nJamu Nusantara",
                "Body Detoxification\nDigestive Health\nImmunity Management\nAnti-Inflammatory Herbs\nChronic Stress Management\nFunctional Nutrition\nModern Phytomedicine\nNusantara Jamu",
                "إزالة سموم الجسم\nصحة الجهاز الهضمي\nإدارة المناعة\nأعشاب مضادة للالتهابات\nإدارة التوتر المزمن\nالتغذية الوظيفية\nالطب النباتي الحديث\nجامو نوسانتارا",
            ],

            // ─────────── PERJALANAN / TIMELINE ───────────
            'journey_title' => ['Perjalanan Kang Bahri', "Kang Bahri's Journey", 'مسيرة كانغ باهري'],
            'journey_desc' => [
                'Dari keingintahuan masa kecil di kebun nenek hingga mendampingi ratusan orang menemukan jalan sehatnya.',
                'From childhood curiosity in grandmother\'s garden to guiding hundreds of people to find their path to health.',
                'من فضول الطفولة في حديقة الجدة إلى إرشاد المئات للعثور على طريقهم نحو الصحة.',
            ],
            'tl1_year'  => ['2005 — Titik Awal', '2005 — The Starting Point', '2005 — نقطة البداية'],
            'tl1_title' => ['Penyembuhan Keluarga yang Mengubah Pandangan', 'A Family Healing That Changed His View', 'شفاء عائلي غيّر نظرته'],
            'tl1_desc'  => [
                'Anggota keluarga terdekat didiagnosis dengan kondisi kronis yang divonis sulit disembuhkan secara medis konvensional. Kang Bahri, yang saat itu masih muda, memutuskan untuk mendalami jalur herbal dan holistik. Dalam 8 bulan dengan pendampingan terapis tradisional, kondisi tersebut membaik signifikan — pengalaman yang menjadi benih dari seluruh perjalanan ini.',
                'A close family member was diagnosed with a chronic condition deemed difficult to cure through conventional medicine. Kang Bahri, then still young, decided to delve into the herbal and holistic path. Within 8 months under the guidance of a traditional therapist, the condition improved significantly — an experience that became the seed of this entire journey.',
                'شُخّص أحد أفراد العائلة المقربين بحالة مزمنة اعتُبر علاجها صعباً بالطب التقليدي. قرر كانغ باهري، وكان لا يزال شاباً، التعمق في المسار العشبي والشامل. وخلال 8 أشهر بإرشاد معالج تقليدي، تحسنت الحالة بشكل كبير — تجربة أصبحت بذرة هذه الرحلة بأكملها.',
            ],
            'tl2_year'  => ['2007 — Pendidikan Formal', '2007 — Formal Education', '2007 — التعليم الرسمي'],
            'tl2_title' => ['Studi Kesehatan & Berguru pada Para Maestro', 'Health Studies & Learning From the Masters', 'دراسة الصحة والتعلّم من الأساتذة'],
            'tl2_desc'  => [
                'Melanjutkan studi formal di bidang kesehatan sambil secara paralel berguru langsung kepada ahli jamu dan terapis tradisional terkemuka di Jawa Tengah. Belajar membaca gejala tubuh secara holistik — bukan hanya dari kacamata patologi, tapi juga dari perspektif keseimbangan energi dan pola hidup.',
                'He continued formal studies in health while simultaneously learning directly from prominent jamu experts and traditional therapists in Central Java. He learned to read the body\'s symptoms holistically — not only through the lens of pathology, but also from the perspective of energy balance and lifestyle.',
                'واصل دراسته الرسمية في مجال الصحة وتعلّم في الوقت نفسه مباشرة من خبراء الجامو البارزين والمعالجين التقليديين في جاوة الوسطى. تعلّم قراءة أعراض الجسم بشكل شامل — ليس فقط من منظور علم الأمراض، بل أيضاً من منظور توازن الطاقة وأسلوب الحياة.',
            ],
            'tl3_year'  => ['2010 — Praktik Pertama', '2010 — First Practice', '2010 — الممارسة الأولى'],
            'tl3_title' => ['Membuka Praktik Terapi Herbal dari Rumah', 'Opening a Home Herbal Therapy Practice', 'افتتاح ممارسة للعلاج بالأعشاب من المنزل'],
            'tl3_desc'  => [
                'Mulai menerima klien secara personal dari lingkungan sekitar. Meskipun masih sangat sederhana, antusiasme dari mulut ke mulut tumbuh pesat. Dalam dua tahun pertama, sudah melayani lebih dari 50 klien dengan berbagai keluhan — dari masalah pencernaan, kelelahan kronis, hingga pemulihan pasca sakit berat.',
                'He began accepting clients personally from the surrounding community. Although still very modest, word-of-mouth enthusiasm grew rapidly. In the first two years, he had already served more than 50 clients with various complaints — from digestive problems and chronic fatigue to recovery after serious illness.',
                'بدأ باستقبال العملاء شخصياً من المجتمع المحيط. ورغم بساطتها الشديدة، نما الحماس المتناقل شفهياً بسرعة. وفي العامين الأولين، كان قد خدم أكثر من 50 عميلاً بشكاوى متنوعة — من مشاكل الهضم والإرهاق المزمن إلى التعافي بعد مرض خطير.',
            ],
            'tl4_year'  => ['2014 — Ekspansi Pengetahuan', '2014 — Expanding Knowledge', '2014 — توسيع المعرفة'],
            'tl4_title' => ['Riset Mendalam & Sertifikasi Profesional', 'In-Depth Research & Professional Certification', 'بحث معمّق وشهادة مهنية'],
            'tl4_desc'  => [
                'Menempuh sertifikasi sebagai Terapis Herbal Bersertifikat dan Konsultan Kesehatan Holistik. Secara aktif mengikuti seminar fitomedicine dan ethnobotany, termasuk workshop dari praktisi herbalis internasional. Mengembangkan metode analisis keluhan yang lebih terstruktur dengan mengintegrasikan pendekatan tradisional dan ilmiah.',
                'He earned certification as a Certified Herbal Therapist and Holistic Health Consultant. He actively attended phytomedicine and ethnobotany seminars, including workshops by international herbalist practitioners. He developed a more structured complaint-analysis method by integrating traditional and scientific approaches.',
                'حصل على شهادة معالج بالأعشاب معتمد واستشاري صحة شاملة. وحضر بنشاط ندوات الطب النباتي وعلم النبات العرقي، بما في ذلك ورش عمل لممارسين عالميين في طب الأعشاب. وطوّر طريقة أكثر تنظيماً لتحليل الشكاوى بدمج النُهج التقليدية والعلمية.',
            ],
            'tl5_year'  => ['2018 — Lahirnya Akar Sehat', '2018 — The Birth of Akar Sehat', '2018 — ولادة أكار سيهات'],
            'tl5_title' => ['Mendirikan Brand & Komunitas Akar Sehat', 'Founding the Akar Sehat Brand & Community', 'تأسيس علامة ومجتمع أكار سيهات'],
            'tl5_desc'  => [
                'Melihat kebutuhan yang semakin besar dan keterbatasan layanan tatap muka, Kang Bahri mendirikan Akar Sehat sebagai platform yang memungkinkan lebih banyak orang mendapatkan pendampingan kesehatan holistik. Brand ini lahir dari tekad untuk mendemokratisasi akses terhadap pengetahuan herbal yang selama ini hanya tersedia bagi sebagian orang.',
                'Seeing the growing need and the limitations of in-person service, Kang Bahri founded Akar Sehat as a platform enabling more people to receive holistic health mentoring. The brand was born from a determination to democratize access to herbal knowledge that had until then been available only to a few.',
                'إدراكاً للحاجة المتزايدة ومحدودية الخدمة وجهاً لوجه، أسس كانغ باهري أكار سيهات كمنصة تمكّن المزيد من الناس من الحصول على إرشاد صحي شامل. وُلدت العلامة من عزم على إتاحة المعرفة العشبية التي كانت حتى ذلك الحين متاحة لقلة فقط.',
            ],
            'tl6_year'  => ['2021 — Platform Digital', '2021 — Digital Platform', '2021 — المنصة الرقمية'],
            'tl6_title' => ['Edukasi & Konsultasi Online untuk Semua', 'Online Education & Consultation for All', 'تثقيف واستشارات عبر الإنترنت للجميع'],
            'tl6_desc'  => [
                'Mengembangkan platform digital Akar Sehat untuk menjangkau pengguna di seluruh Indonesia. Membuka layanan konsultasi online via WhatsApp dan menghadirkan konten edukasi kesehatan yang dapat diakses gratis oleh siapa saja. Dalam setahun, jumlah pengguna yang terjangkau tumbuh lima kali lipat dibanding era praktik tatap muka saja.',
                'He developed the Akar Sehat digital platform to reach users across Indonesia. He opened online consultation via WhatsApp and presented health education content accessible for free to anyone. Within a year, the number of users reached grew fivefold compared to the in-person practice era alone.',
                'طوّر منصة أكار سيهات الرقمية للوصول إلى المستخدمين في جميع أنحاء إندونيسيا. وافتتح استشارات عبر الإنترنت من خلال واتساب وقدّم محتوى تثقيفياً صحياً متاحاً مجاناً للجميع. وخلال عام، نما عدد المستخدمين الذين تم الوصول إليهم خمسة أضعاف مقارنة بعصر الممارسة وجهاً لوجه وحده.',
            ],
            'tl7_year'  => ['2024 — Hari Ini', '2024 — Today', '2024 — اليوم'],
            'tl7_title' => ['500+ Pengguna, Satu Tujuan yang Sama', '500+ Users, One Shared Goal', 'أكثر من 500 مستخدم، هدف واحد مشترك'],
            'tl7_desc'  => [
                'Akar Sehat kini melayani ratusan pengguna aktif dari seluruh Indonesia — dari Sabang sampai Merauke. Dengan 8 produk herbal unggulan, platform edukasi, dan layanan konsultasi personal yang tetap gratis untuk sesi pertama, Kang Bahri terus menjalankan misi yang sama sejak hari pertama: membantu setiap orang menemukan jalan sehatnya sendiri, dari akarnya.',
                'Akar Sehat now serves hundreds of active users from all over Indonesia — from Sabang to Merauke. With 8 flagship herbal products, an education platform, and personal consultation that remains free for the first session, Kang Bahri continues the same mission as on day one: helping everyone find their own path to health, from the root.',
                'تخدم أكار سيهات الآن مئات المستخدمين النشطين من جميع أنحاء إندونيسيا — من سابانغ إلى ميراوكي. مع 8 منتجات عشبية رائدة، ومنصة تثقيفية، واستشارة شخصية تظل مجانية للجلسة الأولى، يواصل كانغ باهري المهمة نفسها منذ اليوم الأول: مساعدة الجميع على إيجاد طريقهم الخاص نحو الصحة، من الجذر.',
            ],

            // ─────────── PROSES PENDAMPINGAN ───────────
            'ck_label' => ['Proses Pendampingan', 'The Mentoring Process', 'عملية الإرشاد'],
            'ck_title' => ['Bagaimana Akar Sehat Bekerja?', 'How Does Akar Sehat Work?', 'كيف تعمل أكار سيهات؟'],
            'ck_desc'  => [
                'Kami tidak menebak-nebak. Ada proses yang terstruktur di balik setiap rekomendasi — dari saat Anda pertama kali menghubungi kami hingga tubuh Anda merespons dengan membaik.',
                'We don\'t guess. There is a structured process behind every recommendation — from the moment you first contact us until your body responds by getting better.',
                'نحن لا نخمّن. هناك عملية منظمة خلف كل توصية — من لحظة تواصلك معنا لأول مرة حتى يستجيب جسدك بالتحسن.',
            ],
            'step1_title' => ['Konsultasi Awal', 'Initial Consultation', 'الاستشارة الأولية'],
            'step1_desc'  => ['Anda cerita, kami mendengar. Tanpa terburu-buru, tanpa penghakiman.', 'You speak, we listen. Without rushing, without judgment.', 'أنت تتحدث، ونحن نستمع. دون استعجال، ودون أحكام.'],
            'step2_title' => ['Analisis Pola Gejala', 'Symptom Pattern Analysis', 'تحليل نمط الأعراض'],
            'step2_desc'  => ['Kang Bahri memetakan pola keluhan dan kaitannya dengan gaya hidup Anda.', 'Kang Bahri maps the pattern of complaints and their connection to your lifestyle.', 'يرسم كانغ باهري نمط الشكاوى وعلاقتها بأسلوب حياتك.'],
            'step3_title' => ['Identifikasi Akar Masalah', 'Identifying the Root Cause', 'تحديد جذر المشكلة'],
            'step3_desc'  => ['Menemukan penyebab yang sesungguhnya — bukan sekadar label diagnosisnya.', 'Finding the true cause — not merely the diagnosis label.', 'إيجاد السبب الحقيقي — وليس مجرد تسمية التشخيص.'],
            'step4_title' => ['Program Personal', 'Personal Program', 'برنامج شخصي'],
            'step4_desc'  => ['Rekomendasi herbal, pola makan, dan gaya hidup yang dibuat khusus untuk Anda.', 'Herbal, diet, and lifestyle recommendations made specifically for you.', 'توصيات عشبية وغذائية وأسلوب حياة مصممة خصيصاً لك.'],
            'step5_title' => ['Pendampingan Berkelanjutan', 'Ongoing Mentoring', 'إرشاد مستمر'],
            'step5_desc'  => ['Kami pantau perkembangan dan sesuaikan program sesuai respons tubuh Anda.', 'We monitor progress and adjust the program according to your body\'s response.', 'نراقب التقدم ونعدّل البرنامج وفقاً لاستجابة جسدك.'],

            'ckd1_title' => ['Apa yang Kami Gali saat Konsultasi', 'What We Explore During Consultation', 'ما الذي نستكشفه أثناء الاستشارة'],
            'ckd1_intro' => ['Kami tidak hanya bertanya tentang gejala saat ini. Kami membangun gambaran lengkap:', 'We don\'t just ask about current symptoms. We build a complete picture:', 'لا نسأل فقط عن الأعراض الحالية. نبني صورة كاملة:'],
            'ckd1_list'  => [
                "Riwayat kesehatan dan keluhan sejak kapan muncul\nPola makan harian — waktu makan, jenis, porsi\nKualitas dan durasi tidur rata-rata\nTingkat dan sumber stres dalam kehidupan sehari-hari\nRiwayat pengobatan — baik konvensional maupun alternatif\nAktivitas fisik dan paparan lingkungan",
                "Health history and when complaints first appeared\nDaily eating patterns — meal times, types, portions\nAverage sleep quality and duration\nLevel and sources of stress in daily life\nTreatment history — both conventional and alternative\nPhysical activity and environmental exposure",
                "التاريخ الصحي ومتى ظهرت الشكاوى لأول مرة\nأنماط الأكل اليومية — أوقات الوجبات وأنواعها وكمياتها\nمتوسط جودة النوم ومدته\nمستوى التوتر ومصادره في الحياة اليومية\nتاريخ العلاج — التقليدي والبديل\nالنشاط البدني والتعرض البيئي",
            ],
            'ckd2_title' => ['Bagaimana Kami Mengidentifikasi Akar Masalah', 'How We Identify the Root Cause', 'كيف نحدد جذر المشكلة'],
            'ckd2_intro' => ['Kang Bahri menggunakan pendekatan berlapis yang menggabungkan beberapa sudut pandang:', 'Kang Bahri uses a layered approach that combines several perspectives:', 'يستخدم كانغ باهري نهجاً متعدد الطبقات يجمع عدة وجهات نظر:'],
            'ckd2_list'  => [
                "Pemetaan organ yang berpotensi terdampak berdasarkan gejala\nAnalisis ketidakseimbangan sistem (pencernaan, imun, hormonal)\nIdentifikasi faktor pemicu eksternal (toksin, pola makan, stres)\nPengecekan silang dengan pengetahuan fitomedicine dan jamu\nKonfirmasi bersama klien — apakah analisis resonan dengan pengalaman mereka",
                "Mapping organs potentially affected based on symptoms\nAnalysis of system imbalances (digestive, immune, hormonal)\nIdentifying external triggers (toxins, diet, stress)\nCross-checking with phytomedicine and jamu knowledge\nConfirming with the client — whether the analysis resonates with their experience",
                "رسم خريطة الأعضاء المحتمل تأثرها بناءً على الأعراض\nتحليل اختلالات الأنظمة (الهضمي، المناعي، الهرموني)\nتحديد المحفزات الخارجية (السموم، النظام الغذائي، التوتر)\nالمقارنة المرجعية مع معرفة الطب النباتي والجامو\nالتأكيد مع العميل — ما إذا كان التحليل يتوافق مع تجربته",
            ],
            'ckd3_title' => ['Pendampingan Setelah Program Dimulai', 'Mentoring After the Program Begins', 'الإرشاد بعد بدء البرنامج'],
            'ckd3_intro' => ['Program bukan hanya diserahkan lalu ditinggal. Kang Bahri memastikan Anda tidak berjalan sendirian:', 'The program is not just handed over and abandoned. Kang Bahri ensures you don\'t walk alone:', 'البرنامج لا يُسلَّم ثم يُترك. يضمن كانغ باهري أنك لا تسير وحدك:'],
            'ckd3_list'  => [
                "Check-in berkala via WhatsApp untuk memantau perkembangan\nPenyesuaian rekomendasi berdasarkan respons tubuh nyata\nEdukasi kontekstual — mengapa tubuh Anda bereaksi seperti itu\nDukungan motivasi untuk menjaga konsistensi program\nEskalasi ke tenaga medis jika diperlukan, tanpa ragu",
                "Periodic check-ins via WhatsApp to monitor progress\nAdjusting recommendations based on real body response\nContextual education — why your body reacts the way it does\nMotivational support to maintain program consistency\nEscalation to medical professionals when needed, without hesitation",
                "متابعات دورية عبر واتساب لمراقبة التقدم\nتعديل التوصيات بناءً على استجابة الجسم الفعلية\nتثقيف سياقي — لماذا يتفاعل جسدك بهذه الطريقة\nدعم تحفيزي للحفاظ على اتساق البرنامج\nالتصعيد إلى المختصين الطبيين عند الحاجة، دون تردد",
            ],

            // ─────────── CTA KONSULTASI ───────────
            'cta_label' => ['Siap Memulai?', 'Ready to Start?', 'مستعد للبدء؟'],
            'cta_title' => ['Ceritakan Keluhanmu, Kami Bantu Temukan Akarnya', 'Tell Us Your Complaint, We\'ll Help Find Its Root', 'أخبرنا بشكواك، وسنساعدك في إيجاد جذرها'],
            'cta_desc'  => [
                'Konsultasi pertama dengan Kang Bahri sepenuhnya gratis dan tanpa komitmen apa pun. Cukup hubungi via WhatsApp dan ceritakan apa yang Anda rasakan.',
                'Your first consultation with Kang Bahri is completely free and with no commitment. Simply contact via WhatsApp and share what you\'re feeling.',
                'استشارتك الأولى مع كانغ باهري مجانية تماماً وبدون أي التزام. فقط تواصل عبر واتساب وأخبره بما تشعر به.',
            ],
            'cta_btn'  => ['Konsultasi Gratis Sekarang', 'Free Consultation Now', 'استشارة مجانية الآن'],
            'cta_note' => ['Gratis · Tanpa komitmen · Respon dalam 1×24 jam', 'Free · No commitment · Response within 1×24 hours', 'مجاني · بدون التزام · رد خلال 1×24 ساعة'],

            // ─────────── BANNER PRODUK ───────────
            'banner_title' => ['Jelajahi Produk Herbal Pilihan Kang Bahri', 'Explore Kang Bahri\'s Selected Herbal Products', 'استكشف منتجات كانغ باهري العشبية المختارة'],
            'banner_desc'  => [
                'Setiap produk yang tersedia di Akar Sehat telah dipilih sendiri oleh Kang Bahri berdasarkan pengalaman klinis bertahun-tahun. Mulai dari detoksifikasi, antioksidan, imunitas, hingga kesehatan pencernaan — semua tersedia untuk mendukung program kesehatan personal Anda.',
                'Every product available at Akar Sehat has been personally selected by Kang Bahri based on years of clinical experience. From detoxification, antioxidants, and immunity to digestive health — all available to support your personal health program.',
                'كل منتج متوفر في أكار سيهات تم اختياره شخصياً من قبل كانغ باهري بناءً على سنوات من الخبرة السريرية. من إزالة السموم ومضادات الأكسدة والمناعة إلى صحة الجهاز الهضمي — كلها متاحة لدعم برنامجك الصحي الشخصي.',
            ],
            'banner_btn' => ['Lihat Semua Produk', 'See All Products', 'عرض جميع المنتجات'],
        ];

        $locales = ['id', 'en', 'ar'];
        foreach ($data as $key => $vals) {
            foreach ($locales as $i => $loc) {
                Setting::updateOrCreate(
                    ['key' => "tentang.{$key}", 'locale' => $loc],
                    ['value' => $vals[$i]]
                );
            }
        }
    }
}
