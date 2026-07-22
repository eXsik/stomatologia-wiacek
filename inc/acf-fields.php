<?php
/**
 * ACF field group registration.
 *
 * In production these groups are managed via the ACF UI and synced to
 * /acf-json/ (version-controlled, auto-loaded by ACF over the DB copy).
 * They are registered here in PHP so the full field structure is
 * reviewable in the codebase without opening the WP admin.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return; // ACF Pro not active — fail gracefully rather than fatal error.
}

/**
 * Front page: Hero, Trust bar, Doctor teaser.
 * (Services / Testimonials / FAQ are CPT-driven, not ACF — see architecture doc §6.)
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
			'key'   => 'field_hero_headline',
			'label' => 'Nagłówek',
			'name'  => 'hero_headline',
			'type'  => 'text',
			'default_value' => 'Nowoczesna stomatologia bez stresu w Ostrowie Wielkopolskim',
		),
		array(
			'key'   => 'field_hero_subheadline',
			'label' => 'Podtytuł',
			'name'  => 'hero_subheadline',
			'type'  => 'textarea',
			'rows'  => 2,
		),
		array(
			'key'   => 'field_hero_image',
			'label' => 'Zdjęcie / wideo tła',
			'name'  => 'hero_media',
			'type'  => 'image',
			'return_format' => 'id',
		),
		array(
			'key'   => 'field_hero_cta_primary_label',
			'label' => 'CTA główne — tekst',
			'name'  => 'hero_cta_primary_label',
			'type'  => 'text',
			'default_value' => 'Umów wizytę',
		),
		array(
			'key'   => 'field_hero_cta_primary_link',
			'label' => 'CTA główne — link',
			'name'  => 'hero_cta_primary_link',
			'type'  => 'url',
		),
		array(
			'key'   => 'field_hero_cta_secondary_label',
			'label' => 'CTA dodatkowe — tekst',
			'name'  => 'hero_cta_secondary_label',
			'type'  => 'text',
			'default_value' => 'Zobacz ofertę',
		),
		array(
			'key'   => 'field_hero_cta_secondary_link',
			'label' => 'CTA dodatkowe — link',
			'name'  => 'hero_cta_secondary_link',
			'type'  => 'url',
		),

		// Trust bar.
		array(
			'key'   => 'field_trust_tab',
			'label' => 'Pasek zaufania',
			'type'  => 'tab',
		),
		array(
			'key'          => 'field_trust_stats',
			'label'        => 'Statystyki (4 pozycje)',
			'name'         => 'trust_stats',
			'type'         => 'repeater',
			'min'          => 1,
			'max'          => 4,
			'layout'       => 'table',
			'sub_fields'   => array(
				array(
					'key'   => 'field_trust_icon',
					'label' => 'Ikona',
					'name'  => 'icon',
					'type'  => 'select',
					'choices' => array(
						'star'    => 'Gwiazda (ocena Google)',
						'years'   => 'Lata doświadczenia',
						'scanner' => 'Skaner 3D',
						'cbct'    => 'Tomografia CBCT',
						'microscope' => 'Mikroskop',
					),
				),
				array(
					'key'   => 'field_trust_value',
					'label' => 'Wartość',
					'name'  => 'value',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_trust_label',
					'label' => 'Opis',
					'name'  => 'label',
					'type'  => 'text',
				),
			),
		),

		// Why us.
		array(
			'key'   => 'field_why_us_tab',
			'label' => 'Dlaczego my',
			'type'  => 'tab',
		),
		array(
			'key'          => 'field_why_us_points',
			'label'        => 'Punkty wyróżniające',
			'name'         => 'why_us_points',
			'type'         => 'repeater',
			'layout'       => 'table',
			'sub_fields'   => array(
				array(
					'key'   => 'field_why_us_title',
					'label' => 'Tytuł',
					'name'  => 'title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_why_us_description',
					'label' => 'Opis',
					'name'  => 'description',
					'type'  => 'textarea',
					'rows'  => 2,
				),
			),
		),

		// Gallery teaser.
		array(
			'key'   => 'field_gallery_tab',
			'label' => 'Galeria',
			'type'  => 'tab',
		),
		array(
			'key'          => 'field_gallery_pairs',
			'label'        => 'Pary przed/po (max 3 na stronie głównej)',
			'name'         => 'gallery_pairs',
			'type'         => 'repeater',
			'layout'       => 'table',
			'sub_fields'   => array(
				array(
					'key'           => 'field_gallery_before',
					'label'         => 'Przed',
					'name'          => 'before',
					'type'          => 'image',
					'return_format' => 'id',
				),
				array(
					'key'           => 'field_gallery_after',
					'label'         => 'Po',
					'name'          => 'after',
					'type'          => 'image',
					'return_format' => 'id',
				),
				array(
					'key'   => 'field_gallery_label',
					'label' => 'Etykieta',
					'name'  => 'label',
					'type'  => 'text',
				),
			),
		),

		// Doctor teaser.
		array(
			'key'   => 'field_doctor_tab',
			'label' => 'Poznaj lekarza',
			'type'  => 'tab',
		),
		array(
			'key'           => 'field_featured_doctor',
			'label'         => 'Wybrany członek zespołu',
			'name'          => 'featured_team_member',
			'type'          => 'relationship',
			'post_type'     => array( 'team_member' ),
			'filters'       => array( 'search' ),
			'max'           => 1,
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
 * Options page: sitewide NAP + hours + socials + map.
 * Single source of truth reused in header, footer, contact section
 * and JSON-LD schema output.
 */
