<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * Mengisi terjemahan EN & AR untuk produk dan artikel demo.
 * Dicocokkan berdasarkan nama (produk) / judul (artikel) bahasa Indonesia.
 * MERGE-safe: hanya mengisi sub-field yang masih kosong — tidak menimpa
 * terjemahan yang sudah diisi admin.
 */
class ProductArticleI18nSeeder extends Seeder
{
    public function run(): void
    {
        // ─────────── PRODUK (key = nama ID) → [en, ar] per field ───────────
        $products = [
            'Jahe Merah Plus' => [
                'en' => ['nama' => 'Red Ginger Plus', 'deskripsi' => 'Herbal drink made from selected red ginger blended with pure forest honey. Helps boost immunity and warms the body.', 'cara_pakai' => 'Brew 1 sachet with 200ml hot water. Drink twice a day, morning and night.'],
                'ar' => ['nama' => 'جنزبيل أحمر بلس', 'deskripsi' => 'مشروب عشبي من الزنجبيل الأحمر المنتقى ممزوج بعسل الغابات النقي. يساعد على تعزيز المناعة وتدفئة الجسم.', 'cara_pakai' => 'انقع كيساً واحداً في 200 مل من الماء الساخن. اشرب مرتين يومياً صباحاً ومساءً.'],
            ],
            'R12 Detox Herbal' => [
                'en' => ['nama' => 'R12 Herbal Detox', 'deskripsi' => 'Natural detoxification formula to cleanse toxins from the body. Uses 12 selected herbal plants that are traditionally proven.', 'cara_pakai' => 'Take 1 capsule 3 times a day after meals.'],
                'ar' => ['nama' => 'ديتوكس عشبي R12', 'deskripsi' => 'تركيبة إزالة سموم طبيعية لتنقية الجسم من السموم. تستخدم 12 نبتة عشبية منتقاة ومثبتة تقليدياً.', 'cara_pakai' => 'تناول كبسولة واحدة 3 مرات يومياً بعد الطعام.'],
            ],
            'Madu Hutan Asli' => [
                'en' => ['nama' => 'Pure Forest Honey', 'deskripsi' => 'Pure forest honey harvested directly from wild bees in the Kalimantan forest. No mixtures, no preservatives.', 'cara_pakai' => 'Consume 1-2 tablespoons per day, directly or mixed with warm water.'],
                'ar' => ['nama' => 'عسل غابات أصلي', 'deskripsi' => 'عسل غابات أصلي يُجنى مباشرة من النحل البري في غابات كاليمانتان. بدون خلط وبدون مواد حافظة.', 'cara_pakai' => 'تناول 1-2 ملعقة كبيرة يومياً، مباشرة أو ممزوجة بماء دافئ.'],
            ],
            'Kapsul Sambiloto' => [
                'en' => ['nama' => 'Sambiloto Capsules', 'deskripsi' => 'Sambiloto herbal capsules to maintain immunity and help fight mild infections naturally.', 'cara_pakai' => 'Take 2 capsules twice a day after meals.'],
                'ar' => ['nama' => 'كبسولات سامبيلوتو', 'deskripsi' => 'كبسولات عشبية من سامبيلوتو للحفاظ على المناعة والمساعدة على مكافحة العدوى الخفيفة طبيعياً.', 'cara_pakai' => 'تناول كبسولتين مرتين يومياً بعد الطعام.'],
            ],
            'Teh Herbal Segar' => [
                'en' => ['nama' => 'Fresh Herbal Tea', 'deskripsi' => 'Herbal tea with a combination of selected spices for relaxation and digestive health.', 'cara_pakai' => 'Brew 1 tea bag with 200ml hot water, let steep 3-5 minutes.'],
                'ar' => ['nama' => 'شاي عشبي منعش', 'deskripsi' => 'شاي عشبي بمزيج من التوابل المنتقاة للاسترخاء وصحة الجهاز الهضمي.', 'cara_pakai' => 'انقع كيس شاي واحد في 200 مل ماء ساخن، اتركه 3-5 دقائق.'],
            ],
            'Minyak Zaitun Herbal' => [
                'en' => ['nama' => 'Herbal Olive Oil', 'deskripsi' => 'A blend of pure olive oil with black seed and lavender essential oil for relaxing massage and skin health.', 'cara_pakai' => 'Apply to the desired area and massage gently.'],
                'ar' => ['nama' => 'زيت زيتون عشبي', 'deskripsi' => 'مزيج من زيت الزيتون النقي مع حبة البركة وزيت اللافندر العطري للتدليك المريح وصحة البشرة.', 'cara_pakai' => 'ضعه على المنطقة المطلوبة ودلّك بلطف.'],
            ],
            'Serbuk Temulawak' => [
                'en' => ['nama' => 'Temulawak Powder', 'deskripsi' => 'Pure temulawak (Javanese turmeric) powder to maintain liver health and naturally boost appetite.', 'cara_pakai' => 'Brew 1 teaspoon with hot water, add honey to taste.'],
                'ar' => ['nama' => 'مسحوق تيمولاواك', 'deskripsi' => 'مسحوق تيمولاواك (الكركم الجاوي) النقي للحفاظ على صحة الكبد وتحفيز الشهية طبيعياً.', 'cara_pakai' => 'انقع ملعقة صغيرة في ماء ساخن، أضف العسل حسب الرغبة.'],
            ],
            'Paket Konsultasi Herbal' => [
                'en' => ['nama' => 'Herbal Consultation Package', 'deskripsi' => 'A 60-minute direct consultation package with Kang Bahri, including personal herbal recommendations and 1 selected herbal product.', 'cara_pakai' => 'Contact via WhatsApp for scheduling.'],
                'ar' => ['nama' => 'باقة استشارة عشبية', 'deskripsi' => 'باقة استشارة مباشرة مع كانغ باهري لمدة 60 دقيقة، تشمل توصيات عشبية شخصية ومنتجاً عشبياً واحداً منتقى.', 'cara_pakai' => 'تواصل عبر واتساب لتحديد الموعد.'],
            ],
        ];

        foreach ($products as $nama => $trans) {
            $p = Product::where('nama', $nama)->first();
            if ($p) $this->mergeTranslations($p, $trans);
        }

        // ─────────── ARTIKEL (key = judul ID) → [en, ar] per field ───────────
        $articles = [
            'Manfaat Jahe Merah untuk Daya Tahan Tubuh' => [
                'en' => [
                    'judul'  => 'The Benefits of Red Ginger for Immunity',
                    'konten' => '<p>Red ginger (<em>Zingiber officinale var. rubrum</em>) has long been used in Indonesian traditional medicine as one of the most beneficial herbal plants.</p><h2>Active Compounds of Red Ginger</h2><p>Red ginger contains gingerol and shogaol in higher concentrations than ordinary ginger. Both compounds have strong anti-inflammatory and antioxidant properties.</p><h2>Benefits for Immunity</h2><p>Regular consumption of red ginger can help increase immune cell production, reduce chronic inflammation, and protect the body from viral and bacterial infections.</p><p>Research shows that red ginger extract can inhibit the growth of several pathogenic bacteria in vitro.</p><h2>The Right Way to Consume</h2><p>For optimal benefits, red ginger should be consumed regularly every day. It can be in the form of a warm drink, capsules, or added to cooking.</p>',
                ],
                'ar' => [
                    'judul'  => 'فوائد الزنجبيل الأحمر لتعزيز المناعة',
                    'konten' => '<p>الزنجبيل الأحمر (<em>Zingiber officinale var. rubrum</em>) استُخدم منذ زمن طويل في الطب التقليدي الإندونيسي كأحد أكثر النباتات العشبية فائدة.</p><h2>المركبات الفعالة في الزنجبيل الأحمر</h2><p>يحتوي الزنجبيل الأحمر على الجنجرول والشوغاول بتركيزات أعلى من الزنجبيل العادي. ولكلا المركبين خصائص قوية مضادة للالتهابات ومضادة للأكسدة.</p><h2>الفوائد للمناعة</h2><p>يمكن أن يساعد تناول الزنجبيل الأحمر بانتظام على زيادة إنتاج الخلايا المناعية، وتقليل الالتهاب المزمن، وحماية الجسم من العدوى الفيروسية والبكتيرية.</p><p>تُظهر الأبحاث أن مستخلص الزنجبيل الأحمر يمكن أن يثبّط نمو عدة أنواع من البكتيريا المُمرضة في المختبر.</p><h2>الطريقة الصحيحة للتناول</h2><p>للحصول على فوائد مثلى، يُفضّل تناول الزنجبيل الأحمر بانتظام كل يوم. يمكن أن يكون في شكل مشروب دافئ أو كبسولات أو مضافاً إلى الطعام.</p>',
                ],
            ],
            'Detoksifikasi Alami: Membersihkan Tubuh dengan Herbal' => [
                'en' => [
                    'judul'  => 'Natural Detoxification: Cleansing the Body with Herbs',
                    'konten' => '<p>Detoxification is the process of cleansing toxins that accumulate in the body due to an unhealthy diet, pollution, and stress.</p><h2>Herbal Plants for Detox</h2><p>Several herbal plants are proven to have good detoxification ability:</p><ul><li><strong>Temulawak</strong> — protects the liver from toxin damage</li><li><strong>Turmeric</strong> — anti-inflammatory and supports liver function</li><li><strong>Sambiloto</strong> — helps the immune system and detox</li><li><strong>Meniran</strong> — supports kidney function</li></ul><h2>7-Day Detox Program</h2><p>A simple herbal detox program that can be done at home with ingredients easily found at traditional markets.</p>',
                ],
                'ar' => [
                    'judul'  => 'إزالة السموم الطبيعية: تنقية الجسم بالأعشاب',
                    'konten' => '<p>إزالة السموم هي عملية تنقية السموم المتراكمة في الجسم نتيجة النظام الغذائي غير الصحي والتلوث والتوتر.</p><h2>نباتات عشبية لإزالة السموم</h2><p>أثبتت عدة نباتات عشبية قدرتها الجيدة على إزالة السموم:</p><ul><li><strong>تيمولاواك</strong> — يحمي الكبد من ضرر السموم</li><li><strong>الكركم</strong> — مضاد للالتهابات ويدعم وظيفة الكبد</li><li><strong>سامبيلوتو</strong> — يساعد الجهاز المناعي وإزالة السموم</li><li><strong>مينيران</strong> — يدعم وظيفة الكلى</li></ul><h2>برنامج إزالة السموم لـ7 أيام</h2><p>برنامج بسيط لإزالة السموم بالأعشاب يمكن تنفيذه في المنزل بمكونات تتوفر بسهولة في الأسواق التقليدية.</p>',
                ],
            ],
            'Menjaga Kesehatan Pencernaan dengan Rempah Tradisional' => [
                'en' => [
                    'judul'  => 'Maintaining Digestive Health with Traditional Spices',
                    'konten' => '<p>A healthy digestive system is the foundation of overall body health. Indonesia\'s traditional spices hold a wealth of benefits for maintaining digestive health.</p><h2>Spices That Befriend Digestion</h2><p>Ginger, turmeric, cinnamon, and cardamom are some spices traditionally used to address digestive problems such as bloating, nausea, and stomach discomfort.</p>',
                ],
                'ar' => [
                    'judul'  => 'الحفاظ على صحة الجهاز الهضمي بالتوابل التقليدية',
                    'konten' => '<p>الجهاز الهضمي الصحي هو أساس صحة الجسم بشكل عام. تحمل التوابل التقليدية الإندونيسية ثروة من الفوائد للحفاظ على صحة الجهاز الهضمي.</p><h2>توابل صديقة للهضم</h2><p>الزنجبيل والكركم والقرفة والهيل بعض التوابل المستخدمة تقليدياً لمعالجة مشاكل الهضم مثل الانتفاخ والغثيان وعدم راحة المعدة.</p>',
                ],
            ],
            'Antioksidan dari Alam: Melawan Radikal Bebas' => [
                'en' => [
                    'judul'  => 'Antioxidants from Nature: Fighting Free Radicals',
                    'konten' => '<p>Free radicals are unstable molecules that can damage body cells and contribute to premature aging and various degenerative diseases.</p><h2>Herbal Antioxidant Sources</h2><p>Indonesia\'s nature provides many easily accessible natural antioxidant sources, from kitchen spices to wild plants growing around us.</p>',
                ],
                'ar' => [
                    'judul'  => 'مضادات الأكسدة من الطبيعة: محاربة الجذور الحرة',
                    'konten' => '<p>الجذور الحرة جزيئات غير مستقرة يمكن أن تتلف خلايا الجسم وتسهم في الشيخوخة المبكرة وأمراض تنكسية متنوعة.</p><h2>مصادر مضادات الأكسدة العشبية</h2><p>توفّر طبيعة إندونيسيا العديد من مصادر مضادات الأكسدة الطبيعية سهلة الوصول، من توابل المطبخ إلى النباتات البرية التي تنمو حولنا.</p>',
                ],
            ],
            'Panduan Memilih Suplemen Herbal yang Tepat' => [
                'en' => ['judul' => 'A Guide to Choosing the Right Herbal Supplement', 'konten' => '<p>Article in progress.</p>'],
                'ar' => ['judul' => 'دليل اختيار المكمل العشبي المناسب', 'konten' => '<p>المقال قيد الكتابة.</p>'],
            ],
        ];

        foreach ($articles as $judul => $trans) {
            $a = Article::where('judul', $judul)->first();
            if ($a) $this->mergeTranslations($a, $trans);
        }
    }

    /**
     * Gabungkan terjemahan baru ke kolom translations tanpa menimpa
     * sub-field yang sudah terisi.
     */
    private function mergeTranslations($model, array $incoming): void
    {
        $current = is_array($model->translations) ? $model->translations : [];
        foreach ($incoming as $loc => $fields) {
            foreach ($fields as $field => $value) {
                if (empty($current[$loc][$field])) {
                    $current[$loc][$field] = $value;
                }
            }
        }
        $model->translations = $current;
        $model->save();
    }
}
