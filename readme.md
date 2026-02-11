## WP Events Manager Pro

A professional WordPress plugin to manage events with RSVP, filtering, REST API support, WP-CLI integration, and more.

---

## 📦 Installation & Activation Instructions

### ✅ Requirements

- WordPress 6.x+  
- PHP 8.0+  
- WP-CLI 2.12.0 (optional, for CLI features)  
- PHPUnit 8.5.2 by Sebastian Bergmann and contributors

---

## 🚀 Installation Steps

### 1️⃣ Clone or Download the Repository


git clone https://github.com/asadalarma/wp-events-manager-pro.git


### 2️⃣ Copy Plugin Folder

Move the plugin folder into:


wp-content/plugins/


### 3️⃣ Activate the Plugin

**Option A: From WordPress Admin**  

- Go to **WordPress Admin → Plugins**  
- Locate **WP Events Manager Pro**  
- Click **Activate**  

**Option B: Via WP-CLI**


wp plugin activate wp-events-manager-pro


### 4️⃣ Flush Permalinks

**From Admin:**  
- Go to **Settings → Permalinks**  
- Click **Save Changes**  

**Or via CLI:**


wp rewrite flush


---

## 🧪 Sample Data for Testing

### Using WP-CLI


wp event create "Sample Event"
wp event create "Conference 2025"


---

### 📝 Manual Testing

1. Go to **Admin → Events → Add New**  
2. Assign an **Event Type**  
3. Add **Event Date** and **Location**  
4. Publish the event  

---

### 🌐 Frontend Testing

Visit the events archive page:


/events/


Use the shortcode in any page or post:


[event_filter]


Test the following features:

- RSVP functionality  
- Search and filter functionality  
- Event archive and single event templates  
- REST API endpoints (if enabled)  

---

## 🧪 Testing & PHPUnit Setup

### 1️⃣ Install Composer Dependencies

composer install
composer require --dev yoast/phpunit-polyfills:^1.0


### 2️⃣ Install WordPress Test Suite


bash bin/install-wp-tests.sh wordpress_test root 'your_db_password' localhost 6.4.3


This will:

- Download WordPress core to /tmp/wordpress  
- Download WordPress PHPUnit test suite to /tmp/wordpress-tests-lib  
- Generate wp-tests-config.php for testing  

### 3️⃣ Create a Sample PHPUnit Test

Create tests/test-sample.php with the following content:

```php
<?php
class Test_Events extends WP_UnitTestCase {

    public function test_event_post_type_exists() {
        $this->assertTrue( post_type_exists('event') );
    }
}
```


Create tests/test-events.php with the following content:

```php
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
```

### 4️⃣ Run Tests


./vendor/bin/phpunit --bootstrap tests/bootstrap.php tests/test-sample.php


Expected output:


OK (1 test, 1 assertion)



./vendor/bin/phpunit --bootstrap tests/bootstrap.php tests/test-events.php


Expected output:


OK (1 test, 1 assertion)

---

## 🖥️ CLI & PHP Version Information

### 🔎 Check PHP Version


php -v


Example output:


PHP 8.2.x (cli)


The plugin requires **PHP 8.0 or higher**.

---

### 🔎 Check WP-CLI Version


wp --info


Example output will display:

- WP-CLI version  
- PHP binary path  
- PHP version  
- WordPress version  

To verify WP-CLI installation:


wp --version


Expected: WP-CLI 2.12.0

---

### 🚀 Using WP-CLI with This Plugin

Activate plugin:


wp plugin activate wp-events-manager-pro


Create events via CLI:


wp event create "Sample Event"
wp event create "Conference 2025"


Flush rewrite rules:


wp rewrite flush


---

## 📄 License

GPLv2 or later

---

## 📌 Notes

- Make sure permalinks are flushed after activation.  
- Ensure proper database permissions when using WP-CLI commands.  
- Compatible with modern PHP versions (8.0+ recommended)  