acf_add_local_field_group( array(
	'key'    => 'group_site_options',
	'title'  => 'Dane gabinetu (globalne)',
	'fields' => array(
		array( 'key' => 'field_opt_phone', 'label' => 'Telefon', 'name' => 'clinic_phone', 'type' => 'text', 'default_value' => '62 123 45 67' ),
		array( 'key' => 'field_opt_email', 'label' => 'E-mail', 'name' => 'clinic_email', 'type' => 'email' ),
		array( 'key' => 'field_opt_address', 'label' => 'Adres', 'name' => 'clinic_address', 'type' => 'text', 'default_value' => 'ul. Przykładowa 1, 63-400 Ostrów Wielkopolski' ),
		array( 'key' => 'field_opt_lat', 'label' => 'Szerokość geogr. (lat)', 'name' => 'clinic_lat', 'type' => 'text' ),
		array( 'key' => 'field_opt_lng', 'label' => 'Długość geogr. (lng)', 'name' => 'clinic_lng', 'type' => 'text' ),
		array(
			'key'        => 'field_opt_hours',
			'label'      => 'Godziny otwarcia',
			'name'       => 'clinic_hours',
			'type'       => 'repeater',
			'layout'     => 'table',
			'sub_fields' => array(
				array( 'key' => 'field_opt_hours_day', 'label' => 'Dzień', 'name' => 'day', 'type' => 'text' ),
				array( 'key' => 'field_opt_hours_open', 'label' => 'Otwarcie', 'name' => 'open', 'type' => 'text' ),
				array( 'key' => 'field_opt_hours_close', 'label' => 'Zamknięcie', 'name' => 'close', 'type' => 'text' ),
			),
		),
		array( 'key' => 'field_opt_fb', 'label' => 'Facebook URL', 'name' => 'social_facebook', 'type' => 'url' ),
		array( 'key' => 'field_opt_ig', 'label' => 'Instagram URL', 'name' => 'social_instagram', 'type' => 'url' ),
		array( 'key' => 'field_opt_google_rating', 'label' => 'Ocena Google (np. 4.9)', 'name' => 'google_rating', 'type' => 'text' ),
		array( 'key' => 'field_opt_google_review_count', 'label' => 'Liczba opinii Google', 'name' => 'google_review_count', 'type' => 'number' ),
	),
	'location' => array(
		array(
			array(
				'param'    => 'options_page',
				'operator' => '==',
				'value'    => 'sw-options',
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
			'key'     => 'field_testimonial_rating',
			'label'   => 'Ocena',
			'name'    => 'rating',
			'type'    => 'select',
			'choices' => array( '5' => '5 gwiazdek', '4' => '4 gwiazdki', '3' => '3 gwiazdki' ),
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
				'aesthetic' => 'Stomatologia estetyczna',
				'endo'      => 'Endodoncja',
				'implant'   => 'Implanty',
				'prosthetic'=> 'Protetyka',
				'surgery'   => 'Chirurgia',
				'perio'     => 'Periodontologia',
				'pediatric' => 'Stomatologia dziecięca',
				'xray'      => 'Radiologia',
			),
		),
		array(
			'key'   => 'field_service_price_range',
			'label' => 'Zakres cenowy (opcjonalnie)',
			'name'  => 'price_range',
			'type'  => 'text',
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
 * Team Member CPT fields: role + certifications.
 */
acf_add_local_field_group( array(
	'key'    => 'group_team_member',
	'title'  => 'Szczegóły profilu',
	'fields' => array(
		array( 'key' => 'field_team_role', 'label' => 'Stanowisko', 'name' => 'role', 'type' => 'text' ),
		array(
			'key'        => 'field_team_certifications',
			'label'      => 'Certyfikaty / specjalizacje',
			'name'       => 'certifications',
			'type'       => 'repeater',
			'layout'     => 'table',
			'sub_fields' => array(
				array( 'key' => 'field_team_cert_name', 'label' => 'Nazwa', 'name' => 'name', 'type' => 'text' ),
			),
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
