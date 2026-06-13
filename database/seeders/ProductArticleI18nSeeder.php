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
                'en' => ['nama' => 'Red Ginger Plus', 'deskripsi' => 'Herbal drink made from selected red ginger blended with pure forest honey. Helps boost immunity and warms the body.', 'cara_pakai' => 'Brew 1 sachet with 200ml hot water. Drink twice a day, morning and night.', 'kandungan' => ['Red Ginger', 'Forest Honey', 'Cinnamon', 'Clove']],
                'ar' => ['nama' => 'جنزبيل أحمر بلس', 'deskripsi' => 'مشروب عشبي من الزنجبيل الأحمر المنتقى ممزوج بعسل الغابات النقي. يساعد على تعزيز المناعة وتدفئة الجسم.', 'cara_pakai' => 'انقع كيساً واحداً في 200 مل من الماء الساخن. اشرب مرتين يومياً صباحاً ومساءً.', 'kandungan' => ['زنجبيل أحمر', 'عسل غابات', 'قرفة', 'قرنفل']],
            ],
            'R12 Detox Herbal' => [
                'en' => ['nama' => 'R12 Herbal Detox', 'deskripsi' => 'Natural detoxification formula to cleanse toxins from the body. Uses 12 selected herbal plants that are traditionally proven.', 'cara_pakai' => '<ol><li><strong>When to Take</strong>Take 1 capsule in the morning after breakfast and 1 capsule at night after dinner.</li><li><strong>Program Duration</strong>Intensive program: 30 days. After that, continue with standard R12 Detox for maintenance.</li><li><strong>Hydration</strong>Drink plenty of water during the program — at least 2.5 liters per day to support toxin removal.</li><li><strong>Storage</strong>Store in a cool, dry place, out of reach of children.</li></ol>', 'kandungan' => ['Temulawak', 'Turmeric', 'Sambiloto', 'Meniran']],
                'ar' => ['nama' => 'ديتوكس عشبي R12', 'deskripsi' => 'تركيبة إزالة سموم طبيعية لتنقية الجسم من السموم. تستخدم 12 نبتة عشبية منتقاة ومثبتة تقليدياً.', 'cara_pakai' => '<ol><li><strong>وقت التناول</strong>تناول كبسولة واحدة صباحاً بعد الفطور وكبسولة واحدة مساءً بعد العشاء.</li><li><strong>مدة البرنامج</strong>برنامج مكثّف: 30 يوماً. بعد ذلك تابع مع ديتوكس R12 القياسي للمحافظة.</li><li><strong>الترطيب</strong>أكثِر من شرب الماء خلال البرنامج — 2.5 لتر على الأقل يومياً لدعم طرد السموم.</li><li><strong>التخزين</strong>يُحفظ في مكان بارد وجاف، بعيداً عن متناول الأطفال.</li></ol>', 'kandungan' => ['تيمولاواك', 'كركم', 'سامبيلوتو', 'مينيران']],
            ],
            'Madu Hutan Asli' => [
                'en' => ['nama' => 'Pure Forest Honey', 'deskripsi' => 'Pure forest honey harvested directly from wild bees in the Kalimantan forest. No mixtures, no preservatives.', 'cara_pakai' => 'Consume 1-2 tablespoons per day, directly or mixed with warm water.', 'kandungan' => ['Pure Forest Honey']],
                'ar' => ['nama' => 'عسل غابات أصلي', 'deskripsi' => 'عسل غابات أصلي يُجنى مباشرة من النحل البري في غابات كاليمانتان. بدون خلط وبدون مواد حافظة.', 'cara_pakai' => 'تناول 1-2 ملعقة كبيرة يومياً، مباشرة أو ممزوجة بماء دافئ.', 'kandungan' => ['عسل غابات نقي']],
            ],
            'Kapsul Sambiloto' => [
                'en' => ['nama' => 'Sambiloto Capsules', 'deskripsi' => 'Sambiloto herbal capsules to maintain immunity and help fight mild infections naturally.', 'cara_pakai' => 'Take 2 capsules twice a day after meals.', 'kandungan' => ['Sambiloto', 'Meniran', 'Soursop Leaf']],
                'ar' => ['nama' => 'كبسولات سامبيلوتو', 'deskripsi' => 'كبسولات عشبية من سامبيلوتو للحفاظ على المناعة والمساعدة على مكافحة العدوى الخفيفة طبيعياً.', 'cara_pakai' => 'تناول كبسولتين مرتين يومياً بعد الطعام.', 'kandungan' => ['سامبيلوتو', 'مينيران', 'ورق القشطة']],
            ],
            'Teh Herbal Segar' => [
                'en' => ['nama' => 'Fresh Herbal Tea', 'deskripsi' => 'Herbal tea with a combination of selected spices for relaxation and digestive health.', 'cara_pakai' => 'Brew 1 tea bag with 200ml hot water, let steep 3-5 minutes.', 'kandungan' => ['Lemongrass', 'Pandan Leaf', 'Cinnamon', 'Cardamom']],
                'ar' => ['nama' => 'شاي عشبي منعش', 'deskripsi' => 'شاي عشبي بمزيج من التوابل المنتقاة للاسترخاء وصحة الجهاز الهضمي.', 'cara_pakai' => 'انقع كيس شاي واحد في 200 مل ماء ساخن، اتركه 3-5 دقائق.', 'kandungan' => ['عشبة الليمون', 'ورق الباندان', 'قرفة', 'هيل']],
            ],
            'Minyak Zaitun Herbal' => [
                'en' => ['nama' => 'Herbal Olive Oil', 'deskripsi' => 'A blend of pure olive oil with black seed and lavender essential oil for relaxing massage and skin health.', 'cara_pakai' => 'Apply to the desired area and massage gently.', 'kandungan' => ['Extra Virgin Olive Oil', 'Black Seed', 'Lavender']],
                'ar' => ['nama' => 'زيت زيتون عشبي', 'deskripsi' => 'مزيج من زيت الزيتون النقي مع حبة البركة وزيت اللافندر العطري للتدليك المريح وصحة البشرة.', 'cara_pakai' => 'ضعه على المنطقة المطلوبة ودلّك بلطف.', 'kandungan' => ['زيت زيتون بكر ممتاز', 'حبة البركة', 'لافندر']],
            ],
            'Serbuk Temulawak' => [
                'en' => ['nama' => 'Temulawak Powder', 'deskripsi' => 'Pure temulawak (Javanese turmeric) powder to maintain liver health and naturally boost appetite.', 'cara_pakai' => 'Brew 1 teaspoon with hot water, add honey to taste.', 'kandungan' => ['Temulawak', 'White Turmeric', 'Black Pepper']],
                'ar' => ['nama' => 'مسحوق تيمولاواك', 'deskripsi' => 'مسحوق تيمولاواك (الكركم الجاوي) النقي للحفاظ على صحة الكبد وتحفيز الشهية طبيعياً.', 'cara_pakai' => 'انقع ملعقة صغيرة في ماء ساخن، أضف العسل حسب الرغبة.', 'kandungan' => ['تيمولاواك', 'كركم أبيض', 'فلفل أسود']],
            ],
            'Paket Konsultasi Herbal' => [
                'en' => ['nama' => 'Herbal Consultation Package', 'deskripsi' => 'A 60-minute direct consultation package with Kang Bahri, including personal herbal recommendations and 1 selected herbal product.', 'cara_pakai' => 'Contact via WhatsApp for scheduling.'],
                'ar' => ['nama' => 'باقة استشارة عشبية', 'deskripsi' => 'باقة استشارة مباشرة مع كانغ باهري لمدة 60 دقيقة، تشمل توصيات عشبية شخصية ومنتجاً عشبياً واحداً منتقى.', 'cara_pakai' => 'تواصل عبر واتساب لتحديد الموعد.'],
            ],
        ];

        // Kandungan kini berupa HTML (WYSIWYG) — ubah array bahan jadi intro + list per bahasa
        $kandunganIntro = [
            'en' => 'Formulated from the following selected herbal ingredients:',
            'ar' => 'مُركّبة من المكونات العشبية المنتقاة التالية:',
        ];
        foreach ($products as $nama => &$trans) {
            foreach ($trans as $loc => &$fields) {
                if (isset($fields['kandungan']) && is_array($fields['kandungan'])) {
                    $items = array_values(array_filter(array_map('trim', $fields['kandungan'])));
                    $fields['kandungan'] = empty($items) ? '' :
                        '<p>' . e($kandunganIntro[$loc] ?? '') . '</p><ul>'
                        . implode('', array_map(fn ($x) => '<li>' . e($x) . '</li>', $items)) . '</ul>';
                }
            }
        }
        unset($trans, $fields);

        // Field baru (deskripsi singkat, manfaat, satuan, isi kemasan) — terjemahan en/ar
        $extra = [
            'Jahe Merah Plus' => [
                'en' => ['singkat' => 'Red ginger and forest honey drink to boost immunity and warm the body.', 'manfaat' => ['Boosts immunity', 'Naturally warms the body', 'Helps relieve colds'], 'satuan' => 'sachet', 'isi' => '10 sachets / box'],
                'ar' => ['singkat' => 'مشروب الزنجبيل الأحمر وعسل الغابات لتعزيز المناعة وتدفئة الجسم.', 'manfaat' => ['يعزّز المناعة', 'يدفّئ الجسم طبيعياً', 'يساعد على تخفيف نزلات البرد'], 'satuan' => 'كيس', 'isi' => '10 أكياس / علبة'],
            ],
            'R12 Detox Herbal' => [
                'en' => ['singkat' => 'A natural detox formula from 12 selected herbs to cleanse toxins from the body.', 'manfaat' => ['Supports natural detox', 'Supports liver & kidney function', 'Ideal for a 14–30 day detox program'], 'satuan' => 'bottle', 'isi' => '60 capsules / bottle'],
                'ar' => ['singkat' => 'تركيبة إزالة سموم طبيعية من 12 عشبة منتقاة لتنقية الجسم من السموم.', 'manfaat' => ['يدعم إزالة السموم الطبيعية', 'يدعم وظائف الكبد والكلى', 'مناسب لبرنامج ديتوكس 14–30 يوماً'], 'satuan' => 'زجاجة', 'isi' => '60 كبسولة / زجاجة'],
            ],
            'Madu Hutan Asli' => [
                'en' => ['singkat' => 'Pure forest honey from wild Kalimantan bees, with no mixtures or preservatives.', 'manfaat' => ['100% pure forest honey', 'Natural source of energy & antioxidants', 'No added sugar'], 'satuan' => 'bottle', 'isi' => '250 ml / bottle'],
                'ar' => ['singkat' => 'عسل غابات أصلي من النحل البري في كاليمانتان، بدون خلط أو مواد حافظة.', 'manfaat' => ['عسل غابات نقي 100%', 'مصدر طبيعي للطاقة ومضادات الأكسدة', 'بدون سكر مضاف'], 'satuan' => 'زجاجة', 'isi' => '250 مل / زجاجة'],
            ],
            'Kapsul Sambiloto' => [
                'en' => ['singkat' => 'Sambiloto capsules to maintain immunity and help fight mild infections.', 'manfaat' => ['Supports the immune system', 'Helps relieve mild infections', 'Natural herbal ingredients'], 'satuan' => 'bottle', 'isi' => '50 capsules / bottle'],
                'ar' => ['singkat' => 'كبسولات سامبيلوتو للحفاظ على المناعة والمساعدة على مكافحة العدوى الخفيفة.', 'manfaat' => ['يدعم الجهاز المناعي', 'يساعد على تخفيف العدوى الخفيفة', 'مكونات عشبية طبيعية'], 'satuan' => 'زجاجة', 'isi' => '50 كبسولة / زجاجة'],
            ],
            'Teh Herbal Segar' => [
                'en' => ['singkat' => 'Herbal spice tea for relaxation and digestive health.', 'manfaat' => ['Helps the body relax', 'Maintains digestive health', 'Soothing spice aroma'], 'satuan' => 'box', 'isi' => '20 tea bags / box'],
                'ar' => ['singkat' => 'شاي أعشاب بالتوابل للاسترخاء وصحة الجهاز الهضمي.', 'manfaat' => ['يساعد الجسم على الاسترخاء', 'يحافظ على صحة الجهاز الهضمي', 'رائحة توابل مهدّئة'], 'satuan' => 'علبة', 'isi' => '20 كيس شاي / علبة'],
            ],
            'Minyak Zaitun Herbal' => [
                'en' => ['singkat' => 'Olive oil with black seed and lavender for relaxing massage and skin health.', 'manfaat' => ['Moisturizes & nourishes skin', 'Great for relaxing massage', 'Calming lavender aroma'], 'satuan' => 'bottle', 'isi' => '100 ml / bottle'],
                'ar' => ['singkat' => 'زيت زيتون مع حبة البركة واللافندر للتدليك المريح وصحة البشرة.', 'manfaat' => ['يرطّب البشرة ويغذّيها', 'مثالي للتدليك المريح', 'رائحة لافندر مهدّئة'], 'satuan' => 'زجاجة', 'isi' => '100 مل / زجاجة'],
            ],
            'Serbuk Temulawak' => [
                'en' => ['singkat' => 'Pure temulawak powder to maintain liver health and boost appetite.', 'manfaat' => ['Maintains liver health', 'Boosts appetite', '100% pure temulawak'], 'satuan' => 'pouch', 'isi' => '200 g / pouch'],
                'ar' => ['singkat' => 'مسحوق تيمولاواك نقي للحفاظ على صحة الكبد وزيادة الشهية.', 'manfaat' => ['يحافظ على صحة الكبد', 'يزيد الشهية', 'تيمولاواك نقي 100%'], 'satuan' => 'كيس', 'isi' => '200 غرام / كيس'],
            ],
            'Paket Konsultasi Herbal' => [
                'en' => ['singkat' => 'A 60-minute personal consultation with Kang Bahri plus herbal recommendations and 1 selected product.', 'manfaat' => ['60-minute personal consultation', 'Herbal recommendations for your needs', 'Includes 1 selected herbal product'], 'satuan' => 'session', 'isi' => '1 session of 60 minutes'],
                'ar' => ['singkat' => 'استشارة شخصية لمدة 60 دقيقة مع كانغ باهري مع توصيات عشبية ومنتج واحد منتقى.', 'manfaat' => ['استشارة شخصية 60 دقيقة', 'توصيات عشبية حسب احتياجك', 'تشمل منتجاً عشبياً واحداً منتقى'], 'satuan' => 'جلسة', 'isi' => 'جلسة واحدة 60 دقيقة'],
            ],
        ];
        foreach ($extra as $nama => $locs) {
            if (!isset($products[$nama])) $products[$nama] = [];
            foreach ($locs as $loc => $v) {
                $products[$nama][$loc]['deskripsi_singkat'] = '<p>' . e($v['singkat']) . '</p>';
                $products[$nama][$loc]['manfaat']           = '<ul>' . implode('', array_map(fn ($x) => '<li>' . e($x) . '</li>', $v['manfaat'])) . '</ul>';
                $products[$nama][$loc]['satuan']            = $v['satuan'];
                $products[$nama][$loc]['isi_kemasan']       = $v['isi'];
            }
        }

        foreach ($products as $nama => $trans) {
            $p = Product::where('nama', $nama)->first();
            if ($p) $this->mergeTranslations($p, $trans);
        }

        // ─────────── ARTIKEL (key = judul ID) → [en, ar] per field ───────────
        $articles = [
            'Manfaat Jahe Merah untuk Daya Tahan Tubuh' => [
                'en' => [
                    'judul'    => 'The Benefits of Red Ginger for Immunity',
                    'keywords' => ['red ginger', 'immunity', 'herbal'],
                    'konten'   => '<p>Red ginger (<em>Zingiber officinale var. rubrum</em>) has long been used in Indonesian traditional medicine as one of the most beneficial herbal plants.</p><h2>Active Compounds of Red Ginger</h2><p>Red ginger contains gingerol and shogaol in higher concentrations than ordinary ginger. Both compounds have strong anti-inflammatory and antioxidant properties.</p><h2>Benefits for Immunity</h2><p>Regular consumption of red ginger can help increase immune cell production, reduce chronic inflammation, and protect the body from viral and bacterial infections.</p><p>Research shows that red ginger extract can inhibit the growth of several pathogenic bacteria in vitro.</p><h2>The Right Way to Consume</h2><p>For optimal benefits, red ginger should be consumed regularly every day. It can be in the form of a warm drink, capsules, or added to cooking.</p>',
                ],
                'ar' => [
                    'judul'    => 'فوائد الزنجبيل الأحمر لتعزيز المناعة',
                    'keywords' => ['زنجبيل أحمر', 'مناعة', 'أعشاب'],
                    'konten'   => '<p>الزنجبيل الأحمر (<em>Zingiber officinale var. rubrum</em>) استُخدم منذ زمن طويل في الطب التقليدي الإندونيسي كأحد أكثر النباتات العشبية فائدة.</p><h2>المركبات الفعالة في الزنجبيل الأحمر</h2><p>يحتوي الزنجبيل الأحمر على الجنجرول والشوغاول بتركيزات أعلى من الزنجبيل العادي. ولكلا المركبين خصائص قوية مضادة للالتهابات ومضادة للأكسدة.</p><h2>الفوائد للمناعة</h2><p>يمكن أن يساعد تناول الزنجبيل الأحمر بانتظام على زيادة إنتاج الخلايا المناعية، وتقليل الالتهاب المزمن، وحماية الجسم من العدوى الفيروسية والبكتيرية.</p><p>تُظهر الأبحاث أن مستخلص الزنجبيل الأحمر يمكن أن يثبّط نمو عدة أنواع من البكتيريا المُمرضة في المختبر.</p><h2>الطريقة الصحيحة للتناول</h2><p>للحصول على فوائد مثلى، يُفضّل تناول الزنجبيل الأحمر بانتظام كل يوم. يمكن أن يكون في شكل مشروب دافئ أو كبسولات أو مضافاً إلى الطعام.</p>',
                ],
            ],
            'Detoksifikasi Alami: Membersihkan Tubuh dengan Herbal' => [
                'en' => [
                    'judul'    => 'Natural Detoxification: Cleansing the Body with Herbs',
                    'keywords' => ['detox', 'detoxification', 'temulawak', 'turmeric'],
                    'konten' => '<p>Detoxification is the process of cleansing toxins that accumulate in the body due to an unhealthy diet, pollution, and stress.</p><h2>Herbal Plants for Detox</h2><p>Several herbal plants are proven to have good detoxification ability:</p><ul><li><strong>Temulawak</strong> — protects the liver from toxin damage</li><li><strong>Turmeric</strong> — anti-inflammatory and supports liver function</li><li><strong>Sambiloto</strong> — helps the immune system and detox</li><li><strong>Meniran</strong> — supports kidney function</li></ul><h2>7-Day Detox Program</h2><p>A simple herbal detox program that can be done at home with ingredients easily found at traditional markets.</p>',
                ],
                'ar' => [
                    'judul'    => 'إزالة السموم الطبيعية: تنقية الجسم بالأعشاب',
                    'keywords' => ['ديتوكس', 'إزالة السموم', 'تيمولاواك', 'كركم'],
                    'konten' => '<p>إزالة السموم هي عملية تنقية السموم المتراكمة في الجسم نتيجة النظام الغذائي غير الصحي والتلوث والتوتر.</p><h2>نباتات عشبية لإزالة السموم</h2><p>أثبتت عدة نباتات عشبية قدرتها الجيدة على إزالة السموم:</p><ul><li><strong>تيمولاواك</strong> — يحمي الكبد من ضرر السموم</li><li><strong>الكركم</strong> — مضاد للالتهابات ويدعم وظيفة الكبد</li><li><strong>سامبيلوتو</strong> — يساعد الجهاز المناعي وإزالة السموم</li><li><strong>مينيران</strong> — يدعم وظيفة الكلى</li></ul><h2>برنامج إزالة السموم لـ7 أيام</h2><p>برنامج بسيط لإزالة السموم بالأعشاب يمكن تنفيذه في المنزل بمكونات تتوفر بسهولة في الأسواق التقليدية.</p>',
                ],
            ],
            'Menjaga Kesehatan Pencernaan dengan Rempah Tradisional' => [
                'en' => [
                    'judul'    => 'Maintaining Digestive Health with Traditional Spices',
                    'keywords' => ['digestion', 'spices', 'turmeric', 'temulawak'],
                    'konten' => '<p>A healthy digestive system is the foundation of overall body health. Indonesia\'s traditional spices hold a wealth of benefits for maintaining digestive health.</p><h2>Spices That Befriend Digestion</h2><p>Ginger, turmeric, cinnamon, and cardamom are some spices traditionally used to address digestive problems such as bloating, nausea, and stomach discomfort.</p>',
                ],
                'ar' => [
                    'judul'    => 'الحفاظ على صحة الجهاز الهضمي بالتوابل التقليدية',
                    'keywords' => ['هضم', 'توابل', 'كركم', 'تيمولاواك'],
                    'konten' => '<p>الجهاز الهضمي الصحي هو أساس صحة الجسم بشكل عام. تحمل التوابل التقليدية الإندونيسية ثروة من الفوائد للحفاظ على صحة الجهاز الهضمي.</p><h2>توابل صديقة للهضم</h2><p>الزنجبيل والكركم والقرفة والهيل بعض التوابل المستخدمة تقليدياً لمعالجة مشاكل الهضم مثل الانتفاخ والغثيان وعدم راحة المعدة.</p>',
                ],
            ],
            'Antioksidan dari Alam: Melawan Radikal Bebas' => [
                'en' => [
                    'judul'    => 'Antioxidants from Nature: Fighting Free Radicals',
                    'keywords' => ['antioxidant', 'free radicals', 'herbal'],
                    'konten' => '<p>Free radicals are unstable molecules that can damage body cells and contribute to premature aging and various degenerative diseases.</p><h2>Herbal Antioxidant Sources</h2><p>Indonesia\'s nature provides many easily accessible natural antioxidant sources, from kitchen spices to wild plants growing around us.</p>',
                ],
                'ar' => [
                    'judul'    => 'مضادات الأكسدة من الطبيعة: محاربة الجذور الحرة',
                    'keywords' => ['مضادات الأكسدة', 'الجذور الحرة', 'أعشاب'],
                    'konten' => '<p>الجذور الحرة جزيئات غير مستقرة يمكن أن تتلف خلايا الجسم وتسهم في الشيخوخة المبكرة وأمراض تنكسية متنوعة.</p><h2>مصادر مضادات الأكسدة العشبية</h2><p>توفّر طبيعة إندونيسيا العديد من مصادر مضادات الأكسدة الطبيعية سهلة الوصول، من توابل المطبخ إلى النباتات البرية التي تنمو حولنا.</p>',
                ],
            ],
            'Panduan Memilih Suplemen Herbal yang Tepat' => [
                'en' => ['judul' => 'A Guide to Choosing the Right Herbal Supplement', 'keywords' => ['supplement', 'herbal', 'guide'], 'konten' => '<p>Article in progress.</p>'],
                'ar' => ['judul' => 'دليل اختيار المكمل العشبي المناسب', 'keywords' => ['مكمل', 'أعشاب', 'دليل'], 'konten' => '<p>المقال قيد الكتابة.</p>'],
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
