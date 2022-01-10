<?php

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Wallet_Output_History_Table extends WP_List_Table {

    var $per_page = 50;
    var $current_page = 1;
    var $total_items;
    var $offset = 0;
    var $sum = 0;
    var $query = array(
            'select'    => array(),
            'join'      => array(),
            'where'     => array(),
            'group'     => '',
            'orderby'   => 'ID',
            'relation'   => 'AND',
            'order'   => 'DESC',
            'include'   => '',
            'exclude'   => ''
        );

    function __construct(){
        global $status, $page;
        parent::__construct( array(
            'singular'  => __( 'payment', 'rcl-wallet' ),
            'plural'    => __( 'payments', 'rcl-wallet' ),
            'ajax'      => false
        ) );

        $this->per_page = $this->get_items_per_page('rcl_wallet_per_page', 50);
        $this->current_page = $this->get_pagenum();
        $this->offset = ($this->current_page-1)*$this->per_page;

        add_action( 'admin_head', array( &$this, 'admin_header' ) );
    }

    function admin_header() {
        $page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
        if( 'manage-rmag' != $page )
        return;
        echo '<style type="text/css">';
        echo '.wp-list-table .column-user_rq { width: 10%; }';
        echo '.wp-list-table .column-count_rq { width: 25%; }';
        echo '.wp-list-table .column-output_rq { width: 10%; }';
        echo '.wp-list-table .column-comment_rq { width: 10%;}';
        echo '.wp-list-table .column-time_rq { width: 30%;}';
        echo '.wp-list-table .column-status_rq { width: 15%;}';
        echo '</style>';
    }

    function no_items() {
        _e( 'No orders found.', 'rcl-wallet' );
    }

    function column_default( $item, $column_name ) {
        global $rcl_options;

        $percent = $rcl_options['percent_output_request'];

        switch( $column_name ) {
            case 'user_rq':
                return $item->user_rq.': '.get_the_author_meta('display_name',$item->user_rq);
            case 'count_rq':
                return $item->count_rq.' '.rcl_get_primary_currency(1);
            case 'output_rq':
                if($item->status_rq==1){
                    if($percent) return ($item->count_rq - round(($item->count_rq*$percent/100),2)).' '.rcl_get_primary_currency(1);
                    else return $item->count_rq.' '.rcl_get_primary_currency(1);
                }else{
                    return $item->output_rq.' '.rcl_get_primary_currency(1);
                }
            case 'comment_rq':
                return $item->comment_rq;
            case 'time_rq':
                return $item->time_rq;
            case 'status_rq':
                if($item->status_rq==1){
                    return '<span style="color:red;">'.__('Consideration','rcl-wallet').'</span>';
                }
                if($item->status_rq==2){
                    return '<span style="color:green;">'.__('Made','rcl-wallet').'</span>';
                }
            default:
                return print_r( $item, true ) ;
        }
    }

    function get_columns(){
        $columns = array(
            'cb'        => '<input type="checkbox" />',
            'user_rq'        => __('User','rcl-wallet'),
            'count_rq'     => __('Amount request','rcl-wallet'),
            'output_rq'      => __('Withdrawal amount','rcl-wallet'),
            'comment_rq'     => __('Comment','rcl-wallet'),
            'time_rq'        => __('Date','rcl-wallet'),
            'status_rq'      => __('Status','rcl-wallet')
        );
         return $columns;
    }

    function column_user_rq($item){
      $actions = array(
            'details'    => sprintf('<a href="'.admin_url('admin.php?page=wallet-history-payments&action=history&user=%d').'">'.__( 'Payments history', 'rcl-wallet' ).'</a>',$item->user_rq),
          'requests'    => sprintf('<a href="?page=%s&action=%s&user=%s">'.__( 'All requests', 'rcl-wallet' ).'</a>',$_REQUEST['page'],'requests',$item->user_rq),
        );
      return sprintf('%1$s %2$s', $item->user_rq.': '.get_the_author_meta('display_name',$item->user_rq), $this->row_actions($actions) );
    }

    function column_status_rq($item){

        if($item->status_rq!=1) return '<span style="color:green;">'.__('Made','rcl-wallet').'</span>';

        $actions = array(
            'reject'    => sprintf('<a href="?page=%s&action=%s&request=%s">'.__( 'Reject', 'rcl-wallet' ).'</a>',$_REQUEST['page'],'reject',$item->ID),
            'approves'    => sprintf('<a href="?page=%s&action=%s&request=%s">'.__( 'Approve', 'rcl-wallet' ).'</a>',$_REQUEST['page'],'approves',$item->ID)
        );

        return sprintf('%1$s %2$s', '<span style="color:red;">'.__('Consideration','rcl-wallet').'</span>', $this->row_actions($actions) );
    }

    function get_bulk_actions() {
      $actions = array(
          'delete' => __( 'Delete', 'rcl-wallet' )
          );
      return $actions;
    }

    function column_cb($item) {
        return sprintf(
            '<input type="checkbox" name="requests[]" value="%s" />', $item->ID
        );
    }

    function months_dropdown( $post_type ) {
        global $wpdb,$wp_locale;

        $months = $wpdb->get_results("
                SELECT DISTINCT YEAR( time_rq ) AS year, MONTH( time_rq ) AS month
                FROM ".RCL_PREF."wallet_request
                ORDER BY time_rq DESC
        ");

        $months = apply_filters( 'months_dropdown_results', $months, $post_type );

        $month_count = count( $months );
        if ( !$month_count || ( 1 == $month_count && 0 == $months[0]->month ) )
                return;

        $m = isset( $_GET['m'] ) ? $_GET['m'] : 0; ?>
        <label for="filter-by-status" class="screen-reader-text"><?php _e( 'Filter by date' ); ?></label>
        <select name="m" id="filter-by-date">
            <option<?php selected( $m, 0 ); ?> value="0"><?php _e( 'All dates' ); ?></option>
            <?php foreach ( $months as $arc_row ) {
                    if ( 0 == $arc_row->year )
                            continue;
                    $month = zeroise( $arc_row->month, 2 );
                    $year = $arc_row->year;
                    printf( "<option %s value='%s'>%s</option>\n",
                            selected( $m, $year .'-'. $month, false ),
                            esc_attr( $arc_row->year .'-'. $month ),
                            sprintf( __( '%1$s %2$d' ), $wp_locale->get_month( $month ), $year )
                    );
            } ?>
        </select>
    <?php }

    function count_items(){
        global $wpdb;
        $query_string = $this->query_string('count');
        return $wpdb->get_var( $query_string );
    }

    function get_sum(){
        global $wpdb;
        $query_string = $this->query_string('sum');
        return $wpdb->get_var( $query_string );
    }

    function get_items(){
        global $wpdb;
        $query_string = $this->query_string();
        return $wpdb->get_results( $query_string );
    }

    function query_string($count=false){
        global $wpdb,$rcl_options;

        if($count=='count'){

            $this->query['select'] = array(
                "COUNT(ID)"
            );

        }else if($count=='sum'){

            $this->query['select'] = array(
                "SUM(output_rq)"
            );

        }else{

            $this->query['select'] = array(
                "*"
            );

        }

        if($this->include) $this->query['where'][] = "ID IN ($this->include)";
        if($this->exclude) $this->query['where'][] = "ID NOT IN ($this->exclude)";

        $query_string = "SELECT "
            . implode(", ",$this->query['select'])." "
            . "FROM ".RCL_PREF."wallet_request "
            . implode(" ",$this->query['join'])." ";

        if($this->query['where']) $query_string .= "WHERE ".implode(' '.$this->query['relation'].' ',$this->query['where'])." ";
        if($this->query['group']) $query_string .= "GROUP BY ".$this->query['group']." ";

        if(!$count){
            $query_string .= "ORDER BY ".$this->query['orderby']." ".$this->query['order']." ";
            $query_string .= "LIMIT $this->offset,$this->per_page";
        }

        return $query_string;

    }

    function get_data(){

        if(isset($_POST['s'])){

            $this->query['where'][] = "user_rq = '".$_POST['s']."'";

            if(isset($_GET['m'])&&$_GET['m']){

                $this->query['where'][] = "time_rq LIKE '".$_GET['m']."-%'";

            }

        }else if(isset($_GET['m'])&&$_GET['m']){

            $this->query['where'][] = "time_rq LIKE '".$_GET['m']."-%'";

        }else if($_GET['user']){

            $this->query['where'][] = "user_rq = '".$_GET['user']."'";

        }

        $this->total_items = $this->count_items();
        $this->sum = $this->get_sum();
        $items = $this->get_items();

        return $items;

    }

    function prepare_items() {

        $data = $this->get_data();
        $this->_column_headers = $this->get_column_info();
        $this->set_pagination_args( array(
            'total_items' => $this->total_items,
            'per_page'    => $this->per_page
        ) );

        $this->items = $data;

    }
}

add_action('admin_init','rcl_wallet_update_status_request');
function rcl_wallet_update_status_request(){

    $page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
    if( 'manage-output-wallet' != $page ) return;

    if(isset($_REQUEST['action'])){
        if(isset($_POST['action'])){
            if(!isset($_POST['requests'])) return;
            $action = $_POST['action'];
            foreach($_POST['requests'] as $request_id){
                mw_delete_request($request_id);
            }
            wp_redirect($_POST['_wp_http_referer']);exit;
        }
        if(isset($_GET['action'])){
            switch($_GET['action']){
                case 'reject': return mw_admin_cancel_request($_GET['request']);
                case 'approves': return mw_admin_success_request($_GET['request']);
                case 'details': return;
                case 'requests': return;
            }

            wp_redirect(admin_url('admin.php?page=manage-output-wallet'));exit;
        }

    }
}

function rcl_wallet_history_page_options() {
    global $Wallet_Output_History;
    $option = 'per_page';
    $args = array(
        'label' => __( 'Payments', 'rcl-wallet' ),
        'default' => 30,
        'option' => 'rcl_wallet_per_page'
    );
    add_screen_option( $option, $args );
    $Wallet_Output_History = new Wallet_Output_History_Table();
}

function rcl_wallet_history_admin_page(){
  global $Wallet_Output_History;

  $Wallet_Output_History->prepare_items();

  echo '</pre><div class="wrap"><h2>'.__('Requests history','rcl-wallet').'</h2>';

  //echo rcl_get_chart_orders($Wallet_Output_History->items);
   ?>
    <form method="get">
    <input type="hidden" name="page" value="manage-output-wallet">
    <?php
    $Wallet_Output_History->months_dropdown('rcl_wallet');
    submit_button( __( 'Filter', 'rcl-wallet' ), 'button', '', false, array('id' => 'search-submit') ); ?>
    </form>
    <form method="post">
    <input type="hidden" name="page" value="manage-output-wallet">
    <?php
    //$Wallet_Output_History->search_box( __( 'Search', 'rcl-wallet' ), 'search_id' );

    $Wallet_Output_History->display(); ?>
  </form>
</div>
<?php }

