<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Enums\DentalSpecialty;
use Tests\TestCase;

class DentalSpecialtyEnumTest extends TestCase
{
    public function test_enum_values_exist(): void
    {
        // Test that all expected enum cases exist
        $this->assertSame('genel_dis_hekimligi', DentalSpecialty::GENERAL_DENTISTRY->value);
        $this->assertSame('ortodonti', DentalSpecialty::ORTHODONTICS->value);
        $this->assertSame('periodontoloji', DentalSpecialty::PERIODONTICS->value);
        $this->assertSame('endodonti', DentalSpecialty::ENDODONTICS->value);
        $this->assertSame('agiz_dis_ve_cene_cerrahisi', DentalSpecialty::ORAL_SURGERY->value);
        $this->assertSame('pedodonti', DentalSpecialty::PEDIATRIC_DENTISTRY->value);
        $this->assertSame('protetik_dis_tedavisi', DentalSpecialty::PROSTHODONTICS->value);
        $this->assertSame('agiz_dis_ve_cene_radyolojisi', DentalSpecialty::ORAL_RADIOLOGY->value);
        $this->assertSame('restoratif_dis_tedavisi', DentalSpecialty::RESTORATIVE_DENTISTRY->value);
        $this->assertSame('implantoloji', DentalSpecialty::IMPLANTOLOGY->value);
        $this->assertSame('estetik_dis_hekimligi', DentalSpecialty::AESTHETIC_DENTISTRY->value);
    }
    
    public function test_get_label_method_returns_correct_turkish_labels(): void
    {
        // Test that getLabel method returns correct Turkish translations
        $this->assertSame('Genel Diş Hekimliği', DentalSpecialty::GENERAL_DENTISTRY->getLabel());
        $this->assertSame('Ortodonti', DentalSpecialty::ORTHODONTICS->getLabel());
        $this->assertSame('Periodontoloji', DentalSpecialty::PERIODONTICS->getLabel());
        $this->assertSame('Endodonti', DentalSpecialty::ENDODONTICS->getLabel());
        $this->assertSame('Ağız, Diş ve Çene Cerrahisi', DentalSpecialty::ORAL_SURGERY->getLabel());
        $this->assertSame('Pedodonti', DentalSpecialty::PEDIATRIC_DENTISTRY->getLabel());
        $this->assertSame('Protetik Diş Tedavisi', DentalSpecialty::PROSTHODONTICS->getLabel());
        $this->assertSame('Ağız, Diş ve Çene Radyolojisi', DentalSpecialty::ORAL_RADIOLOGY->getLabel());
        $this->assertSame('Restoratif Diş Tedavisi', DentalSpecialty::RESTORATIVE_DENTISTRY->getLabel());
        $this->assertSame('İmplantoloji', DentalSpecialty::IMPLANTOLOGY->getLabel());
        $this->assertSame('Estetik Diş Hekimliği', DentalSpecialty::AESTHETIC_DENTISTRY->getLabel());
    }
    
    public function test_get_options_returns_array_of_all_options(): void
    {
        // Test that getOptions returns an array with all options
        $options = DentalSpecialty::getOptions();
        
        // Assert array has all cases
        $this->assertCount(11, $options);
        
        // Assert specific mappings exist
        $this->assertArrayHasKey('ortodonti', $options);
        $this->assertArrayHasKey('implantoloji', $options);
        
        // Assert values are correct
        $this->assertEquals('Ortodonti', $options['ortodonti']);
        $this->assertEquals('İmplantoloji', $options['implantoloji']);
    }
    
    public function test_can_create_from_string_value(): void
    {
        // Test that we can create an enum from its string value
        $specialty = DentalSpecialty::from('ortodonti');
        
        // Assert that it's the correct enum case
        $this->assertSame(DentalSpecialty::ORTHODONTICS, $specialty);
        $this->assertEquals('Ortodonti', $specialty->getLabel());
    }
    
    public function test_invalid_value_throws_exception(): void
    {
        // Assert that trying to get an enum with an invalid value throws exception
        $this->expectException(\ValueError::class);
        DentalSpecialty::from('invalid_value');
    }
} 