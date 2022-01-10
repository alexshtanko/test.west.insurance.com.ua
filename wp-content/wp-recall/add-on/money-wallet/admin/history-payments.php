<?php

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Wallet_Payments_History_Table extends WP_List_Table {
    
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
        if( 'wallet-history-payments' != $page )
        return;
        echo '<style type="text/css">';
        echo '.wp-list-table .column-user_id { width: 20%; }';
        echo '.wp-list-table .column-count_pay { width: 10%; }';
        echo '.wp-list-table .column-user_balance { width: 10%; }';
        echo '.wp-list-table .column-comment_pay { width: 35%;}';
        echo '.wp-list-table .column-time_pay { width: 15%;}';
        echo '</style>';
    }

    function no_items() {
        _e( 'No payments found.', 'rcl-wallet' );
    }

    function column_default( $item, $column_name ) {
        
        switch( $column_name ) { 
            case 'user_id':
                return $item->user_id.': '.get_the_author_meta('display_name',$item->user_id);
            case 'count_pay':
                $z = ($item->type_pay==1)? '-': '+';
                return $z.' '.$item->count_pay.' '.rcl_get_primary_currency(2);
            case 'user_balance':
                if($item->user_balance) return $item->user_balance.' '.rcl_get_primary_currency(2);
                else return '-';
            case 'comment_pay':   
                return $item->comment_pay;
            case 'time_pay':
                return $item->time_pay;           
            default:
                return print_r( $item, true ) ;
        }
    }

    function get_columns(){
        $columns = array(
            //'cb'        => '<input type="checkbox" />',
            'user_id'        => __('Users','rcl-wallet'),
            'count_pay'        => __('Parish','rcl-wallet').'/'.__('Consumption','rcl-wallet'),
            'user_balance'     => __('The rest','rcl-wallet'),
            'comment_pay'      => __('Comment','rcl-wallet'),
            'time_pay'     => __('Date','rcl-wallet')
        );
         return $columns;
    }
    
    function column_user_id($item){
      $actions = array(
            'history'    => sprintf('<a href="?page=%s&action=%s&user=%s">'.__( 'All history', 'rcl-wallet' ).'</a>',$_REQUEST['page'],'history',$item->user_id),
        );
      return sprintf('%1$s %2$s', $item->user_id.': '.get_the_author_meta('display_name',$item->user_id), $this->row_actions($actions) );
    }

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
            . "FROM ".RCL_PREF."wallet_history "
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

            $this->query['where'][] = "user_id = '".$_POST['s']."'";
            
            if(isset($_GET['m'])&&$_GET['m']){ 
            
                $this->query['where'][] = "time_pay LIKE '".$_GET['m']."-%'";

            }
            
        }else if(isset($_GET['m'])&&$_GET['m']){ 
            
            $this->query['where'][] = "time_pay LIKE '".$_GET['m']."-%'";
            
        }else if($_GET['user']){
            
            $this->query['where'][] = "user_id = '".$_GET['user']."'";
            
        }
        
        $this->total_items = $this->count_items();
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

function rcl_wallet_payments_page_options() {
    global $Wallet_Payments_History;
    $option = 'per_page';
    $args = array(
        'label' => __( 'Flow of funds', 'rcl-wallet' ),
        'default' => 30,
        'option' => 'rcl_wallet_per_page'
    );
    add_screen_option( $option, $args );
    $Wallet_Payments_History = new Wallet_Payments_History_Table();
}

function rcl_wallet_payments_admin_page(){
  global $Wallet_Payments_History;
  
  //$Wallet_Payments_History = new Wallet_Payments_History_Table();
  $Wallet_Payments_History->prepare_items();

  echo '</pre><div class="wrap"><h2>'.__('Flow of funds','rcl-wallet').'</h2>';
  
   ?>  
    <form method="post">
    <input type="hidden" name="page" value="rcl-wallet-payments">    
    <?php
    $Wallet_Payments_History->display(); ?>
  </form>
</div>
<?php }

