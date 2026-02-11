<?php
/**
 * WP Events Manager Pro Plugin Tests
 */

class Test_Events_Manager extends WP_UnitTestCase {

    // -------------------------------
    // 1️⃣ Test CPT registration
    // -------------------------------
    public function test_event_post_type_exists() {
        $this->assertTrue( post_type_exists( 'event' ), 'The Event CPT should be registered.' );
    }

    // -------------------------------
    // 2️⃣ Test taxonomy registration
    // -------------------------------
    public function test_event_type_taxonomy_exists() {
        $this->assertTrue( taxonomy_exists( 'event_type' ), 'The Event Type taxonomy should be registered.' );
    }

    // -------------------------------
    // 3️⃣ Test creating event with meta fields
    // -------------------------------
    public function test_event_meta_fields() {
        $post_id = $this->factory->post->create([
            'post_type' => 'event',
            'post_title' => 'Sample Event',
        ]);

        // Add meta
        update_post_meta( $post_id, 'event_date', '2026-02-15' );
        update_post_meta( $post_id, 'event_location', 'Karachi' );

        $this->assertEquals( '2026-02-15', get_post_meta( $post_id, 'event_date', true ) );
        $this->assertEquals( 'Karachi', get_post_meta( $post_id, 'event_location', true ) );
    }

    // -------------------------------
    // 4️⃣ Test assigning taxonomy term
    // -------------------------------
    public function test_event_taxonomy_assignment() {
        $term = wp_insert_term( 'Conference', 'event_type' );

        $post_id = $this->factory->post->create([
            'post_type' => 'event',
            'post_title' => 'Conference Event',
        ]);

        wp_set_object_terms( $post_id, $term['term_id'], 'event_type' );

        $terms = wp_get_object_terms( $post_id, 'event_type', ['fields' => 'ids'] );
        $this->assertContains( $term['term_id'], $terms );
    }

    // -------------------------------
    // 5️⃣ Test RSVP meta
    // -------------------------------
    public function test_event_rsvp() {
        $post_id = $this->factory->post->create([
            'post_type' => 'event',
            'post_title' => 'RSVP Event',
        ]);

        // Simulate RSVP meta
        update_post_meta( $post_id, 'event_rsvp_count', 5 );
        $this->assertEquals( 5, get_post_meta( $post_id, 'event_rsvp_count', true ) );

        // Increment RSVP
        $rsvp_count = get_post_meta( $post_id, 'event_rsvp_count', true );
        update_post_meta( $post_id, 'event_rsvp_count', $rsvp_count + 1 );
        $this->assertEquals( 6, get_post_meta( $post_id, 'event_rsvp_count', true ) );
    }

    // -------------------------------
    // 6️⃣ Test shortcode output
    // -------------------------------
    public function test_event_filter_shortcode() {
        $output = do_shortcode( '[event_filter]' );
        $this->assertIsString( $output );
        $this->assertNotEmpty( $output );
    }
}
