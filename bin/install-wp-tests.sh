#!/usr/bin/env bash

DB_NAME=${1-wordpress_test}
DB_USER=${2-root}
DB_PASS=${3-}
DB_HOST=${4-localhost}
WP_VERSION=${5-6.4.3}

WP_TESTS_DIR=${WP_TESTS_DIR-/tmp/wordpress-tests-lib}
WP_CORE_DIR=${WP_CORE_DIR-/tmp/wordpress}

set -ex

install_wp() {
  if [ ! -d "$WP_CORE_DIR" ]; then
    mkdir -p "$WP_CORE_DIR"
    wget -q -O - https://wordpress.org/wordpress-${WP_VERSION}.tar.gz | tar -xz -C "$WP_CORE_DIR" --strip-components=1
  fi
}

install_test_suite() {
  # Download test suite includes and data
  if [ ! -d "$WP_TESTS_DIR" ]; then
    mkdir -p "$WP_TESTS_DIR"
    svn export --quiet https://develop.svn.wordpress.org/tags/${WP_VERSION}/tests/phpunit/includes/ "$WP_TESTS_DIR/includes"
    svn export --quiet https://develop.svn.wordpress.org/tags/${WP_VERSION}/tests/phpunit/data/ "$WP_TESTS_DIR/data"
  fi

  # Create wp-tests-config.php manually
  cat > "$WP_TESTS_DIR/wp-tests-config.php" <<EOL
<?php
define( 'DB_NAME', '$DB_NAME' );
define( 'DB_USER', '$DB_USER' );
define( 'DB_PASSWORD', '$DB_PASS' );
define( 'DB_HOST', '$DB_HOST' );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

define( 'WP_TESTS_DIR', '$WP_TESTS_DIR' );
define( 'WP_CACHE', false );
define( 'WP_TESTS_FORCE_KNOWN_BUGS', false );
define( 'ABSPATH', '$WP_CORE_DIR/' );

require_once WP_TESTS_DIR . '/includes/functions.php';
EOL
}

install_wp
install_test_suite

echo "✅ WordPress test suite installed successfully in $WP_TESTS_DIR"
