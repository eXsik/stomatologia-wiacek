<?php
/**
 * ACF field group registration (ACF Free compatible).
 *
 * Uses only Free field types: text, textarea, image, url, select,
 * true_false, post_object, tab. No Options Page, Repeater, or Relationship.
 *
 * Multi-row homepage content (trust bar, why-us, gallery) is stored as
 * fixed-slot fields and assembled into arrays by helpers.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return; // ACF not active — fail gracefully rather than fatal error.
}

/**
 * Front page: Hero, Trust bar, Why us, Gallery, Doctor teaser.
 */
acf_add_local_field_group( array(
	'key'      => 'group_front_page',
	'title'    => 'Strona główna — sekcje',
	'fields'   => array(
		// Hero.
		array(
			'key'   => 'field_hero_tab',
			'label' => 'Hero',
			'type'  => 'tab',
		),
		array(
			'key'   => 'field_hero_eyebrow',
			'label' => 'Eyebrow (nad nagłówkiem)',
			'name'  => 'hero_eyebrow',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_hero_heading_before',
			'label' => 'Nagłówek — przed wyróżnieniem',
			'name'  => 'hero_heading_before',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_hero_heading_emphasis',
			'label' => 'Nagłówek — wyróżnienie (kursywa)',
			'name'  => 'hero_heading_emphasis',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_hero_heading_after',
			'label' => 'Nagłówek — po wyróżnieniu (kursywa)',
			'name'  => 'hero_heading_after',
			'type'  => 'text',
		),
		array(
			'key'           => 'field_hero_headline',
			'label'         => 'Nagłówek (zapasowy)',
			'name'          => 'hero_headline',
			'type'          => 'text',
			'instructions'  => 'Używany tylko gdy pola podziału nagłówka są puste.',
			'default_value' => '',
		),
		array(
			'key'   => 'field_hero_subheadline',
			'label' => 'Podtytuł',
			'name'  => 'hero_subheadline',
			'type'  => 'textarea',
			'rows'  => 2,
		),
		array(
			'key'           => 'field_hero_image',
			'label'         => 'Zdjęcie / wideo tła',
			'name'          => 'hero_media',
			'type'          => 'image',
			'return_format' => 'id',
		),
		array(
			'key'           => 'field_hero_cta_primary_label',
			'label'         => 'CTA główne — tekst',
			'name'          => 'hero_cta_primary_label',
			'type'          => 'text',
			'default_value' => 'Umów wizytę',
		),
		array(
			'key'   => 'field_hero_cta_primary_link',
			'label' => 'CTA główne — link',
			'name'  => 'hero_cta_primary_link',
			'type'  => 'url',
		),
		array(
			'key'           => 'field_hero_cta_secondary_label',
			'label'         => 'CTA dodatkowe — tekst',
			'name'          => 'hero_cta_secondary_label',
			'type'          => 'text',
			'default_value' => 'Zobacz ofertę',
		),
		array(
			'key'   => 'field_hero_cta_secondary_link',
			'label' => 'CTA dodatkowe — link',
			'name'  => 'hero_cta_secondary_link',
			'type'  => 'url',
		),

		// Trust bar — 4 fixed slots (ACF Free; no Repeater).
		array(
			'key'   => 'field_trust_tab',
			'label' => 'Pasek zaufania',
			'type'  => 'tab',
		),
		array(
			'key'     => 'field_trust_1_icon',
			'label'   => 'Statystyka 1 — ikona',
			'name'    => 'trust_1_icon',
			'type'    => 'select',
			'choices' => array(
				'star'       => 'Gwiazda (ocena Google)',
				'years'      => 'Lata doświadczenia',
				'scanner'    => 'Skaner 3D',
				'cbct'       => 'Tomografia CBCT',
				'microscope' => 'Mikroskop',
			),
			'default_value' => 'star',
		),
		array(
			'key'           => 'field_trust_1_value',
			'label'         => 'Statystyka 1 — wartość',
			'name'          => 'trust_1_value',
			'type'          => 'text',
			'default_value' => '4.9/5',
		),
		array(
			'key'           => 'field_trust_1_label',
			'label'         => 'Statystyka 1 — opis',
			'name'          => 'trust_1_label',
			'type'          => 'text',
			'default_value' => 'Ocena Google',
		),
		array(
			'key'     => 'field_trust_2_icon',
			'label'   => 'Statystyka 2 — ikona',
			'name'    => 'trust_2_icon',
			'type'    => 'select',
			'choices' => array(
				'star'       => 'Gwiazda (ocena Google)',
				'years'      => 'Lata doświadczenia',
				'scanner'    => 'Skaner 3D',
				'cbct'       => 'Tomografia CBCT',
				'microscope' => 'Mikroskop',
			),
			'default_value' => 'years',
		),
		array(
			'key'           => 'field_trust_2_value',
			'label'         => 'Statystyka 2 — wartość',
			'name'          => 'trust_2_value',
			'type'          => 'text',
			'default_value' => '15+ lat',
		),
		array(
			'key'           => 'field_trust_2_label',
			'label'         => 'Statystyka 2 — opis',
			'name'          => 'trust_2_label',
			'type'          => 'text',
			'default_value' => 'Doświadczenia',
		),
		array(
			'key'     => 'field_trust_3_icon',
			'label'   => 'Statystyka 3 — ikona',
			'name'    => 'trust_3_icon',
			'type'    => 'select',
			'choices' => array(
				'star'       => 'Gwiazda (ocena Google)',
				'years'      => 'Lata doświadczenia',
				'scanner'    => 'Skaner 3D',
				'cbct'       => 'Tomografia CBCT',
				'microscope' => 'Mikroskop',
			),
			'default_value' => 'scanner',
		),
		array(
			'key'           => 'field_trust_3_value',
			'label'         => 'Statystyka 3 — wartość',
			'name'          => 'trust_3_value',
			'type'          => 'text',
			'default_value' => 'Skaner 3D',
		),
		array(
			'key'           => 'field_trust_3_label',
			'label'         => 'Statystyka 3 — opis',
			'name'          => 'trust_3_label',
			'type'          => 'text',
			'default_value' => 'Bez odcisków',
		),
		array(
			'key'     => 'field_trust_4_icon',
			'label'   => 'Statystyka 4 — ikona',
			'name'    => 'trust_4_icon',
			'type'    => 'select',
			'choices' => array(
				'star'       => 'Gwiazda (ocena Google)',
				'years'      => 'Lata doświadczenia',
				'scanner'    => 'Skaner 3D',
				'cbct'       => 'Tomografia CBCT',
				'microscope' => 'Mikroskop',
			),
			'default_value' => 'microscope',
		),
		array(
			'key'           => 'field_trust_4_value',
			'label'         => 'Statystyka 4 — wartość',
			'name'          => 'trust_4_value',
			'type'          => 'text',
			'default_value' => 'Mikroskop',
		),
		array(
			'key'           => 'field_trust_4_label',
			'label'         => 'Statystyka 4 — opis',
			'name'          => 'trust_4_label',
			'type'          => 'text',
			'default_value' => 'Precyzyjne leczenie kanałowe',
		),

		// Why us — 3 fixed slots.
		array(
			'key'   => 'field_why_us_tab',
			'label' => 'Dlaczego my',
			'type'  => 'tab',
		),
		array(
			'key'           => 'field_why_us_1_title',
			'label'         => 'Punkt 1 — tytuł',
			'name'          => 'why_us_1_title',
			'type'          => 'text',
			'default_value' => 'Bezbolesne leczenie',
		),
		array(
			'key'           => 'field_why_us_1_description',
			'label'         => 'Punkt 1 — opis',
			'name'          => 'why_us_1_description',
			'type'          => 'textarea',
			'rows'          => 2,
			'default_value' => 'Nowoczesne znieczulenie i delikatne podejście do każdego pacjenta.',
		),
		array(
			'key'           => 'field_why_us_2_title',
			'label'         => 'Punkt 2 — tytuł',
			'name'          => 'why_us_2_title',
			'type'          => 'text',
			'default_value' => 'Nowoczesny sprzęt',
		),
		array(
			'key'           => 'field_why_us_2_description',
			'label'         => 'Punkt 2 — opis',
			'name'          => 'why_us_2_description',
			'type'          => 'textarea',
			'rows'          => 2,
			'default_value' => 'Skaner 3D, tomografia CBCT i mikroskop zabiegowy.',
		),
		array(
			'key'           => 'field_why_us_3_title',
			'label'         => 'Punkt 3 — tytuł',
			'name'          => 'why_us_3_title',
			'type'          => 'text',
			'default_value' => 'Indywidualne podejście',
		),
		array(
			'key'           => 'field_why_us_3_description',
			'label'         => 'Punkt 3 — opis',
			'name'          => 'why_us_3_description',
			'type'          => 'textarea',
			'rows'          => 2,
			'default_value' => 'Plan leczenia dopasowany do Twoich potrzeb i budżetu.',
		),
		array(
			'key'           => 'field_why_us_intro',
			'label'         => 'Krótki wstęp',
			'name'          => 'why_us_intro',
			'type'          => 'textarea',
			'rows'          => 3,
			'default_value' => 'Wierzymy, że spokojna rozmowa, precyzja i indywidualny plan leczenia budują zaufanie na lata.',
		),
		array(
			'key'           => 'field_why_us_image',
			'label'         => 'Obraz sekcji (manifest)',
			'name'          => 'why_us_image',
			'type'          => 'image',
			'return_format' => 'id',
			'preview_size'  => 'medium',
			'instructions'  => 'Duże zdjęcie po prawej stronie sekcji „Dlaczego my”.',
		),
		array(
			'key'           => 'field_services_detail_image',
			'label'         => 'Usługi — obraz detail',
			'name'          => 'services_detail_image',
			'type'          => 'image',
			'return_format' => 'id',
			'preview_size'  => 'medium',
			'instructions'  => 'Opcjonalny mały obraz pod nagłówkiem sekcji usług.',
		),

		// Gallery — 3 fixed before/after slots.
		array(
			'key'   => 'field_gallery_tab',
			'label' => 'Galeria',
			'type'  => 'tab',
		),
		array(
			'key'           => 'field_gallery_1_before',
			'label'         => 'Para 1 — przed',
			'name'          => 'gallery_1_before',
			'type'          => 'image',
			'return_format' => 'id',
		),
		array(
			'key'           => 'field_gallery_1_after',
			'label'         => 'Para 1 — po',
			'name'          => 'gallery_1_after',
			'type'          => 'image',
			'return_format' => 'id',
		),
		array(
			'key'   => 'field_gallery_1_label',
			'label' => 'Para 1 — etykieta',
			'name'  => 'gallery_1_label',
			'type'  => 'text',
		),
		array(
			'key'           => 'field_gallery_2_before',
			'label'         => 'Para 2 — przed',
			'name'          => 'gallery_2_before',
			'type'          => 'image',
			'return_format' => 'id',
		),
		array(
			'key'           => 'field_gallery_2_after',
			'label'         => 'Para 2 — po',
			'name'          => 'gallery_2_after',
			'type'          => 'image',
			'return_format' => 'id',
		),
		array(
			'key'   => 'field_gallery_2_label',
			'label' => 'Para 2 — etykieta',
			'name'  => 'gallery_2_label',
			'type'  => 'text',
		),
		array(
			'key'           => 'field_gallery_3_before',
			'label'         => 'Para 3 — przed',
			'name'          => 'gallery_3_before',
			'type'          => 'image',
			'return_format' => 'id',
		),
		array(
			'key'           => 'field_gallery_3_after',
			'label'         => 'Para 3 — po',
			'name'          => 'gallery_3_after',
			'type'          => 'image',
			'return_format' => 'id',
		),
		array(
			'key'   => 'field_gallery_3_label',
			'label' => 'Para 3 — etykieta',
			'name'  => 'gallery_3_label',
			'type'  => 'text',
		),

		// Doctor teaser — Post Object (Free) instead of Relationship (Pro).
		array(
			'key'   => 'field_doctor_tab',
			'label' => 'Poznaj lekarza',
			'type'  => 'tab',
		),
		array(
			'key'           => 'field_featured_doctor',
			'label'         => 'Wybrany członek zespołu',
			'name'          => 'featured_team_member',
			'type'          => 'post_object',
			'post_type'     => array( 'team_member' ),
			'return_format' => 'object',
			'allow_null'    => 1,
			'ui'            => 1,
			'instructions'  => 'Wybierz jedną osobę do wyróżnienia na stronie głównej.',
		),
	),
	'location' => array(
		array(
			array(
				'param'    => 'page_type',
				'operator' => '==',
				'value'    => 'front_page',
			),
		),
	),
) );

