<?php

return [
    // Common
    'title' => 'Vitrinim Yönetimi',
    'save' => 'Kaydet',
    'edit' => 'Düzenle',
    'delete' => 'Sil',
    'add' => 'Ekle',
    'cancel' => 'İptal',
    'success' => 'Başarıyla kaydedildi',
    'error' => 'Bir hata oluştu',

    // Tabs
    'tabs' => [
        'profile' => 'Profil Bilgileri',
        'slots' => 'Çalışma Saatleri',
        'services' => 'Hizmetler',
        'seo' => 'SEO ve Görünüm',
    ],

    // Profile tab
    'profile' => [
        'title' => 'Başlık',
        'specialty' => 'Uzmanlık Alanı',
        'select_specialty' => 'Uzmanlık Alanı Seçin',
        'contact' => [
            'phone' => 'Telefon',
            'email' => 'E-posta',
        ],
        'location' => [
            'city' => 'Şehir',
            'address' => 'Adres',
        ],
        'description' => [
            'label' => 'Kısa Açıklama',
            'help' => 'SEO ve listelerde görünecek kısa açıklama (160 karakter)',
        ],
        'bio' => [
            'label' => 'Biyografi',
            'help' => 'Eğitim, deneyim ve uzmanlıklarınızı içeren detaylı biyografi',
            'tools' => [
                'bold' => 'Kalın',
                'italic' => 'İtalik',
                'underline' => 'Altı çizili',
                'list' => 'Madde işaretleri',
                'ordered_list' => 'Numaralı liste',
            ],
        ],
        'social_media' => [
            'label' => 'Sosyal Medya',
            'show' => 'Göster',
            'hide' => 'Gizle',
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'twitter' => 'Twitter',
            'linkedin' => 'LinkedIn',
        ],
        'photo' => [
            'label' => 'Profil Fotoğrafı',
            'upload' => 'Fotoğraf yükle',
            'help' => 'PNG, JPG, WEBP, 2MB max.',
        ],
        'submit' => 'Profil Bilgilerini Kaydet',
    ],

    // Slots tab
    'slots' => [
        'title' => 'Çalışma Saatleri',
        'description' => 'Hastalarınızın randevu alabileceği saatleri belirleyin.',
        'day' => 'Gün',
        'start' => 'Başlangıç',
        'end' => 'Bitiş',
        'add' => 'Saat Ekle',
        'remove' => 'Kaldır',
        'working_hours' => 'Çalışma Saatleri',
        'recurring' => 'Bu saatler her hafta tekrarlansın',
        'days' => [
            'monday' => 'Pazartesi',
            'tuesday' => 'Salı',
            'wednesday' => 'Çarşamba',
            'thursday' => 'Perşembe',
            'friday' => 'Cuma',
            'saturday' => 'Cumartesi',
            'sunday' => 'Pazar',
        ],
        'vacation' => [
            'title' => 'İzin Dönemleri',
            'add' => 'İzin Dönemi Ekle',
            'start_date' => 'Başlangıç Tarihi',
            'end_date' => 'Bitiş Tarihi',
            'description' => 'Açıklama',
        ],
        'submit' => 'Çalışma Saatlerini Kaydet',
    ],

    // Services tab
    'services' => [
        'title' => 'Hizmetler',
        'description' => 'Sunduğunuz hizmetleri ekleyin ve düzenleyin.',
        'name' => 'Hizmet Adı',
        'description' => 'Açıklama',
        'price' => 'Fiyat',
        'category' => 'Kategori',
        'select_category' => 'Kategori Seçin',
        'categories' => [
            'general' => 'Genel',
            'cosmetic' => 'Kozmetik',
            'surgical' => 'Cerrahi',
            'restorative' => 'Restoratif',
            'preventive' => 'Koruyucu',
            'pediatric' => 'Çocuk',
            'orthodontic' => 'Ortodontik',
        ],
        'add' => 'Hizmet Ekle',
        'edit' => 'Hizmeti Düzenle',
        'delete' => 'Hizmeti Sil',
        'no_services' => 'Henüz hizmet eklenmemiş.',
        'submit' => 'Hizmetleri Kaydet',
    ],

    // SEO tab
    'seo' => [
        'title' => 'SEO ve Görünüm',
        'description' => 'SEO ayarlarınızı optimize edin ve vitrininizi özelleştirin.',
        'visibility' => [
            'title' => 'Görünürlük',
            'show' => 'Vitrinimi Yayınla',
            'hide' => 'Vitrinimi Gizle',
        ],
        'preview' => [
            'title' => 'Vitrin Önizleme',
            'description' => 'Profilinizi nasıl görüneceğini önizleyin ve yayınlayın.',
            'button' => 'Önizleme',
        ],
        'meta' => [
            'title' => 'Meta Bilgileri',
            'keywords' => 'Anahtar Kelimeler',
            'help' => 'Anahtar kelimeleri virgülle ayırın. Örn: implant, ortodonti, diş beyazlatma',
        ],
        'analysis' => [
            'title' => 'SEO Analizi',
            'description' => 'Profilinizin SEO analizi.',
            'score' => 'SEO Puanı',
            'recommendations' => 'Öneriler',
        ],
        'structured_data' => [
            'title' => 'Yapılandırılmış Veri',
            'description' => 'Google gibi arama motorlarında daha iyi görünmenizi sağlar.',
            'enable' => 'Yapılandırılmış veriyi etkinleştir',
        ],
        'submit' => 'SEO Ayarlarını Kaydet',
    ],
]; 