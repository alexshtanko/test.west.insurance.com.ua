<?php	global $wpdb;$wpdb->query("ALTER TABLE ".WP_PREFIX."prt_incentives MODIFY action_inc VARCHAR(20)");