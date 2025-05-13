# Hekimport Test Suite

Bu belge, Hekimport projesinin test altyapısını, test senaryolarını ve test sırasında tespit edilen sorunları düzeltme talimatlarını içermektedir.

## Test Dosyaları

### Unit Testleri
- `tests/Unit/VitrinModelTest.php`: Vitrin modelinin ilişkilerini ve yöntemlerini test eder
- `tests/Unit/DentalSpecialtyEnumTest.php`: DentalSpecialty enum değerlerini ve çevirilerini test eder

### Feature Testleri
- `tests/Feature/AuthenticationTest.php`: Kimlik doğrulama işlemlerini test eder (giriş, başarısız giriş, korumalı sayfalara erişim)
- `tests/Feature/VitrinimModuleTest.php`: Vitrinim modülünün sayfa yükleme ve form işlevlerini test eder
- `tests/Feature/KlinigimPlaceholderTest.php`: Kliniğim sayfasının yüklenmesini ve geri bildirim formunu test eder

### Browser Testleri (Laravel Dusk)
- `tests/Browser/LoginTest.php`: Giriş akışını test eder (giriş sayfasını ziyaret etme, kimlik bilgilerini girme, /masam'a yönlendirmeyi doğrulama)
- `tests/Browser/VitrinimFlowTest.php`: "Vitrinim" modülü akışını test eder (giriş, /masam/vitrinim'i ziyaret etme, profil biyografisini güncelleme, randevu saati ekleme)
- `tests/Browser/KlinigimFlowTest.php`: "Kliniğim" placeholder sayfasını test eder (giriş, /masam/kliniğim'i ziyaret etme, "Yakında" mesajını doğrulama, geri bildirim gönderme)

## Testleri Çalıştırma

### Unit ve Feature Testleri

Unit ve Feature testlerini çalıştırmak için:

```bash
php artisan test
```

Bu komut, tüm test dosyalarını çalıştırır. Belirli bir test dosyasını çalıştırmak için:

```bash
php artisan test tests/Feature/AuthenticationTest.php
```

### Browser Testleri (Laravel Dusk)

Dusk tarayıcı testlerini çalıştırmak için:

```bash
php artisan dusk
```

Not: Dusk testleri için Chrome tarayıcısı gereklidir. Eğer "cannot find Chrome binary" hatası alırsanız, uygun Chrome sürücüsünü yüklemeniz gerekir:

```bash
php artisan dusk:chrome-driver
```

## Yaygın Sorunlar ve Çözümleri

Testleri çalıştırırken karşılaşılabilecek yaygın sorunlar ve çözümleri aşağıda listelenmiştir:

### 1. Doğrulama Hataları

**Sorun**: VitrinimPage bileşeninde form doğrulama hataları alınabilir.

**Çözüm**: Tüm zorunlu alanların doğru şekilde doldurulduğundan emin olun:
- `title`: En az 5, en fazla 60 karakter (zorunlu)
- `description`: En az 10, en fazla 160 karakter (zorunlu)
- `bio`: En az 20 karakter (zorunlu)
- `specialty`: Zorunlu alan
- `city`: Zorunlu alan
- `contact_info.phone`: Zorunlu alan
- `contact_info.email`: Geçerli bir e-posta adresi (zorunlu)

### 2. Çalışma Saatleri Dizi Yapısı

**Sorun**: Çalışma saatleri dizisinde tanımsız indeks hatası alınabilir.

**Çözüm**: Çalışma saatleri dizisinin tüm günleri içerdiğinden emin olun. Dizinin günleri İngilizce olarak ('Monday', 'Tuesday', vb.) tanımlanmalıdır. Testlerde başlangıçta tüm günleri sıfırlayın:

```php
'working_hours' => [
    'Monday' => ['09:00-10:00'],
    'Tuesday' => [],
    'Wednesday' => [],
    'Thursday' => [],
    'Friday' => [],
    'Saturday' => [],
    'Sunday' => []
]
```

### 3. Livewire Metot Adları

**Sorun**: Livewire bileşenlerinde metot bulunamadı hatası alınabilir.

**Çözüm**: Doğru metot adlarını kullanın:
- `saveProfile()`: Biyografi ve diğer profil bilgilerini kaydetmek için
- `addSlot()`: Randevu saati eklemek için
- `removeSlot()`: Randevu saati kaldırmak için
- `toggleVisibility()`: Profil görünürlüğünü değiştirmek için

### 4. SQLite Uyumluluğu

**Sorun**: MySQL'e özgü fonksiyonlar SQLite ile çalışmaz.

**Çözüm**: Veritabanı bağlantı türünü kontrol edip uygun fonksiyonları kullanın:

```php
// MySQL için:
DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')");
// SQLite için:
DB::raw("strftime('%Y-%m-%d', created_at)");
```

### 5. Özel Tablo Hatası

**Sorun**: Testler sırasında "no such table: custom_domains" hatası alınabilir.

**Çözüm**: Tablolar için Schema::hasTable() kontrolü yapın:

```php
if (Schema::hasTable('custom_domains')) {
    // Tablo mevcutsa sorgu çalıştır
}
```

### 6. Object/Array Dönüşüm Hataları

**Sorun**: Dizi olması gereken değerler string olabilir, ve bu "Cannot assign string to property X of type array" hatalarına neden olabilir.

**Çözüm**: Değerleri doğrulamanız ve dönüştürmeniz gerekir:

```php
$this->services = is_array($this->vitrin->services) ? $this->vitrin->services : [];
```

## Önerilen Geliştirmeler

1. **Test Kapsamının Genişletilmesi**:
   - Hizmet yönetimi için daha kapsamlı testler ekleyin
   - Analitik özellikleri için testler ekleyin
   - SEO optimizasyon özellikleri için testler ekleyin

2. **Test Verimlerini İyileştirme**:
   - Fabrika tanımlarını zenginleştirin
   - Test yardımcı işlevleri tanımlayın

3. **Entegrasyon Testleri**:
   - Uygulamanın tüm parçalarının birlikte nasıl çalıştığını test eden entegrasyon testleri ekleyin

## Test Bağımlılıkları

- Laravel 12
- PHPUnit 11
- Laravel Dusk (tarayıcı testi için)
- SQLite (test veritabanı olarak) 