# نظام يومياتي - Laravel Blade

نظام شخصي (من غير auth) لإدارة:
1. تاسكات يومية ثابتة (روتين) + تاسكات إضافية بنقاط.
2. إحصائيات شهرية للنقاط.
3. إدارة الفلوس (دخل / مصروف / رصيد).

## خطوات التركيب في مشروعك

1. **انسخ الملفات دي في مشروع Laravel عندك** (نفس المسارات بالظبط):
   - `database/migrations/*` → 3 ملفات migration
   - `database/seeders/TaskTemplateSeeder.php`
   - `app/Models/*` → 3 موديلز (Task, TaskTemplate, Transaction)
   - `app/Http/Controllers/*` → 5 كنترولرز
   - `resources/views/*` → layout + views
   - محتوى `routes/web.php` هنا **دمجه** جوه ملف routes/web.php بتاعك (أو استبدله لو المشروع جديد)

2. **فعّل السيدر** في `database/seeders/DatabaseSeeder.php`:
```php
public function run(): void
{
    $this->call(TaskTemplateSeeder::class);
}
```

3. **اضبط اللغة العربية** في `config/app.php`:
```php
'locale' => 'ar',
'faker_locale' => 'ar_EG',
```
(ده عشان `translatedFormat` يطلع أسماء الأيام والشهور بالعربي - Carbon بيدعمها افتراضيًا مع Laravel).

4. **شغل الأوامر**:
```bash
php artisan migrate
php artisan db:seed --class=TaskTemplateSeeder
php artisan serve
```

5. افتح `/` أو `/today` وابدأ تستخدم النظام.

## ملاحظات مهمة

- **التاسكات الثابتة بتتولّد تلقائيًا** أول ما تفتح صفحة "تاسكات اليوم" لأي يوم جديد (مفيش داعي لـ scheduler أو cron).
- **عدّل الروتين بتاعك** من صفحة "التاسكات الثابتة" (`/templates`) - تقدر تغيّر الأسماء، المواعيد، النقاط، أو تعطّل/تفعّل أي تاسك.
- **الصلوات الخمسة** متسجلة كـ 5 تاسكات منفصلة (كل واحدة 5 نقاط) عشان تقدر تتابعهم فرادى.
- **الفلوس**: كل حركة ليها `type` (دخل/مصروف)، `category` اختياري (زي "أكل"، "مواصلات") بيتحسب منه توزيع المصروفات تلقائيًا.
- **التصميم Responsive بالكامل**: على الموبايل بيظهر top bar + bottom navigation، وعلى التابلت/ديسكتوب بيظهر sidebar جانبي. مفيش JS بناء (Tailwind عن طريق CDN) فمش محتاج `npm run build`.
- الألوان والـ dark theme قابلين للتعديل بسهولة من `resources/views/layouts/app.blade.php`.

## إمكانية توسعة مستقبلية (لو حبيت)
- Command مجدول (`schedule:run`) لتوليد تاسكات الغد تلقائيًا الساعة 12 بالليل.
- Chart.js في صفحة الإحصائيات لعرض النقاط كـ line chart بدل الجدول.
- تصدير حركات الفلوس لملف Excel (تقدر تستخدم `maatwebsite/excel` زي ما عملت في مشاريعك التانية).