/**
 * Testimonial CPT fields: rating + quote + treatment.
 */
acf_add_local_field_group( array(
	'key'    => 'group_testimonial',
	'title'  => 'Szczegóły opinii',
	'fields' => array(
		array(
			'key'           => 'field_testimonial_rating',
			'label'         => 'Ocena',
			'name'          => 'rating',
			'type'          => 'select',
			'choices'       => array( '5' => '5 gwiazdek', '4' => '4 gwiazdki', '3' => '3 gwiazdki' ),
			'default_value' => '5',
		),
		array(
			'key'   => 'field_testimonial_quote',
			'label' => 'Treść opinii',
			'name'  => 'quote',
			'type'  => 'textarea',
			'rows'  => 3,
		),
		array(
			'key'   => 'field_testimonial_treatment',
			'label' => 'Zabieg',
			'name'  => 'treatment',
			'type'  => 'text',
		),
	),
	'location' => array(
		array(
			array( 'param' => 'post_type', 'operator' => '==', 'value' => 'testimonial' ),
		),
	),
) );

/**
 * Service CPT fields: icon + price range.
 */
acf_add_local_field_group( array(
	'key'    => 'group_service',
	'title'  => 'Szczegóły usługi',
	'fields' => array(
		array(
			'key'     => 'field_service_icon',
			'label'   => 'Ikona',
			'name'    => 'icon',
			'type'    => 'select',
			'choices' => array(
				'aesthetic'  => 'Stomatologia estetyczna',
				'endo'       => 'Endodoncja',
				'implant'    => 'Implanty',
				'prosthetic' => 'Protetyka',
				'surgery'    => 'Chirurgia',
				'perio'      => 'Periodontologia',
				'pediatric'  => 'Stomatologia dziecięca',
				'xray'       => 'Radiologia',
			),
		),
		array(
			'key'          => 'field_service_price_range',
			'label'        => 'Zakres cenowy (opcjonalnie)',
			'name'         => 'price_range',
			'type'         => 'text',
			'instructions' => 'np. „od 350 zł” — zostaw puste, aby nie wyświetlać.',
		),
	),
	'location' => array(
		array(
			array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ),
		),
	),
) );

/**
 * Team Member CPT fields: role + certifications (textarea) + featured flag.
 */
acf_add_local_field_group( array(
	'key'    => 'group_team_member',
	'title'  => 'Szczegóły profilu',
	'fields' => array(
		array( 'key' => 'field_team_role', 'label' => 'Stanowisko', 'name' => 'role', 'type' => 'text' ),
		array(
			'key'          => 'field_team_certifications',
			'label'        => 'Certyfikaty / specjalizacje',
			'name'         => 'certifications',
			'type'         => 'textarea',
			'rows'         => 4,
			'instructions' => 'Jedna pozycja na linię.',
		),
		array(
			'key'   => 'field_team_featured',
			'label' => 'Pokaż na stronie głównej',
			'name'  => 'featured_on_homepage',
			'type'  => 'true_false',
			'ui'    => 1,
		),
	),
	'location' => array(
		array(
			array( 'param' => 'post_type', 'operator' => '==', 'value' => 'team_member' ),
		),
	),
) );
